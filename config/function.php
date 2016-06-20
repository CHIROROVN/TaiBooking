<?php

	function test() {
		return 'test';
	}


	/**
	 * permistion user login
	 * $u_power: user power (array or json)
	 * $power: full power
	 * if 
	 */
	function permistion($u_power = array())
	{
		$arr = array();
		$tmp_u_power = $u_power;
		if ( !is_array($u_power) ) {
			$tmp_u_power = json_decode($u_power, true);
		}

		if ( Auth::check() && count($tmp_u_power) > 0 ) {
			$power = array('000' => 'SUPPER_ADMIN', '010' => 'ADMIN', '020' => 'MEMBER', '030' => 'PRINTER', '040' => 'STAFF');

			foreach ( $tmp_u_power as $item ) {
				if ( isset($power[$item]) ) {
					$arr[] = $power[$item];
				}
			}

			return $arr;
		}



		return redirect()->route('backend.login');
	}
