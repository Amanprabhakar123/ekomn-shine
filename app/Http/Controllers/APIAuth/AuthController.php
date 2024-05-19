<?php

namespace App\Http\Controllers\APIAuth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }


    /** 
     * @OA\Post(
     *     path="/api/login",
     *     summary="Sign in",
     *     description="Login by email, password",
     *     operationId="authLogin",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *        required=true,
     *        description="Pass user credentials",
     *        @OA\JsonContent(
     *           required={"email","password"},
     *           @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *           @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *        ),
     *     ),
     *     @OA\Response(
     *        response=200,
     *        description="Success",
     *        @OA\JsonContent(
     *           @OA\Property(property="statusCode", type="integer", example="200"),
     *           @OA\Property(property="status", type="string", example="OK"),
     *           @OA\Property(property="message", type="string", example="Logged in successfully"),
     *        )
     *     ),
     *     @OA\Response(
     *        response=400,
     *        description="Bad Request",
     *        @OA\JsonContent(
     *           @OA\Property(property="statusCode", type="integer", example="400"),
     *           @OA\Property(property="status", type="string", example="Bad Request"),
     *           @OA\Property(property="message", type="string", example="Validation Error"),
     *        )
     *     ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *        @OA\JsonContent(
     *           @OA\Property(property="statusCode", type="integer", example="401"),
     *           @OA\Property(property="status", type="string", example="Unauthorized"),
     *           @OA\Property(property="message", type="string", example="Invalid credentials"),
     *        )
     *     ),
     *     @OA\Response(
     *        response=500,
     *        description="Server Error",
     *        @OA\JsonContent(
     *           @OA\Property(property="statusCode", type="integer", example="500"),
     *           @OA\Property(property="status", type="string", example="Server Error"),
     *           @OA\Property(property="message", type="string", example="Server Error"),
     *        )
     *     )
     * )
     */

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%.]).*$/',
            ]);
            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status400'),
                    'message' => $validator->errors()->first()
                ]], __('statusCode.statusCode400'));
            }
            if (!$token = auth()->attempt(request(['email', 'password']))) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode401'),
                    'status' => __('statusCode.status401'),
                    'message' => __('auth.failed')
                ]], __('statusCode.statusCode401'));
            }
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode500'),
                'status' => __('statusCode.status500'),
                'message' => $e->getMessage()
            ]], __('statusCode.statusCode500'));
        }
    }


    /**
     * Get the authenticated user information.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *     path="/api/me",
     *     summary="Get authenticated user",
     *     description="Retrieve the information of the authenticated user.",
     *     operationId="getAuthenticatedUser",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="statusCode", type="string", example="200"),
     *                 @OA\Property(property="status", type="string", example="OK"),
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="integer", example="1"),
     *                     @OA\Property(property="name", type="string", example="John Doe"),
     *                     @OA\Property(property="email", type="string", example="john@example.com"),
     *                     @OA\Property(property="email_verified_at", type="string", format="date-time", example="2022-01-01 12:00:00"),
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated."),
     *         ),
     *     ),
     * )
     */
    public function me()
    {
        return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'user' => [
                "id" => auth()->user()->id,
                "name" => auth()->user()->name,
                "email" => auth()->user()->email,
                "email_verified_at" => auth()->user()->email_verified_at,
            ]
        ]], __('statusCode.statusCode200'));
    }

    /**
     * Logout the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout",
     *     description="Logout the authenticated user.",
     *     operationId="logout",
     *     tags={"Authentication"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="statusCode", type="string", example="200"),
     *                 @OA\Property(property="status", type="string", example="OK"),
     *                 @OA\Property(property="message", type="string", example="Logged out successfully."),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated."),
     *         ),
     *     ),
     * )
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'message' => __('auth.logout')
        ]], __('statusCode.statusCode200'));
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *     path="/api/refresh",
     *     summary="Refresh token",
     *     description="Refresh the authentication token.",
     *     operationId="refreshToken",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="statusCode", type="string", example="200"),
     *                 @OA\Property(property="status", type="string", example="OK"),
     *                 @OA\Property(property="message", type="string", example="Token refreshed successfully."),
     *                 @OA\Property(property="auth", type="object",
     *                     @OA\Property(property="access_token", type="string", example="new_token"),
     *                     @OA\Property(property="token_type", type="string", example="bearer"),
     *                     @OA\Property(property="expires_in", type="integer", example="3600"),
     *                     @OA\Property(property="user", type="object",
     *                         @OA\Property(property="id", type="integer", example="1"),
     *                         @OA\Property(property="name", type="string", example="John Doe"),
     *                         @OA\Property(property="email", type="string", example="john@example.com"),
     *                         @OA\Property(property="email_verified_at", type="string", format="date-time", example="2022-01-01 12:00:00"),
     *                     ),
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated."),
     *         ),
     *     ),
     * )
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }


    /**
     * Responds with a JSON containing the authentication token and user information.
     *
     * @param  string  $token  The authentication token.
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'message' => __('auth.loginSuccess'),
            'auth' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
                'user' => [
                    "id" => auth()->user()->id,
                    "name" => auth()->user()->name,
                    "email" => auth()->user()->email,
                    "email_verified_at" => auth()->user()->email_verified_at,
                ]
            ],
        ]], __('statusCode.statusCode200'));
    }
}
