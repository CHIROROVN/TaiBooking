<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelLocalization;
use Config;

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


        $configs = Config::get('constants.DEFINE');
        foreach($configs as $key => $value)
        {
            define($key, $value);
        }
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


    protected function top($clsObject, $id, $field_sort)
    {
        $min = $clsObject->get_min();

        // update
        $dataUpdate = array(
            $field_sort => $min - 1
        );
        $clsObject->update($id, $dataUpdate);
    }

    protected function last($clsObject, $id, $field_sort)
    {
        $max = $clsObject->get_max();

        // update
        $dataUpdate = array(
            $field_sort => $max + 1
        );
        $clsObject->update($id, $dataUpdate);
    }

    protected function up($clsObject, $id, $array, $field_primary, $field_sort)
    {
        $count = count($array);
        $cur_belong = NULL;
        $up_belong = NULL;
        for($i = 0; $i < $count; $i++)
        {
            
            if($array[$i]->$field_primary == $id)
            {
                $cur_belong = $array[$i];
                $up_belong = $array[$i - 1];
                break;
            }
        }

        // update
        // swap cur->up
        $dataUpdate = array(
            $field_sort => $up_belong->$field_sort
        );
        $clsObject->update($cur_belong->$field_primary, $dataUpdate);

        // swap up->cur
        $dataUpdate = array(
            $field_sort => $cur_belong->$field_sort
        );
        $clsObject->update($up_belong->$field_primary, $dataUpdate);
    }

    protected function down($clsObject, $id, $array, $field_primary, $field_sort)
    {
        $count = count($array);
        $cur_belong = NULL;
        $down_belong = NULL;
        for($i = 0; $i < $count; $i++)
        {
            
            if($array[$i]->$field_primary == $id)
            {
                $cur_belong = $array[$i];
                $down_belong = $array[$i + 1];
                break;
            }
        }

        // update
        // swap cur->down
        $dataUpdate = array(
            $field_sort => $down_belong->$field_sort
        );
        $clsObject->update($cur_belong->$field_primary, $dataUpdate);

        // swap down->cur
        $dataUpdate = array(
            $field_sort => $cur_belong->$field_sort
        );
        $clsObject->update($down_belong->$field_primary, $dataUpdate);
    }
}