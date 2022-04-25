<?php
session_start();
include '../models/_config_db.php';
include '../models/ManageModel.php';
date_default_timezone_set('Asia/Bangkok');
$db = new DB();
$resp = [];
$pre_id = "";
$year = (date("Y") + 543);
$strDate = substr($year, 2);

if ($_POST) {
    if ($_POST["petition_type"] === "1") {
        $pre_id = "A" . $strDate;
    } else if ($_POST["petition_type"] === "2") {
        $pre_id = "B" . $strDate;
    } else if ($_POST["petition_type"] === "3") {
        $pre_id = "C" . $strDate;
    } else if ($_POST["petition_type"] === "4") {
        $pre_id = "D" . $strDate;
    }
    $formData = [
        "hn" => $_POST["hn"],
        "vn" => $_POST["vn"],
        "an" => $_POST["an"],
        "patient_cid" => $_POST["cid"],
        "patient_name" => $_POST["patient_name"],
        "request_cid" => $_POST["petition_cid"],
        "request_name" => $_POST["petition_name"],
        "request_about_id" => $_POST["about_patient"],
        "request_phone" => $_POST["petition_phone"],
        "request_address" => $_POST["petition_address"],
        "request_details" => $_POST["request_details"],
        "request_detail_2" => $_POST["request_detail_2"] !== "" ? $_POST["request_detail_2"] : "null",
        "vstdate" => $_POST["vst_date"],
        "regdate" => $_POST["admit_date"],
        "dchdate" => $_POST["dhc_date"] !== "" ? $_POST["dhc_date"] : "null",
        "dep_name" => $_POST["ward_name"],
        "doctor_name" => $_POST["doctor_name"],
        "petition_id" => $_POST["petition_type"],
        "approve_user" => $_SESSION['userId'],
        "approve_datetime" => "NOW()",
        "approve_status" => 1,
        "appointment_date" => $_POST["appointment_date_admin"],
        "updated_date" => "NOW()",
        "created_date" => "NOW()",
    ];
    
    $insert_register = $db->Insert("register_document", $formData);
    $query_register = $conn_main->query($insert_register);
    if ($query_register) {
        $id = $conn_main->insert_id;
        $pad_id = str_pad($id, 5, '0', STR_PAD_LEFT);
        $petition_id = $pre_id . $pad_id;
        $arrTrack = [
            "track_id" => $petition_id,
            "doc_id" => $id,
            "created_date" => "NOW()"
        ];
        $insert_tracking = $db->Insert("register_tracking", $arrTrack);
        $query_tracking = $conn_main->query($insert_tracking);
        if ($query_tracking) {
            $arrayLog = [
                "track_id" => $petition_id,
                "event_name" => "Add",
                "log_datetime" => "NOW()",
            ];
            $insertLog = $db->Insert("register_log", $arrayLog);
            $queryLog = $conn_main->query($insertLog);
            $resp = [
                "status_code" => 200,
                "msg" => "บันทึกข้อมูลเรียบร้อย",
                "track_id" => $petition_id,
                "type" => "success",
                "sql" => $insert_register
            ];
        } else {
            $resp = [
                "status_code" => 400,
                "msg" => $conn_main->error,
                "type" => "error",
                "sql_error" => $insert_tracking
            ];
        }
    } else {
        $resp = [
            "status_code" => 400,
            "msg" => $conn_main->error,
            "type" => "error",
            "sql_error" => $insert_register
        ];
    }
    echo json_encode($resp);
}
