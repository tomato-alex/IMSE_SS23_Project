<?php

class DatabaseHelper
{
    // Details for connecting with the database
    const username = 'root';
    const password = 'testpass';
    const host = 'mysql';
    const database = 'imse_23_ss';
    const port = '3306';

    protected $conn;
    protected static $tablesCreated = false;

    // Create connection in the constructor
    public function __construct()
    {
        try {
            // Create connection with the command mysqli_connect(String(host), String(username), String(password), String(database), Integer(port))
            $this->conn = mysqli_connect(
                DatabaseHelper::host,
                DatabaseHelper::username,
                DatabaseHelper::password,
                DatabaseHelper::database,
                DatabaseHelper::port
            );

            // Check if the connection object is not null
            if (!$this->conn) {
                echo "<script>console.log('" . $this->conn . "');</script>";
                //die("DB error: Connection can't be established!");
                $this->conn = mysqli_connect(
                    DatabaseHelper::host,
                    DatabaseHelper::username,
                    DatabaseHelper::password,
                    null,
                    DatabaseHelper::port
                );
                $createScript = file_get_contents('createDB.sql');
                if ($createScript) {
                    // Execute the create script
                    $result = mysqli_multi_query($this->conn, $createScript);
                    if (!$result) {
                        die("DB error: Failed to execute the create script: " . mysqli_error($this->conn));
                    }
                } else {
                    die("DB error: Failed to read the create script.");
                }
                mysqli_select_db($this->conn, DatabaseHelper::database);
            }
        } catch (Exception $e) {
            die("DB error: {$e->getMessage()}");
        }
    }
    public function getCreated()
    {
        return $this->tablesCreated;
    }
    public function createTables()
    {
        if ($this->tablesCreated === true) {
            return;
        }
        $createTables = file_get_contents('create_script.sql');
        if ($createTables) {
            // Execute the create script
            $result = mysqli_multi_query($this->conn, $createTables);
            if (!$result) {
                die("DB error: Failed to execute the create script: " . mysqli_error($this->conn));
            }
        } else {
            die("DB error: Failed to read the create script.");
        }
        $this->tablesCreated = true;
    }
    public function getConnection()
    {
        return $this->conn;
    }
    public function __destruct()
    {
        // clean up
        mysqli_close($this->conn);
    }

    public function checkEmployeeInDB($login)
    {
        $id = '';
        $name = '';
        if (preg_match('/^(\d+)([A-Za-z]+)$/', $login, $matches)) {
            $id = $matches[1];
            $name = $matches[2];
        } else {
            $name = $login;
        }

        // Extract the name part
        $id = mysqli_real_escape_string($this->conn, $id);
        $name = mysqli_real_escape_string($this->conn, $name);
        //echo '<script>console.log("' . $id . '_' . $name . '__' . '")</script>';
        $query = "SELECT COUNT(*) AS count FROM employee WHERE employeeId = '$id' AND first_name = '$name'";
        $result = mysqli_query($this->conn, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $count = $row['count'];
            if ($count > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    // This function creates and executes a SQL select statement and returns an array as the result
    // 2-dimensional array: the result array contains nested arrays (each contains the data of a single row)
    public function selectAllLocations($fid, $stadt, $land, $adresse)
    {
        //echo mysqli_error($this->conn);
        $sql = "SELECT * FROM locations WHERE 1=1";
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
         AND carId NOT IN (Select carId from sells)
          AND carId LIKE '%{$aid}%'
          AND upper(brand) LIKE upper('%{$marke}%')
          AND upper(modell) LIKE upper('%{$modell}%')
          AND leasingNr LIKE '%{$lnr}%'
          ORDER BY carId ASC";

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
        $sql = "SELECT * FROM total_sales WHERE employeeId IN (SELECT employeeId FROM employee WHERE locationId = ?) order by total_sum asc";

        $statement = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($statement, 's', $fid);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($statement);

        return $res;
    }

    public function selectSells($location)
    {
        $sql = "SELECT e.employeeId, e.first_name, e.last_name, c.brand, c.modell, s.price, s.date
                from sells as s left join employee as e on s.employeeId = e.employeeId left join car as c on c.carId = s.carId where locationId = ?";

        $statement = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($statement, 'i', $location);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($statement);

        return $res;
    }

    // This function creates and executes a SQL insert statement and returns true or false
    public function insertIntoLocation($stadt, $land, $adresse)
    {
        $sql = "INSERT INTO locations (city, country, address) VALUES (?, ?, ?)";

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
        //echo "<p>H" . $s1 . "_" . $s2 . "</p>";
        //echo "_" . $autoID . "_" . $fid;
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
        $test = 'SELECT * FROM locations WHERE locationId = ?';
        $statement = mysqli_prepare($this->conn, $test);
        mysqli_stmt_bind_param($statement, 'i', $location_id);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($statement);

        if (empty($res)) {
            return 0;
        }

        $sql = 'DELETE FROM locations WHERE locationId = ?';
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
        $sql = 'SELECT city FROM locations WHERE locationId = ?';
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
    public function getFid()
    {
        $fid = array();
        $stmt = $this->conn->prepare("SELECT locationId FROM locations");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $fid[] = $row['locationId'];
        }

        $stmt->close();

        return $fid;
    }
    // getLeasingNR
    public function getLeasingNR()
    {
        $lnr = array();
        $stmt = $this->conn->prepare("SELECT leasingNr FROM leasing");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $lnr[] = $row['leasingNr'];
        }

        $stmt->close();

        return $lnr;
    }

    // getAutoId
    public function getAutoId()
    {
        $aid = array();
        $stmt = $this->conn->prepare("SELECT carId FROM car");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $aid[] = $row['carId'];
        }

        $stmt->close();

        return $aid;
    }
    // getMitarbeiterId
    public function getMitarbeiterId()
    {
        $mid = array();
        $stmt = $this->conn->prepare("SELECT employeeId FROM employee");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $mid[] = $row['employeeId'];
        }

        $stmt->close();

        return $mid;
    }

