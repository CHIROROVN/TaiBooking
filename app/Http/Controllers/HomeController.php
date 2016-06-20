<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Hash;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }


    public function change(Request $request)
    {
        if(!empty($request->input('ok'))){
            $user = Auth::user();

            if (Auth::attempt(['email' => $user->email, 'password' => $request->old_password])) {
                $user = User::findOrFail($user->id);
                $user->fill([
                    'password' => Hash::make($request->password)
                ])->save();

                return redirect('/home');
            }else{
                return view('auth/change');
            }
        }
        
        return view('auth/change');
    }


    public function profile()
    {
        echo '<pre>';
        print_r(Auth::user());
        die;
    }
}
