<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Classes\Helpers\Roles\Helper;


class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = '/admin/home';

    protected $_helper;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest_admin')->except('logout');
        $this->_helper = new Helper();
    }

    public function showLoginForm(){
        return view('admin.auth.login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            /* Login Date Update */
            $admin = Auth::guard('admin')->getUser();
            $admin->last_login_date = !empty( $admin->current_login_date ) ? $admin->current_login_date : \DateFacades::getCurrentDateTime('format-1');
            $admin->current_login_date = \DateFacades::getCurrentDateTime('format-1');
            $admin->save();

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function credentials(Request $request)
    {
        $adminRoleId = $this->_helper->getAdminRoleId();
        return array_merge(
            $request->only($this->username(), 'password'),['role_id' => $adminRoleId,'status' => 1]
        );
    }

    public function logout(Request $request)
    {
        $this->guard('admin')->logout();
        $request->session()->invalidate();
        return redirect('/admin_login');
    }
}
