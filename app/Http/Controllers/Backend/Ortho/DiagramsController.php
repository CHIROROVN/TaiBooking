<?php namespace App\Http\Controllers\Backend\Ortho;

use App\Http\Controllers\BackendController;
use App\Http\Requests;
use Illuminate\Http\Request;

use Form;


class DiagramsController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

	public function index(){
		$data 					= array();
		return view('backend.ortho.diagrams.index', $data);
	}
}