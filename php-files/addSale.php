<?php
session_start();

require_once('DatabaseHelper.php');

$database = new DatabaseHelper();
$login = '';
if (isset($_POST['login'])) {
    $login = $_POST['login'];
}
$carId = '';
if (isset($_POST['carId'])) {
    $carId = $_POST['carId'];
}

$employeeId = '';
if (isset($_POST['employeeId'])) {
    $employeeId = $_POST['employeeId'];
    echo '<script>console.log("Login:", "' . $employeeId . '")</script>';
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

    <div style="width: 8%;margin: auto;align-items: center">
        <form method="post" action="chosenLocation.php">
            <input type="hidden" name="login" value="<?php echo $login; ?>">
            <button type="submit" class="button2">Go back</button>
        </form>
    </div>
</div>