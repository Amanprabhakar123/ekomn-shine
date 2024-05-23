<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from the Google authentication.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function handleGoogleCallback()
    {
        try {
            // Get the user information from Google
            $user = Socialite::driver('google')->stateless()->user();

            // Check if the user already exists in the database
            $finduser = User::where('email', $user->email)->first();

            // If the user exists, log them in and redirect to the intended page
            if ($finduser) {
                // Generate a JWT token for the existing user
                $token = JWTAuth::fromUser($finduser);
                
                if(config('app.front_end_tech') == false){
                    Auth::login($finduser);
                }

                return redirect()->intended('/')->with([
                    'user_details' => [
                            "id" => salt_encrypt($finduser->id),
                            "name" => $finduser->name,
                            "email" => $finduser->email,
                            "email_verified_at" => $finduser->email_verified_at,
                            "picture" => $user->avatar,
                    ], 'token' =>  $token]);

                // Return the token in the response
                // return response()->json(['data' => [
                //     'statusCode' => __('statusCode.statusCode200'),
                //     'status' => __('statusCode.status200'),
                //     'message' => trans(__('auth.loginSuccess')),
                //     'auth' => [
                //         'access_token' => $token,
                //         'token_type' => 'bearer',
                //         'expires_in' => auth('api')->factory()->getTTL() * 60,
                //         'user' => [
                //             "id" => salt_encrypt($finduser->id),
                //             "name" => $finduser->name,
                //             "email" => $finduser->email,
                //             "email_verified_at" => $finduser->email_verified_at,
                //         ]
                //     ],
                // ]], __('statusCode.statusCode200'));
            } else {
                // If the user does not exist, create a new user with the Google information
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'picture' => $user->avatar,
                    'password' => Hash::make(Str::random(10))
                ]);

                // Add supplier role to the new user
                $newUser->assignRole(User::ROLE_SUPPLIER);

                // Generate a JWT token for the new user
                $token = JWTAuth::fromUser($newUser);

                if(config('app.front_end_tech') == false){
                    Auth::login($newUser);
                }

                return redirect()->intended('/')->with([
                    'user_details' => [
                            "id" => salt_encrypt($newUser->id),
                            "name" => $newUser->name,
                            "email" => $newUser->email,
                            "email_verified_at" => $newUser->email_verified_at,
                            "picture" => $user->avatar,
                    ], 'token' =>  $token]);

                 // Return the token in the response
                // return response()->json(['data' => [
                //     'statusCode' => __('statusCode.statusCode200'),
                //     'status' => __('statusCode.status200'),
                //     'message' => trans(__('auth.loginSuccess')),
                //     'auth' => [
                //         'access_token' => $token,
                //         'token_type' => 'bearer',
                //         'expires_in' => auth('api')->factory()->getTTL() * 60,
                //         'user' => [
                //             "id" => salt_encrypt($finduser->id),
                //             "name" => $finduser->name,
                //             "email" => $finduser->email,
                //             "email_verified_at" => $finduser->email_verified_at,
                //         ]
                //     ],
                // ]], __('statusCode.statusCode200'));
            }
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the authentication process
            return response()->json(['error' => $e->getMessage(), '-Line'.$e->getLine()], 500);
        }
    }
}
