<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Models\User\User;
use App\Classes\Helpers\User\Helper;
use App\Classes\Helpers\SearchHelper;
use App\Classes\Helpers\Roles\Helper as HelperRoles;
use App\Classes\Common\Common;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Classes\Models\Service\Service;

class HomeController extends Controller
{
    protected $userObj;
    protected $serviceObj;
    protected $_helper;
    protected $_helperRoles;
    protected $_searchHelper;

    public function __construct(User $userModel){

        $this->userObj = $userModel;
        $this->_helper = new Helper();
        $this->_helperRoles = new HelperRoles();  
		$this->serviceObj = new Service();		
    }

    public function index(Request $request){

        $loginUser = Auth::guard('admin')->user();
        
        /* Business */
        $businessesRoleId = $this->_helperRoles->getBusinessRoleId();
        $filter = ['role_id'     => $businessesRoleId];
        $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['*'], $filter );
        $totalBusinesses = $this->userObj->getListTotalCount($searchHelper);

        /* Customers */
        $customerRoleId = $this->_helperRoles->getCustomeRoleId();
        $filter = ['role_id'     => $customerRoleId];
        $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['*'], $filter );
        $totalCustomers = $this->userObj->getListTotalCount($searchHelper);

		/* Recent Customers */
		$searchHelper = new SearchHelper( -1, 4, $selectColumns = ['*'], $filter, $sortOrder = ['created_at' => 'DESC'] );
        $recentCustomers = $this->userObj->getList( $searchHelper );
		
        /* Services */        
        $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['*'], $filter );
        $totalServices = $this->serviceObj->getListTotalCount($searchHelper);
		
        return view('admin.home', compact('loginUser','totalBusinesses','totalCustomers','recentCustomers','totalServices') );
    }
}
