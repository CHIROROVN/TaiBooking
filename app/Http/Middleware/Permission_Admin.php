<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;
use Config;

class Permission_Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( Auth::check() ) {
            // check permisition SUPER_ADMIN and ADMIN
            $arr_power = permistion(Auth::user()->u_power);

            if ( !in_array('SUPPER_ADMIN', $arr_power) || !in_array('ADMIN', $arr_power) ) {
                Session::flash('no_access', trans('common.baitai_title_index'));
                return redirect()->route('backend.menu');
            }
        }

        return $next($request);
    }
}
