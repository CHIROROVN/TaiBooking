<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Models\Ortho\BookingTemplateModel;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\FacilityModel;
use App\Http\Models\Ortho\BookingModel;
use App\Http\Models\Ortho\TemplateModel;
use App\Http\Models\Ortho\ServiceModel;
//use App\Http\Models\Ortho\BookingTemplateModel;

use Request;
use Auth;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;
use Config;

class BookingTemplateController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * 
     */
    public function index($clinic_id)
    {
        $clsMbt                     = new BookingTemplateModel();
        $clsClinic                  = new ClinicModel();
        $data['mbts']               = $clsMbt->get_all($clinic_id);
        $data['clinic']             = $clsClinic->get_by_id($clinic_id);

        return view('backend.ortho.clinics.booking.templates.index', $data);
    }

    /**
     * 
    */
    public function getRegist($clinic_id)
    {
        $clsClinic              = new ClinicModel();
        $data['clinic']         = $clsClinic->get_by_id($clinic_id);

        return view('backend.ortho.clinics.booking.templates.regist',$data);
    }

    /**
     * 
     */
    public function postRegist($clinic_id)
    {
        $clsMbt         = new BookingTemplateModel();
        $clsTemplate    = new TemplateModel();
        $rules          = $clsMbt->Rules();

        $max = $clsMbt->get_max();
        $dataInsert = array(
            'clinic_id'                     => $clinic_id,
            'mbt_name'                      => Input::get('mbt_name'),
            'mbt_sort_no'                   => $max + 1,

            'last_kind'                     => INSERT,
            'last_ipadrs'                   => CLIENT_IP_ADRS,
            'last_date'                     => date('y-m-d H:i:s'),
            'last_user'                     => Auth::user()->id
        );

        $validator      = Validator::make($dataInsert, $rules, $clsMbt->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.clinics.booking.templates.regist', [$clinic_id])->withErrors($validator)->withInput();
        }

        // insert to table m_booking_template
        $mbt_id = $clsMbt->insert_get_id($dataInsert);
        
        // insert to table m_template
        $dataInsert = array(
            'mbt_id'                        => $mbt_id,

            'last_kind'                     => INSERT,
            'last_ipadrs'                   => CLIENT_IP_ADRS,
            'last_date'                     => date('y-m-d H:i:s'),
            'last_user'                     => Auth::user()->id
        );

        if ( $mbt_id && $clsTemplate->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
            return redirect()->route('ortho.clinics.booking.templates.index',[$clinic_id]);
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
            return redirect()->route('ortho.clinics.booking.templates.index', [$clinic_id]);
        }
    }

    /**
     * 
     */
    public function getEdit($clinic_id, $id)
    {
        $clsFacility                = new FacilityModel();
        $clsClinic                  = new ClinicModel();
        $clsBookingTemplate         = new BookingTemplateModel();
        $clsTemplate                = new TemplateModel();
        $clsService                 = new ServiceModel();
        $data['booking_template']   = $clsBookingTemplate->get_by_id($id);
        $data['clinic']             = $clsClinic->get_by_id($clinic_id);
        $data['facilitys']          = $clsFacility->getAll();
        $data['services']           = $clsService->get_all();
        $data['times']              = Config::get('constants.TIME');

        $templates                  = $clsTemplate->get_all($id);
        $arr_templates              = array();
        foreach ( $data['times'] as $time ) {
            // $time_replate = str_replace (':', '', $time);
            foreach ( $data['facilitys'] as $fac ) {
                foreach ( $templates as $template ) {
                    if ( $template->facility_id == $fac->facility_id ) {
                        $arr_templates[$fac->facility_id][$time] = $template;
                    }
                }
            }
        }
        $data['arr_templates']       = $arr_templates;
        // echo '<pre>';
        // print_r($data['booking_template']);
        // echo '</pre>';die;

        return view('backend.ortho.clinics.booking.templates.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($clinic_id, $id)
    {
        $clsMbt           = new BookingTemplateModel();
       
        $validator                = Validator::make(Input::all(), $rules, $clsMbt->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.clinics.booking.templates.edit', [$clinic_id, $id])->withErrors($validator)->withInput();
        }

        $dataUpdate = array(
            'clinic_id'                     => $clinic_id,
            'mbt_name'                      => Input::get('mbt_name'),
            'mbt_sort_no'                   => Input::get('mbt_sort_no'),
            'last_kind'                     => INSERT,
            'last_ipadrs'                   => CLIENT_IP_ADRS,
            'last_date'                     => date('y-m-d H:i:s'),
            'last_user'                     => Auth::user()->id
        );
        if ( $clsMbt->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.clinics.booking.templates.index',$clinic_id);
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.clinics.booking.templates.edit', [$clinic_id, $id]);
        }
    }

    /**
     * 
     */
    public function delete($clinic_id, $id)
    {
        $clsMbt = new BookingTemplateModel();
        $dataDelete = array(
            'last_kind'         => DELETE,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => Auth::user()->id,
            'last_date'         => date('y-m-d H:i:s'),
        );

        if ( $clsMbt->update($id, $dataDelete) ) {
            Session::flash('success', trans('common.message_delete_success'));
            return redirect()->route('ortho.clinics.booking.templates.index',$clinic_id);
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
            return redirect()->route('ortho.clinics.booking.templates.edit', [$clinic_id, $id]);
        }
    }

    /**
     * 
     */
    public function orderby_top($clinic_id)
    {
        $clsMbt = new BookingTemplateModel();
        $id = Input::get('id');
        $this->top($clsMbt, $id, 'mbt_sort_no');
        return redirect()->route('ortho.clinics.booking.templates.index',$clinic_id);
    }

    /**
     * 
     */
    public function orderby_last($clinic_id)
    {
        $clsMbt = new BookingTemplateModel();
        $id = Input::get('id');        
        $this->last($clsMbt, $id, 'mbt_sort_no');
        return redirect()->route('ortho.clinics.booking.templates.index',$clinic_id);
    }

    /**
     * 
     */
    public function orderby_up($clinic_id)
    {
        $clsMbt = new BookingTemplateModel();
        $id = Input::get('id');
        $mbts = $clsMbt->get_all($clinic_id);
        
        $this->up($clsMbt, $id, $mbts, 'mbt_id', 'mbt_sort_no');

        return redirect()->route('ortho.clinics.booking.templates.index',$clinic_id);
    }

    /**
     * 
     */
    public function orderby_down($clinic_id)
    {
        $clsMbt = new BookingTemplateModel();
        $id = Input::get('id');
        $mbts = $clsMbt->get_all($clinic_id);
        $this->down($clsMbt, $id, $mbts, 'mbt_id', 'mbt_sort_no');
        return redirect()->route('ortho.clinics.booking.templates.index',$clinic_id);
    }
}
