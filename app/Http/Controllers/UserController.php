<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions;

class UserController extends Controller
{
    public function authenticate(Request $request): JsonResponse
    {
        $credentials = $request->only("email","password");
        try {
            if(! $token = JWTAuth::attempt($credentials)){
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        }catch (JWTException $e){
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    public function getAuthenticatedUser(Request $req): JsonResponse
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
//        $user2 = auth()->user();

        return response()->json(compact('user'));

    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos'=> 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'rol' => 'required|integer',
            'password' => 'required|string|min:6',
            'rut'=> 'required|integer'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = new User;
        $user->id = $request->get('rut');
        $user->nombres =  $request->get('nombres');
        $user->apellidos =  $request->get('apellidos');
        $user->email = $request->get('email');
        $user->rol = $request->get('rol');
        $user->estado = 1;
        $user->password =  Hash::make($request->get('password'));

        $user->save();
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user','token'),201);
    }
}


