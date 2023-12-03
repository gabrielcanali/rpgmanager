<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\UsersRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersControllerApi extends Controller
{
    private UsersRepositoryInterface $userRepository;

    public function __construct(UsersRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            return response()->json([
                'users' => $this->userRepository->getAllUsers()
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userData = $request->all();

        $rules = [
            'status'                => ['nullable'],
            'display_name'          => ['required', 'unique:users', 'max:40'],
            'email'                 => ['required', 'email', 'unique:users', 'max:80'],
            'password'              => ['required', 'confirmed', 'max:60'],
            'profile_image'         => ['nullable', 'file', 'mimes:png,jpg', 'dimensions:max_width=800,max_height=800', 'max:1000']
        ]; 

        $validator = Validator::make($userData, $rules);

        if($validator->fails()) {
            return response()->json([
                'error' => $validator->messages()
            ]);
        }

        try {
            $createdUserData = $this->userRepository->createUser($userData);
            return response()->json([
                'user' => $createdUserData
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($userId): JsonResponse
    {
        if (!$userId) {
            return response()->json([
                'error' => 'ID de usuário não informado.'
            ], 400);
        }

        try {
            return response()->json([
                'user' => $this->userRepository->getUserById($userId)
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Usuário não encontrado.'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $userId)
    {
        if (!$userId) {
            return response()->json([
                'error' => 'ID de usuário não informado.'
            ], 400);
        }

        $newUserData = $request->all();

        $rules = [
            'status'                => ['required'],
            'display_name'          => ['required', Rule::unique('users')->ignore($userId), 'max:40'],
            'email'                 => ['required', Rule::unique('users')->ignore($userId), 'max:80'],
            'password'              => ['required', 'confirmed', 'max:60'],
            'profile_image'         => ['nullable', 'file', 'mimes:png,jpg', 'dimensions:max_width=800,max_height=800', 'max:1000']
        ]; 

        $validator = Validator::make($newUserData, $rules);

        if($validator->fails()) {
            return response()->json([
                'error' => $validator->messages()
            ]);
        }

        try {
            $updatedUserData = $this->userRepository->updateUser($userId, $newUserData);
            return response()->json([
                'user' => $updatedUserData
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
