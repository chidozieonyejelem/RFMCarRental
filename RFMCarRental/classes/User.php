<?php

class User
{
    protected $name;
    protected $email;
    protected $password;
    protected $phoneNumber;
    protected $isAdmin;

    public function __construct($name, $email, $password, $phoneNumber, $isAdmin = false)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->phoneNumber = $phoneNumber;
        $this->isAdmin = (int) $isAdmin;
    }

    public function getName() {
        return $this->name;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function isAdmin()
    {
        return $this->isAdmin;
    }
}