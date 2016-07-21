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
      $bookings                 = $clsBooking->get_all($where);
      $data['doctors']        	= $clsUser->get_by_belong([1]);
      
      // for in month
      $date_current             = date('Y-m-d');
      $month                    = date('m');
      $year                     = date('Y');
      $days                     = getDay($month, $year);
      $tempDiagram              = array();
      foreach ( $days as $day ) {
        $dayName = DayJp($year . '-' . $month . '-' . $day);
        $str = '<table class="table table-bordered table--indiagram custom-indiagram"><tbody>';
        $str .= '<tr>
                  <td align="center" class="col-title" colspan="2">時間帯</td>
                  <td align="center" class="col-title">本院</td>
                  <td align="center" class="col-title">Dr.</td>
                </tr>';

        // set Satuday
        if ( $dayName == '土' ) {
          $str .= '<tr>
                  <td rowspan="2">午前</td>
                  <td>1</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>
                <tr>
                  <td rowspan="2">午後</td>
                  <td>1</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>';
        // set Sunday
        } elseif ( $dayName == '日' ) {
          $str .= '<tr>
                  <td rowspan="2">午前</td>
                  <td>1</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>
                <tr>
                  <td rowspan="2">午後</td>
                  <td>1</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>';
        // set Tuesday
        } elseif ( $dayName == '火' ) {
          $str .= '<tr>
                  <td rowspan="1">午前</td>
                  <td>1</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>
                <tr>
                  <td rowspan="4">午後</td>
                  <td>1</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>';
        // set Wednesday/Thursday/Friday
        } else {
          $str .= '<tr>
                  <td rowspan="1">午前</td>
                  <td>1</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>
                <tr>
                  <td rowspan="4">午後</td>
                  <td>1</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>0%</td>
                  <td>0%</td>
                </tr>';
        }
        
        $str .= '</tbody></table>';

        // set Monday
        if ( $dayName == '月' ) {
          $str = '<p class="col-pspec">休診日</p>';
        }

        $tempDiagram[] = array(
          'title' => $str,
          'start' => $year . '-' . $month . '-' . $day,
          'end' => addOneDay($year . '-' . $month . '-' . $day),
          'url' => '',
          'color' => 'white',
          'textColor' => '#257272'
        );
      }

      // echo '<pre>';
      // print_r($bookings);
      // echo '</pre>';die;

      $data['bookings'] 			= json_encode($tempDiagram);

  		return view('backend.ortho.diagrams.index', $data);
  	}
}