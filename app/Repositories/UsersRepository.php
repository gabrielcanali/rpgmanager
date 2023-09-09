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

    /**
    * Create a new User
    *
    * 
    * @param array $userData 
    * [  
    *   'status' => (boolean)  
    *   'display_name' => (string, max:40)  
    *   'email' => (string, max:80)  
    *   'password' => (string, max:60)  
    *   'password_confirmation' => (string, confirmed)  
    *   'profile_image' => (file, mimes:png,jpg)  
    * ]
    */
    public function createUser(array $userData) 
    {
        // TODO: encrypt password
        return Users::create($userData);
    }

    public function updateUser($userId, array $newUserData) 
    {
        return Users::whereId($userId)->update($newUserData);
    }
}