<?php
$ini_conf = parse_ini_file("assets/conf.ini");
$ini_minimum_value = $ini_conf['ukpk.minimimum_value'];
$ini_ukpk_year = $ini_conf['ukpk.year'];
$ini_ukpk_month = $ini_conf['ukpk.month'];
$ini_ukpk_day = $ini_conf['ukpk.day'];
$ini_ukpk_hour = $ini_conf['ukpk.hour'];
$ini_ukpk_minute = $ini_conf['ukpk.minute'];
$ini_ukpk_secound = $ini_conf['ukpk.secound'];
$ini_ukpk_long_hour = $ini_conf['ukpk.long_hour'];
$ini_ukpk_long_minute = $ini_conf['ukpk.long_minute'];
$ini_ukpk_long_secound = $ini_conf['ukpk.long_secound'];

$colorGreen = 'style="color: rgb(32, 184, 74);-"';
$colorRed = 'style="color: rgb(236, 45, 74);-"';
$iconCheck = ' <i class="fa fa-check"></i>';
$iconTimes = ' <i class="fa fa-times"></i>';

date_default_timezone_set('Asia/Jakarta');
$dateNow = date('d/m/Y H:i:s');
$dateStart = date("d/m/Y H:i:s", mktime($ini_ukpk_hour, $ini_ukpk_minute, $ini_ukpk_secound, $ini_ukpk_month, $ini_ukpk_day, $ini_ukpk_year));
$dateEnd =  date("d/m/Y H:i:s", mktime($ini_ukpk_hour + $ini_ukpk_long_hour, $ini_ukpk_minute + $ini_ukpk_long_minute, $ini_ukpk_secound + $ini_ukpk_long_secound, $ini_ukpk_month, $ini_ukpk_day, $ini_ukpk_year));

// echo "dateNow : $dateNow //n";
// echo "dateStart : $dateStart //n";
// echo "dateEnd : $dateEnd //n";

if ($dateStart > $dateNow) {
	$_SESSION['allowedTest'] = 0;
} else if ($dateStart < $dateNow && $dateNow < $dateEnd) {
	$_SESSION['allowedTest'] = 1;
}else if($dateEnd < $dateNow) {
	$_SESSION['allowedTest'] = 2;
}

$allowedTest = $_SESSION['allowedTest'];


echo '<script>';
echo 'var ukpkYear=' . $ini_ukpk_year . ';';
echo 'var ukpkMonth=' . $ini_ukpk_month . ';';
echo 'var ukpkDay=' . $ini_ukpk_day . ';';
echo 'var ukpkHour=' . $ini_ukpk_hour . ';';
echo 'var ukpkMinute=' . $ini_ukpk_minute . ';';
echo 'var ukpkSecound=' . $ini_ukpk_secound . ';';
echo 'var ukpkLongHour=' . $ini_ukpk_long_hour . ';';
echo 'var ukpkLongMinute=' . $ini_ukpk_long_minute . ';';
echo 'var ukpkLongSecound=' . $ini_ukpk_long_secound . ';';
echo 'var allowedTest=' . $_SESSION['allowedTest'] . ';';
echo "</script>";
?>
