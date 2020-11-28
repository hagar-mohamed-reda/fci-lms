<?php

namespace App\helpers;

use App\Translation;

if (!function_exists('trans')) {

    /**
     * Translate the given message.
     *
     * @param  string|null  $key
     * @param  array   $replace
     * @param  string|null  $locale
     * @return \Illuminate\Contracts\Translation\Translator|string|array|null
     */
    function trans($key = null, $replace = [], $locale = null) {
        $word = $key;
        // prepare key
        $key = strtolower($key);
        $key = str_replace(" ", "_", $key);

        // my code for translation
        try {
            $translation = Translation::where('key', $key)->first();

            if ($translation) {
                $translate = (app()->getLocale() == 'ar') ? $translation->word_ar : $translation->word_en;

                if ($translate)
                    return $translate;
            } else {
                Translation::create([
                    "key" => $key,
                    "word_en" => $word
                ]);
            }
        } catch (\Exception $exc) {
            //
        }



        return $word;
    }

    if (function_exists('__')) {

        function __($key = null, $replace = [], $locale = null) {
            return trans($key, $replace, $locale);
        }

    }
}


if (!function_exists('randamToken')) {

    /**
     * random token every milisecond encrypted
     * @return type String
     */
    function randamToken() {
        // time in mili seconds
        $timeInMiliSeconds = (int) round(microtime(true) * 1000);

        // random number with 8 digit
        $randKey1 = rand(11111111, 99999999);

        // token
        $token = $timeInMiliSeconds + $randKey1;

        // convert token to array
        $tokenToArray = str_split($token);

        // shif array
        array_shift($tokenToArray);

        // array to string
        $token = implode("", $tokenToArray);

        // encrypt token
        $cryptedToken = encrypt($token);

        // return token in small size
        $b = json_decode(base64_decode($cryptedToken));

        // return mac attribute
        return $b->mac;
    }

}

