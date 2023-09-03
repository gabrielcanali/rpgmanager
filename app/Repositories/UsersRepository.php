<?php

namespace App\Repositories;

use App\Interfaces\UsersRepositoryInterface;
use App\Models\Users;

class UsersRepository implements UsersRepositoryInterface 
{
    public function getAllUsers()
    {
        return Users::all();
    }

    public function getUserById($userId) 
    {
        return Users::findOrFail($userId);
    }

    public function deleteUser($userId) 
    {
        Users::destroy($userId);
    }

    public function createUser(array $userData) 
    {
        return Users::create($userData);
    }

    public function updateUser($userId, array $newUserData) 
    {
        return Users::whereId($userId)->update($newUserData);
    }
}