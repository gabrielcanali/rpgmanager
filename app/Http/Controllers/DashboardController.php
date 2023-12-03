<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
    * Autenticação Login
    * 
    * @param Request $request
    */
    public function authenticate(Request $request)
    {
        if (!$request) {
            return response()->json([
                'error' => 'Credenciais não informadas.'
            ], 400);
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('DASHBOARD_ACCESS_TOKEN', time());
            
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'E-mail e/ou senha incorretos. Tente novamente.',
        ])->onlyInput('email');
    }

    
    /**
    * Logout do Usuário
    */
    public function logout()
    {
        if (Auth::user() && session()->get('DASHBOARD_ACCESS_TOKEN')) {
            Auth::logout();
            session()->forget('DASHBOARD_ACCESS_TOKEN');
        }
        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
