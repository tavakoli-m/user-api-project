<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function GetAllUsers($query = null)
    {
        return User::search($query)->orderByDesc('created_at')->paginate(50);
    }
    public function GetUser(User $user)
    {
        return $user;
    }
    public function AddNewUser(array $inputs)
    {
        $inputs['password'] = Hash::make($inputs['password']);
        return User::create($inputs);
    }
    public function UpdateUser(User $user,array $inputs)
    {
        if(isset($inputs['password']))
            $inputs['password'] = Hash::make($inputs['password']);
        $user->update($inputs);
        return $user;
    }
    public function DeleteUser(User $user)
    {
        return $user->delete();
    }
}
