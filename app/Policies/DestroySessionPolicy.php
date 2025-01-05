<?php

namespace App\Policies;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class DestroySessionPolicy
{
    public function destroy()
    {
        // Destroy the session
        Session::flush();

        // Clear the cache
        Cache::flush();

        // Regenerate the session ID
        session()->regenerate(true);

        // Clear the cookies
        foreach ($_COOKIE as $key => $value) {
            setcookie($key, '', time() - 3600, '/');
        }

        // Set cache control headers to prevent caching
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        return true;
    }
}
