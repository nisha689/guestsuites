<?php

namespace App\Http\Controllers\Admin\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Models\User\User;
use App\Classes\Helpers\User\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Classes\Models\State\State;
use App\Classes\Models\City\City;
use App\Classes\Helpers\City\Helper as HelperCity;
class IndexController extends Controller
{
    protected $userObj;
    protected $stateObj;
    protected $cityObj;
    protected $_helper;    
    protected $_searchHelper;

    public function __construct(User $userModel){

        $this->userObj = $userModel;
        $this->stateObj = new State();
        $this->cityObj = new City();
        $this->_helper = new Helper();        
    }

    public function index(Request $request){

        $admin = Auth::guard('admin')->getUser();
        $stateDropDown = $this->stateObj->getDropDown();
        $cityDropDown = $this->cityObj->getCityDropDownByStateId($admin->state_id);
        return view('admin.profile.index', compact('admin','stateDropDown', 'cityDropDown'));
    }

    public function profileSave(Request $request)
    {
        $data = $request->all();
        $result = $this->userObj->adminProfileSave($data);

        if ( !empty($result['success'] ) && $result['success'] == 1 ) {
            $request->session()->flash( 'success', 'User profile update successfully.' );
            return Redirect::back();
        } else {
            return Redirect::back()->withErrors($result['message']);
        }
    }

    public function changePassword(Request $request)
    {
        $data = $request->all();
        $result = $this->userObj->changePassword($data);
        if ( !empty($result['user_id'] ) && $result['user_id'] > 0 ) {
            $request->session()->flash( 'success', "User password changed successfully." );
            return Redirect::back();
        } else {
            return Redirect::back()->withErrors($result['message']);
        }
    }
}
