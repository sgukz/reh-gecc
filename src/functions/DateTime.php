<?php
function DateTimeThai($strDate, $type)
{
    $resultDate = "";
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthFull = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai = $strMonthCut[$strMonth];
    if ($type === 1) {
        $resultDate = "$strDay $strMonthFull[$strMonth] $strYear";
    } else if ($type === 2) {
        $resultDate = "$strDay $strMonthCut[$strMonth] $strYear";
    } else if ($type === 3) {
        $resultDate = "$strHour:$strMinute น.";
    } else {
        $resultDate = "$strDay $strMonthThai $strYear, $strHour:$strMinute น.";
    }
    return $resultDate;
}

function thainumDigit($num)
{
	return str_replace(
		array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'),
		array("o", "๑", "๒", "๓", "๔", "๕", "๖", "๗", "๘", "๙"),
		$num
	);
};
