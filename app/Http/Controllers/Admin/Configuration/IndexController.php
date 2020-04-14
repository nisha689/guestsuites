<?php

namespace App\Http\Controllers\Admin\Configuration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Classes\Models\AdminConfiguration\AdminConfiguration;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Classes\Helpers\SearchHelper;
use App\Classes\Common\Common;

class IndexController extends Controller
{

    public function __construct()
    {
    }

    public function index( Request $request )
    {
        $allKey = Config::get( 'admin-configuration' );
        $configurationList = [];

        foreach ( $allKey as $key => $value ) {

            $configurations = AdminConfiguration::where( 'key', $key )
                                                ->first();

            if ( $configurations === null ) {

                $returnArray['key'] = $key;
                $returnArray['value'] = $value['value'];
                $returnArray['label'] = $value['label'];
                $returnArray['group_type'] = $value['group_type'];

            } else {

                $returnArray['key'] = $configurations->key;
                $returnArray['value'] = $configurations->value;
                $returnArray['label'] = $configurations->label;
                $returnArray['group_type'] = $configurations->group_type;
            }

            $configurationList[] = $returnArray;
        }
        $currentTab = 'general';
        if ( Session::has( 'active_tab' ) ) {
            $currentTab = Session::get( 'active_tab' );
        }

       
        return view( 'admin.configuration.create', compact( 'configurationList', 'currentTab' ) );
    }

    public function save( Request $request )
    {
        if ( $request->isMethod( 'post' ) ) {

            $data = $request->except( ['_token',
                                       'currenttab'] );

            $currentSelection = $request->only( 'currenttab' );

            $currentTab = isset( $currentSelection['currenttab'] ) ? $currentSelection['currenttab'] : 'general';

            $admin = Auth::guard( 'admin' )
                         ->getUser();
            $userId = $admin->user_id;
            foreach ( $data as $key => $value ) {

                $settingObj = AdminConfiguration::where( 'key', $key )
                                                ->first();

                if ( $settingObj === null ) {
                    $row = ['user_id' => $userId,
                            'key'     => $key,
                            'label'   => Config::get( 'admin-configuration.' . $key . '.label' ),
                            'value'   => $value];

                    AdminConfiguration::create( $row );

                } else {
                    $row = ['user_id' => $userId,
                            'value'   => $value];

                    $settingObj->update( $row );
                }
            }

        }
        $request->session()
                ->flash( 'success', 'Setting updated successfully.' );
        Session::put( 'active_tab', $currentTab );
        return Redirect::back();

    }
}
