<?php

class Booking
{
    private $customerID;
    private $carID;
    private $startDate;
    private $endDate;
    private $totalCost;
    private $status;

    public function __construct($customerID, $carID, $startDate, $endDate, $totalCost)
    {
        $this->customerID = $customerID;
        $this->carID = $carID;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->totalCost = $totalCost;
        $this->status = "Pending";
    }

    public function getCustomerID()
    {
        return $this->customerID;
    }

    public function getCarID()
    {
        return $this->carID;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function getTotalCost()
    {
        return $this->totalCost;
    }

    public function confirm()
    {
        $this->status = "Confirmed";
    }

    public function cancel()
    {
        $this->status = "Cancelled";
    }

    public function calculateTotalCost($rentalPrice)
    {
        $start = new DateTime($this->startDate);
        $end = new DateTime($this->endDate);
        $days = $start->diff($end)->days;
        return $days * $rentalPrice;
    }

    public function getStatus()
    {
        return $this->status;
    }
}