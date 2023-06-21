<?php

class DataGenerator
{
    private $firstNames = [
        "John", "Emma", "Michael", "Sophia", "Robert", "Olivia", "David", "Ava", "William", "Mia"
    ];
    private $lastNames =  [
        "Smith", "Johnson", "Brown", "Davis", "Miller", "Wilson", "Moore", "Taylor", "Anderson", "Jackson"
    ];
    private $addresses = [];
    private $cars = [
        "BMW" => "M3",
        "Mercedes" => "C-Class",
        "Audi" => "A4",
        "Toyota" => "Camry",
        "Honda" => "Accord",
        "Ford" => "Mustang",
        "Chevrolet" => "Camaro",
        "Volkswagen" => "Golf",
        "Nissan" => "Altima",
        "Mazda" => "CX-5"
    ];
    private $citiesAndCountries = [
        "Turkey" => "Istanbul",
        "United States" => "New York",
        "United Kingdom" => "London",
        "France" => "Paris",
        "Germany" => "Berlin",
        "Italy" => "Rome",
        "Spain" => "Madrid",
        "Canada" => "Toronto",
        "Australia" => "Sydney",
        "Japan" => "Tokyo"
    ];

    public function __construct()
    {
        $this->fillAddresses();
    }

    private function fillAddresses()
    {
        for ($i = 1; $i <= 100; $i++) {
            $this->addresses[] = "Address " . $i;
        }
    }

    public function getRandomAddress()
    {
        $randomIndex = rand(0, count($this->addresses) - 1);
        return $this->addresses[$randomIndex];
    }

    public function getCitiesAndCountriesSize()
    {
        return count($this->citiesAndCountries);
    }

    public function getCountry($index)
    {
        $countries = array_keys($this->citiesAndCountries);
        return $countries[$index];
    }

    public function getCity($index)
    {
        $cities = array_values($this->citiesAndCountries);
        return $cities[$index];
    }

    public function getCarsSize()
    {
        return count($this->cars);
    }

    public function getMarke($index)
    {
        $carBrands = array_keys($this->cars);
        return $carBrands[$index];
    }

    public function getModell($index)
    {
        $carModels = array_values($this->cars);
        return $carModels[$index];
    }

    public function getFirstName($index)
    {
        $randomIndex = rand(0, count($this->firstNames) - 1);
        return $this->firstNames[$randomIndex];
    }

    public function getFirstNameSize()
    {
        return count($this->firstNames);
    }

    public function getSurname($index)
    {
        $randomIndex = rand(0, count($this->lastNames) - 1);
        return $this->lastNames[$randomIndex];
    }

    public function getSurnameSize()
    {
        return count($this->lastNames);
    }
}
