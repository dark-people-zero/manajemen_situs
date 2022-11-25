<?php

use Illuminate\Support\Facades\Http;

if (!function_exists("DO_purge")) {
    function DO_purge($dirFile) {
        return env("DO_CDN_ENDPOINT");
        return Http::asJson()->delete(
            env("DO_CDN_ENDPOINT") . '/cache',
            [
                'files' => ["{$dirFile}"],
            ]
        );
    }
}
