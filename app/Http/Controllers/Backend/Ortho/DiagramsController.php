<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Ortho\UserModel;
use App\Http\Models\Ortho\BookingModel;
use Form;
use Input;

class DiagramsController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

  	public function index(){
  		$data 						        = array();
      $data['doctor_id']        = Input::get('doctor_id');

  		$clsUser                	= new UserModel();
      $clsBooking               = new BookingModel();
      $where = array(
        'u_id' => $data['doctor_id']
      );
      $data['doctors']        	= $clsUser->get_by_belong([1]);

      // for in month
      $date_current             = date('Y-m-d');
      if ( Input::get('date') ) {
        $date_current           = Input::get('date');
      }
      $month                    = explode('-', $date_current)[1];
      $year                     = explode('-', $date_current)[0];
      $days                     = getDay($month, $year);
      $tempDiagram              = array();
      foreach ( $days as $day ) {
        $dayName = DayJp($year . '-' . $month . '-' . $day);
        $date_current = $year . '-' . $month . '-' . $day;

        $str = '<table class="table table-bordered table--indiagram custom-indiagram"><tbody>';
        $str .= '<tr>
                  <td align="center" class="col-title" colspan="2">時間帯</td>
                  <td align="center" class="col-title">本院</td>
                  <td align="center" class="col-title">Dr.</td>
                </tr>';

        // set Satuday
        if ( $dayName == '土' ) {
          // AM
          $countTotal1AM          = $clsBooking->countTotal($date_current, 1000, 1130);
          $countTotalPatient1AM   = $clsBooking->countTotal($date_current, 1000, 1130, true);
          $percent1AM             = ($countTotalPatient1AM == 0) ? 0 : floor($countTotalPatient1AM * 100 / $countTotal1AM);
          $countTotal2AM          = $clsBooking->countTotal($date_current, 1130, 1230);
          $countTotalPatient2AM   = $clsBooking->countTotal($date_current, 1130, 1230, true);
          $percent2AM             = ($countTotalPatient2AM == 0) ? 0 : floor($countTotalPatient2AM * 100 / $countTotal2AM);
          // PM
          $countTotal1PM          = $clsBooking->countTotal($date_current, 1430, 1600);
          $countTotalPatient1PM   = $clsBooking->countTotal($date_current, 1430, 1600, true);
          $percent1PM             = ($countTotalPatient1PM == 0) ? 0 : floor($countTotalPatient1PM * 100 / $countTotal1PM);
          $countTotal2PM          = $clsBooking->countTotal($date_current, 1600, 1730);
          $countTotalPatient2PM   = $clsBooking->countTotal($date_current, 1600, 1730, true);
          $percent2PM             = ($countTotalPatient2PM == 0) ? 0 : floor($countTotalPatient2PM * 100 / $countTotal2PM);
          
          $percent1AMDoctor = 0;
          $percent2AMDoctor = 0;
          $percent1PMDoctor = 0;
          $percent2PMDoctor = 0;
          if ( !empty($data['doctor_id']) ) {
            // AM Doctor
            $countTotal1AMAll             = $clsBooking->countTotal($date_current, 1000, 1130);
            $countTotal1AMAllDoctor       = $clsBooking->countTotal($date_current, 1000, 1130, false, $data['doctor_id']);
            $percent1AMDoctor             = ($countTotal1AMAllDoctor == 0) ? 0 : floor($countTotal1AMAllDoctor * 100 / $countTotal1AMAll);
            $countTotal2AMAll             = $clsBooking->countTotal($date_current, 1130, 1230);
            $countTotal2AMAllDoctor       = $clsBooking->countTotal($date_current, 1130, 1230, false, $data['doctor_id']);
            $percent2AMDoctor             = ($countTotal2AMAllDoctor == 0) ? 0 : floor($countTotal2AMAllDoctor * 100 / $countTotal2AMAll);
            // PM Doctor
            $countTotal1PMAll             = $clsBooking->countTotal($date_current, 1430, 1600);
            $countTotal1PMAllDoctor       = $clsBooking->countTotal($date_current, 1430, 1600, false, $data['doctor_id']);
            $percent1PMDoctor             = ($countTotal1PMAllDoctor == 0) ? 0 : floor($countTotal1PMAllDoctor * 100 / $countTotal1PMAll);
            $countTotal2PMAll             = $clsBooking->countTotal($date_current, 1600, 1730);
            $countTotal2PMAllDoctor       = $clsBooking->countTotal($date_current, 1600, 1730, false, $data['doctor_id']);
            $percent2PMDoctor             = ($countTotal2PMAllDoctor == 0) ? 0 : floor($countTotal2PMAllDoctor * 100 / $countTotal2PMAll);
          }

          $str .= '<tr>
                    <td rowspan="2">午前</td>
                    <td>1</td>
                    <td class="' . checkPercent($percent1AM) . '">' . $percent1AM . '%</td>
                    <td class="' . checkPercent($percent1AMDoctor) . '">' . $percent1AMDoctor . '%</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td class="' . checkPercent($percent2AM) . '">' . $percent2AM . '%</td>
                    <td class="' . checkPercent($percent2AMDoctor) . '">' . $percent2AMDoctor . '%</td>
                  </tr>
                  <tr>
                    <td rowspan="2">午後</td>
                    <td>1</td>
                    <td class="' . checkPercent($percent1PM) . '">' . $percent1PM . '%</td>
                    <td class="' . checkPercent($percent1PMDoctor) . '">' . $percent1PMDoctor . '%</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td class="' . checkPercent($percent2PM) . '">' . $percent2PM . '%</td>
                    <td class="' . checkPercent($percent2PMDoctor) . '">' . $percent2PMDoctor . '%</td>
                  </tr>';
        // set Sunday
        } elseif ( $dayName == '日' ) {
          // AM
          $countTotal1AM          = $clsBooking->countTotal($date_current, 1000, 1130);
          $countTotalPatient1AM   = $clsBooking->countTotal($date_current, 1000, 1130, true);
          $percent1AM             = ($countTotalPatient1AM == 0) ? 0 : floor($countTotalPatient1AM * 100 / $countTotal1AM);
          $countTotal2AM          = $clsBooking->countTotal($date_current, 1130, 1230);
          $countTotalPatient2AM   = $clsBooking->countTotal($date_current, 1130, 1230, true);
          $percent2AM             = ($countTotalPatient2AM == 0) ? 0 : floor($countTotalPatient2AM * 100 / $countTotal2AM);
          // PM
          $countTotal1PM          = $clsBooking->countTotal($date_current, 1430, 1600);
          $countTotalPatient1PM   = $clsBooking->countTotal($date_current, 1430, 1600, true);
          $percent1PM             = ($countTotalPatient1PM == 0) ? 0 : floor($countTotalPatient1PM * 100 / $countTotal1PM);
          $countTotal2PM          = $clsBooking->countTotal($date_current, 1600, 1700);
          $countTotalPatient2PM   = $clsBooking->countTotal($date_current, 1600, 1700, true);
          $percent2PM             = ($countTotalPatient2PM == 0) ? 0 : floor($countTotalPatient2PM * 100 / $countTotal2PM);
          
          $percent1AMDoctor = 0;
          $percent2AMDoctor = 0;
          $percent1PMDoctor = 0;
          $percent2PMDoctor = 0;
          if ( !empty($data['doctor_id']) ) {
            // AM Doctor
            $countTotal1AMAll             = $clsBooking->countTotal($date_current, 1000, 1130);
            $countTotal1AMAllDoctor       = $clsBooking->countTotal($date_current, 1000, 1130, false, $data['doctor_id']);
            $percent1AMDoctor             = ($countTotal1AMAllDoctor == 0) ? 0 : floor($countTotal1AMAllDoctor * 100 / $countTotal1AMAll);
            $countTotal2AMAll             = $clsBooking->countTotal($date_current, 1130, 1230);
            $countTotal2AMAllDoctor       = $clsBooking->countTotal($date_current, 1130, 1230, false, $data['doctor_id']);
            $percent2AMDoctor             = ($countTotal2AMAllDoctor == 0) ? 0 : floor($countTotal2AMAllDoctor * 100 / $countTotal2AMAll);
            // PM Doctor
            $countTotal1PMAll             = $clsBooking->countTotal($date_current, 1430, 1600);
            $countTotal1PMAllDoctor       = $clsBooking->countTotal($date_current, 1430, 1600, false, $data['doctor_id']);
            $percent1PMDoctor             = ($countTotal1PMAllDoctor == 0) ? 0 : floor($countTotal1PMAllDoctor * 100 / $countTotal1PMAll);
            $countTotal2PMAll             = $clsBooking->countTotal($date_current, 1600, 1700);
            $countTotal2PMAllDoctor       = $clsBooking->countTotal($date_current, 1600, 1700, false, $data['doctor_id']);
            $percent2PMDoctor             = ($countTotal2PMAllDoctor == 0) ? 0 : floor($countTotal2PMAllDoctor * 100 / $countTotal2PMAll);
          }
          $str .= '<tr>
                    <td rowspan="2">午前</td>
                    <td>1</td>
                    <td class="' . checkPercent($percent1AM) . '">' . $percent1AM . '%</td>
                    <td class="' . checkPercent($percent1AMDoctor) . '">' . $percent1AMDoctor . '%</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td class="' . checkPercent($percent2AM) . '">' . $percent2AM . '%</td>
                    <td class="' . checkPercent($percent2AMDoctor) . '">' . $percent2AMDoctor . '%</td>
                  </tr>
                  <tr>
                    <td rowspan="2">午後</td>
                    <td>1</td>
                    <td class="' . checkPercent($percent1PM) . '">' . $percent1PM . '%</td>
                    <td class="' . checkPercent($percent1PMDoctor) . '">' . $percent1PMDoctor . '%</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td class="' . checkPercent($percent2PM) . '">' . $percent2PM . '%</td>
                    <td class="' . checkPercent($percent2PMDoctor) . '">' . $percent2PMDoctor . '%</td>
                  </tr>';
        // set Tuesday
        } elseif ( $dayName == '火' ) {
          // AM
          $countTotal1AM          = $clsBooking->countTotal($date_current, 930, 1215);
          $countTotalPatient1AM   = $clsBooking->countTotal($date_current, 930, 1215, true);
          $percent1AM             = ($countTotalPatient1AM == 0) ? 0 : floor($countTotalPatient1AM * 100 / $countTotal1AM);
          // PM
          $countTotal1PM          = $clsBooking->countTotal($date_current, 1400, 1500);
          $countTotalPatient1PM   = $clsBooking->countTotal($date_current, 1400, 1500, true);
          $percent1PM             = ($countTotalPatient1PM == 0) ? 0 : floor($countTotalPatient1PM * 100 / $countTotal1PM);
          $countTotal2PM          = $clsBooking->countTotal($date_current, 1500, 1630);
          $countTotalPatient2PM   = $clsBooking->countTotal($date_current, 1500, 1630, true);
          $percent2PM             = ($countTotalPatient2PM == 0) ? 0 : floor($countTotalPatient2PM * 100 / $countTotal2PM);
          $countTotal3PM          = $clsBooking->countTotal($date_current, 1630, 1800);
          $countTotalPatient3PM   = $clsBooking->countTotal($date_current, 1630, 1800, true);
          $percent3PM             = ($countTotalPatient3PM == 0) ? 0 : floor($countTotalPatient3PM * 100 / $countTotal3PM);
          $countTotal4PM          = $clsBooking->countTotal($date_current, 1800, 2000);
          $countTotalPatient4PM   = $clsBooking->countTotal($date_current, 1800, 2000, true);
          $percent4PM             = ($countTotalPatient4PM == 0) ? 0 : floor($countTotalPatient4PM * 100 / $countTotal4PM);
          
          $percent1AMDoctor = 0;
          $percent1PMDoctor = 0;
          $percent2PMDoctor = 0;
          $percent3PMDoctor = 0;
          $percent4PMDoctor = 0;
          if ( !empty($data['doctor_id']) ) {
            // AM Doctor
            $countTotal1AMAll             = $clsBooking->countTotal($date_current, 930, 1215);
            $countTotal1AMAllDoctor       = $clsBooking->countTotal($date_current, 930, 1215, false, $data['doctor_id']);
            $percent1AMDoctor             = ($countTotal1AMAllDoctor == 0) ? 0 : floor($countTotal1AMAllDoctor * 100 / $countTotal1AMAll);
            // PM Doctor
            $countTotal1PMAll             = $clsBooking->countTotal($date_current, 1400, 1500);
            $countTotal1PMAllDoctor       = $clsBooking->countTotal($date_current, 1400, 1500, false, $data['doctor_id']);
            $percent1PMDoctor             = ($countTotal1PMAllDoctor == 0) ? 0 : floor($countTotal1PMAllDoctor * 100 / $countTotal1PMAll);
            $countTotal2PMAll             = $clsBooking->countTotal($date_current, 1500, 1630);
            $countTotal2PMAllDoctor       = $clsBooking->countTotal($date_current, 1500, 1630, false, $data['doctor_id']);
            $percent2PMDoctor             = ($countTotal2PMAllDoctor == 0) ? 0 : floor($countTotal2PMAllDoctor * 100 / $countTotal2PMAll);
            $countTotal3PMAll             = $clsBooking->countTotal($date_current, 1630, 1800);
            $countTotal3PMAllDoctor       = $clsBooking->countTotal($date_current, 1630, 1800, false, $data['doctor_id']);
            $percent3PMDoctor             = ($countTotal3PMAllDoctor == 0) ? 0 : floor($countTotal3PMAllDoctor * 100 / $countTotal3PMAll);
            $countTotal4PMAll             = $clsBooking->countTotal($date_current, 1800, 2000);
            $countTotal4PMAllDoctor       = $clsBooking->countTotal($date_current, 1800, 2000, false, $data['doctor_id']);
            $percent4PMDoctor             = ($countTotal4PMAllDoctor == 0) ? 0 : floor($countTotal4PMAllDoctor * 100 / $countTotal4PMAll);
          }
          $str .= '<tr>
                    <td rowspan="1">午前</td>
                    <td>1</td>
                    <td class="' . checkPercent($percent1AM) . '">' . $percent1AM . '%</td>
                    <td class="' . checkPercent($percent1AMDoctor) . '">' . $percent1AMDoctor . '%</td>
                  </tr>
                  <tr>
                    <td rowspan="4">午後</td>
                    <td>1</td>
                    <td class="' . checkPercent($percent1PM) . '">' . $percent1PM . '%</td>
                    <td class="' . checkPercent($percent1PMDoctor) . '">' . $percent1PMDoctor . '%</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td class="' . checkPercent($percent2PM) . '">' . $percent2PM . '%</td>
                    <td class="' . checkPercent($percent2PMDoctor) . '">' . $percent2PMDoctor . '%</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td class="' . checkPercent($percent3PM) . '">' . $percent3PM . '%</td>
                    <td class="' . checkPercent($percent3PMDoctor) . '">' . $percent3PMDoctor . '%</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td class="' . checkPercent($percent4PM) . '">' . $percent4PM . '%</td>
                    <td class="' . checkPercent($percent4PMDoctor) . '">' . $percent4PMDoctor . '%</td>
                  </tr>';
        // set Wednesday/Thursday/Friday
        } else {
          // AM
          $countTotal1AM          = $clsBooking->countTotal($date_current, 900, 1130);
          $countTotalPatient1AM   = $clsBooking->countTotal($date_current, 900, 1130, true);
          $percent1AM             = ($countTotalPatient1AM == 0) ? 0 : floor($countTotalPatient1AM * 100 / $countTotal1AM);
          // PM
          $countTotal1PM          = $clsBooking->countTotal($date_current, 1300, 1430);
          $countTotalPatient1PM   = $clsBooking->countTotal($date_current, 1300, 1430, true);
          $percent1PM             = ($countTotalPatient1PM == 0) ? 0 : floor($countTotalPatient1PM * 100 / $countTotal1PM);
          $countTotal2PM          = $clsBooking->countTotal($date_current, 1430, 1600);
          $countTotalPatient2PM   = $clsBooking->countTotal($date_current, 1430, 1600, true);
          $percent2PM             = ($countTotalPatient2PM == 0) ? 0 : floor($countTotalPatient2PM * 100 / $countTotal2PM);
          $countTotal3PM          = $clsBooking->countTotal($date_current, 1600, 1800);
          $countTotalPatient3PM   = $clsBooking->countTotal($date_current, 1600, 1800, true);
          $percent3PM             = ($countTotalPatient3PM == 0) ? 0 : floor($countTotalPatient3PM * 100 / $countTotal3PM);
          $countTotal4PM          = $clsBooking->countTotal($date_current, 1800, 1900);
          $countTotalPatient4PM   = $clsBooking->countTotal($date_current, 1800, 1900, true);
          $percent4PM             = ($countTotalPatient4PM == 0) ? 0 : floor($countTotalPatient4PM * 100 / $countTotal4PM);
          
          $percent1AMDoctor = 0;
          $percent1PMDoctor = 0;
          $percent2PMDoctor = 0;
          $percent3PMDoctor = 0;
          $percent4PMDoctor = 0;
          if ( !empty($data['doctor_id']) ) {
            // AM Doctor
            $countTotal1AMAll             = $clsBooking->countTotal($date_current, 900, 1130);
            $countTotal1AMAllDoctor       = $clsBooking->countTotal($date_current, 900, 1130, false, $data['doctor_id']);
            $percent1AMDoctor             = ($countTotal1AMAllDoctor == 0) ? 0 : floor($countTotal1AMAllDoctor * 100 / $countTotal1AMAll);
            // PM Doctor
            $countTotal1PMAll             = $clsBooking->countTotal($date_current, 1300, 1430);
            $countTotal1PMAllDoctor       = $clsBooking->countTotal($date_current, 1300, 1430, false, $data['doctor_id']);
            $percent1PMDoctor             = ($countTotal1PMAllDoctor == 0) ? 0 : floor($countTotal1PMAllDoctor * 100 / $countTotal1PMAll);
            $countTotal2PMAll             = $clsBooking->countTotal($date_current, 1430, 1600);
            $countTotal2PMAllDoctor       = $clsBooking->countTotal($date_current, 1430, 1600, false, $data['doctor_id']);
            $percent2PMDoctor             = ($countTotal2PMAllDoctor == 0) ? 0 : floor($countTotal2PMAllDoctor * 100 / $countTotal2PMAll);
            $countTotal3PMAll             = $clsBooking->countTotal($date_current, 1600, 1800);
            $countTotal3PMAllDoctor       = $clsBooking->countTotal($date_current, 1600, 1800, false, $data['doctor_id']);
            $percent3PMDoctor             = ($countTotal3PMAllDoctor == 0) ? 0 : floor($countTotal3PMAllDoctor * 100 / $countTotal3PMAll);
            $countTotal4PMAll             = $clsBooking->countTotal($date_current, 1800, 1900);
            $countTotal4PMAllDoctor       = $clsBooking->countTotal($date_current, 1800, 1900, false, $data['doctor_id']);
            $percent4PMDoctor             = ($countTotal4PMAllDoctor == 0) ? 0 : floor($countTotal4PMAllDoctor * 100 / $countTotal4PMAll);
          }
          $str .= '<tr>
                    <td rowspan="1">午前</td>
                    <td>1</td>
                    <td class="' . checkPercent($percent1AM) . '">' . $percent1AM . '%</td>
                    <td class="' . checkPercent($percent1AMDoctor) . '">' . $percent1AMDoctor . '%</td>
                  </tr>
                  <tr>
                    <td rowspan="4">午後</td>
                    <td>1</td>
                    <td class="' . checkPercent($percent1AM) . '">' . $percent1AM . '%</td>
                    <td class="' . checkPercent($percent1PMDoctor) . '">' . $percent1PMDoctor . '%</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td class="' . checkPercent($percent2PM) . '">' . $percent2PM . '%</td>
                    <td class="' . checkPercent($percent2PMDoctor) . '">' . $percent2PMDoctor . '%</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td class="' . checkPercent($percent3PM) . '">' . $percent3PM . '%</td>
                    <td class="' . checkPercent($percent3PMDoctor) . '">' . $percent3PMDoctor . '%</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td class="' . checkPercent($percent4PM) . '">' . $percent4PM . '%</td>
                    <td class="' . checkPercent($percent4PMDoctor) . '">' . $percent4PMDoctor . '%</td>
                  </tr>';
        }
        
        $str .= '</tbody></table>';

        // set Monday
        if ( $dayName == '月' ) {
          $str = '<p class="col-pspec">休診日</p>';
        }

        $tempDiagram[]  = array(
          'title'       => $str,
          'start'       => $year . '-' . $month . '-' . $day,
          'end'         => addOneDay($year . '-' . $month . '-' . $day),
          'url'         => '',
          'color'       => 'white',
          'textColor'   => '#257272'
        );
      }

      $data['date']               = $date_current;
      $data['bookings'] 			    = json_encode($tempDiagram);

  		return view('backend.ortho.diagrams.index', $data);
  	}
}