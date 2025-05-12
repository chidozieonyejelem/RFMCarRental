<?php

class CarManager
{
    private $cars = [];

    public function addCar(Car $car)
    {
        $this->cars[] = $car;
    }

    public function getAllCars()
    {
        return $this->cars;
    }

    public function searchCars($keyword)
    {
        $results = [];
        foreach ($this->cars as $car) {
            if (stripos($car->getMake(), $keyword) !== false || stripos($car->getModel(), $keyword) !== false) {
                $results[] = $car;
            }
        }
        return $results;
    }
}