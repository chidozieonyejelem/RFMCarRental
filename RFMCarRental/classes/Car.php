<?php

class Car
{
    private $make;
    private $model;
    private $year;
    private $regNumber;
    private $rentalPrice;
    private $availabilityStatus;
    private $image;
    private $description;

    public function __construct($make, $model, $year, $regNumber, $rentalPrice, $availabilityStatus, $image = '', $description = '')
    {
        $this->make = $make;
        $this->model = $model;
        $this->year = $year;
        $this->regNumber = $regNumber;
        $this->rentalPrice = $rentalPrice;
        $this->availabilityStatus = $availabilityStatus;
        $this->image = $image;
        $this->description = $description;
    }

    public function getMake()
    {
        return $this->make;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getRegNumber()
    {
        return $this->regNumber;
    }

    public function getRentalPrice()
    {
        return $this->rentalPrice;
    }

    public function updateAvailability($status)
    {
        $this->availabilityStatus = $status;
    }

    public function getAvailabilityStatus()
    {
        return $this->availabilityStatus;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getDescription()
    {
        return $this->description;
    }
}