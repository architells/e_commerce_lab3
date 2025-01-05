<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Policies\DestroySessionPolicy;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->roles->contains('role_name', 'Admin')) {
            return redirect()->intended('/dashboard');
        } elseif ($user->roles->contains('role_name', 'Customer')) {
            return redirect()->intended('/customer');
        }

        return redirect()->intended('/home');
    }

    public function logout(Request $request)
    {
        // Log out the user
        $this->guard()->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate session token
        $request->session()->regenerateToken();

        // Clear all session data
        $request->session()->flush();

        // Clear any user-specific cache
        cache()->flush();

        // Apply additional security headers to prevent caching
        return response()
            ->redirectTo('/')
            ->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Thu, 01 Jan 1970 00:00:00 GMT',
            ]);
    }


    protected function loggedOut(Request $request)
    {
        return redirect('/');
    }
}
