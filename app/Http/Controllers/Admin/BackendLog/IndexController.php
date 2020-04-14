<?php

namespace App\Http\Controllers\Admin\BackendLog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Models\User\User;
use App\Classes\Helpers\User\Helper;
use App\Classes\Common\Common;
use App\Classes\Helpers\SearchHelper;
use Illuminate\Support\Facades\Redirect;
use App\Classes\Models\Roles\Roles;

class IndexController extends Controller
{
    protected $userObj;
    protected $rolesObj;
    protected $_helper;
    protected $_searchHelper;

    public function __construct(User $userModel){

        $this->userObj = $userModel;
        $this->rolesObj = new Roles();
        $this->_helper = new Helper();
    }

    public function index(Request $request){

        $data = $request->all();
        $page= !empty($data['page']) ? $data['page'] : 0;
        $sortedBy = !empty($request->get('sorted_by')) ? $request->get('sorted_by') : 'last_login_date';
        $sortedOrder = !empty($request->get('sorted_order')) ? $request->get('sorted_order') : 'DESC';

        $name = !empty($data['name']) ? $data['name'] : "";
        $email = !empty($data['email']) ? $data['email'] : "";
        $roleId = isset($data['role_id']) ? $data['role_id'] : '';
        $roleIdIn = isset($data['role_id']) ? [$data['role_id']] : [2,3];

        $perPage = $this->_helper->getConfigPerPageRecord();
        $recordStart = common::getRecordStart($page, $perPage);
        $filter = ['status'      => 1,
                   'is_login'    => 1,
                   'name'        => $name,
                   'email'       => $email,
                   'role_id_in'     => $roleIdIn];
        $searchHelperCustomer = new SearchHelper($page, $perPage, $selectColumns = ['*'], $filter, $sortOrder = [$sortedBy => $sortedOrder ]);
        $users = $this->userObj->getList($searchHelperCustomer);
        $totalRecordCount= $this->userObj->getListTotalCount($searchHelperCustomer);
        $paginationBasePath = Common::getPaginationBasePath( ['name'    => $name,
                                                              'email'   => $email,
                                                              'role_id' => $roleId] );
        $paging = $this->userObj->preparePagination($totalRecordCount,$paginationBasePath,$searchHelperCustomer);
        $roleDropDownList = ['' => 'All', '2' => 'Business', '3' => 'Customer'];
        return view('admin.backend_log.index',compact('sortedBy', 'sortedOrder', 'recordStart','users','paging','totalRecordCount','roleDropDownList','name','email','roleId'));
    }

}