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
$ep_id = '';
if (isset($_POST['id'])) {
    $ep_id = $_POST['id'];
}

// Delete method
$success = $database->deleteEmployee($ep_id);


// Check result
if ($success == 1) {
    echo "<p class='phpecho'>Employee with ID: '{$ep_id}' successfully deleted!</p>";
} else {
    echo "<p class='phpecho'> Employee with ID: '{$ep_id}' does not exist!</p>";
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