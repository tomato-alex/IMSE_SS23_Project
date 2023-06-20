<?php

require_once 'DatabaseHelper.php';
require_once 'DataGenerator.php';

echo "based\n";
$helper = new DatabaseHelper();
$dgen = new DataGenerator();

// Filiale insertion
for ($i = 0; $i < 10; $i++) {
    $getter = random_int(0, $dgen->getCitiesAndCountriesSize() - 1);
    $helper->insertIntoLocation($dgen->getCity($getter), $dgen->getCountry($getter), $dgen->getRandomAddress());
}

// Autowerkstatt insertion
$fid = $helper->getFid();
for ($i = 0; $i < 15; $i++) {
    $workerCount = random_int(1, 6);
    $j = 6679220592 + $i;
    $telefonnummer = "+43" . $j;
    $random = random_int(0, count($fid) - 1);
    $helper->insertIntoAutowerkstatt($fid[$random], $telefonnummer, $workerCount);
}

// Leasing insertion
for ($i = 0; $i < 20; $i++) {
    $dauer = random_int(1, 10);
    $cents = random_int(0, 100) / 100.00;
    $preis = random_int(30000, 200000) + 30000 + $cents;
    $helper->insertIntoLeasing($dauer, $preis);
}

// Auto insertion
$lnr = $helper->getLeasingNR();
for ($i = 0; $i <= 50; $i++) {
    $random = random_int(0, count($lnr) - 1);
    $getter = random_int(0, $dgen->getCarsSize());
    $helper->insertIntoCar($dgen->getMarke($getter), $dgen->getModell($getter), $lnr[$random], $fid[$random]);
}
$aid = $helper->getAutoId();
// Mitarbeiter insertion
for ($i = 0; $i < count($fid); $i++) { // workers without bosses
    $randomName = random_int(0, $dgen->getFirstNameSize() - 1);
    $randomSurname = random_int(0, $dgen->getSurnameSize() - 1);
    $helper->insertIntoEmployee($dgen->getFirstName($randomName), $dgen->getSurname($randomSurname), $fid[$i], null); // in every location/filiale will be one boss
} {
    $filialAndMitarbeiter = $helper->getFidMid();
    for ($i = 0; $i < count($fid); $i++) {
        for ($j = 0; $j < 5; $j++) {
            $randomName = random_int(0, $dgen->getFirstNameSize() - 1);
            $randomSurname = random_int(0, $dgen->getSurnameSize() - 1);
            $helper->insertIntoEmployee($dgen->getFirstName($randomName), $dgen->getSurname($randomSurname), $fid[$i], $filialAndMitarbeiter[$i]);
        }
    }
}

// hat insert
$numbers = array();
foreach ($helper->getFid() as $i => $value) {
    $numbers = array();
    for ($j = 0; $j <= 30; $j++) {
        $random = random_int(0, count($aid) - 1);
        while (in_array($random, $numbers)) {
            $random = random_int(0, count($aid) - 1);
        }
        $numbers[] = $random;
        $helper->insertIntoHat($fid[$i], $aid[$random]);
    }
}

// Verkauft insert
$mid = $helper->getMitarbeiterId();
$usedNumbers = array();
for ($i = 0; $i < 500; $i++) {
    $preis = (random_int(20000, 200000)) * 100 / 100.00;
    $randomMitarbeiter = random_int(0, count($mid) - 1);
    $randomAuto = random_int(0, count($aid) - 1);
    while (in_array($randomAuto, $usedNumbers)) {
        $randomAuto = random_int(0, count($aid) - 1);
    }
    $usedNumbers[] = $randomAuto;
    $date = (random_int(2012, 2022)) . "-" . (random_int(1, 12)) . "-" . (random_int(1, 28));
    $helper->insertIntoVerkauft($mid[$randomMitarbeiter], $aid[$randomAuto], $preis, $date);
}
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