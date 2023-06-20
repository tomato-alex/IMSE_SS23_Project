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
    var_dump($helper->getConnection()->error);
    if ($helper->getConnection()->query($sql) === TRUE) {
        echo "Deleted all entries from table '" . $table . "' successfully.<br>";
    } else {
        echo "Error deleting entries from table '" . $table . "': " . $helper->getConnection()->error . "<br>";
    }
    $sql = "COMMIT";
    $helper->getConnection()->query($sql);
}

// Close the database connection
?>

<!DOCTYPE html>
<html>

<head>
    <title>Database Filler</title>
</head>

<body>
    <!-- Your database filler content goes here -->

    <a href="index.php"><button>Go Back</button></a>
</body>

</html>