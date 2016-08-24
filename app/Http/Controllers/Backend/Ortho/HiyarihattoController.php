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
        $this->middleware('auth', ['except' => ['getInput', 'postInput', 'confirmHiyar', 'sent','sendEmail','complete']]);
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
        $input['dentist']               = Input::get('dentist');
        $input['hygienist']             = Input::get('hygienist');
        $input['medical_error']         = Input::get('medical_error');
        $input['malfunction']           = Input::get('malfunction');
        $input['discoverer']            = Input::get('discoverer');
        $input['handle']                = Input::get('handle');
        $input['technician']            = Input::get('technician');
        $input['placement']             = Input::get('placement');
        $input['quantity']              = Input::get('quantity');
        $input['medical_text']          = Input::get('medical_text');
        $input['education']             = Input::get('education');
        $input['edu_text']              = Input::get('edu_text');
        $input['nurse']                 = Input::get('nurse');
        $input['other']                 = Input::get('other');
        $input['secretary']             = Input::get('secretary');
        $input['confirm']               = Input::get('confirm');
        $input['judgment']              = Input::get('judgment');
        $input['observation']           = Input::get('observation');
        $input['knowledge']           = Input::get('knowledge');
        $input['technology']           = Input::get('technology');
        $input['corners']           = Input::get('corners');
        $input['impact']                = Input::get('impact');
        $input['solution']              = Input::get('solution');
        $input['affect_env']              = Input::get('affect_env');
        $input['contact']              = Input::get('contact');
        $input['transmission']              = Input::get('transmission');
        $input['manual']              = Input::get('manual');
        $input['mistake']              = Input::get('mistake');
        $input['misreading']              = Input::get('misreading');
        $input['inappropriate']              = Input::get('inappropriate');
        $input['edu_training']              = Input::get('edu_training');
        $input['explan_patient']              = Input::get('explan_patient');
        $input['understand_patient']              = Input::get('understand_patient');
        $input['other_chk']              = Input::get('other_chk');
        $input['impact_affect']              = Input::get('impact_affect');

        $input['name']                  = Input::get('name');
        $input = (object) $input;
        Session::put('hiyarihatto', $input);
        return redirect()->route('ortho.hiyarihatto.confirm');

    }

    public function confirmHiyar()
    {
        $data['hiyar'] = Session::get('hiyarihatto');
        return view('backend.ortho.hiyarihatto.confirm', $data);
    }

    public function sent()
    {
        $data['hiyar'] = Session::get('hiyarihatto');
        return view('backend.ortho.hiyarihatto.sent', $data);
    }

    public function sendEmail()
    {
        $hiyar = (array) Session::get('hiyarihatto');
        Mail::send(['html'=>'backend.ortho.hiyarihatto.email'], ['hiyar'=>$hiyar], function($message) use ($hiyar) {
        $email_to   = env('BACKEND_EMAIL_TO', null);
        $email_from = env('BACKEND_EMAIL_FROM', null);
        $email_subject = env('BACKEND_EMAIL_SUBJECT', 'ヒヤリハット報告フォーム');
        $message->to($email_to, 'Tai Booking');
        $message->subject($email_subject);
        $message->from($email_from);
        });

        return redirect()->route('ortho.hiyarihatto.complete');
    }

    public function complete()
    {
        return view('backend.ortho.hiyarihatto.complete');
    }

}
