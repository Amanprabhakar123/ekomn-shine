<?php

namespace App\Http\Controllers\APIAuth;

use App\Models\User;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['verify']]);
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    
    /**
     * @OA\Post(
     *     path="/api/resend",
     *     tags={"Authentication"},
     *     summary="Resend email verification",
     *     operationId="resend",
     *     @OA\Response(
     *         response=200,
     *         description="Email verification resent successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="statusCode", type="integer", example=200),
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="message", type="string", example="Email verification resent successfully."),
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             @OA\Property(property="statusCode", type="integer", example=403),
     *             @OA\Property(property="status", type="string", example="Forbidden"),
     *             @OA\Property(property="message", type="string", example="Email already verified."),
     *         )
     *     ),
     * )
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'message' => __('auth.verified')
            ]], __('statusCode.statusCode200'));
        }
        $request->user()->sendEmailVerificationNotification();

        return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'message' => __('auth.verify')
        ]], __('statusCode.statusCode200'));
    }

    
    /**
     * @OA\Post(
     *     path="/api/verify",
     *     tags={"Authentication"},
     *     summary="Verify a user's email",
     *     operationId="verify",
     *     @OA\RequestBody(
     *         required=true,
     *         description="User verification data",
     *         @OA\JsonContent(
     *             required={"id","hash"},
     *             @OA\Property(property="id", type="string", format="text", example="1bfb1ee10a846b6003b057333bc7292ef3540e27"),
     *             @OA\Property(property="hash", type="string", format="text", example="5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Email verified successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="statusCode", type="integer", example=200),
     *             @OA\Property(property="status", type="string", example="OK"),
     *             @OA\Property(property="verified", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Email verified successfully."),
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             @OA\Property(property="statusCode", type="integer", example=403),
     *             @OA\Property(property="status", type="string", example="Forbidden"),
     *             @OA\Property(property="message", type="string", example="Invalid verification data."),
     *         )
     *     ),
     * )
     */
    public function verify(Request $request)
    {
        $user = User::find(salt_decrypt($request->id));
        $redirect = $user->hasRole(User::ROLE_SUPPLIER) ? route('supplier.login') : route('buyer.login');

        if (! hash_equals((string) salt_decrypt($request->id), (string)  $user->id)) {
            return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode403'),
            'status' => __('statusCode.status403'),
            'message' => __('auth.invalidVerificationData')
            ]], __('statusCode.statusCode403'));
        }

        if (! hash_equals((string) $request->hash, sha1($user->getEmailForVerification()))) {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode403'),
                'status' => __('statusCode.status403'),
                'message' => __('auth.invalidVerificationData')
                ]], __('statusCode.statusCode403'));
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode200'),
                'status' => __('statusCode.status200'),
                'redirect' => $redirect,
                'verified' => true,
                'message' =>  __('auth.verified')
            ]], __('statusCode.statusCode200'));
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            // Send the welcome email
            Mail::to($user->email)->send(new WelcomeEmail($user));
        }
        return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'redirect' => $redirect,
            'verified' => true,
            'message' =>  __('auth.verifySuccess')
        ]], __('statusCode.statusCode200'));
    }
}