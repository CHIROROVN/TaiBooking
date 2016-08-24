<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Models\Ortho\HiyarihattoModel;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;
use Mail;
use Response;

class HiyarihattoController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth', ['except' => ['getInput', 'postInput', 'confirm', 'sent']]);
    }

    /**
     * get form input
     */
    public function getInput()
    {
        if(Session::has('hiyarihatto')) Session::forget('hiyarihatto');
        return view('backend.ortho.hiyarihatto.input');
    }

    public function postInput()
    {
        if(Session::has('hiyarihatto')) Session::forget('hiyarihatto');
        $clsHiyarihatto = new HiyarihattoModel();
        $validator      = Validator::make(Input::all(), $clsHiyarihatto->Rules(), $clsHiyarihatto->Messages());

        if ($validator->fails()) {
            return redirect()->route('ortho.hiyarihatto.input')->withErrors($validator)->withInput();
        }

        $input = array();
        $input['year']                  = Input::get('year');
        $input['month']                 = Input::get('month');
        $input['day']                   = Input::get('day');
        $input['hour']                  = Input::get('hour');
        $input['place']                 = Input::get('place');
        $input['sex']                   = Input::get('sex');
        $input['age']                   = Input::get('age');
        $input['other_input']           = Input::get('other_input');
        $input['scene']                 = Input::get('scene');
        $input['contents']              = Input::get('contents');
        $input['party']                 = Input::get('party');
        $input['medical_device']        = Input::get('medical_device');
        $input['occurrence']            = Input::get('occurrence');
        $input['affect_text']           = Input::get('affect_text');
        $input['defect']                = Input::get('defect');
        $input['medical_error']         = Input::get('medical_error');
        $input['malfunction']           = Input::get('malfunction');
        $input['handle']                = Input::get('handle');
        $input['placement']             = Input::get('placement');
        $input['quantity']              = Input::get('quantity');
        $input['medical_text']          = Input::get('medical_text');
        $input['education']             = Input::get('education');
        $input['edu_text']              = Input::get('edu_text');
        $input['other']                 = Input::get('other');
        $input['impact']                = Input::get('impact');
        $input['solution']              = Input::get('solution');
        $input['name']                  = Input::get('name');
        //$input = (object) $input;
        Session::put('hiyarihatto', $input);
        return redirect()->route('ortho.hiyarihatto.confirm');

    }

    public function confirm()
    {
        $hiyarihatto = Session::get('hiyarihatto');
        return view('backend.ortho.hiyarihatto.confirm', $hiyarihatto);
    }

    public function sent()
    {
        return view('backend.ortho.hiyarihatto.sent');
    }

}
