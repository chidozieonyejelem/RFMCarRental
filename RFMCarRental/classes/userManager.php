<?php

class userManager {
    private $users = [];

    public function addUser($user) {
        $this->users[] = $user;
    }

    public function getAllUsers() {
        return $this->users;
    }

    public function findUserByEmail($email) {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }
        return null;
    }
}