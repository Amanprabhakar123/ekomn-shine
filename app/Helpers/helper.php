<?php
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
        print_r($string);
        exit;
    }
}



