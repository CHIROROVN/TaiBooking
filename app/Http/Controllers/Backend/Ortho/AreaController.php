<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use App\User;
use App\Http\Models\Ortho\AreaModel;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\ClinicAreaModel;

use Form;
use Html;
use Input;
use Validator;
use URL;

class AreaController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * 
     */
    public function index()
    {
        $clsArea = new AreaModel();
        $data['areas'] = $clsArea->get_all();

        return view('backend.ortho.areas.index', $data);
    }

    /**
     * 
     */
    public function getRegist()
    {
        $clsClinic          = new ClinicModel();
        $data['clinics']    = $clsClinic->get_all();

        return view('backend.ortho.areas.regist', $data);
    }

    /**
     * 
     */
    public function postRegist()
    {
        $clsArea        = new AreaModel();
        $clsClinicArea  = new ClinicAreaModel();
        $inputs         = Input::all();
        $validator      = Validator::make($inputs, $clsArea->Rules(), $clsArea->Messages());

        if ($validator->fails()) {
            return redirect()->route('ortho.areas.regist')->withErrors($validator)->withInput();
        }

        // insert
        $max = $clsArea->get_max();
        $dataInsert = array(
            'area_name'         => Input::get('area_name'),

            'last_date'         => date('y-m-d H:i:s'),
            'area_sort_no'      => $max + 1,
            'last_kind'         => INSERT,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        $id_area = $clsArea->insert_get_id($dataInsert);

        // insert to table clinic_area
        $clinics = Input::get('clinic');
        if(!empty($clinics))
        {
            foreach($clinics as $clinic)
            {
                if(!$clsClinicArea->exist_area_clinic($id_area, $clinic)) // && !$clsClinicArea->exist_clinic($clinic)
                {
                    $dataInsert = array(
                        'area_id'           => $id_area,
                        'clinic_id'         => $clinic,

                        'last_date'         => date('y-m-d H:i:s'),
                        'last_kind'         => INSERT,
                        'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
                        'last_user'         => Auth::user()->id
                    );
                    $clsClinicArea->insert($dataInsert);   
                }
            }
        }

        return redirect()->route('ortho.areas.index');
    }

    /**
     * 
     */
    public function getEdit($id)
    {
        $clsArea                = new AreaModel();
        $clsClinic              = new ClinicModel();
        $clsClinicArea          = new ClinicAreaModel();
        $data['area']           = $clsArea->get_by_id($id);
        $data['clinics']        = $clsClinic->get_all();
        $area_clinics           = $clsClinicArea->get_by_area($id);
        $tmp                    = array();
        foreach($area_clinics as $area_clinic)
        {
            $tmp[$area_clinic->clinic_id] = $area_clinic->clinic_id;
        }
        $data['area_clinics']   = $tmp;

        return view('backend.ortho.areas.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($id)
    {
        $clsArea                = new AreaModel();
        $clsClinicArea          = new ClinicAreaModel();
        $inputs                 = Input::all();

        $validator              = Validator::make($inputs, $clsArea->Rules(), $clsArea->Messages());

        if ($validator->fails()) {
            return redirect()->route('ortho.areas.edit', [$id])->withErrors($validator)->withInput();
        }

        // update table area
        $dataUpdate = array(
            'area_name'         => Input::get('area_name'),

            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => UPDATE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        $clsArea->update($id, $dataUpdate);

        // before update table clinic_area
        $clinics = Input::get('clinic');
        if(!empty($clinics))
        {
            foreach($clinics as $clinic)
            {
                if($clsClinicArea->exist_clinic($clinic))
                {
                    // update
                    $data = array(
                        'area_id'           => $id,
                        'clinic_id'         => $clinic,

                        'last_date'         => date('y-m-d H:i:s'),
                        'last_kind'         => UPDATE,
                        'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
                        'last_user'         => Auth::user()->id
                    );
                    $clsClinicArea->update_by_clinic($clinic, $data);
                }
                else
                {
                    // add new
                    $dataInsert = array(
                        'area_id'           => $id,
                        'clinic_id'         => $clinic,

                        'last_date'         => date('y-m-d H:i:s'),
                        'last_kind'         => INSERT,
                        'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
                        'last_user'         => Auth::user()->id
                    );
                    $clsClinicArea->insert($dataInsert); 
                }
            } 
        }

        return redirect()->route('ortho.areas.index');
    }

    /**
     * 
     */
    public function getDelete($id)
    {
        $clsArea                = new AreaModel();
        $clsClinicArea          = new ClinicAreaModel();

        // update table area
        $dataUpdate = array(
            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => DELETE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        $clsArea->update($id, $dataUpdate);

        // update to table clinic_area
        $dataUpdate = array(
            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => DELETE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        $clsClinicArea->update_by_area($id, $dataUpdate);


        return redirect()->route('ortho.areas.index');
    }

    /**
     * 
     */
    public function orderby_top()
    {
        $clsArea = new AreaModel();
        $id = Input::get('id');

        $this->top($clsArea, $id, 'area_sort_no');

        return redirect()->route('ortho.areas.index');
    }

    /**
     * 
     */
    public function orderby_last()
    {
        $clsArea = new AreaModel();
        $id = Input::get('id');
        
        $this->last($clsArea, $id, 'area_sort_no');

        return redirect()->route('ortho.areas.index');
    }

    /**
     * 
     */
    public function orderby_up()
    {
        $clsArea = new AreaModel();
        $id = Input::get('id');
        $areas = $clsArea->get_all();
        
        $this->up($clsArea, $id, $areas, 'area_id', 'area_sort_no');

        return redirect()->route('ortho.areas.index');
    }

    /**
     * 
     */
    public function orderby_down()
    {
        $clsArea = new AreaModel();
        $id = Input::get('id');
        $areas = $clsArea->get_all();
        
        $this->down($clsArea, $id, $areas, 'area_id', 'area_sort_no');

        return redirect()->route('ortho.areas.index');
    }
}
