<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Classes\Models\User\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Classes\Helpers\User\Helper;
use App\Classes\Common\Common;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    protected $_helper;

    protected $userObj;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest_admin');
        $this->userObj = new User();
        $this->_helper = new Helper();
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $tableName = $this->userObj->getTableName();
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:'.$tableName],
            'phone' => ['required', 'numeric', 'min:10'],
            'photo' => ['mimes:jpeg,jpg,png,gif'],
            'password' => ['required', 'string','min:6', 'confirmed',],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $photo = "";
        if ( ! empty( $data['photo'] ) ) {
            $image = $data['photo'];
            $photoName = $image->getClientOriginalName();
            $photoName = strtolower( str_replace( ' ', '-', $photoName ) );
            $photoName = str_replace( '.' . $image->getClientOriginalExtension(), '_' . time() . '.' . $image->getClientOriginalExtension(), $photoName );
            $imagePath = $this->_helper->getImagePath();
            $destinationPath = public_path( '/'.$imagePath );
            $image->move( $destinationPath, $photoName );
            $photo = $imagePath.'/'. $photoName;
        }

        $adminRoleId = $this->_helper->getAdminRoleId();

        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'signup_method' => $data['signup_method'],
            'created_at' => $data['created_at'],
            'ip_address' => $data['ip_address'],
            'photo' => $photo,
            'role_id' => $adminRoleId,
            'status' => 1,
            'e_token_check' => 1,
            'password' => Common::generatePassword($data['password']),
        ]);
    }
}
