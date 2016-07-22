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

	function DayEn($date){
		$dayEn = strtotime($date);
		return date("D", $dayEn);
	}

	function splitHourMin($str_time, $char = ':'){
		// if(strlen($str_time) != 4){
		// 	return '00:00';
		// }else{
			$tmpStr = sprintf("%04d",$str_time);
			$date = str_split($tmpStr, 2);
			$hour = $date[0];
			$min = $date[1];
			return $hour. $char .$min;
		// }
	}

	/**
	 * ex: {{ splitHourMin($booking->booking_start_time) }}～{{ toTime($booking->booking_start_time, $booking->booking_total_time) }}
	 */
	function toTime($from_time, $total_min){
			// if(strlen($from_time) != 4){
			// 	return '00:00';
			// }else{
			$tmpStr = sprintf("%04d",$from_time);
				$datef = str_split($tmpStr, 2);
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
			// }
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
	function getDay($month, $year)
	{
		if ( empty($year) ) {
			$year = date('Y');
		}
		$day_arr            = array();
		if ( $month != 0 ) {
			$number             = date('t', mktime(0, 0, 0, $month, 1, $year));
			for ( $i = 1; $i <= $number; $i++ ) {
				$i = sprintf('%02d', $i);
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
		//booking change date
	function booking_change_date($date=null, $param=null){
		if($date == '' || $param == ''){
			return '';
		}else{
			switch ($param) {
				case 'one_week':
					$result = date ( 'Y-m-d', strtotime ( '+1 week' , strtotime ( $date ) )) ;
					break;
				case 'one_month':
					$result = date ( 'Y-m-d', strtotime ( '+1 month' , strtotime ( $date ) )) ;
					break;
				case 'two_month':
					$result = date ( 'Y-m-d', strtotime ( '+2 month' , strtotime ( $date ) )) ;
					break;
				case 'two_week':
					$result = date ( 'Y-m-d', strtotime ( '+2 week' , strtotime ( $date ) )) ;
					break;
				case 'three_week':
					$result = date ( 'Y-m-d', strtotime ( '+3 week' , strtotime ( $date ) )) ;
					break;
				case 'four_week':
					$result = date ( 'Y-m-d', strtotime ( '+4 week' , strtotime ( $date ) )) ;
					break;
				case 'five_week':
					$result = date ( 'Y-m-d', strtotime ( '+5 week' , strtotime ( $date ) )) ;
					break;
				case '':
					$result = '';
					break;
				default:
					$result = $param;
					break;
			}
			return $result;
		}
	}

	//convert date to YYYYMM
	function date2YearMonth($date=null){
		if(!empty($date)){
			return date('Ym', strtotime($date));
		}else{
			return '';
		}
	}

	function dateAddMonth($date=null, $monthNum=null, $format=null){
		if(!empty($date)){
			if($format == null)
				$format = 'Y-m-d';
			return date($format, strtotime("+".$monthNum." month", strtotime($date)));
		}else{
			return '';
		}
	}

// 	$time = strtotime("2016-07-19");
// $final = date("Y-m-d", strtotime("+2 month", $time));

	/**
	 * ex: 00,02 -> 00,03 ==> 60s
	 */
	function totalSecond($hh1, $mm1, $ss1 = '0', $hh2, $mm2, $ss3 = '0')
	{
		$seconds = mktime($hh1, $mm1, $ss1) - mktime($hh2, $mm2, $ss3);
		return $seconds;
	}

	/**
	 * ex: 70 => 01:10
	 * ex: 70, 'H:i:s' => 01:10:00
	 */
	function convertSecond2Time($seconds, $formatTime = 'H:i:s')
	{
		$result = date($formatTime, mktime(0, 0, $seconds));
		return $result;
	}

	function splitHourMinArray($hh_mm)
	{
		$result = array(
			'hh' => '00',
			'mm' => '00'
		);

		if ( strlen($hh_mm) == 4 ) {
			$result['hh'] = substr($hh_mm, 0, 2);
			$result['mm'] = substr($hh_mm, 2, 2);
		}

		return $result;
	}

	function convertHour2Min($hhmm)
	{
		$totalMin = 0;

		$hh = substr($hhmm, 0, 2);
		$mm = substr($hhmm, 2, 2);
		$totalMin = $hh * 60 + $mm;

		return $totalMin;
	}

	function addOneDay($currentDay)
	{
		if ( empty($currentDay) ) {
			$currentDay = date('Y-m-d');
		}

		$nextDate            = strtotime ( '+ 1 day' , strtotime ( $currentDay ) ) ;
      	$nextDate            = date ( 'Y-m-d' , $nextDate );

      	return $nextDate;
	}

	function subOneDay($currentDay)
	{
		if ( empty($currentDay) ) {
			$currentDay = date('Y-m-d');
		}

		$prevDate            = strtotime ( '- 1 day' , strtotime ( $currentDay ) ) ;
      	$prevDate            = date ( 'Y-m-d' , $prevDate );

      	return $prevDate;
	}

	function checkPercent($percent)
	{
		if ( 0 < $percent && $percent <= 9 ) {
			$colorCls = 'percent-1';
		} elseif ( 10 <= $percent && $percent <= 19 ) {
			$colorCls = 'percent-2';
		} elseif ( 20 <= $percent && $percent <= 29 ) {
			$colorCls = 'percent-3';
		} elseif ( 30 <= $percent && $percent <= 39 ) {
			$colorCls = 'percent-4';
		} elseif ( 40 <= $percent && $percent <= 49 ) {
			$colorCls = 'percent-5';
		} elseif ( 50 <= $percent && $percent <= 59 ) {
			$colorCls = 'percent-6';
		} elseif ( 60 <= $percent && $percent <= 69 ) {
			$colorCls = 'percent-7';
		} elseif ( 70 <= $percent && $percent <= 79 ) {
			$colorCls = 'percent-8';
		} elseif ( 80 <= $percent && $percent <= 89 ) {
			$colorCls = 'percent-9';
		} elseif ( 90 <= $percent && $percent <= 99 ) {
			$colorCls = 'percent-10';
		} elseif ( $percent == 100 ) {
			$colorCls = 'percent-11';
		} else {
			$colorCls = '';
		}

		return $colorCls;
	}

