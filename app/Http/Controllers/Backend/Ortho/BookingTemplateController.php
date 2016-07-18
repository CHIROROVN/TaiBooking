<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Models\Ortho\BookingTemplateModel;
use App\Http\Models\Ortho\ClinicModel;
use App\Http\Models\Ortho\FacilityModel;
use App\Http\Models\Ortho\BookingModel;
use App\Http\Models\Ortho\TemplateModel;
use App\Http\Models\Ortho\ServiceModel;
use App\Http\Models\Ortho\ClinicServiceModel;

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
        $data['facilitys']          = $clsFacility->getAll($clinic_id);
        $data['facilitys_popup']    = $clsFacility->getAll($clinic_id, 1);
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

        $update2 = true;
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
                        $dataUpdate['template_group_id'] = $tmp[3];
                        $update2 = $clsTemplate->update($tmpDataOld[$tmp[0] . '|' . $tmp[2]]->template_id, $dataUpdate);
                        unset($dataUpdate['clinic_service_id']);
                        unset($dataUpdate['template_group_id']);
                        unset($tmpDataOld[$tmp[0] . '|' . $tmp[2]]);
                    }
                } else {
                    // insert new
                    $dataInsert['facility_id']          = $tmp[0];
                    $dataInsert['clinic_service_id']    = $tmp[1];
                    $dataInsert['template_time']        = $tmp[2];
                    $dataInsert['template_group_id']    = (isset($tmp[3])) ? $tmp[3] : '';
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

        if ( $update2 ) {
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
        $data                   = array();
        $data['s_clinic_id']    = Input::get('s_clinic_id');
        $clsClinic              = new ClinicModel();
        $clsBooking             = new BookingModel();
        $data['clinics']        = $clsClinic->get_list_clinic();

        $bookings               = $clsBooking->get_all($data);
        if ( empty(Input::get('s_clinic_id')) ) {
            $bookings = array();
        }
        $tmpBookings            = array();
        foreach ( $bookings as $booking ) {
            $tmpBookings[]      = array(
                'title'         => 'xxxxxxx',
                'start'         => $booking->booking_date,
                'end'           => $booking->booking_date + 1,
                'url'           => '',
                'className'     => 'booking-template-set',
            );
        }
        $data['bookings']      = json_encode($tmpBookings);

        return view('backend.ortho.bookings.booking_template_set', $data);
    }


    public function getBookingTemplateDaily()
    {
        $data['date'] = date('Y-m-d');
        if ( Input::get('date') ) {
            $data['date'] = Input::get('date');
        }

        $data['s_mbt_id']           = Input::get('s_mbt_id');

        $clsFacility                = new FacilityModel();
        $clsTemplate                = new TemplateModel();
        $clsService                 = new ServiceModel();
        $clsClinicService           = new ClinicServiceModel();
        $clsBookingTemplate         = new BookingTemplateModel();
        $clsClinic                  = new ClinicModel();
        $data['clinic']             = $clsClinic->get_by_id(Input::get('clinic_id'));
        $data['facilitys']          = $clsFacility->getAll(@$data['clinic']->clinic_id);
        $data['facilitys_popup']    = $clsFacility->getAll(@$data['clinic']->clinic_id, 1);
        $services                   = $clsClinicService->getAll(@$data['clinic']->clinic_id);
        $data['times']              = Config::get('constants.TIME');
        $data['booking_templates']  = $clsBookingTemplate->get_list();

        $arrServices                = array();
        foreach ( $services as $service ) {
            $arrServices[$service->clinic_service_id] = $service;
        }
        $data['services']           = $arrServices;

        $templates                  = $clsTemplate->get_all(Input::get('s_mbt_id'));
        if ( empty(Input::get('s_mbt_id')) ) {
            $templates = array();
        }

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
        // print_r($data['arr_templates']);
        // echo '</pre>';die;

        return view('backend.ortho.bookings.booking_template_daily', $data);
    }


    public function postBookingTemplateDaily()
    {
        $clsTemplate                = new TemplateModel();
        $clsFacility                = new FacilityModel();
        $clsBooking                 = new BookingModel();
        $clsClinicService           = new ClinicServiceModel();
        $facilitys                  = $clsFacility->getAll(Input::get('clinic_id'));
        $clinicServices             = $clsClinicService->getAll();

        $mbt_id = Input::get('mbt_id');
        $templates = array();
        if ( !empty($mbt_id) ) {
            $templates = $clsTemplate->get_all($mbt_id);
        }
        
        if ( count($templates) ) {
            foreach ( $templates as $template ) {
                foreach ( $facilitys as $facility ) {
                    if ( $facility->facility_id == $template->facility_id ) {
                        // insert to table "t_booking"
                        $data                           = array();
                        $data['booking_date']           = Input::get('date');
                        $data['booking_start_time']     = $template->template_time;
                        $data['booking_total_time']     = 0;
                        $data['clinic_id']              = Input::get('clinic_id');
                        $data['facility_id']            = $template->facility_id;
                        foreach ( $clinicServices as $clinicService ) {
                            if ( $clinicService->clinic_service_id == $template->clinic_service_id ) {
                                $data['service_1']          = $clinicService->service_id; //error service here
                                $data['service_1_kind']     = 1;
                            } else {
                                if ( $template->clinic_service_id == -1 ) {
                                    $data['service_1']          = -1;
                                    $data['service_1_kind']     = 2;
                                }
                            }
                        }
                        $data['booking_group_id']       = $template->template_group_id;

                        $data['last_date']              = date('y-m-d H:i:s');
                        $data['last_kind']              = INSERT;
                        $data['last_ipadrs']            = $_SERVER['REMOTE_ADDR'];
                        $data['last_user']              = Auth::user()->id;

                        $where = array(
                            'booking_start_time'    => $template->template_time,
                            'booking_group_id'      => $template->template_group_id,
                            'booking_date'          => Input::get('date'),
                            'clinic_id'             => Input::get('clinic_id'),
                        );
                        $booking = $clsBooking->checkExist($where);
                        if ( !empty($booking) ) {
                            $clsBooking->update($booking->booking_id, $data);
                        } else {
                            $clsBooking->insert($data);
                        }
                    }
                }
            }
        }

        return redirect()->route('ortho.bookings.template.daily', [ 'clinic_id' => Input::get('clinic_id'), 'date' => Input::get('date'), 's_mbt_id' => Input::get('mbt_id') ]);
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


    public function getTotalTimeClinicService()
    {
        $clinic_service_id = Input::get('clinic_service_id');

        $clsClinicService = new ClinicServiceModel();
        $clinicService = $clsClinicService->get_by_id($clinic_service_id);

        $tmpArr = array();
        $startTime = Input::get('startTime');
        $hour = (int)substr($startTime, 0, 2);
        $min = (int)substr($startTime, 2, 2);
        
        $totalTime = 0;
        // 1
        if ( !empty($clinicService->service_facility_1) && !empty($clinicService->service_time_1) ) {
            $totalTime += $clinicService->service_time_1;

            $n = $clinicService->service_time_1 / 15;
            if ( $min < 10 ) {
                $min = '0' . $min;
            }
            if ( strlen($hour) < 2 ) {
                $hour = '0' . $hour;
            }
            $tmpArr[] = array(
                'facility_id' => $clinicService->service_facility_1,
                'clinic_service' => $clinicService->clinic_service_id,
                'time' => $hour.$min,
                'group' => 'group_' . $startTime . '_' . $clinicService->clinic_service_id . '_' . $clinicService->clinic_id . '_' . $clinicService->service_id,
            );
            for ( $i = 2; $i <= $n; $i++ ) {
                $min = $min + 15;
                if ( $min > 45 ) {
                    $hour = $hour + 1;
                    $min = 0;
                }
                if ( $min < 10 ) {
                    $min = '0' . $min;
                }
                if ( strlen($hour) < 2 ) {
                    $hour = '0' . $hour;
                }

                $tmpArr[] = array(
                    'facility_id' => $clinicService->service_facility_1,
                    'clinic_service' => $clinicService->clinic_service_id,
                    'time' => $hour.$min,
                    'group' => 'group_' . $startTime . '_' . $clinicService->clinic_service_id . '_' . $clinicService->clinic_id . '_' . $clinicService->service_id,
                );
            }
        }

        // 2
        if ( !empty($clinicService->service_facility_2) && !empty($clinicService->service_time_2) ) {
            $totalTime += $clinicService->service_time_2;

            $n = $clinicService->service_time_2 / 15;
            for ( $i = 1; $i <= $n; $i++ ) {
                $min = $min + 15;
                if ( $min > 45 ) {
                    $hour = $hour + 1;
                    $min = 0;
                }
                if ( $min < 10 ) {
                    $min = '0' . $min;
                }
                if ( strlen($hour) < 2 ) {
                    $hour = '0' . $hour;
                }

                $tmpArr[] = array(
                    'facility_id' => $clinicService->service_facility_2,
                    'clinic_service' => $clinicService->clinic_service_id,
                    'time' => $hour.$min,
                    'group' => 'group_' . $startTime . '_' . $clinicService->clinic_service_id . '_' . $clinicService->clinic_id . '_' . $clinicService->service_id,
                );
            }
        }
         // 3
        if ( !empty($clinicService->service_facility_3) && !empty($clinicService->service_time_3) ) {
            $totalTime += $clinicService->service_time_3;

            $n = $clinicService->service_time_3 / 15;
            for ( $i = 1; $i <= $n; $i++ ) {
                $min = $min + 15;
                if ( $min > 45 ) {
                    $hour = $hour + 1;
                    $min = 0;
                }
                if ( $min < 10 ) {
                    $min = '0' . $min;
                }
                if ( strlen($hour) < 2 ) {
                    $hour = '0' . $hour;
                }

                $tmpArr[] = array(
                    'facility_id' => $clinicService->service_facility_3,
                    'clinic_service' => $clinicService->clinic_service_id,
                    'time' => $hour.$min,
                    'group' => 'group_' . $startTime . '_' . $clinicService->clinic_service_id . '_' . $clinicService->clinic_id . '_' . $clinicService->service_id,
                );
            }
        }

        // 4
        if ( !empty($clinicService->service_facility_4) && !empty($clinicService->service_time_4) ) {
            $totalTime += $clinicService->service_time_4;

            $n = $clinicService->service_time_4 / 15;
            for ( $i = 1; $i <= $n; $i++ ) {
                $min = $min + 15;
                if ( $min > 45 ) {
                    $hour = $hour + 1;
                    $min = 0;
                }
                if ( $min < 10 ) {
                    $min = '0' . $min;
                }
                if ( strlen($hour) < 2 ) {
                    $hour = '0' . $hour;
                }

                $tmpArr[] = array(
                    'facility_id' => $clinicService->service_facility_4,
                    'clinic_service' => $clinicService->clinic_service_id,
                    'time' => $hour.$min,
                    'group' => 'group_' . $startTime . '_' . $clinicService->clinic_service_id . '_' . $clinicService->clinic_id . '_' . $clinicService->service_id,
                );
            }
        }

        // 5
        if ( !empty($clinicService->service_facility_5) && !empty($clinicService->service_time_5) ) {
            $totalTime += $clinicService->service_time_5;

            $n = $clinicService->service_time_5 / 15;
            for ( $i = 1; $i <= $n; $i++ ) {
                $min = $min + 15;
                if ( $min > 45 ) {
                    $hour = $hour + 1;
                    $min = 0;
                }
                if ( $min < 10 ) {
                    $min = '0' . $min;
                }
                if ( strlen($hour) < 2 ) {
                    $hour = '0' . $hour;
                }

                $tmpArr[] = array(
                    'facility_id' => $clinicService->service_facility_5,
                    'clinic_service' => $clinicService->clinic_service_id,
                    'time' => $hour.$min,
                    'group' => 'group_' . $startTime . '_' . $clinicService->clinic_service_id . '_' . $clinicService->clinic_id . '_' . $clinicService->service_id,
                );
            }
        }

        echo json_encode(['tmpArr' => $tmpArr, 'totalTime' => $totalTime]);
    }


    public function editBookingTemplateDailyAjax()
    {
        $clsBooking = new BookingModel();

        $dataUpdate = array(
            'last_date'             => date('y-m-d H:i:s'),
            'last_kind'             => DELETE,
            'last_ipadrs'           => $_SERVER['REMOTE_ADDR'],
            'last_user'             => Auth::user()->id
        );
        $where = array(
            'booking_start_time'    => Input::get('booking_start_time'),
            'booking_group_id'      => Input::get('booking_group_id'),
            'booking_date'          => Input::get('booking_date'),
            'clinic_id'             => Input::get('clinic_id'),
        );
        $booking = $clsBooking->checkExist($where);
        $status = '';
        if ( !empty($booking) ) {
            $status = $clsBooking->update($booking->booking_id, $dataUpdate);
        }

        echo json_encode(array('status', $status));
    }
}
