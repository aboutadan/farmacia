<?php 

/*
 *  These are my custom functions.
 */

// This confirms the age of the person.
function age($type, $age) {

	// This will return the age of the user. 
	// 1 is for years and 2 is for months.
	
	if($type == 1 || $type == 0) {
		if($age == 1) {
			return $age.' año';
		} else {
			return $age.' años';	
		}
	} else {
		if($age == 1) {
			return $age.' mes';
		} else {
			return $age.' meses';	
		}
	}
	
}

function get_age($date) {

	/*$from = new DateTime($date);
	$to   = new DateTime('today');
	$age = $from->diff($to)->y;*/

	$years = date_diff(date_create($date), date_create('today'))->y;
	$age = $years > 1 ? $years.' Años' : $years.' Año';
	if($age == 0) {
		$months = date_diff(date_create($date), date_create('today'))->m;
		$age = $months > 1 ? $months.' Meses' : $months. ' Mes';
		if($months == 0) {
			$days = date_diff(date_create($date), date_create('today'))->d;
			$age = $days > 1 ? $days.' días' : $days.' día';
			return $age;
		} else return $age;
	} return $age;

}

function format_date($query_date, $type = null) {

	$date = date('d', strtotime($query_date));
	$month = date('n', strtotime($query_date));
	$year = date('Y', strtotime($query_date));
	
    if($type === 'short'):
        $months = array(1 => 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
        return $date.' '.$months[$month].' '.$year;
    elseif($type === 'short2'):
        $months = array(1 => 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
        return $date.' '.$months[$month].' de '.$year;
    elseif($type === 'long'): 
        $months = array(1 => 'enero', 'febrero', 'marzo', 'abril', 'may', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
        return $date.' de '.$months[$month].' de '.$year;

  	elseif($type === 'form'): 
       $date = date('d/m/Y', strtotime($query_date));
       return $date;
    elseif($type === 'sentence'):
    	// This will pass the date as a sentence. 
    	// Note: If the year matches the current year, it will not be included.
    	$day = date('d', strtotime($query_date));
    	$months = array(1 => 'enero', 'febrero', 'marzo', 'abril', 'may', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    	$month = date('n', strtotime($query_date));
    	$year = date('Y', strtotime($query_date));

    	if($year !== date('Y')) {
    		$ending = date(' \d\e\l Y \a \l\a\s H:i', strtotime($query_date));
    	} else {
    		$ending = date(' \a \l\a\s H:i', strtotime($query_date));
    	}

    	return $day.' de '.$months[$month].$ending;
    else: 
        die('Check values passed to date function. Try again.');
    endif;
}

function format_phone($phone_number) {

    $phone = preg_replace("/[^0-9]/", "", $phone_number);
 
	if(strlen($phone) == 8)
		return preg_replace("/([0-9]{4})([0-9]{4})/", "$1-$2", $phone);
	elseif(strlen($phone) == 10)
		return preg_replace("/([0-9]{2})([0-9]{4})([0-9]{4})/", "($1) $2-$3", $phone);
	else
		return $phone;
	
}