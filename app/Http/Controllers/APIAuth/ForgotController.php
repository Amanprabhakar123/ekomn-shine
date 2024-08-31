<?php

namespace App\Http\Controllers\APIAuth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class   ForgotController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function __construct()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/password/forget",
     *     summary="Send password reset link email",
     *     description="Send a password reset link email to the user",
     *     tags={"Password Reset"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password reset link sent successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Password reset link sent successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", example={"email": {"The email field is required."}})
     *         )
     *     )
     * )
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // check if the email belongs to a supplier or buyer
        $user = User::where('email', $request->email)->first();

        // if ($user && $user->hasAnyRole([User::ROLE_SUPPLIER, User::ROLE_BUYER])) {
        if ($user) {
            // User exists and has the role of supplier or buyer
            // Proceed with sending the password reset link
            $response = Password::sendResetLink(
                $request->only('email')
            );
            return $response == Password::RESET_LINK_SENT
                ? $this->sendResetLinkResponse($request, $response)
                : $this->sendResetLinkFailedResponse($request, $response);
        } else {
            // User does not exist or does not have the role of supplier or buyer
            // Return an error response
            return response()->json(['data' => [
                'statusCode' => __('statusCode.statusCode422'),
                'status' => __('statusCode.status422'),
                'message' => trans('validation.email', ['attribute' => 'email'])
            ]], __('statusCode.statusCode400'));
        }

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = Password::sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'message' =>  trans("An email has been sent to ".$request->email.". If this email address is registered to Ekomn.com, you'll receive instructions on how to set a new password.")
        ]], __('statusCode.statusCode200'));
    }


    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json(['data' => [
            'statusCode' => __('statusCode.statusCode400'),
            'status' => __('statusCode.status400'),
            'message' => trans($response)
        ]], __('statusCode.statusCode400'));
    }
}
