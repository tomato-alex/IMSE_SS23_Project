<?php
require_once 'DatabaseHelper.php';
$helper = new DatabaseHelper();

// Array of table names to delete entries from
$tables = array(
    "has",
    "sells",
    "employee",
    "car",
    "leasing",
    "workshop",
    "location"
);

// Delete all entries from each table
foreach ($tables as $table) {
    $sql = "DELETE FROM " . $table;
//    var_dump($helper->getConnection()->error);
    if ($helper->getConnection()->query($sql) === TRUE) {
//        echo "Deleted all entries from table '" . $table . "' successfully.<br>";
//    } else {
//        echo "Error deleting entries from table '" . $table . "': " . $helper->getConnection()->error . "<br>";
    }
    $sql = "COMMIT";
    $helper->getConnection()->query($sql);
}

// Close the database connection
?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
<head>
    <title>Database Filler</title>
</head>

<body>
    <p class='phpecho'> All inputs deleted from the database!</p>
    <!-- Your database filler content goes here -->

    <div style="
    width: 8%;
    margin: auto;
    align-items: center">
        <a  href="index.php">
            <button class="button2"> Go Back</button>
        </a>
    </div>
</body>

</html>