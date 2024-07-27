<?php

namespace App\Http\Controllers\APIAuth;

use App\Events\ExceptionEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    /**
     * Create a new RegisterController instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Authentication"},
     *     summary="Register a new user",
     *     operationId="registerUser",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="User data",
     *
     *         @OA\JsonContent(
     *             required={"name","email","password","password_confirmation"},
     *
     *             @OA\Property(property="name", type="string", format="text", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="role", type="string", format="text", example="role"),
     *             @OA\Property(property="password", type="string", format="password", example="Passw0rd!"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="Passw0rd!"),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="User registered successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjE2LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE1NzYyMzY1NjMsImV4cCI6MTU3NjI0MDE2MywibmJmIjoxNTc2MjM2NTYzLCJqdGkiOiJQcHJnSVZ6YXlWV1BjSXhRIn0.5BvuBxS0z6C1aOvh3y0-8b5zD8EyJexsze1zSeprAAo"),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="statusCode", type="integer", example=400),
     *             @OA\Property(property="status", type="string", example="Bad Request"),
     *             @OA\Property(property="message", type="string", example="The email has already been taken."),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="statusCode", type="integer", example=401),
     *             @OA\Property(property="status", type="string", example="Unauthorized"),
     *             @OA\Property(property="message", type="string", example="These credentials do not match our records."),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="statusCode", type="integer", example=500),
     *             @OA\Property(property="status", type="string", example="Internal Server Error"),
     *             @OA\Property(property="message", type="string", example="An error occurred while processing your request."),
     *         )
     *     ),
     * )
     */
    public function registerUser(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'role' => 'required|string',
                'password' => 'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@_.]).*$/|confirmed',
            ]);
            if ($validator->fails()) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode400'),
                    'status' => __('statusCode.status400'),
                    'message' => $validator->errors()->first(),
                ]], __('statusCode.statusCode400'));
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if ($request->input('role') === User::ROLE_BUYER) {
                $user->assignRole(User::ROLE_BUYER);
            } elseif ($request->input('role') === User::ROLE_SUPPLIER) {
                $user->assignRole(User::ROLE_SUPPLIER);
            }

            DB::commit();

            if (! $token = JWTAuth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json(['data' => [
                    'statusCode' => __('statusCode.statusCode401'),
                    'status' => __('statusCode.status401'),
                    'message' => __('auth.failed'),
                ]], __('statusCode.statusCode401'));
            }

            // Trigger email verification notification
            $user->notify(new VerifyEmail);

            return $this->respondWithToken($token);
        } catch (\Exception $e) {

            // Log the exception details and trigger an ExceptionEvent
            $message = $e->getMessage(); // Get the error message
            $file = $e->getFile(); // Get the file
            $line = $e->getLine(); // Get the line number where the exception occurred
            event(new ExceptionEvent($message, $line, $file)); // Trigger an event with exception details

            DB::rollback();

            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode500'),
                'status' => __('statusCode.status500'),
                'message' => $e->getMessage().$e->getLine(),
            ]], __('statusCode.statusCode500'));
        }
    }

    /**
     * Respond with the authentication token.
     *
     * This function generates a JSON response that includes the authentication token and user information.
     *
     * @param  string  $token  JWT token for the authenticated user.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the token and user information.
     */
    protected function respondWithToken($token)
    {
        if (config('app.front_end_tech') == false) {
            // Get the session ID
            $sessionId = session()->getId();
            $sessionName = session()->getName();

            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.registerSuccess'),
                'auth' => [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'session_id' => $sessionId,
                    'session_name' => $sessionName,
                    'expires_in' => auth('api')->factory()->getTTL() * 60,
                    'user' => [
                        'id' => salt_encrypt(auth()->user()->id),
                        'name' => auth()->user()->name,
                        'email' => auth()->user()->email,
                        'email_verified_at' => auth()->user()->email_verified_at,
                        'picture' => auth()->user()->picture,
                    ],
                ],
            ]], __('statusCode.statusCode200'));
        }

        return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'message' => __('auth.registerSuccess'),
            'auth' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
                'user' => [
                    'id' => salt_encrypt(auth()->user()->id),
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'email_verified_at' => auth()->user()->email_verified_at,
                    'picture' => auth()->user()->picture,
                ],
            ],
        ]], __('statusCode.statusCode200'));
    }
}
