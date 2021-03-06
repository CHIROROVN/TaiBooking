<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Models\Ortho\MemoModel;
use Form;
use Html;
use Input;
use Validator;
use URL;
use Session;

class MemoController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * 
     */
    public function calendar()
    {
        $clsMemo            = new MemoModel();
        $memos              = $clsMemo->get_all();
        $tmpMemos           = array();
        foreach ( $memos as $memo ) {
            $tmpMemos[]     = array(
                'title'     => $memo->memo_contents,
                'start'     => $memo->memo_date,
                'end'       => $memo->memo_date + 1,
                'url'       => route('ortho.memos.edit', [ $memo->memo_id ]),
                'color'     => 'transparent',
                'border'    => 'none',
            );
        }
        $data['memos']      = json_encode($tmpMemos);
        return view('backend.ortho.memos.calendar', $data);
    }

    /**
     * 
     */
    public function getRegist()
    {
        $memo_date = Input::get('memo_date');
        if ( empty($memo_date) ) {
            return redirect()->route('ortho.memos.calendar');
        }
        $clsMemo = new MemoModel();
        $memo = $clsMemo->get_by_memo_date($memo_date);
        if ( count($memo) ) {
            return redirect()->route('ortho.memos.calendar');
        }
        $data = array();
        $data['memo_date'] = $memo_date;
        return view('backend.ortho.memos.regist', $data);
    }

    /**
     * 
     */
    public function postRegist()
    {
        $memo_date              = Input::get('memo_date');
        $clsMemo                = new MemoModel();
        $dataInsert             = array(
            'memo_date'         => $memo_date,
            'memo_contents'     => Input::get('memo_contents'),
            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => INSERT,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => Auth::user()->id
        );

        $validator      = Validator::make(Input::all(), $clsMemo->Rules(), $clsMemo->Messages());
        if ($validator->fails()) {
            return redirect()->to('ortho/memos/regist?memo_date='.$memo_date)->withErrors($validator)->withInput();
        }

        // check exist in day
        if ( !empty($clsMemo->get_by_memo_date($dataInsert['memo_date'])) ) {
            Session::flash('danger', trans('common.message_regist_danger'));
            return redirect()->route('ortho.memos.calendar');
        }
        
        if ( $clsMemo->insert($dataInsert) ) {
            Session::flash('success', trans('common.message_regist_success'));
        } else {
            Session::flash('danger', trans('common.message_regist_danger'));
        }
        return redirect()->route('ortho.memos.calendar');
    }

    /**
     * 
     */
    public function getEdit($id)
    {
        $clsMemo                = new MemoModel();
        $data                   = array();
        $data['memo']           = $clsMemo->get_by_id($id);
        return view('backend.ortho.memos.edit', $data);
    }

    /**
     * 
     */
    public function postEdit($id)
    {
        $clsMemo                = new MemoModel();
        $dataUpdate             = array(
            'memo_contents'     => Input::get('memo_contents'),

            'last_date'         => date('y-m-d H:i:s'),
            'last_kind'         => UPDATE,
            'last_ipadrs'       => CLIENT_IP_ADRS,
            'last_user'         => Auth::user()->id
        );
        $validator      = Validator::make($dataUpdate, $clsMemo->Rules(), $clsMemo->Messages());
        if ($validator->fails()) {
            return redirect()->route('ortho.memos.edit', [ $id ])->withErrors($validator)->withInput();
        }
        if ( $clsMemo->update($id, $dataUpdate) ) {
            Session::flash('success', trans('common.message_edit_success'));
        } else {
            Session::flash('danger', trans('common.message_edit_danger'));
        }
        return redirect()->route('ortho.memos.calendar');
    }
}
