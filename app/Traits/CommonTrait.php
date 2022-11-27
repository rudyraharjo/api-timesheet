<?php

namespace App\Traits;

trait CommonTrait
{

    // Get Request IP Address
    public function getRequestIP()
    {
        $ip = request()->ip();
        try {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        } catch (\Exception $e) {
        }
        return $ip;
    }
}
