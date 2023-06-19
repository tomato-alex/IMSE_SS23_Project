<?php
require_once('DatabaseHelper.php');

$database = new DatabaseHelper();

$fid = '';
if (isset($_GET['fid'])) {
    $fid = $_GET['fid'];
}

$stadt = '';
if (isset($_GET['stadt'])) {
    $stadt = $_GET['stadt'];
}

$land = '';
if (isset($_GET['land'])) {
    $land = $_GET['land'];
}

$adresse = '';
if (isset($_GET['adresse'])) {
    $adresse = $_GET['adresse'];
}

//Fetch data from database
$locations_array = $database->selectAllLocations($fid, $stadt, $land, $adresse);
?>

<html>

<head>
    <style>
        body {
            background-image: linear-gradient(#87d9fa, #7abaff);
        }
    </style>
    <meta charset="utf-8">
    <title>Best Cars</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>


    <div style="background-image: url('car_1.jpeg');
background-position: center;
background-repeat: no-repeat;
background-size: cover;
height: 800px;
padding-top: 0;">

        <h1 style="color: cadetblue; text-shadow: 5px 3px 7px black;
-webkit-text-stroke-width: 1px;
  -webkit-text-stroke-color: steelblue;">Best Cars</h1>

    </div>


    <br>

    <h2>Our Locations:</h2>
    <div class="tableContainer">
        <table class="table">
            <thead class="head">
                <tr>
                    <th class="col">ID</th>
                    <th class="col">Country</th>
                    <th class="col">City</th>
                    <th class="col4">Address</th>
                </tr>
            </thead>
            <?php foreach ($locations_array as $location) : ?>
                <tr>
                    <td><?php echo $location['FID']; ?> </td>
                    <td><?php echo $location['LAND']; ?> </td>
                    <td><?php echo $location['STADT']; ?> </td>
                    <td><?php echo $location['ADRESSE']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <br>
    <br>




</body>

</html>