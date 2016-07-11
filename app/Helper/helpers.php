<?php

	function formatDate($date = null, $comma = null){
		$dates = date_create($date);
		if($comma == null){
			return date_format($dates,"Y/m/d");
		}else{
			return date_format($dates,"Y".$comma."m".$comma."d");
		}
		
	}

	function formatDateJp($date=null){
		$year = date('Y', strtotime($date));
		$month = date('m', strtotime($date));
		$day = date('d', strtotime($date));
		return $year.'年'.$month.'月'.$day.'日';
	}

	function convert2Digit($num){
		return sprintf("%02d", $num);
	}

	function DayJp($date){
		$convertEn2Jp = array('Sun'=>'日', 'Mon'=>'月', 'Tue'=>'火', 'Wed'=>'水', 'Thu'=>'木', 'Fri'=>'金', 'Sat'=>'土');
		$dayEn = strtotime($date);
		return $convertEn2Jp[date("D", $dayEn)];
	}

	function splitHourMin($str_time){
		if(strlen($str_time) != 4){
			return '00:00';
		}else{
			$date = str_split($str_time, 2);
			$hour = $date[0];
			$min = $date[1];
			return $hour.':'.$min;
		}
	}

	/**
	 * ex: {{ splitHourMin($booking->booking_start_time) }}～{{ toTime($booking->booking_start_time, $booking->booking_total_time) }}
	 */
	function toTime($from_time, $total_min){
			if(strlen($from_time) != 4){
				return '00:00';
			}else{
				$datef = str_split($from_time, 2);
				$hf = (int)$datef[0];
				$mf = (int)$datef[1];
				$to_time = min2hour($total_min);
				$ht = $to_time[0];
				$mt = $to_time[1];
				$fm = $mf + $mt;
				$fh = $ht + $hf;
				if($fm >= 60){
					$tmp_time = min2hour($fm);
					$tmp_h = $tmp_time[0];
					$tmp_m = $tmp_time[1];
					$fh = $fh + $tmp_h;
					$fm = $tmp_m;
				}
				$toTime = sprintf("%02d",$fh).':'.sprintf("%02d",$fm);
				return $toTime;
			}
	}

	function min2hour($min=null){
		if($min >= 60){
			$mt = (int)$min % 60;
			$ht = (int)floor($min / 60);
			return array('0'=>$ht, '1'=>$mt);
		}else{
			$mt = (int)$min;
			$ht = 0;
			return array('0'=>$ht, '1'=>$mt);
		}
	}

	function clinic_service($service_id){
		return App\Http\Controllers\Backend\Ortho\ClinicServiceController::get_all_by_sid($service_id);
	}


	/**
	* get array number day by month current
	*/
	function getDay($month)
	{
		$year_current       = date('Y');
		$day_arr            = array();
		if ( $month != 0 ) {
			$number             = date('t', mktime(0, 0, 0, $month, 1, $year_current));
			for ( $i = 1; $i <= $number; $i++ ) {
				$day_arr[$i] = $i;
			}
		}

		return $day_arr;
	}

	/**
	 * ex: 2016-07-11, 1
	 * return array(
	 	'2016-07-10' => 2016-07-10,
		'2016-07-11' => 2016-07-11,
		'2016-07-12' => 2016-07-12,
	 )
	 */
	function getSomeDayFromDay($currentDay, $number)
	{
		if ( $number == 0 ) {
			return $tmpDates[$currentDay] = $currentDay;
		}

		$tmpDates = array();
		$newdate = '';
        for ( $i = $number; $i >= 1; $i-- ) {
            $newdate = strtotime ( '-' . $i . ' day' , strtotime ( $currentDay ) ) ;
            $newdate = date ( 'Y-m-j' , $newdate );
            $tmpDates[$newdate] = $newdate;
        }
        $tmpDates[$currentDay] = $currentDay;
        for ( $i = 1; $i <= $number; $i++ ) {
            $newdate = strtotime ( '+' . $i . ' day' , strtotime ( $currentDay ) ) ;
            $newdate = date ( 'Y-m-j' , $newdate );
            $tmpDates[$newdate] = $newdate;
        }

        return $tmpDates;
	}

