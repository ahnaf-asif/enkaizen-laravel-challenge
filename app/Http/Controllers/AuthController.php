<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $req){
//        return $req;
        $validation = Validator::make($req->all(), [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:128'
        ]);

        if($validation->fails()){
            return response()->json(['errors' => $validation->errors(), 'error' => true]);
        }

        $user = new User;

        $user -> name = $req->name;
        $user -> email = $req->email;
        $user -> password = bcrypt($req->password);

        $user->save();

        return $user;
    }

    /**
     * @throws AuthenticationException
     */
    public function login(Request $req){
        if(!Auth::attempt($req->only('email','password'))){
            throw new AuthenticationException();
        }
        $user = User::where('email', $req->email)->first();

        return $user->createToken('browser')->plainTextToken;

    }
    public function logout(Request $req){
        Auth::logout();
        $req -> session() -> invalidate();
        $req -> session() -> regenerateToken();
    }
}
