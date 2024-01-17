<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
$SDate = rdate('Y-m-d', '-7 days');
$EDate = $date;

if(isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $filter_date1 = filter($_POST['start_date']);
    $filter_date2 = filter($_POST['end_date']);
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(validate_date($filter_date1) == false || validate_date($filter_date2) == false) {
		ShennXit(['type' => false,'message' => 'Input does not match.']);
    } else if(strtotime($filter_date2) < strtotime($filter_date1)) {
        ShennXit(['type' => false,'message' => 'The period starts beyond the end period.']);
    } else {
        $SDate = date('Y-m-d', strtotime($filter_date1));
        $EDate = date('Y-m-d', strtotime($filter_date2));
    }
}

if(countDay($SDate,$EDate) >= 2 && countDay($SDate,$EDate) <= 31) {
    $end_date = new DateTime($EDate);
    $end_date->add(new DateInterval('P1D'));
    $period = new DatePeriod(new DateTime($SDate), new DateInterval('P1D'), new DateTime($end_date->format('Y-m-d')));
    $dateList = []; foreach ($period as $key => $value) $dateList[] = $value->format('Y-m-d');
}