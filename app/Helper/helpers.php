<?php

function showPatient($p_id=null){
    if(App\Http\Models\Ortho\PatientModel::checkExistID($p_id)){
        $patient = App\Http\Controllers\Backend\Ortho\PatientController::patientByID($p_id);
        if ( empty($patient->p_name_f_kana) && empty($patient->p_name_g_kana) ) {
            $p_name_kana = '';
        } else {
            $p_name_kana = '(' . $patient->p_name_f_kana . ' ' . $patient->p_name_g_kana . ')';
        }
        
        $pt = $patient->p_no .' '. $patient->p_name_f . ' ' . $patient->p_name_g . ' ' . $p_name_kana;
        $result = ['p_id' => $patient->p_id, 'patient' => $pt];
        return $result;
    }else{
        return array();
    }
}

    function formatDate($date = null, $comma = null){
        $dates = date_create($date);
        if($comma == null){
            return date_format($dates,"Y/m/d");
        }else{
            return date_format($dates,"Y".$comma."m".$comma."d");
        }
    }

    function formatYm($date = null, $comma = null){
        $ym     = str_split($date, 4);
        $y = $ym[0];
        $m = $ym[1];
        if($comma == null){
            return $y."/".$m;
        }else{
            return $y.$comma.$m;
        }
    }

    function formatDateJp($date=null){
        if(!empty($date)){
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $day = date('d', strtotime($date));
            return $year.'年'.$month.'月'.$day.'日';
        }else{
            return null;
        }
    }

    function convert2Digit($num){
        return sprintf("%02d", $num);
    }

    function DayJp($date=null, $comm=null){
        if(empty($comm)){
            if(!empty($date)){
                $convertEn2Jp = array('Sun'=>'日', 'Mon'=>'月', 'Tue'=>'火', 'Wed'=>'水', 'Thu'=>'木', 'Fri'=>'金', 'Sat'=>'土');
                $dayEn = strtotime($date);
                return $convertEn2Jp[date("D", $dayEn)];
            }else{
                return null;
            }
        }else{
            if(!empty($date)){
                $convertEn2Jp = array('Sun'=>'日', 'Mon'=>'月', 'Tue'=>'火', 'Wed'=>'水', 'Thu'=>'木', 'Fri'=>'金', 'Sat'=>'土');
                $dayEn = strtotime($date);
                return '('.$convertEn2Jp[date("D", $dayEn)].')';
            }else{
                return null;
            }
        }
    }

    function DayEn($date){
        $dayEn = strtotime($date);
        return date("D", $dayEn);
    }

    function splitHourMin($str_time, $char = ':'){
        if(!empty($str_time)){
            $tmpStr = sprintf("%04d",$str_time);
            $date = str_split($tmpStr, 2);
            $hour = $date[0];
            $min = $date[1];
            return $hour. $char .$min;
        }else{
            return null;
        }
    }

    /**
     * ex: {{ splitHourMin($booking->booking_start_time) }}～{{ toTime($booking->booking_start_time, $booking->booking_total_time) }}
     */
    function toTime($from_time, $total_min){
            // if(strlen($from_time) != 4){
            //  return '00:00';
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
    function booking_change_date($booking_date, $week_later = null){
        $booking_date = Carbon::parse($booking_date);
        if(!empty($week_later)){
            switch ($week_later) {
                case 'one_week':
                    return formatDate( $booking_date->addWeek()->toDateTimeString(),'-');
                    break;
                case 'two_week':
                    return formatDate( $booking_date->addWeeks(2)->toDateTimeString(),'-');
                    break;
                case 'three_week':
                    return formatDate( $booking_date->addWeeks(3)->toDateTimeString(),'-');
                    break;
                case 'four_week':
                    return formatDate( $booking_date->addWeeks(4)->toDateTimeString(),'-');
                    break;
                case 'five_week':
                    return formatDate( $booking_date->addWeeks(5)->toDateTimeString(),'-');
                    break;
                case 'one_month':
                    return formatDate( $booking_date->addMonth()->toDateTimeString(),'-');
                    break;
                case 'two_month':
                    return formatDate( $booking_date->addMonths(2)->toDateTimeString(),'-');
                    break;
                default:
                    return '';
                    break;
            }
        }else{
            return null;
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

//  $time = strtotime("2016-07-19");
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

    /**
     * ex: 2016-07-22 => 2016-07-23
     */
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

    function addOneMonth($currentDay)
    {
        if ( empty($currentDay) ) {
            $currentDay = date('Y-m-d');
        }

        $nextDate            = strtotime ( '+ 1 month' , strtotime ( $currentDay ) ) ;
        $nextDate            = date ( 'Y-m-d' , $nextDate );

        return $nextDate;
    }

    function subOneMonth($currentDay)
    {
        if ( empty($currentDay) ) {
            $currentDay = date('Y-m-d');
        }

        $nextDate            = strtotime ( '- 1 month' , strtotime ( $currentDay ) ) ;
        $nextDate            = date ( 'Y-m-d' , $nextDate );

        return $nextDate;
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

    function weeklater($week_later = null){
        $datenow = Carbon::now();
        if(!empty($week_later)){
            switch ($week_later) {
                case 'one_week':
                    return getWeek($datenow->addWeek(), 'w');
                    break;
                case 'two_week':
                    return getWeek($datenow->addWeeks(2), 'w');
                    break;
                case 'three_week':
                    return getWeek($datenow->addWeeks(3), 'w');
                    break;
                case 'four_week':
                    return getWeek($datenow->addWeeks(4), 'w');
                    break;
                case 'five_week':
                    return getWeek($datenow->addWeeks(5), 'w');
                    break;
                case 'one_month':
                    return getWeek($datenow->addMonth(), 'm');
                    break;
                case 'two_month':
                    return getWeek($datenow->addMonths(2), 'm');
                    break;
                default:
                    return '';
                    break;
            }
        }else{
            return null;
        }
    }


    function getWeek($date, $kind){
        if($kind == 'w'){
            return [formatDate($date->subDays(3)->toDateTimeString(),'-'), formatDate($date->addDays(6)->toDateTimeString(), '-')];
        }else if($kind == 'm'){
            return [formatDate($date->subDays(7)->toDateTimeString(),'-'), formatDate($date->addDays(14)->toDateTimeString(), '-')];
        }else{
            return '';
        }
    }
    

    function cal_change_date($week_later = null){
        $datenow = Carbon::now();
        if(!empty($week_later)){
            switch ($week_later) {
                case 'one_week':
                    return cal_week($datenow->addWeek(), 'w');
                    break;
                case 'two_week':
                    return cal_week($datenow->addWeeks(2), 'w');
                    break;
                case 'three_week':
                    return cal_week($datenow->addWeeks(3), 'w');
                    break;
                case 'four_week':
                    return cal_week($datenow->addWeeks(4), 'w');
                    break;
                case 'five_week':
                    return cal_week($datenow->addWeeks(5), 'w');
                    break;
                case 'one_month':
                    return cal_week($datenow->addMonth(), 'm');
                    break;
                case 'two_month':
                    return cal_week($datenow->addMonths(2), 'm');
                    break;
                default:
                    return $week_later;
                    break;
            }
        }else{
            return null;
        }
    }

    function cal_week($date, $kind){
        if($kind == 'w'){
            return formatDate($date->toDateTimeString(),'-');
        }else if($kind == 'm'){
            return formatDate($date->toDateTimeString(),'-');
        }else{
            return '';
        }
    }


    function hourMin2Min($hhmm)
    {
        $tmpHhmm = sprintf('%04d', $hhmm);

        $hh = substr($tmpHhmm, 0, 2);
        $mm = substr($tmpHhmm, 2, 2);

        return $hh * 60 + $mm;
    }

    function min2HourMin($mm)
    {
        $tmpHh = sprintf('%02d', floor($mm / 60));
        $tmpMm = sprintf('%02d', $mm % 60);

        return $tmpHh . $tmpMm;
    }

    function relationship($primary_sex = null, $second_sex = null, $brother_relation = null){
        switch ($brother_relation) {
            //兄
            case '1':
                if($primary_sex == 1){
                    if($second_sex == 1){
                        return '兄';
                    }else{
                        return '姉';
                    }
                }else{
                    if($second_sex == 1){
                        return '兄';
                    }else{
                        return '姉';
                    }
                }
                break;
            //弟
            case '2':
                if($primary_sex == 1){
                    if($second_sex == 1){
                        return '弟';
                    }else{
                        return '妹';
                    }
                }else{
                    if($second_sex == 1){
                        return '兄';
                    }else{
                        return '姉';
                    }
                }
                break;
            //姉
            case '3':
                if($primary_sex == 1){
                    if($second_sex == 1){
                        return '兄';
                    }else{
                        return '姉';
                    }
                }else{
                    if($second_sex == 1){
                        return '弟';
                    }else{
                        return '弟';
                    }
                }
                break;
            //妹　
            case '4':
                if($primary_sex == 1){
                    if($second_sex == 1){
                        return '弟';
                    }else{
                        return '妹';
                    }
                }else{
                    if($second_sex == 1){
                        return '弟';
                    }else{
                        return '妹';
                    }
                }
                break;
            //いとこ
            default:
                return 'いとこ';
                break;
        }
    }

    //convert time 3 digit to 4 digit
    function time2D4($time){
        if ( strlen($time) <= 3 )
            $time  = sprintf('%04d', $time);

        $result = array(
            'hh' => '00',
            'mm' => '00'
        );

        if ( strlen($time) == 4 ) {
            $result['hh'] = substr($time, 0, 2);
            $result['mm'] = substr($time, 2, 2);
        }

        return $result;
    }

        function cal_date($week_later = null){
        $datenow = Carbon::now();
        if(!empty($week_later)){
            switch ($week_later) {
                case 'one_week':
                    return formatDate($datenow->addWeek()->toDateTimeString(),'-');
                    break;
                case 'two_week':
                    return formatDate($datenow->addWeeks(2)->toDateTimeString(),'-');
                    break;
                case 'three_week':
                    return formatDate($datenow->addWeeks(3)->toDateTimeString(),'-');
                    break;
                case 'four_week':
                    return formatDate($datenow->addWeeks(4)->toDateTimeString(),'-');
                    break;
                case 'five_week':
                    return formatDate($datenow->addWeeks(5)->toDateTimeString(),'-');
                    break;
                case 'one_month':
                    return formatDate($datenow->addMonth()->toDateTimeString(),'-');
                    break;
                case 'two_month':
                    return formatDate($datenow->addMonths(2)->toDateTimeString(),'-');
                    break;
                default:
                    return '';
                    break;
            }
        }else{
            return null;
        }
    }

    function formatDateTime($datetime, $comma=null)
    {
        $dt = date_create($datetime);
        if(!empty($comma)){
            return date_format($dt,"Y".$comma."m".$comma."d H:i");
        }else{
            return date_format($dt,"Y/m/d H:i");
        }
    }

    function dateHourMinSecond($datetime, $comma=null)
    {
        $dt = date_create($datetime);
        if(!empty($comma)){
            return date_format($dt,"Y".$comma."m".$comma."d H:i:s");
        }else{
            return date_format($dt,"Y/m/d H:i:s");
        }
    }

    function countReply($forum_id){
        return App\Http\Controllers\Backend\Ortho\ForumController::countReply($forum_id);
    }

    function reader($forum_id){
        return App\Http\Controllers\Backend\Ortho\ForumController::reader($forum_id);
    }

    function checkOwn($user_id, $forum_id){
        return App\Http\Controllers\Backend\Ortho\ForumController::checkOwnValid($user_id, $forum_id);
    }

    function convertStartTime($time){
        if ( strlen($time) <= 3 )
            $time  = sprintf('%04d', $time);
            $spl_time = str_split($time, 2);

            $hour = (int)$spl_time[0];
            $min  = (int)$spl_time[1];

            if($min >= 60){
                $mt = (int)$min % 60;
                $ht = (int)floor($min / 60);
                $h  = $hour + $ht;
                return (int)(sprintf('%02d',$h).sprintf('%02d',$mt));
            }else{
                return (int)(sprintf('%02d',$hour).sprintf('%02d',$min));
            }
    }

    function date_now(){
        return date('Y-m-d');
    }

    function delete_row(&$array, $offset) {
        return array_splice($array, $offset, 1);
    }

    function delete_col(&$array, $offset) {
        return array_walk($array, function (&$v) use ($offset) {
            array_splice($v, $offset, 1);
        });
    }

    function count_treatment($time=null){
        if(!empty($time)){
            return $time / 15;
        }else{
            return 0;
        }
    }