<?php

namespace App\Interfaces;

interface UsersRepositoryInterface 
{
    public function getAllUsers();
    public function getUserById($userId);
    public function deleteUser($userId);
    public function createUser(array $userData);
    public function updateUser($userId, array $newUserData);
}
