<?php

namespace App\Utils;

use Illuminate\Support\Str;

/**
 * Provides utilities to generate difference ids.
 */
class IDGenerator
{
    /**
     * Generate unique user id.
     *
     * @return string
     */
    public static function uuid()
    {
        return Str::uuid();
    }

    /**
     * Generate unique order id.
     *
     * @return string
     */
    public static function ouid()
    {
        return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

}
