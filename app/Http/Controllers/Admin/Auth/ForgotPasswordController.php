<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

//Password Broker Facade
use Illuminate\Support\Facades\Password;
use App\Classes\Helpers\Roles\Helper;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    protected $_helper;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest_admin');
        $this->_helper = new Helper();
    }

    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email');
    }
    //Password Broker for administrator Model
    public function broker()
    {
        return Password::broker('admin');
    }

    public function sendResetLinkEmail(Request $request){

        $adminRoleId = $this->_helper->getAdminRoleId();

        $this->validateEmail($request);

        $response = $this->broker('admin')->sendResetLink(
            array_merge(
                $request->only('email'),['role_id' => $adminRoleId,'status' => 1 ]
            )
        );

        return $response == Password::RESET_LINK_SENT
            ? back()->with('status', trans($response))
            : back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);

        /*return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($response)
            : $this->sendResetLinkFailedResponse($request, $response);*/
    }

    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
    }
}
