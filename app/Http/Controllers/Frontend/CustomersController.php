<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;

use Input;
use Session;
use Validator;
use Auth;

class CustomersController extends FrontendController
{
	public function __construct()
	{
		parent::__construct();
	}


	public function detail() {
		return view('frontend.customer.detail');
	}
}