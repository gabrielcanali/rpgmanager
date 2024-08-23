<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\UsersRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
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
     * Display all users account info
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
     * Create user
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
     * Display a user account info
     * 
     * @param int $userId
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
     * Edit user account info
     */
    public function update(Request $request, $userId)
    {
        // TODO: Auth validation

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
     * Delete user account
     */
    public function destroy()
    {
        // TODO: Auth validation AND remove user
    }

    /** 
    * Make user auth
    * 
    * @param Request $request
    */
    public function authenticate(Request $request)
    {
        $credentials = $request->all(['email', 'password']);

        if (!$request) {
            return response()->json([
                'error'   => true,
                'message' => 'Credenciais não informadas.'
            ], 400);
        }

        $validator = Validator::make($credentials, [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if($validator->fails()) {
            return response()->json([
                'error'   => true,
                'message' => $validator->messages()->first()
            ], 400);
        }

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('DASHBOARD_ACCESS_TOKEN', time() . '-' . Str::uuid());
            
            // TODO: 
            // - Log info login
            // - Create session data ?
            
            return response()->json([
                'success'  => true,
                'redirect' => route('dashboard')
            ], 200);
        }

        return response()->json([
            'error'   => true,
            'message' => 'E-mail e/ou senha incorretos. Tente novamente.'
        ], 400);
    }
}
