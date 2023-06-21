<?php
session_start();

require_once('DatabaseHelper.php');

$database = new DatabaseHelper();

$carId = '';
if (isset($_POST['carId'])) {
    $carId = $_POST['carId'];
}

$employeeId = '';
if (isset($_POST['employeeId'])) {
    $employeeId = $_POST['employeeId'];
}

$price = '';
if (isset($_POST['price'])) {
    $price = $_POST['price'];
}

$date = date('d-m-y');

$success = $database->insertIntoVerkauft($employeeId, $carId, $price, $date);

// Check result
if ($success) {
    echo "<p class='phpecho'>Sold successfully!</p>";
} else {
    echo "<p class='phpecho'>Error cannot add sale!</p>";
}
?>


<title>Best Cars</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">

<!-- link back to previous page-->
<br>
<div style="
    width: 8%;
    margin: auto;
    align-items: center">
    <a href="chosenLocation.php">
        <button class="button2"> go back</button>
    </a>
</div>