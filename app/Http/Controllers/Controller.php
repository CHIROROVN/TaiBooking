<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use Config;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $configs = Config::get('constants.DEFINE');
        foreach($configs as $key => $value)
        {
            define($key, $value);
        }
    }


    protected function top($clsObject, $id)
    {
    	$min = $clsObject->get_min();

        // update
        $dataUpdate = array(
            'belong_sort_no' => $min - 1
        );
        $clsObject->update($id, $dataUpdate);
    }

    protected function last($clsObject, $id)
    {
    	$max = $clsObject->get_max();

        // update
        $dataUpdate = array(
            'belong_sort_no' => $max + 1
        );
        $clsObject->update($id, $dataUpdate);
    }

    protected function up($clsObject, $id, $array)
    {
    	$count = count($array);
        $cur_belong = NULL;
        $up_belong = NULL;
        for($i = 0; $i < $count; $i++)
        {
            
            if($array[$i]->belong_id == $id)
            {
                $cur_belong = $array[$i];
                $up_belong = $array[$i - 1];
                break;
            }
        }

        // update
        // swap cur->up
        $dataUpdate = array(
            'belong_sort_no' => $up_belong->belong_sort_no
        );
        $clsObject->update($cur_belong->belong_id, $dataUpdate);

        // swap up->cur
        $dataUpdate = array(
            'belong_sort_no' => $cur_belong->belong_sort_no
        );
        $clsObject->update($up_belong->belong_id, $dataUpdate);
    }

    protected function down($clsObject, $id, $array)
    {
    	$count = count($array);
        $cur_belong = NULL;
        $down_belong = NULL;
        for($i = 0; $i < $count; $i++)
        {
            
            if($array[$i]->belong_id == $id)
            {
                $cur_belong = $array[$i];
                $down_belong = $array[$i + 1];
                break;
            }
        }

        // update
        // swap cur->down
        $dataUpdate = array(
            'belong_sort_no' => $down_belong->belong_sort_no
        );
        $clsObject->update($cur_belong->belong_id, $dataUpdate);

        // swap down->cur
        $dataUpdate = array(
            'belong_sort_no' => $cur_belong->belong_sort_no
        );
        $clsObject->update($down_belong->belong_id, $dataUpdate);
    }
}
