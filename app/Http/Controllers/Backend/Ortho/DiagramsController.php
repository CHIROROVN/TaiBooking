<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Ortho\UserModel;

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
		$data 						= array();
		$clsUser                	= new UserModel();
        $data['doctors']        	= $clsUser->get_by_belong([1]);
        $data['doctor_id'] 			= Input::get('doctor_id');
        
        $htmlDiagram = '<table class="table table-bordered table--indiagram">
                        <tr>
                          <td align="center" class="col-title" colspan="2">時間帯</td>
                          <td align="center" class="col-title">本院</td>
                          <td align="center" class="col-title">Dr.</td>
                        </tr>
                        <tr>
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
                        </tr>
                      </table>';
        $tempDiagram[] = array(
            'title' => $htmlDiagram,
            'start' => '2016-07-01',
            'end' => '2016-07-02',
            'url' => '',
        );
        
         $data['bookings'] 			= json_encode($tempDiagram);
		return view('backend.ortho.diagrams.index', $data);
	}
}