<?php

	function formatDate($date=null){
		$dates = date_create($date);
		return date_format($dates,"Y/m/d");
	}

	function convert2Digit($num){
		return sprintf("%02d", $num);
	}

