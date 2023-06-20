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

        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #e91e63;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            text-align: center;
            font-size: 12px;
            line-height: 60px;
            cursor: pointer;
        }

        .container {
            display: none;
            margin-bottom: 20px;
        }

        .input-wrapper {
            text-align: right;
            padding: 10px;
        }

        .input-wrapper input[type="text"] {
            outline: none;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            width: 200px;
        }

        .input-wrapper button {
            margin-left: 5px;
        }

        .spinner {
            /* Spinner styles */
            /* ... */
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Faded background */
            z-index: 9999;
            /* Ensure the spinner appears above other elements */
            /*display: flex;*/
            justify-content: center;
            align-items: center;
        }

        .spinner .lds-ring {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }

        .spinner .lds-ring div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            width: 64px;
            height: 64px;
            margin: 8px;
            border: 8px solid #fff;
            border-radius: 50%;
            animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            border-color: #fff transparent transparent transparent;
        }

        .spinner .lds-ring div:nth-child(1) {
            animation-delay: -0.45s;
        }

        .spinner .lds-ring div:nth-child(2) {
            animation-delay: -0.3s;
        }

        .spinner .lds-ring div:nth-child(3) {
            animation-delay: -0.15s;
        }

        @keyframes lds-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <meta charset="utf-8">
    <title>Best Cars</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script>
        function showSpinner() {
            // Show the spinner
            document.getElementById("spinner").style.display = "flex";

            // Redirect to the target page after a short delay
            setTimeout(function() {
                window.location.href = element.getAttribute("href");
            }, 100);
        }

        function showDivs() {
            var inputText = document.getElementById("inputField").value.toLowerCase();
            var adminDiv = document.getElementById("adminDiv");
            var employeeDiv = document.getElementById("employeeDiv");
            var defaultDiv = document.getElementById("defaultDiv");

            if (inputText === "admin") {
                adminDiv.style.display = "block";
                employeeDiv.style.display = "block";
                defaultDiv.style.display = "block";
            } else if (inputText === "employee") {
                adminDiv.style.display = "none";
                employeeDiv.style.display = "block";
                defaultDiv.style.display = "block";
            } else {
                adminDiv.style.display = "none";
                employeeDiv.style.display = "none";
                defaultDiv.style.display = "block";
            }
        }

        function setDef() {
            var adminDiv = document.getElementById("adminDiv");
            var employeeDiv = document.getElementById("employeeDiv");
            var defaultDiv = document.getElementById("defaultDiv");


            adminDiv.style.display = "none";
            employeeDiv.style.display = "none";
            defaultDiv.style.display = "block";

        }
    </script>
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
    <!-- floating insert button -->
    <div id="spinner" class="spinner">
        <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <a href="databaseFiller.php" class="floating-button" onclick="showSpinner()">Fill DB</a>
    <a href="Drop.php" class="floating-button" style="bottom: 90px" onclick="showSpinner()">Delete all</a>
    <div class=" input-wrapper">
        <input type="text" id="inputField" placeholder="Enter role">
        <button onclick="showDivs()">Login</button>
        <button onclick="setDef()">Logout</button>
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
                    <td><?php echo $location['locationId']; ?> </td>
                    <td><?php echo $location['country']; ?> </td>
                    <td><?php echo $location['city']; ?> </td>
                    <td><?php echo $location['address']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <br>
    <br>


    <div class="flex-container">

        <div class="form">
            <!-- Search form -->
            <h3>Location Search:</h3>
            <form method="get">

                <table class="table2">
                    <!-- ID textbox:-->
                    <tr class="spaceunder">
                        <td><label for="fid">ID:</label></td>
                        <td><input id="fid" name="fid" type="text" value='<?php echo $fid; ?>' min="0"></td>
                    </tr>
                    <br>
                    <!-- Country textbox:-->
                    <tr class="spaceunder">
                        <td><label for="land">Country:</label></td>
                        <td><input id="land" name="land" type="text" value='<?php echo $land; ?>' maxlength="20"></td>
                    </tr>
                    <br>

                    <!-- City textbox:-->
                    <tr class="spaceunder">
                        <td><label for="stadt">City:</label></td>
                        <td><input id="stadt" name="stadt" type="text" value='<?php echo $stadt; ?>' maxlength="20"></td>
                    </tr>

                    <br>
                </table>
                <br>

                <!-- Submit button -->
                <div style="margin: auto;
            width: 15%;
            padding: 20px; ">
                    <button id='submit' type='submit'>
                        Search
                    </button>
                </div>
            </form>
        </div>
        <br>
        <hr>

        <br>
        <br>
        <div id="employeeDiv" class="container">
            <!-- Choose Location -->
            <div class="form">
                <h3>Choose Location: </h3>
                <form method="post" action="chosenLocation.php">
                    <!-- ID is not needed, because its autogenerated by the database -->
                    <table class="table2">
                        <!-- ID textbox -->
                        <tr class="spaceunder">
                            <td><label for="new_name">ID:</label></td>
                            <td><input id="new_name" name="id" type="text" maxlength="20"></td>
                        </tr>
                        <br>

                    </table>
                    <br>

                    <!-- Submit button -->
                    <div style="margin: auto;
            width: 18%;
            padding: 20px;">
                        <button type="submit">
                            Choose
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div id="adminDiv" class="container">
            <!-- Add Location -->
            <div class="form">
                <h3>Add Location: </h3>

                <form method="post" action="addLocation.php">
                    <!-- ID is not needed, because its autogenerated by the database -->
                    <table class="table2">
                        <!-- Country textbox -->
                        <tr class="spaceunder">
                            <td><label for="new_country">Country:</label></td>
                            <td><input id="new_country" name="country" type="text" maxlength="20"></td>
                        </tr>
                        <br>

                        <!-- City textbox -->
                        <tr class="spaceunder">
                            <td><label for="new_city">City:</label></td>
                            <td><input id="new_city" name="city" type="text" maxlength="20"></td>
                        </tr>
                        <br>

                        <!-- Address textbox -->
                        <tr>
                            <td><label for="new_address">Address:</label></td>
                            <td><input id="new_address" name="address" type="text" maxlength="20"></td>
                        </tr>

                    </table>
                    <br>


                    <!-- Submit button -->
                    <div style="margin: auto;
            width: 18%;
            padding: 20px;">
                        <input type="submit" name="button" value="Add Location">

                    </div>

                </form>
            </div>
            <div class="form">
                <!-- Delete Location -->
                <h3>Delete Location: </h3>
                <form method="post" action="delLocation.php">
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
                            Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <hr>

    </div>


</body>

</html>