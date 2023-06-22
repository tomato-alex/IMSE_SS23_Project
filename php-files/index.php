<?php
require_once('DatabaseHelper.php');

$database = new DatabaseHelper();
$login = '';
if (isset($_POST['login'])) {
    $login = $_POST['login'];
    echo '<script>console.log("Login:", "' . $login . '")</script>';
    if ($login === 'admin') {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            var adminDiv = document.getElementById("adminDiv");
            var employeeDiv = document.getElementById("employeeDiv");
  
            adminDiv.style.display = "block";
            employeeDiv.style.display = "block";
          });
        </script>';
    } else {
        $exists = $database->checkEmployeeInDB($login);
        if ($exists) {
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    var adminDiv = document.getElementById("adminDiv");
                    var employeeDiv = document.getElementById("employeeDiv");
  
                    adminDiv.style.display = "none";
                    employeeDiv.style.display = "block";
                });
                </script>';
        }
    }
}

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
    echo "<script>console.log('" . $land . "');</script>";
    $cheapest_cars = $database->selectCheapest($land);
    if ($land === '') {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            var cheapest = document.getElementById("cheapest");
            var cheapest2 = document.getElementById("cheapest2");

            cheapest.style.display = "none";
            cheapest2.style.display = "none";
        });
        </script>';
    } else {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            var cheapest = document.getElementById("cheapest");
            var cheapest2 = document.getElementById("cheapest2");

            cheapest.style.display = "block";
            cheapest2.style.display = "block";
        });
        </script>';
    }
}

$adresse = '';
if (isset($_GET['adresse'])) {
    $adresse = $_GET['adresse'];
}

