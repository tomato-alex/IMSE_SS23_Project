<title>Best Cars</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">

<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variable id from POST request
$login = '';
if (isset($_POST['login'])) {
    $login = $_POST['login'];
}
$location_id = '';
if (isset($_POST['id'])) {
    $location_id = $_POST['id'];
}

// Delete method
$success = $database->deleteLocation($location_id);

// Check result
if ($success == 1) {
    echo "<p class='phpecho'>Location with ID: '{$location_id}' successfully deleted!</p>";
} else {
    echo "<p class='phpecho'> Location with ID: '{$location_id}' does not exist!</p>";
}
?>


<!-- link back to index page-->
<br>
<div style="width: 8%;margin: auto;align-items: center">
    <form method="post" action="index.php">
        <input type="hidden" name="login" value="<?php echo $login; ?>">
        <button type="submit" class="button2">Go back</button>
    </form>
</div>