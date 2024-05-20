<?php

if(! function_exists('salt_encrypt')){
    function salt_encrypt($string){
        //return $string;
        if(!empty($string)){
            $encrypted = encrypt(env('SALT_KEY').$string);
            return $encrypted;
        }else{
            return [
                'status'    => false,
                'message'   => 'Error: Please provide string to be decrypted.'
            ];
        }
    }
}
if(! function_exists('salt_decrypt')){
    function salt_decrypt($string){
        //return $string;
        if(!empty($string)){
            $decrypted = decrypt($string);
            $mainString = str_replace(env('SALT_KEY'), '', $decrypted);
            return $mainString;
        }else{
            return [
                'status'    => false,
                'message'   => 'Error: Please provide encrypted string.'
            ];
        }
    }
}