//Fetch data from database
$locations_array = $database->selectAllLocations($fid, $stadt, $land, $adresse);
//&location = $database->getFid();
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
    <title>IMSE</title>
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

            if (inputText === "admin") {
                adminDiv.style.display = "block";
                employeeDiv.style.display = "block";
            } else if (inputText === "employee") {
                adminDiv.style.display = "none";
                employeeDiv.style.display = "block";
            } else {
                adminDiv.style.display = "none";
                employeeDiv.style.display = "none";
            }
        }

        function setDef() {
            var adminDiv = document.getElementById("adminDiv");
            var employeeDiv = document.getElementById("employeeDiv");


            adminDiv.style.display = "none";
            employeeDiv.style.display = "none";

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

        <h1 style="color: mintcream; text-shadow: 5px 3px 7px black;
-webkit-text-stroke-width: 1px;
  -webkit-text-stroke-color: steelblue;font-size: 100px;
    font-family: Helvetica;
    text-align: center;
    padding-top: 300px;
    margin-top: 0;">International Motorvehicle<br>Sales Enterprise</h1>

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
    <!-- Input wrapper -->
    <div class=" input-wrapper">
        <form method="POST" action="index.php">
            <input type="text" name="login" placeholder="Enter login">
            <input type="hidden" name="get_param" value="some_value">
            <button type="submit">Login</button>
        </form>
        <form method="POST" action="index.php">
            <input type="hidden" name="login" value="">
            <button type="submit">Logout</button>
        </form>
    </div>
    <br>
    <!--Location table-->
    <h2 style="text-shadow: 3px 2px 2px steelblue">Our Locations:</h2>
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

    <h2 class="container" id="cheapest2">Budget Friendly Options:</h2>
    <div class="container" id="cheapest">

        <div class="tableContainer">
            <table class="table">
                <thead class="head">
                    <tr>
                        <th class="col">Brand</th>
                        <th class="col">Model</th>
                        <th class="col4">Leasing Number</th>
                        <th class="col">Cost</th>
                    </tr>
                </thead>
                <?php foreach ($cheapest_cars as $car) : ?>
                    <tr>
                        <td><?php echo $car['brand']; ?> </td>
                        <td><?php echo $car['modell']; ?> </td>
                        <td><?php echo $car['leasingNr']; ?></td>
                        <td><?php echo $car['MonthlyFee']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <div class="flex-container">

        <div class="form" style="box-shadow: 7px 7px #87d9fa">
            <!-- Search form -->
            <h3>Location Search:</h3>
            <form method="post" id="searchForm" action>

                <table class="table2">
                    <!-- ID textbox:-->
                    <tr class="spaceunder">
                        <td><label for="fid">ID:</label></td>
                        <td><input id="fid" name="fid" type="text" value='' min="0"></td>
                    </tr>
                    <!-- Country textbox:-->
                    <tr class="spaceunder">
                        <td><label for="land">Country:</label></td>
                        <td><input id="land" name="land" type="text" value='' maxlength="20"></td>
                    </tr>
                    <!-- City textbox:-->
                    <tr class="spaceunder">
                        <td><label for="stadt">City:</label></td>
                        <td><input id="stadt" name="stadt" type="text" value='' maxlength="20"></td>
                    </tr>
                </table>
                <br>
                <input type="hidden" name="login" value="<?php echo $login; ?>">
                <!-- Submit button -->
                <div style="margin: auto; width: 15%; padding: 20px; ">
                    <button id='submit' type='submit'>Search</button>
                </div>
                <script>
                    document.getElementById('searchForm').addEventListener('submit', function(event) {
                        // Get the fid input value
                        var fidValue = document.getElementById('fid').value;
                        var landValue = document.getElementById('land').value;
                        var stadtValue = document.getElementById('stadt').value;
                        // Build the URL query string
                        var queryString = 'fid=' + encodeURIComponent(fidValue);
                        queryString += '&land=';
                        queryString += encodeURIComponent(landValue);
                        queryString += '&stadt=';
                        queryString += encodeURIComponent(stadtValue);
                        document.getElementById('fid').value = '';
                        document.getElementById('land').value = '';
                        document.getElementById('stadt').value = '';
                        // Get the current page URL
                        var currentPageUrl = "index.php";

                        // Append the query string to the current URL
                        var redirectUrl = currentPageUrl + '?' + queryString;

                        // Update the form's action attribute
                        this.action = redirectUrl;
                    });
                </script>
            </form>
        </div>
        <br>
        <hr>

        <br>
        <br>
        <div id="employeeDiv" class="container">
            <!-- Choose Location -->
            <div class="form" style="box-shadow: 7px 7px #87d9fa">
                <h3>Choose Location: </h3>
                <form method="post" action="chosenLocation.php" onsubmit="return validateForm()">
                    <!-- ID is not needed, because its autogenerated by the database -->
                    <table class="table2">
                        <!-- ID textbox -->
                        <tr class="spaceunder">
                            <td><label for="new_name">ID:</label></td>
                            <td><input id="new_name" name="id" type="text" maxlength="20"></td>
                        </tr>
                    </table>
                    <input type="hidden" name="login" value="<?php echo $login; ?>">
                    <!-- Submit button -->
                    <div style="margin: auto; width: 18%; padding: 20px;">
                        <button type="submit">Choose</button>
                    </div>
                </form>
            </div>

            <script>
                function validateForm() {
                    var inputId = document.getElementById("new_name").value.trim();

                    // Array of valid IDs
                    var validIds = <?php echo json_encode(array_map('strval', $database->getFid())); ?>;
                    if (!validIds.includes(inputId)) {
                        alert("Invalid ID! Please enter a valid ID.");
                        return false; // Prevent form submission
                    }

                    return true; // Proceed to the next page
                }
            </script>

        </div>
        <hr>
        <div id="adminDiv" class="container">
            <a href="databaseFiller.php" class="floating-button" onclick="showSpinner()">Fill DB</a>
            <a href="Drop.php" class="floating-button" style="bottom: 90px" onclick="showSpinner()">Delete all</a>
            <!-- Add Location -->
            <div class="form" style="box-shadow: 7px 7px #87d9fa">
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
            <div class="form" style="box-shadow: 7px 7px #87d9fa">
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