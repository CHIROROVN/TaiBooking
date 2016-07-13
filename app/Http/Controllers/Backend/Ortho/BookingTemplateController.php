<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Models\Ortho\BookingTemplateModel;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\FacilityModel;
use App\Http\Models\Ortho\BookingModel;
use App\Http\Models\Ortho\TemplateModel;
use App\Http\Models\Ortho\ServiceModel;
use App\Http\Models\Ortho\ClinicServiceModel;
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
        $clsClinicService           = new ClinicServiceModel();
        $data['booking_template']   = $clsBookingTemplate->get_by_id($id);
        $data['clinic']             = $clsClinic->get_by_id($clinic_id);
        $data['facilitys']          = $clsFacility->getAll();
        $services                   = $clsClinicService->getAll($clinic_id);
        $data['times']              = Config::get('constants.TIME');

        $arrServices                = array();
        foreach ( $services as $service ) {
            $arrServices[$service->clinic_service_id] = $service;
        }
        $data['services']           = $arrServices;

        $templates                  = $clsTemplate->get_all($id);
        $arr_templates              = array();
        foreach ( $data['times'] as $time ) {
            $time_replate = str_replace (':', '', $time);
            foreach ( $data['facilitys'] as $fac ) {
                foreach ( $templates as $template ) {
                    if ( $template->facility_id == $fac->facility_id && $template->template_time == $time_replate ) {
                        $arr_templates[$fac->facility_id][$time] = $template;
                    }
                }
            }
        }
        $data['arr_templates']       = $arr_templates;
        // echo '<pre>';
        // print_r($arr_templates);
        // echo '</pre>';die;

        return view('backend.ortho.clinics.booking.templates.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($clinic_id, $id)
    {
        $clsMbt                     = new BookingTemplateModel();
        $clsTemplate                = new TemplateModel();
       
        // $validator                  = Validator::make(Input::all(), $rules, $clsMbt->Messages());
        // if ($validator->fails()) {
        //     return redirect()->route('ortho.clinics.booking.templates.edit', [$clinic_id, $id])->withErrors($validator)->withInput();
        // }

        $dataUpdate = array(
            'clinic_id'                     => $clinic_id,
            'mbt_name'                      => Input::get('mbt_name'),

            'last_kind'                     => UPDATE,
            'last_ipadrs'                   => CLIENT_IP_ADRS,
            'last_date'                     => date('y-m-d H:i:s'),
            'last_user'                     => Auth::user()->id
        );

        // update to table m_booking_template
        $update1 = $clsMbt->update($id, $dataUpdate);

        // update to table m_template
        $dataInsert = array(
            'mbt_id'                        => $id,
            'last_kind'                     => INSERT,
            'last_ipadrs'                   => CLIENT_IP_ADRS,
            'last_date'                     => date('y-m-d H:i:s'),
            'last_user'                     => Auth::user()->id
        );
        $dataUpdate = array();
        $dataUpdate = array(
            'last_kind'                     => UPDATE,
            'last_ipadrs'                   => CLIENT_IP_ADRS,
            'last_date'                     => date('y-m-d H:i:s'),
            'last_user'                     => Auth::user()->id
        );
        $dataDelete = array(
            'last_kind'                     => DELETE,
            'last_ipadrs'                   => CLIENT_IP_ADRS,
            'last_date'                     => date('y-m-d H:i:s'),
            'last_user'                     => Auth::user()->id
        );

        $dataNews               = Input::get('facility_service_time');
        $dataOlds               = $clsTemplate->get_all($id);

        // position old
        $tmpDataOld = array();
        foreach ( $dataOlds as $key => $value ) {
            $tmpDataOld[$value->facility_id . '|' . $value->template_time] = $value;
        }

        $update2 = false;
        if ( count($dataNews) ) {
            foreach ( $dataNews as $itemKey => $itemValue ) {
                $tmp = explode('|', $itemValue);

                // if no change position
                // (1): no change clinic_service_id => unset
                // (2): change clinic_service_id => update and unset
                if ( isset($tmpDataOld[$tmp[0] . '|' . $tmp[2]]) ) {
                    if ( $tmpDataOld[$tmp[0] . '|' . $tmp[2]]->clinic_service_id == $tmp[1] ) {
                        // (1)
                        unset($tmpDataOld[$tmp[0] . '|' . $tmp[2]]);
                    } else {
                        // (2)
                        $dataUpdate['clinic_service_id'] = $tmp[1];
                        $update2 = $clsTemplate->update($tmpDataOld[$tmp[0] . '|' . $tmp[2]]->template_id, $dataUpdate);
                        unset($dataUpdate['clinic_service_id']);
                        unset($tmpDataOld[$tmp[0] . '|' . $tmp[2]]);
                    }
                } else {
                    // insert new
                    $dataInsert['facility_id']          = $tmp[0];
                    $dataInsert['clinic_service_id']    = $tmp[1];
                    $dataInsert['template_time']        = $tmp[2];
                    $update2 = $clsTemplate->insert($dataInsert);
                }
            }
        }
        // delete old
        if ( count($tmpDataOld) ) {
            foreach ( $tmpDataOld as $itemOld => $keyOld ) {
                $update2 = $clsTemplate->update($keyOld->template_id, $dataDelete);
                unset($tmpDataOld[$itemOld]);
            }
        }

        if ( $update1 && $update2 ) {
            Session::flash('success', trans('common.message_edit_success'));
            return redirect()->route('ortho.clinics.booking.templates.index', $clinic_id);
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
            return redirect()->route('ortho.clinics.booking.templates.index', [ $clinic_id, $id ]);
        }
    }

    /**
     * 
     */
    public function delete($clinic_id, $id)
    {
        $clsMbt                 = new BookingTemplateModel();
        $clsTemplate            = new TemplateModel();

        $dataDelete             = array(
            'last_kind'         => DELETE,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => Auth::user()->id,
            'last_date'         => date('y-m-d H:i:s'),
        );

        // delete table m_booking_template
        $delete1 = $clsMbt->update($id, $dataDelete);
        // delete table m_template
        $delete2 = $clsTemplate->updateByMbtId($id, $dataDelete);

        if ( $delete1 && $delete2 ) {
            Session::flash('success', trans('common.message_delete_success'));
            return redirect()->route('ortho.clinics.booking.templates.index', $clinic_id);
        } else {
            Session::flash('danger', trans('common.message_delete_danger'));
            return redirect()->route('ortho.clinics.booking.templates.index', [ $clinic_id ]);
        }
    }


    public function setBookingTemplate()
    {
        $data               = array();
        $clsClinic          = new ClinicModel();
        $data['clinics']    = $clsClinic->get_list_clinic();

        return view('backend.ortho.bookings.booking_template_set', $data);
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
