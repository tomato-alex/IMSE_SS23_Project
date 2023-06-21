<?php

require_once 'DatabaseHelper.php';
require_once 'DataGenerator.php';


$helper = new DatabaseHelper();
$data_generator = new DataGenerator();

// Location insertion
for ($location = 0; $location < 10; $location++) {
    $getter = random_int(0, $data_generator->getCitiesAndCountriesSize() - 1);
    $helper->insertIntoLocation($data_generator->getCity($getter), $data_generator->getCountry($getter), $data_generator->getRandomAddress());
}

// Workshop insertion
$location_id = $helper->getFid();
for ($workshop = 0; $workshop < 15; $workshop++) {
    $workerCount = random_int(1, 6);
    $j = 6679220592 + $workshop;
    $phone_number = "+43" . $j;
    $random = random_int(0, count($location_id) - 1);
    $helper->insertIntoAutowerkstatt($location_id[$random], $phone_number, $workerCount);
}

// Leasing insertion
for ($leasing = 0; $leasing < 20; $leasing++) {
    $period = random_int(1, 10);
    $cents = random_int(0, 100) / 100.00;
    $price = random_int(30000, 200000) + 30000 + $cents;
    $helper->insertIntoLeasing($period, $price);
}

// Car insertion
$leasing_nr = $helper->getLeasingNR();
for ($car = 0; $car <= 100; $car++) {
    $random = random_int(0, count($leasing_nr) - 1);
    $getter = random_int(0, $data_generator->getCarsSize());
    $helper->insertIntoCar($data_generator->getMarke($getter), $data_generator->getModell($getter), $leasing_nr[$random], $location_id[$random]);
}
$car_ids = $helper->getAutoId();
// Employee insertion
for ($employee = 0; $employee < count($location_id); $employee++) { // workers without bosses
    $randomName = random_int(0, $data_generator->getFirstNameSize() - 1);
    $randomSurname = random_int(0, $data_generator->getSurnameSize() - 1);
    $helper->insertIntoEmployee($data_generator->getFirstName($randomName), $data_generator->getSurname($randomSurname), $location_id[$employee], null); // in every location/filiale will be one boss
} {
    $filialAndMitarbeiter = $helper->getFidMid();
    for ($i = 0; $i < count($location_id); $i++) {
        for ($j = 0; $j < 5; $j++) {
            $randomName = random_int(0, $data_generator->getFirstNameSize() - 1);
            $randomSurname = random_int(0, $data_generator->getSurnameSize() - 1);
            $helper->insertIntoEmployee($data_generator->getFirstName($randomName), $data_generator->getSurname($randomSurname), $location_id[$i], $filialAndMitarbeiter[$i]);
        }
    }
}

// has insert
$numbers = array();
foreach ($helper->getFid() as $i => $value) {
    $numbers = array();
    for ($j = 0; $j <= 30; $j++) {
        $random = random_int(0, count($car_ids) - 1);
        while (in_array($random, $numbers)) {
            $random = random_int(0, count($car_ids) - 1);
        }
        $numbers[] = $random;
        $helper->insertIntoHat($location_id[$i], $car_ids[$random]);
    }
}

// sells insert
$employee_ids = $helper->getMitarbeiterId();
$usedNumbers = array();
for ($i = 0; $i < 50; $i++) {
    $price = (random_int(20000, 200000)) * 100 / 100.00;
    $random_employee = random_int(0, count($employee_ids) - 1);
    $random_car = random_int(0, count($car_ids) - 1);
    //    while (in_array($random_car, $usedNumbers)) {
    //        $random_car = random_int(0, count($car_ids) - 1);
    //    }

    $usedNumbers[] = $random_car;
    $date = (random_int(2012, 2022)) . "-" . (random_int(1, 12)) . "-" . (random_int(1, 28));
    $helper->insertIntoVerkauft($employee_ids[$random_employee], $car_ids[$random_car], $price, $date);
}
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">

<head>
    <title>Database Filler</title>
</head>

<body>
    <p class='phpecho'> The Database has been filled! 🍺🍺🍺 </p>
    <div style="
    width: 8%;
    margin: auto;
    align-items: center">
        <a href="index.php">

            <button class="button2"> Go Back</button>
        </a>
    </div>
</body>

</html>