    // getFidMid
    public function getFidMid()
    {
        $fidAndMid = array();
        $stmt = $this->conn->prepare("SELECT locationId, managerId FROM employee");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $fidAndMid[$row['locationId']] = $row['managerId'];
        }

        $stmt->close();

        return $fidAndMid;
    }
    // insertIntoVerkauft
    public function insertIntoVerkauft($mid, $aid, $preis, $date)
    {
        //echo "<p>" . $mid . $aid . $preis . $date . "</p>";
        $sql = "INSERT INTO sells(employeeId, carId, price, date) VALUES (?, ?, ?, ?)";
        $statement = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($statement, "iids", $mid, $aid, $preis, $date);
        $success = mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);

        return $success;
    }

    // insertIntoHat
    public function insertIntoHat($fid, $aid)
    {
        $statementString = "INSERT INTO has(locationId, carId) VALUES (?, ?)";
        try {
            $prepStmt = $this->conn->prepare($statementString);
            $prepStmt->bind_param("ii", $fid, $aid);
            $prepStmt->execute();
            $prepStmt->close();
        } catch (Exception $e) {
            echo "Error at: insertIntoHat\nmessage: " . $e->getMessage();
        }
    }
    // insertIntoAutowerkstatt
    public function insertIntoAutowerkstatt($fid, $telefonnummer, $anz_mit)
    {
        $statementString = "INSERT INTO workshop(locationId, phone_number, employee_count) VALUES (?, ?, ?)";
        try {
            $prepStmt = $this->conn->prepare($statementString);
            $prepStmt->bind_param("isi", $fid, $telefonnummer, $anz_mit);
            $prepStmt->execute();
            $prepStmt->close();
        } catch (Exception $e) {
            echo "Error at: insertIntoAutowerkstatt\nmessage: " . $e->getMessage();
        }
    }

    // insertIntoLeasing
    public function insertIntoLeasing($dauer, $preis)
    {
        $statementString = "INSERT INTO leasing(duration, fee) VALUES (?, ?)";
        try {
            $prepStmt = $this->conn->prepare($statementString);
            $prepStmt->bind_param("id", $dauer, $preis);
            $prepStmt->execute();
            $prepStmt->close();
        } catch (Exception $e) {
            echo "Error at: insertIntoLeasing\nmessage: " . $e->getMessage();
        }
    }

    public function selectCheapest($locId)
    {
        $sql = "SELECT * from cheapest_leasing_options where country = ? limit 10";
        $statement = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($statement, 's', $locId);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($statement);

        return $res;
    }
}
