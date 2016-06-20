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
