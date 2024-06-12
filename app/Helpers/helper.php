<?php

use Illuminate\Support\Str;
use App\Models\CompanyDetail;
use Illuminate\Http\JsonResponse;

/**
 * Encrypts a string using a salt key.
 *
 * @param string $string The string to be encrypted.
 *
 * @return string|array If successful, returns the encrypted string. 
 *                      If no string provided, returns an array with status false and an error message.
 */
if (!function_exists('salt_encrypt')) {
    function salt_encrypt($string)
    {
        //return $string;
        if (!empty($string)) {
            $encrypted = encrypt(env('SALT_KEY') . $string);
            return $encrypted;
        } else {
            return [
                'status' => false,
                'message' => 'Error: Please provide string to be decrypted.'
            ];
        }
    }
}

/**
 * Decrypts an encrypted string, removing the salt key from it.
 *
 * @param string $string The encrypted string to be decrypted.
 *
 * @return string|array If successful, returns the decrypted string. 
 *                      If no encrypted string provided, returns an array with status false and an error message.
 */
if (!function_exists('salt_decrypt')) {
    function salt_decrypt($string)
    {
        //return $string;
        if (!empty($string)) {
            $decrypted = decrypt($string);
            $mainString = str_replace(env('SALT_KEY'), '', $decrypted);
            return $mainString;
        } else {
            return [
                'status' => false,
                'message' => 'Error: Please provide encrypted string.'
            ];
        }
    }
}

/**
 * Prints the human-readable representation of a variable and exits the script.
 *
 * This function is useful for debugging purposes to print out the contents of a variable
 * in a human-readable format and then exit the script execution.
 *
 * @param mixed $string The variable to be printed.
 *
 * @return void This function does not return a value.
 */
if (!function_exists('printR')) {
    function printR($string)
    {
        echo '<pre>';
        print_r($string);
        echo '</pre>';
        exit;
    }
}

if (!function_exists('generateUniqueCompanyUsername')) {
    function generateUniqueCompanyUsername($companyName)
    {
        // Extract the initials
        $username = '';
        $words = explode(' ', $companyName);
        foreach ($words as $word) {
            $username .= strtoupper($word[0]);
        }
        $counter = 1;
        $originalUsername = $username;

        // Ensure the username is unique
        while (CompanyDetail::where('display_name', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        return $username;
    }



    // Function to convert an image to a Base64-encoded string
    function convertImageToBase64($imagePath)
    {
        // Check if the file exists
        if (file_exists($imagePath)) {
            // Get the image content
            $imageData = file_get_contents($imagePath);

            // Encode the image content in Base64
            $base64Image = base64_encode($imageData);

            // Get the image type
            $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);

            // Return the Base64 encoded image with the appropriate data URL prefix
            return 'data:image/' . $imageType . ';base64,' . $base64Image;
        } else {
            // Handle the error if the file does not exist
            return null;
        }
    }

    /**
     * Generate an error response.
     *
     * @param string $message
     * @return JsonResponse
     */
    function errorResponse(string $message): JsonResponse
    {
        $parts = explode("-", $message);
        $key = '';
        if (!empty($parts)) {
            $message = $parts[0];
            $key = $parts[1] ?? null;
        }
        $response = [
            'statusCode' => __('statusCode.statusCode422'),
            'status' => __('statusCode.status422'),
            'message' => $message
        ];
        if ($key) {
            $response['key'] = trim($key);
        }
        return response()->json(['data' => $response], __('statusCode.statusCode200'));
    }

    /**
     * Generate a success response.
     *
     * @param int|null $id
     * @return JsonResponse
     */
    function successResponse(int $id = null, array $data = null): JsonResponse
    {
        $response = [
            'statusCode' => __('statusCode.statusCode200'),
            'status' => __('statusCode.status200'),
            'message' => __('auth.registerSuccess'),
        ];

        if ($id) {
            $response['id'] = $id;
        }
        if ($data) {
            $response['data'] = $data;
        }

        return response()->json(['data' => $response],  __('statusCode.statusCode200'));
    }
}
