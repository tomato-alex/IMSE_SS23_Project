<?php
session_start();

require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

$login = '';
if (isset($_POST['login'])) {
    $login = $_POST['login'];

    $empid = '';
    if (preg_match('/^(\d+)([A-Za-z]+)$/', $login, $matches)) {
        $empid = $matches[1];
    }
    echo '<script>console.log("Login:", "' . $login . '_' . $empid . '")</script>';
}

$id = '';
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if ($id != null) {
    $_SESSION["id"] = $id;
}

$CarID = '';
if (isset($_GET['aid'])) {
    $CarID = $_GET['aid'];
}

$brand = '';
if (isset($_GET['marke'])) {
    $brand = $_GET['marke'];
}

$model = '';
if (isset($_GET['modell'])) {
    $model = $_GET['modell'];
}

$leasingNr = '';
if (isset($_GET['lnr'])) {
    $leasingNr = $_GET['lnr'];
}

$name = '';
if (isset($_GET['vorname'])) {
    $name = $_GET['vorname'];
}
$surname = '';
if (isset($_GET['nachname'])) {
    $surname = $_GET['nachname'];
}
$mid = '';
if (isset($_GET['mid'])) {
    $mid = $_GET['mid'];
}

$locationName = $database->getLocationName($_SESSION["id"]);
$employee_array = $database->selectEmployeesFromLocation($_SESSION["id"]);
$cars_array = $database->selectCarsFromLocation($CarID, $brand, $model, $leasingNr, $_SESSION["id"]);
$cheapest_cars = $database->selectCheapest($_SESSION["id"]);
?>
<html>

<head>
    <meta charset="utf-8">
    <title>Best Cars</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="image1">
        <?php foreach ($locationName as $name) : ?>
            <h1 style="color: cadetblue; text-shadow: 5px 3px 7px black;
