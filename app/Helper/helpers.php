<?php

	function formatDate($date=null){
		$dates = date_create($date);
		return date_format($dates,"Y/m/d");
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
