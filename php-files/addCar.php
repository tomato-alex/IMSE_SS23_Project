<?php
session_start();

require_once('DatabaseHelper.php');

$database = new DatabaseHelper();

//Grab variables from POST request
$login = '';
if (isset($_POST['login'])) {
    $login = $_POST['login'];
}
$brand = '';
if (isset($_POST['brand'])) {
    $brand = $_POST['brand'];
}

$model = '';
if (isset($_POST['model'])) {
    $model = $_POST['model'];
}

$leasingNr = '';
if (isset($_POST['leasingNr'])) {
    $leasingNr = $_POST['leasingNr'];
}
echo "<p>" . $leasingNr . $model . $brand . "</p>";
$success = $database->insertIntoCar($model, $brand, $leasingNr, $_SESSION["id"]);

// Check result
if ($success) {
    echo "<p class='phpecho'> {$brand} {$model} successfully added!</p>";
} else {
    echo "<p class='phpecho'>Error can't insert Car {$brand} {$model} {$leasingNr}!</p>";
}
?>
<title>Best Cars</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">

<!-- link back to previous page-->
<br>
<div style="width: 8%;margin: auto;align-items: center">
    <form method="post" action="chosenLocation.php">
        <input type="hidden" name="login" value="<?php echo $login; ?>">
        <button type="submit" class="button2">Go back</button>
    </form>
</div>