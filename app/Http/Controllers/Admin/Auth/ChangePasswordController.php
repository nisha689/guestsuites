<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Hash;
use Validator;

class ChangePasswordController extends Controller{
    /**
     * Create a new controller instance.
     */
    public function __construct(){
        $this->middleware('admin');
    }
    /**
     * Where to redirect users after password is changed.
     *
     * @var string $redirectTo
     */
    protected $redirectTo = '/admin_change_password';

    /**
     * Change password form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showChangePasswordForm()
	{
        $admin = Auth::guard('admin')->getUser();

        return view('admin.auth.change_password', compact('admin'));
    }

    /**
     * Change password.
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
	{
        $admin = Auth::guard('admin')->getUser();
        $this->validator($request->all())->validate();
        if (Hash::check($request->get('current_password'), $admin->password)) {
            $admin->password = Hash::make($request->get('new_password'));
            $admin->save();
            return redirect($this->redirectTo)->with('success', 'Password change successfully!');
        } else {
            return redirect()->back()->withErrors('Current password is incorrect');
        }
    }

    /**
     * Get a validator for an incoming change password request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
	{
		return Validator::make($data, [
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);
    }
}
