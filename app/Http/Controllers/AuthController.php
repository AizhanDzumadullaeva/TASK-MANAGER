<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            ] );

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)]);
                
                return response()->json(['message' => 'User registered', 'user'=>$user]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !
        Hash::check($request->password, $user->password)) {
            throw 
        ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }
        return response()->json(['message'=>'Login successful', 'user'=>$user]);
    }
}