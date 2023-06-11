<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

/**
     * Log in .
     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }

/**
     * Register .
     */

     public function register(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'name' => 'required|string|between:2,100',
             'email' => 'required|string|email|max:100|unique:users',
             'password' => 'required|string|min:6',
         ]);
     
         if ($validator->fails()) {
             return response()->json($validator->errors()->toJson(), 400);
         }
     
         $requestData = $request->all();
     
         if ($request->hasFile('image') && $request->file('image')->isValid()) {
             $fileName = time() . $request->file('image')->getClientOriginalName();
             $path = $request->file('image')->storeAs('images', $fileName, 'public');
             $requestData["image"] = '/storage/' . $path;
         } else {
             $requestData["image"] = null; // Set the image to null if not provided
         }
     
         $user = User::create([
             'name' => $request->name,
             'email' => $request->email,
             'password' => Hash::make($request->password),
             'location' => $request->location,
             'image' => $requestData["image"],
         ]);
     
         $token = auth()->login($user);
     
         return response()->json([
             'status' => 'success',
             'message' => 'User created successfully',
             'user' => $user,
             'authorization' => [
                 'token' => $token,
                 'type' => 'bearer',
             ],
         ]);
     }
     

    /**
     * Log out .
     */

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    // public function refresh()
    // {
    //     return response()->json([
    //         'status' => 'success',
    //         'user' => Auth::user(),
    //         'authorisation' => [
    //             'token' => Auth::refresh(),
    //             'type' => 'bearer',
    //         ]
    //     ]);
    // }

    }