<title>Best Cars</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">

<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variables from POST request
$login = '';
if (isset($_POST['login'])) {
    $login = $_POST['login'];
}
$country = '';
if (isset($_POST['country'])) {
    $country = $_POST['country'];
}

$city = '';
if (isset($_POST['city'])) {
    $city = $_POST['city'];
}

$address = '';
if (isset($_POST['address'])) {
    $address = $_POST['address'];
}

// Insert method
$success = $database->insertIntoLocation($city, $country, $address);

// Check result
if ($success) {
    echo "<p class='phpecho'> Location successfully added!</p>";
} else {
    echo "<p class='phpecho'>Error can't insert Location '{$country} {$city} {$address}'!</p>";
}
?>


<!-- link back to index page-->
<br>
<div style="width: 8%;margin: auto;align-items: center">
    <form method="post" action="chosenLocation.php">
        <input type="hidden" name="login" value="<?php echo $login; ?>">
        <button type="submit" class="button2">Go back</button>
    </form>
</div>