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
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;



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
        if ( empty( $data['question_id'] ) ) {
            return abort( 404 );
        }

        $response = [];
        $response['success'] = false;
        
        $questionId = $data['question_id'];
        $question = \DB::select('SELECT * FROM gs_question WHERE question_id='.$questionId);
        if(!empty($question)){
            $option = $question[0]->option;
            if(!empty($option)){
                $option = explode(',', $option);
                foreach ($option as $key => $option_id) {
                    $option = \DB::select('SELECT * FROM gs_option WHERE option_id='.$option_id);
                    if(!empty($option)){
                        Common::deleteFile( $option[0]->image_url );
                        \DB::table('gs_option')->where('option_id', '=', $option_id)->delete(); 
                    }
                }
            }
            \DB::table('gs_question')->where('question_id', '=', $questionId)->delete(); 
        }

        $response['success'] = true;
        $response['message'] = "Question deleted successfully.";
        return response()->json( $response );
        
    }

    public function saveAjax( Request $request )
    {
        $data = $request->all();
        $response = [];
        $response['success'] = false;
        $currentDate = \DateFacades::getCurrentDateTime( 'format-1' );
        $responseOption = [];

        $questionId = NULL;
        $oldOptionArray = [];
        if(!empty($data['question_id']) && $data['question_id'] > 0){
            $questionId = $data['question_id'];

            $oldOptionOptionArray = \DB::select('SELECT option FROM gs_question WHERE question_id ='.$questionId);
            if(!empty($oldOptionOptionArray[0]->option)){
                $oldOptionArray = explode(',', $oldOptionOptionArray[0]->option);
            }    
        }

        $questionData = ['service_category_id' => $data['service_category_id'],
                        'label' => $data['label'],
                        'type' => $data['type'],
                        'updated_at'  => $currentDate,
                        'parent_question_id' => $data['parent_question_id']];


        /* Option */
        $option_csv = "";
        $option_array = [];
        $newOptionArray = [];

        if(!empty($data['option'])){
            
            foreach ($data['option'] as $key => $option) {

                $optionData = ['option_name' => $option['label'],
                                'updated_at'  => $currentDate];

                if(!empty($option['image_url'])){
                    
                    if(empty($option['option_id']) || $option['option_id'] < 0){
                         
                         $image = $option['image_url'];
                         $filePath = 'images/option';
                         $type = explode(';', $image)[0];
                         $type = explode('/', $type)[1];
                         $path = $filePath.'/option'.'_' . time().mt_rand().'.'.$type;
                
                        if ( ! File::isDirectory( $filePath ) ) {
                            File::makeDirectory( $filePath, 0777, true, true );
                        }

                        $aspectImage = Image::make( $image )
                                        ->resize( 200, 200, function ( $constraint ) {
                                            $constraint->aspectRatio();
                                            $constraint->upsize();
                                        } )
                                        ->save( $path );
                        $optionData['image_url'] = $path;
                        
                    }else{
                        $optionData['image_url'] = $option['image_url'];
                    }
                }

                if(!empty($option['option_id']) && $option['option_id'] > 0){
                    
                    $option_id = $option['option_id'];
                    \DB::table('gs_option')->where('option_id','=', $option_id)->update($optionData);

                }else{
                    
                    $optionData['created_at'] = $currentDate;
                    $option_id = \DB::table('gs_option')->insertGetId($optionData);

                }

                $option_array[] = $option_id;
                $responseOption[$option['o_id']] = $option_id;                
            }

            if(!empty($option_array)){
                $newOptionArray = $option_array;
                $option_csv = implode($option_array, ',');
            }
        }

        $questionData['option'] = $option_csv;
        
        if($questionId > 0){
            \DB::table('gs_question')->where('question_id','=', $questionId)->update($questionData);


            $deleteOptionIdArray=array_diff($oldOptionArray,$newOptionArray);
            if(!empty($deleteOptionIdArray)){
                \DB::table('gs_option')->whereIn('option_id', $deleteOptionIdArray)->delete();
            }

        }else{
            $questionData['created_at'] = $currentDate;
            $questionId = \DB::table('gs_question')->insertGetId($questionData);
        }

        $response['question_id'] = $questionId;
        $response['options'] = $responseOption;
        $response['success'] = true;
        $response['message'] = "Question saved successfully.";
        return response()->json( $response );
    }

    public function questionBuilder( Request $request )
    {
        
        $servicesWithCategory = [];
        $searchHelper = new SearchHelper( -1, -1, ['*'], [], ['business_service_id' => 'ASC'] );
        $services = $this->serviceObj->getList( $searchHelper );
        
        foreach ($services as $key => $service) {

            $businessServiceIcon = !empty($service->business_service_icon) ? url($service->business_service_icon) : "";
            $business_service_id = $service->business_service_id;

            $serviceData = ["business_service_id" => $business_service_id,
                            "business_service_name" => $service->business_service_name,
                            "business_service_icon" => $businessServiceIcon,
                            ];       

            /* Service category */
            $filter = ['business_service_id' => $business_service_id];
            $searchHelper = new SearchHelper( -1, -1, ['*'], $filter, ['service_category_id' => 'ASC'] );
            $serviceCategory = $this->serviceCategoryObj->getList( $searchHelper );
            
            $subCategoryData = [];

            foreach ($serviceCategory as $key => $category) {
                $subCategoryData[$category->service_category_id] = ["service_category_id" => $category->service_category_id,
                                    "business_service_id" => $category->business_service_id,
                                    "service_category_name" => $category->service_category_name,];
                                    
            }        
            $serviceData["sub_category"] = $subCategoryData;
            $servicesWithCategory[$service->business_service_id] = $serviceData;
        }

        $questionList = [];
        $questionArray = \DB::select('SELECT q.*,sc.business_service_id  FROM gs_question q 
                                      join gs_service_category sc on q.service_category_id = sc.service_category_id  
                                      order by updated_at desc');

        foreach ($questionArray as $key => $question) {

            $questionList['question_'.$question->question_id] = [   'type' => $question->type,
                                                        'question_id' => $question->question_id,
                                                        'q_id' => 'question_'.$question->question_id,
                                                        'label' => $question->label,
                                                        'service_category_id' => $question->service_category_id,
                                                        'business_service_id' => $question->business_service_id,
                                                    ];
            $optionArray = $question->option; 
            if(!empty($optionArray)){
                $optionArray = explode(',', $optionArray);
                $optionsResponse = [];
                $optionResults = \DB::table('gs_option')->whereIn('option_id', $optionArray)->get()->toArray();
                
                foreach ($optionResults as $key => $option) {
                    $optionsData = ['option_id' => $option->option_id,
                                          'label' => $option->option_name,
                                        'o_id' => 'option_'.$option->option_id];

                   if(!empty($option->image_url)){
                       $optionsData['image_url'] = \URL::to($option->image_url); 
                   }
                   
                   $optionsResponse[] = $optionsData;                       
                }
                $questionList['question_'.$question->question_id]['options'] = $optionsResponse;
            }
        }
        return view( 'admin.question_builder.index', compact('servicesWithCategory','questionList'));
    }
}
