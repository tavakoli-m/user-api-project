<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }
    public function getAllUsers($query = null)
    {
        return $this->userRepository->GetAllUsers($query);
    }
    public function getUser(User $user)
    {
        return $this->userRepository->GetUser($user);
    }
    public function addNewUser(array $inputs)
    {
        return $this->userRepository->AddNewUser($inputs);
    }
    public function updateUser(User $user,array $inputs)
    {
        return $this->userRepository->UpdateUser($user,$inputs);
    }
    public function deleteUser(User $user)
    {
        return $this->userRepository->DeleteUser($user);
    }
}
