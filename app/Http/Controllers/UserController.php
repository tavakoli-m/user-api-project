<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserDetailsApiResource;
use App\Http\Resources\User\UsersListApiResourceCollection;
use App\Http\Services\ApiResponse\Facades\ApiResponse;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private readonly UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = $this->userService->getAllUsers($request->get('query'));

        return ApiResponse::withStatus(200)->withAppends(['result' => new UsersListApiResourceCollection($users)])->send();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->addNewUser($request->validated());

        return ApiResponse::withStatus(201)->withAppends(['result' => new UserDetailsApiResource($user)])->send();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = $this->userService->getUser($user);

        return ApiResponse::withStatus(200)->withAppends(['result' => new UserDetailsApiResource($user)])->send();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user = $this->userService->updateUser($user, $request->validated());

        return ApiResponse::withStatus(200)->withAppends(['result' => new UserDetailsApiResource($user)])->send();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $result = $this->userService->deleteUser($user);

        return ApiResponse::withStatus(200)->withAppends([])->send();
    }
}
