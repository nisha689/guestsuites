<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Common\Common;

class HomeController extends Controller
{

    public function __construct(){
    }

	public function index() {
        Common::setUserSessionForWordPress();
		return include public_path().'/wp_view/home.php';
		exit;
    }

	public function aboutUs() {
        Common::setUserSessionForWordPress();
		return include public_path().'/wp_view/aboutus.php';
		exit;
    }

	public function contactUs() {
        Common::setUserSessionForWordPress();
		return include public_path().'/wp_view/contactus.php';
		exit;
    }

	public function privacyPolicy() {
        Common::setUserSessionForWordPress();
		return include public_path().'/wp_view/privacypolicy.php';
		exit;
    }

	public function termsServices() {
        Common::setUserSessionForWordPress();
		return include public_path().'/wp_view/termsservices.php';
		exit;
    }


}
