<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\UsersRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

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
            'status'                => ['required'],
            'display_name'          => ['required', 'unique:users', 'max:40'],
            'email'                 => ['required', 'unique:users', 'max:80'],
            'password'              => ['required', 'confirmed', 'max:60'],
            'profile_image'         => ['nullable', 'file', 'mimes:png,jpg']
        ]; 

        $validator = Validator::make($userData, $rules);

        if($validator->fails()) {
            return response()->json([
                'error' => $validator->messages()
            ]);
        }

        try {
            $createdUser = $this->userRepository->createUser($userData);
            return response()->json([
                'user' => $createdUser
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
    public function show()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
