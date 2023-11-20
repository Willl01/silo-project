<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


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
    protected function authenticated(Request $request, $user)
    {
        if ($user->role == 'admin') {
            return redirect('admin');
        } elseif ($user->role == 'dokter') {
            return redirect('/');
        }
        return redirect('/');
    }

    public function login(Request $request)
    {
        if (Auth::guard('web')->attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $user = Auth::guard('web')->user();
    
            if ($user->role == $request['role']) {
                // Role cocok, lanjutkan
                if (isset($request['remember']) && !empty($request['remember'])) {
                    setcookie("email", $request['email'], time() + 120);
                    setcookie("role", $request['role'], time() + 120);
                    setcookie("password", $request['password'], time() + 120);
                }
            } else {
                // Role tidak cocok, logout dan tampilkan pesan kesalahan
                Auth::guard('web')->logout();
                    return redirect()->back()->withInput()->withErrors(['role' => 'Role tidak sesuai.']);
            }
        } else {
            setcookie("email", "");
            setcookie("role", "");
            setcookie("password", "");
    
            return redirect()->back()->withInput()->withErrors(['email' => 'Email atau password salah.']);
        }
    
        return redirect('/admin');
    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
