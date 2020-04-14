<?php

namespace App\Http\Controllers\Admin\EmailTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Helpers\EmailTemplate\Helper;
use App\Classes\Common\Common;
use App\Classes\Helpers\SearchHelper;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Classes\Helpers\Roles\Helper as HelperRoles;
use App\Classes\Models\EmailTemplate\EmailTemplate;

class IndexController extends Controller
{
    protected $emailtemplateObj;    
    protected $_helper;
    

    public function __construct()
    {
        $this->emailtemplateObj = new EmailTemplate();        
        $this->_helper = new Helper();        
    }

    public function index( Request $request )
    {
        $data = $request->all();
        $page = ! empty( $data['page'] ) ? $data['page'] : 0;
        $sortedBy = ! empty( $request->get( 'sorted_by' ) ) ? $request->get( 'sorted_by' ) : 'created_at';
        $sortedOrder = ! empty( $request->get( 'sorted_order' ) ) ? $request->get( 'sorted_order' ) : 'DESC';
        $templateName = !empty( $data['template_name'] ) ? $data['template_name'] : '';

        $perPage = $this->_helper->getConfigPerPageRecord();
        $recordStart = common::getRecordStart( $page, $perPage );
        $filter = ['template_name' => $templateName];
        $searchHelper = new SearchHelper( $page, $perPage, $selectColumns = ['*'], $filter, $sortOrder = [$sortedBy => $sortedOrder] );
        $emailTemplates = $this->emailtemplateObj->getList( $searchHelper );
        $totalRecordCount = $this->emailtemplateObj->getListTotalCount( $searchHelper );
        $paginationBasePath = Common::getPaginationBasePath( ['template_name' => $templateName] );
        $paging = $this->emailtemplateObj->preparePagination( $totalRecordCount, $paginationBasePath, $searchHelper );

        return view( 'admin.emailtemplate.index', compact( 'sortedBy', 'recordStart','sortedOrder',  'paging', 'totalRecordCount', 'emailTemplates','templateName') );
    }
	
	public function emailDetails(Request $request, $emailtemplateId) {
		
        $emailtemplateId = Common::getDecryptId($emailtemplateId);

        if( $emailtemplateId <= 0 ){ return abort(404); }
        $emailtemplate = $this->emailtemplateObj->getDateById($emailtemplateId);		
		return view('admin.emailtemplate.details',compact('emailtemplate'));
	}

	public function save(Request $request)
    {		
        $data = $request->all();		
        $result = $this->emailtemplateObj->saveRecord($data);				
        if ( !empty($result['email_template_id'] ) && $result['email_template_id'] > 0 ) {
            $request->session()->flash( 'success', $result['message'] );			
			return Redirect::back();
        } else {
            return Redirect::back()->withInput()->withErrors($result['message']);
        }
    }	
}