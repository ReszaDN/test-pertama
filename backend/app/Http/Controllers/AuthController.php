<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


use App\Models\User;
use App\Http\Controllers\Controller;



class AuthController extends Controller
{


    public function user(Request $request)
    {
        $user = Auth::user(); // Mendapatkan user yang sedang login

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'User retrieved successfully',
        ], Response::HTTP_OK);
    }

    //----------REGISTER----------//
    //     /**
    //  * @OA\Get(
    //  *     path="/api/register",
    //  *     summary="Show All Pekerjaan",
    //  *     @OA\Response(response=200, description="Successful response")
    //  * )
    //  */
    public function register(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);


        //simpan user baru
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // Hashing password
        ]);

        return response()->json(['message' => 'User registered successfully!']);
    }


    //----------LOGIN----------//



    public function login(Request $request)
    {
        //validasi input
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        //periksa ketersediaan akun
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        //buat token untuk pengguna yang login
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        // dd($user);

        $plainTextToken = $user->createToken('access_token')->plainTextToken;

        //pisah token
        [$id, $token] = explode('|', $plainTextToken, 2);

        //berikan response
        return response()->json([
            'id' => $id,
            'accessToken' => $token,
            'token_type' => 'Bearer',
            'jenis_pegawai' => $user['jenis_pegawai'], 
        ]);
    }

    //----------LOGOUT----------//

    public function logout(Request $request)
    {
        // Revoke the user's current token
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    //----------LOGOUT SEMUA PERANGKAT----------//

    // public function logout(Request $request)
    // {
    //     // Revoke all tokens for the authenticated user
    //     $request->user()->tokens()->delete();

    //     return response()->json(['message' => 'Logged out from all devices successfully']);
    // }

}
