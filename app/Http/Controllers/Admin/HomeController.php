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
use App\Classes\Models\Transaction\Transaction;
use App\Classes\Models\CustomerBookingService\CustomerBookingService;

class HomeController extends Controller
{
    protected $userObj;
    protected $serviceObj;
    protected $transactionObj;
    protected $_helper;
    protected $_helperRoles;
    protected $_searchHelper;
    protected $customerBookingServiceObj;

    public function __construct(User $userModel){

        $this->userObj = $userModel;
        $this->_helper = new Helper();
        $this->_helperRoles = new HelperRoles();  
		$this->serviceObj = new Service();		
        $this->transactionObj = new Transaction();      
        $this->customerBookingServiceObj = new CustomerBookingService();      
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

        /* Transaction */
        $filter = ['status'     => 1];
        $searchHelper = new SearchHelper( -1, -1, ['amount'], $filter );
        $totalTransaction = $this->transactionObj->getSum($searchHelper);

        /* Order */
        $searchHelper = new SearchHelper( -1, -1, ['*'] );
        $totalOrder = $this->customerBookingServiceObj->getListTotalCount($searchHelper);

        $customerMap = collect(\DB::select('SELECT count(user_id) as count FROM gs_users WHERE role_id = 3 
                                    AND created_at >= DATE_SUB(now(), INTERVAL 6 MONTH)
                                    GROUP BY month(created_at)'))->pluck('count')->toArray();
        
        $customerMap = array_map('intval', $customerMap);

        $businessMap = collect(\DB::select('SELECT count(user_id) as count FROM gs_users WHERE role_id = 2 
                                    AND created_at >= DATE_SUB(now(), INTERVAL 6 MONTH)
                                    GROUP BY month(created_at)'))->pluck('count')->toArray();

        $businessMap = array_map('intval', $businessMap);

        $orderMap = collect(\DB::select('SELECT count(customer_booked_id) as count FROM gs_customer_booked 
                                        WHERE  created_at >= DATE_SUB(now(), INTERVAL 6 MONTH)
                                        GROUP BY month(created_at)'))->pluck('count')->toArray();

        $orderMap = array_map('intval', $orderMap);
        
        $transactionMap = collect(\DB::select('SELECT ROUND(sum(amount)) as count FROM gs_transaction 
                                        WHERE status = 1 AND created_at >= DATE_SUB(now(), INTERVAL 6 MONTH) 
                                        GROUP BY month(created_at)'))->pluck('count')->toArray();
        
        $transactionMap = array_map('intval', $transactionMap);
            
        return view('admin.home', compact('loginUser','totalBusinesses','totalCustomers','recentCustomers','totalTransaction','totalOrder','customerMap','businessMap','orderMap','transactionMap') );
    }
}
