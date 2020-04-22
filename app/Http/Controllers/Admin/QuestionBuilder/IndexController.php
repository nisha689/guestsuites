<?php

namespace App\Http\Controllers\Admin\QuestionBuilder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Models\Service\Service;
use App\Classes\Helpers\Service\Helper;
use App\Classes\Common\Common;
use App\Classes\Helpers\SearchHelper;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Classes\Models\User\User;
use App\Classes\Models\ServiceCategory\ServiceCategory;

class IndexController extends Controller
{
    protected $serviceObj;
    protected $serviceCategoryObj;
    protected $userObj;
    protected $_helper;

    public function __construct( Service $serviceModel )
    {
        $this->serviceObj = $serviceModel;
        $this->serviceCategoryObj = new ServiceCategory();
        $this->userObj = new User();
        $this->_helper = new Helper();
    }

    
    public function delete( Request $request )
    {
        $data = $request->all();
        if ( empty( $data['id'] ) ) {
            return abort( 404 );
        }
        $isDelete = $this->serviceObj->removed( $data['id'] );
        if ( $isDelete ) {
            $request->session()
                    ->flash( 'success', 'Service deleted successfully.' );
        } else {
            $request->session()
                    ->flash( 'error', 'Service is not deleted successfully.' );
        }
        return Redirect::back();
    }

    public function saveAjax( Request $request )
    {
        $data = $request->all();
        $results = $this->serviceObj->saveRecord( $data );
        if ( ! empty( $results['business_service_id'] ) && $results['business_service_id'] > 0 ) {
            return response()->json( $results );
        } else {
            /* Set Validation Message */
            $message = null;
            foreach ( $results['message'] as $key => $value ) {
                if ( empty( $message ) ) {
                    $message = $results['message']->{$key}[0];
                    break;
                }
            }
            $response = [];
            $response['success'] = false;
            $response['message'] = $message;
            return response()->json( $response );
        }
    }

    public function questionBuilder( Request $request )
    {
        $servicesWithCategory = [];
        $searchHelper = new SearchHelper( -1, -1, ['*'], [], ['business_service_id' => 'ASC'] );
        $services = $this->serviceObj->getList( $searchHelper );
        
        foreach ($services as $key => $service) {

            $businessServiceIcon = !empty($service->business_service_icon) ? url($service->business_service_icon) : "";
            $business_service_id = $service->business_service_id;

            $serviceData = ['business_service_id' => $business_service_id,
                            'business_service_name' => $service->business_service_name,
                            'business_service_icon' => $businessServiceIcon,
                            ];       

            /* Service category */
            $filter = ['business_service_id' => $business_service_id];
            $searchHelper = new SearchHelper( -1, -1, ['*'], $filter, ['service_category_id' => 'ASC'] );
            $serviceCategory = $this->serviceCategoryObj->getList( $searchHelper );
            
            $subCategoryData = [];

            foreach ($serviceCategory as $key => $category) {
                $subCategoryData[$category->service_category_id] = ['service_category_id' => $category->service_category_id,
                                    'business_service_id' => $category->business_service_id,
                                    'service_category_name' => $category->service_category_name,];
                                    
            }        
            $serviceData['sub_category'] = $subCategoryData;
            $servicesWithCategory[$service->business_service_id] = $serviceData;
        }
        return view( 'admin.question_builder.index', compact('servicesWithCategory'));
    }
}
