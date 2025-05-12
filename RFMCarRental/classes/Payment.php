<?php

class Payment
{
    private $bookingID;
    private $customerID;
    private $amount;
    private $paymentStatus;

    public function __construct($bookingID, $customerID, $amount)
    {
        $this->bookingID = $bookingID;
        $this->customerID = $customerID;
        $this->amount = $amount;
        $this->paymentStatus = "Completed";
    }

    public function getBookingID()
    {
        return $this->bookingID;
    }

    public function getCustomerID()
    {
        return $this->customerID;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function refund()
    {
        $this->paymentStatus = "Refunded";
    }

    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }
}