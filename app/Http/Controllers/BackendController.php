<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelLocalization;
class BackendController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->middleware('auth');

		$ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        define('CLIENT_IP_ADRS', $ipaddress);

        LaravelLocalization::setLocale('ja');
	}

    /**
     * function set page, using in function delete(id)
     * $class_model: class object
     * $input_page: page current 
     */
    public function set_page($class_model, $input_page) {
        $count = $class_model->count();
        $tmp_page = $count / PAGINATION;
        $tmp_page = ceil($tmp_page);
        $tmp_page1 = $count % PAGINATION;
        $page = $input_page;

        if ($tmp_page1 != 0) {
            $tmp_page = $tmp_page + 1;
        }
        if ($tmp_page < $page) {
            $page = $tmp_page;
        }

        return $page;
    }
}