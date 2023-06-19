<?php

class DatabaseHelper
{
    // Details for connecting with the database
    const username = 'root';
    const password = 'testpass';
    const host = 'mariadb';
    const database = 'imse_23_ss';
    const port = '3306';

    protected $conn;

    // Create connection in the constructor
    public function __construct()
    {
        try {
            // Create connection with the command oci_connect(String(username), String(password), String(connection_string))
            $this->conn = mysqli_connect(
                DatabaseHelper::host,
                DatabaseHelper::username,
                DatabaseHelper::password,
                DatabaseHelper::database
            );

            //check if the connection object is != null
            if (!$this->conn) {
                die("DB error: Connection can't be established!");
            }
        } catch (Exception $e) {
            die("DB error: {$e->getMessage()}");
        }
    }

    public function __destruct()
    {
        // clean up
        mysqli_close($this->conn);
    }

    // This function creates and executes a SQL select statement and returns an array as the result
    // 2-dimensional array: the result array contains nested arrays (each contains the data of a single row)
    public function selectAllLocations($fid, $stadt, $land, $adresse)
    {
        $sql = "SELECT * FROM location WHERE 1=1";
        $params = array();

        if (!empty($stadt)) {
            $sql .= " AND city LIKE ?";
            $params[] = "%$stadt%";
        }

        if (!empty($fid)) {
            $sql .= " AND locationId LIKE ?";
            $params[] = "%$fid%";
        }

        if (!empty($land)) {
            $sql .= " AND country LIKE ?";
            $params[] = "%$land%";
        }

        // Add additional conditions for other optional parameters if needed

        $sql .= " ORDER BY country ASC";

        $statement = mysqli_prepare($this->conn, $sql);

        // Bind parameters dynamically
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            mysqli_stmt_bind_param($statement, $types, ...$params);
        }

        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Clean up
        mysqli_stmt_close($statement);

        return $res;
    }



    public function selectCarsFromLocation($aid, $marke, $modell, $lnr, $id)
    {
        $sql = "SELECT * FROM car 
         WHERE carId IN (SELECT carId from has WHERE locationId = '$id')
          AND carId LIKE '%{$aid}%'
          AND upper(brand) LIKE upper('%{$marke}%')
          AND upper(modell) LIKE upper('%{$modell}%')
          AND leasingNr LIKE '%{$lnr}%'
          ORDER BY brand ASC";

        $statement = mysqli_query($this->conn, $sql);

        // Check if the query executed successfully
        if (!$statement) {
            die("DB error: Query execution failed!");
        }

        $res = mysqli_fetch_all($statement, MYSQLI_ASSOC);

        // Clean up
        mysqli_free_result($statement);

        return $res;
    }


    public function selectEmployeesFromLocation($fid)
    {
        $sql = "SELECT * FROM employee WHERE locationId = ?";
        $statement = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($statement, 's', $fid);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($statement);

        return $res;
    }

    public function selectSales($fid)
    {
        $sql = "SELECT * FROM total_sales WHERE employeeId IN (SELECT employeeId FROM employee WHERE locationId = ?)";

        $statement = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($statement, 's', $fid);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($statement);

        return $res;
    }


    // This function creates and executes a SQL insert statement and returns true or false
    public function insertIntoLocation($stadt, $land, $adresse)
    {
        $sql = "INSERT INTO location (city, country, address) VALUES (?, ?, ?)";

        $statement = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($statement, 'sss', $stadt, $land, $adresse);
        $success = mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);

        return $success;
    }


    public function insertIntoCar($marke, $modell, $lnr, $fid)
    {
        // Insert car
        $sql = "INSERT INTO car (brand, modell, leasingNr) VALUES (?, ?, ?)";
        $statement = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($statement, 'sss', $marke, $modell, $lnr);
        $s1 = mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);

        // Get carId of the inserted car
        $sql = "SELECT carId FROM car WHERE brand = ? AND modell = ? AND carId = (SELECT MAX(carId) FROM car)";
        $statement = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($statement, 'ss', $marke, $modell);
        $s2 = mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $row = mysqli_fetch_assoc($result);
        $autoID = $row['carId'];
        mysqli_stmt_close($statement);
        echo "<p>H" . $s1 . "_" . $s2 . "</p>";
        echo "_" . $autoID . "_" . $fid;
        // Insert into has table
        $sql = "INSERT INTO has (locationId, carId) VALUES (?, ?)";
        $statement = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($statement, 'ii', $fid, $autoID);
        $success = mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);

        return $success;
    }


    public function insertIntoEmployee($name, $surname, $fid)
    {
        $errorcode = 0;
        $sql = "INSERT into employee (first_name, last_name, locationId) values (?, ?, ?)";
        $statement = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($statement, 'sss', $name, $surname, $fid);
        $success = mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);

        return $success;
    }

    public function deleteLocation($location_id)
    {
        $test = 'SELECT * FROM location WHERE locationId = ?';
        $statement = mysqli_prepare($this->conn, $test);
        mysqli_stmt_bind_param($statement, 'i', $location_id);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($statement);

        if (empty($res)) {
            return 0;
        }

        $sql = 'DELETE FROM location WHERE locationId = ?';
        $statement = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($statement, 'i', $location_id);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);

        return 1;
    }


    public function deleteCar($location_id, $car_id)
    {
        $test = "SELECT * FROM has WHERE locationId = ? AND carId = ?";
        $statement = mysqli_prepare($this->conn, $test);
        mysqli_stmt_bind_param($statement, 'ii', $location_id, $car_id);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($statement);

        if (empty($res)) {
            return 0;
        }

        $sql = "DELETE FROM has WHERE locationId = ? AND carId = ?";
        $statement = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($statement, 'ii', $location_id, $car_id);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);

        return 1;
    }


    public function deleteEmployee($id)
    {
        $errorcode = 0;

        $sql = 'BEGIN DELETE_Mitarbeiter(:id, :errorcode); END;';
        $statement = @oci_parse($this->conn, $sql);


        @oci_bind_by_name($statement, ':id', $id);
        @oci_bind_by_name($statement, ':errorcode', $errorcode);

        @oci_execute($statement);
        @oci_free_statement($statement);
        return $errorcode;
    }

    public function getLocationName($id)
    {
        $sql = 'SELECT city FROM location WHERE locationId = ?';
        $statement = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($statement, 'i', $id);

        // Debug statement to check the query
        //echo "Query: " . $sql . " with id = " . $id . PHP_EOL;
        //echo $statement;

        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
        //echo $res[0]['city'];
        mysqli_stmt_close($statement);

        return $res;
    }
}