-webkit-text-stroke-width: 1px;
  -webkit-text-stroke-color: steelblue;"><?php echo $name['city'] ?></h1>
        <?php endforeach; ?>
    </div>


    <br>

    <h2>Available Cars:</h2>

    <div class="tableContainer">
        <table class="table">
            <thead class="head">
                <tr>
                    <th class="col">ID</th>
                    <th class="col">Brand</th>
                    <th class="col">Model</th>
                    <th class="col4">Leasing Number</th>
                </tr>
            </thead>
            <?php foreach ($cars_array as $car) : ?>
                <tr>
                    <td><?php echo $car['carId']; ?> </td>
                    <td><?php echo $car['brand']; ?> </td>
                    <td><?php echo $car['modell']; ?> </td>
                    <td><?php echo $car['leasingNr']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <h2>Budget Friendly Options:</h2>

    <div class="tableContainer">
        <table class="table">
            <thead class="head">
                <tr>
                    <th class="col">ID</th>
                    <th class="col">Brand</th>
                    <th class="col">Model</th>
                    <th class="col4">Leasing Number</th>
                    <th class="col">Cost</th>
                </tr>
            </thead>
            <?php foreach ($cheapest_cars as $car) : ?>
                <tr>
                    <td><?php echo $car['carId']; ?> </td>
                    <td><?php echo $car['brand']; ?> </td>
                    <td><?php echo $car['modell']; ?> </td>
                    <td><?php echo $car['leasingNr']; ?></td>
                    <td><?php echo $car['MonthlyFee']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <br>

    <!-- Add Car -->
    <div class="form">
        <h3>Add Car: </h3>

        <form method="post" action="addCar.php">
            <!-- ID is not needed, because its autogenerated by the database -->
            <table class="table2">
                <!-- Brand textbox -->
                <tr class="spaceunder">
                    <td><label for="brand">Brand:</label></td>
                    <td><input id="brand" name="brand" type="text" maxlength="20"></td>
                </tr>
                <br>

                <!-- Model textbox -->
                <tr class="spaceunder">
                    <td><label for="model">Model:</label></td>
                    <td><input id="model" name="model" type="text" maxlength="20"></td>
                </tr>
                <br>

                <!-- Leasing textbox -->
                <tr>
                    <td><label for="leasingNr">Leasing:</label></td>
                    <td><input id="leasingNr" name="leasingNr" type="text" maxlength="20"></td>
                </tr>

            </table>
            <br>


            <!-- Submit button -->
            <div style="margin: auto;
                width: 18%;
                padding: 20px;">
                <input type="submit" name="button" value="Add Car">

            </div>

        </form>
    </div>

    <div class="form">
        <!-- Delete Car -->
        <h3>Delete Car: </h3>
        <form method="post" action="delCar.php">
            <!-- ID textbox -->
            <table class="table2">
                <tr class="spaceover">
                    <td><label for="del_name">ID:</label></td>
                    <td><input id="del_name" name="id" type="number" min="0"></td>
                </tr>
            </table>
            <br>
            <!-- Submit button -->
            <div class="button">
                <button type="submit">
                    Delete Car
                </button>
            </div>
        </form>
    </div>

    <br>
    <br>
    <br>

    <?php

    ?>

    <!-- Add Employee -->
    <div class="form">
        <h3>Add Employee: </h3>

        <form method="post" action="addEmployee.php" onsubmit="return validateForm()">
            <!-- ID is not needed, because its autogenerated by the database -->
            <table class="table2">
                <!-- Name textbox -->
                <tr class="spaceunder">
                    <td><label for="name">Name:</label></td>
                    <td><input id="name" name="name" type="text" maxlength="20"></td>
                </tr>
                <br>

                <!-- Surname textbox -->
                <tr class="spaceunder">
                    <td><label for="surname">Surname:</label></td>
                    <td><input id="surname" name="surname" type="text" maxlength="20"></td>
                </tr>
                <br>

            </table>
            <br>


            <!-- Submit button -->
            <div style="margin: auto;
                width: 18%;
                padding: 20px;">
                <input type="submit" name="button" value="Add Employee">

            </div>

        </form>

        <script>
            function validateForm() {
                var nameInput = document.getElementById("name").value.trim();
                var surnameInput = document.getElementById("surname").value.trim();

                var employees = <?php echo json_encode($employee_array); ?>;

                for (var i = 0; i < employees.length; i++) {
                    var employee = employees[i];
                    var employeeName = employee.first_name.toLowerCase().trim();
                    var employeeSurname = employee.last_name.toLowerCase().trim();

                    if (employeeName === nameInput.toLowerCase() && employeeSurname === surnameInput.toLowerCase()) {
                        alert("Employee already exists.");
                        return false; // Prevent form submission
                    }
                }

                return true; // Proceed to the next page
            }
        </script>
    </div>

    <div class="form">
        <!-- Delete Employee -->
        <h3>Delete Employee: </h3>
        <form method="post" action="delEmployee.php">
            <!-- ID textbox -->
            <table class="table2">
                <tr class="spaceover">
                    <td><label for="id">ID:</label></td>
                    <td><input id="id" name="id" type="number" min="0"></td>
                </tr>
            </table>
            <br>
            <!-- Submit button -->
            <div class="button">
                <button type="submit">
                    Delete Employee
                </button>
            </div>
        </form>
    </div>
    <br>
    <br>

    <h3 style="font-size: 45px; margin-right:850px">Our Staff Members:</h3>

    <div style=" padding: 0px; height: 250px; width: 450px; overflow: hidden; overflow-y: auto; border-radius: 15px; margin-left: auto; margin-right: auto; border: 1px solid;">
        <table class="table">
            <thead class="head1">
                <tr>
                    <th class="col">ID</th>
                    <th class="col">Name</th>
                    <th class="col">Surname</th>
                </tr>
            </thead>
            <?php foreach ($employee_array as $emp) : ?>
                <tr>
                    <td><?php echo $emp['employeeId']; ?> </td>
                    <td><?php echo $emp['first_name']; ?> </td>
                    <td><?php echo $emp['last_name']; ?> </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>


    <?php $sales_array = $database->selectSales($_SESSION["id"]); ?>
    <h3 style="font-size: 45px; margin-right:850px">Sales:</h3>
    <!--Sales-->
    <div style="padding: 0px;
    height: 300px;
    width: 850px;
    overflow: hidden;
    overflow-y: auto;
    margin-left: auto;
    margin-right: auto;">
        <table class="table">
            <thead class="head">
                <tr>
                    <th class="col">MID</th>
                    <th class="col">Name</th>
                    <th class="col">Surname</th>
                    <th class="col">Brand</th>
                    <th class="col">Model</th>
                    <th class="col">Date</th>
                    <th class="col">Price</th>
                </tr>
            </thead>
            <?php foreach ($sales_array as $sale) : ?>
                <tr>
                    <td><?php echo $sale['employeeId']; ?> </td>
                    <td><?php echo $sale['first_name']; ?> </td>
                    <td><?php echo $sale['last_name']; ?> </td>
                    <td><?php echo $sale['brand']; ?> </td>
                    <td><?php echo $sale['modell']; ?> </td>
                    <td><?php echo $sale['date']; ?> </td>
                    <td><?php echo $sale['sum'] . " €" ?> </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>


    <br>
    <br>
    <!-- New Sale -->
    <div class="form">
        <h3>New Sale: </h3>

        <form method="post" action="addSale.php" onsubmit="return validateFormSales()">
            <!-- ID is not needed, because its autogenerated by the database -->
            <table class="table2">
                <!-- Car Id textbox -->
                <tr class="spaceunder">
                    <td><label for="carId">Car Id:</label></td>
                    <td><input id="carId" name="carId" type="text" maxlength="20"></td>
                </tr>

                <!-- Price textbox -->
                <tr class="spaceunder">
                    <td><label for="price">Price:</label></td>
                    <td><input id="price" name="price" type="text" maxlength="20"></td>
                </tr>
            </table>
            <!-- Employee id textbox -->
            <input type="hidden" name="login" value="<?php echo $login; ?>">
            <input id="employeeId" name="employeeId" type="hidden" value="<?php echo $empid ?>">
            <!-- Submit button -->
            <div style="margin: auto;width: 18%;padding: 20px;">
                <input type="submit" name="button" value="Add Sale">
            </div>
        </form>

        <script>
            function validateFormSales() {
                var carInput = parseInt(document.getElementById("carId").value.trim(), 10);

                var cars = <?php echo json_encode($cars_array); ?>;

                for (var i = 0; i < cars.length; i++) {
                    var car = cars[i];
                    var carId = parseInt(car.carId, 10);


                    if (carId === carInput) {
                        return true; // Proceed to the next page
                    }
                }
                alert("Selected car is not available at this location.");
                return false; // Prevent form submission
            }
        </script>
    </div>

    <!-- link back to index page-->
    <div style="width: 8%;margin: auto;align-items: center">
        <form method="post" action="index.php">
            <input type="hidden" name="login" value="<?php echo $login; ?>">
            <button type="submit" class="button2">Go back</button>
        </form>
    </div>

</body>

</html>