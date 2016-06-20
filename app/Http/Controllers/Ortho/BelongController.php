<?php namespace App\Http\Controllers\Ortho;

use App\Http\Controllers\Controller;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use App\User;
use App\Http\Models\Ortho\BelongModel;

use Form;
use Html;
use Input;
use Validator;
use URL;

class BelongController extends Controller
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
        $clsBelong = new BelongModel();
        $data['belongs'] = $clsBelong->get_all();

        return view('ortho.belongs.index', $data);
    }

    /**
     * 
     */
    public function getRegist()
    {
        return view('ortho.belongs.regist');
    }

    /**
     * 
     */
    public function postRegist()
    {
        $clsBelong = new BelongModel();
        $inputs = Input::all();
        $validator = Validator::make($inputs, $clsBelong->Rules(), $clsBelong->Messages());

        if ($validator->fails()) {
            return redirect('ortho/belongs/regist')->withErrors($validator)->withInput();
        }

        // insert
        $max = $clsBelong->get_max();
        $dataInsert = array(
            'belong_name'       => Input::get('belong_name'),
            'belong_sort_no'    => $max + 1,
            'last_kind'         => INSERT,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        $clsBelong->insert($dataInsert);

        return redirect()->route('ortho.belongs.index');
    }

    /**
     * 
     */
    public function getEdit($id)
    {
        $clsBelong = new BelongModel();
        $data['belong'] = $clsBelong->get_by_id($id);

        return view('ortho.belongs.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($id)
    {
        $clsBelong = new BelongModel();
        $inputs = Input::all();
        $validator = Validator::make($inputs, $clsBelong->Rules(), $clsBelong->Messages());

        if ($validator->fails()) {
            return redirect('ortho/belongs/edit')->withErrors($validator)->withInput();
        }

        // update
        $dataUpdate = array(
            'belong_name'       => Input::get('belong_name'),
            'last_kind'         => UPDATE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        $clsBelong->update($id, $dataUpdate);

        return redirect()->route('ortho.belongs.index');
    }

    /**
     * 
     */
    public function getDelete($id)
    {
        $clsBelong = new BelongModel();

         // update
        $dataUpdate = array(
            'last_kind'         => DELETE,
            'last_ipadrs'       => $_SERVER['REMOTE_ADDR'],
            'last_user'         => Auth::user()->id
        );
        $clsBelong->update($id, $dataUpdate);

        return redirect()->route('ortho.belongs.index');
    }

    /**
     * 
     */
    public function orderby_top()
    {
        $clsBelong = new BelongModel();
        $id = Input::get('id');

        $this->top($clsBelong, $id);

        return redirect()->route('ortho.belongs.index');
    }

    /**
     * 
     */
    public function orderby_last()
    {
        $clsBelong = new BelongModel();
        $id = Input::get('id');
        
        $this->last($clsBelong, $id);

        return redirect()->route('ortho.belongs.index');
    }

    /**
     * 
     */
    public function orderby_up()
    {
        $clsBelong = new BelongModel();
        $id = Input::get('id');
        $belongs = $clsBelong->get_all();
        
        $this->up($clsBelong, $id, $belongs);

        return redirect()->route('ortho.belongs.index');
    }

    /**
     * 
     */
    public function orderby_down()
    {
        $clsBelong = new BelongModel();
        $id = Input::get('id');
        $belongs = $clsBelong->get_all();
        
        $this->down($clsBelong, $id, $belongs);

        return redirect()->route('ortho.belongs.index');
    }
}
