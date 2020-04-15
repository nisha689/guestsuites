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

class HomeController extends Controller
{
    protected $userObj;
    protected $_helper;
    protected $_helperRoles;
    protected $_searchHelper;

    public function __construct(User $userModel){

        $this->userObj = $userModel;
        $this->_helper = new Helper();
        $this->_helperRoles = new HelperRoles();
    }

    public function index(Request $request){

        $loginUser = Auth::guard('admin')->user();
        
        /* School */
        /*$schoolRoleId = $this->_helperRoles->getSchoolRoleId();
        $filter = ['role_id'     => $schoolRoleId];
        $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['*'], $filter );
        $totalSchool = $this->userObj->getListTotalCount($searchHelper);*/

        /* Student */
        /*$studentRoleId = $this->_helperRoles->getStudentRoleId();
        $filter = ['role_id'     => $studentRoleId];
        $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['*'], $filter );
        $totalStudent = $this->userObj->getListTotalCount($searchHelper);*/

        /* Teacher */
        /*$teacherRoleId = $this->_helperRoles->getTeacherRoleId();
        $filter = ['role_id'     => $teacherRoleId];
        $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['*'], $filter );
        $totalTeacher = $this->userObj->getListTotalCount($searchHelper);*/

        /* Parent */
        /*$parentRoleId = $this->_helperRoles->getParentRoleId();
        $filter = ['role_id'     => $parentRoleId];
        $searchHelper = new SearchHelper( -1, -1, $selectColumns = ['*'], $filter );
        $totalParent = $this->userObj->getListTotalCount($searchHelper);*/
		
        /* Recent School */
        /*$schoolRoleId = $this->_helperRoles->getschoolRoleId();
        $filter = ['role_id'     => $schoolRoleId];
        $schoolSearchHelper = new SearchHelper( $page =0 , $perPage =4, $selectColumns = ['*'], $filter, $sortOrder = ['updated_at' => 'DESC'] );
        $recentSchools = $this->userObj->getList($schoolSearchHelper);*/

        /* Event */
        /*$searchHelper = new SearchHelper( -1, -1  );
        $totalEvent = $this->eventsObj->getListTotalCount($searchHelper);*/

        /* Club */
        /*$searchHelper = new SearchHelper( -1, -1  );
        $totalClub = $this->clubObj->getListTotalCount($searchHelper);*/
		$totalSchool = $totalTeacher = $totalParent =  $totalStudent = $totalClub = $totalEvent = 100;
        return view('admin.home', compact('loginUser','totalSchool','totalTeacher','totalParent','totalStudent','totalClub','totalEvent') );
    }
}
