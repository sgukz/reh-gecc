<?php
include '../../src/models/_config_db.php';
include '../../src/models/ManageModel.php';
$db = new DB();

$resp = $arrayData = array();
if ($_POST) {
    if (isset($_POST["approve_datetime"])) {
        $arrayData = array(
            "approve_status" => $_POST["approve_status"],
            "approve_datetime" => $_POST["approve_datetime"],
            "approve_user" => $_POST["approve_user"],
            "completed_date" => $_POST["completed_date"],
            "approve_details" => $_POST["approve_details"]
        );
    } else {
        $arrayData = array(
            "approve_status" => $_POST["approve_status"],
            "appointment_date" => $_POST["appointment_date"],
            "approve_user" => $_POST["approve_user"],
            "completed_date" => $_POST["completed_date"],
            "approve_details" => $_POST["approve_details"]
        );
    }
    $condition = "id = " . $_POST["id"];

    $updateRegister = $db->Update("register_document", $arrayData, $condition);
    $queryRegister = $conn_main->query($updateRegister);
    if ($queryRegister) {
        $pad_id = str_pad($_POST["id"], 5, '0', STR_PAD_LEFT);
        $getTrackId = "SELECT track_id FROM register_tracking WHERE track_id LIKE '%$pad_id'";
        $queryGetTrackId = $conn_main->query($getTrackId);
        if ($queryGetTrackId) {
            $dataTrack = $queryGetTrackId->fetch_array();
            $approve_status = "";
            if ($_POST["approve_status"] === "0") {
                $approve_status = "Add";
            } elseif ($_POST["approve_status"] === "1") {
                $approve_status = "approve_accept";
            } elseif ($_POST["approve_status"] === "2") {
                $approve_status = "approve_success";
            } elseif ($_POST["approve_status"] === "9") {
                $approve_status = "approve_consult";
            }
            $arrayLog = [
                "track_id" => $dataTrack['track_id'],
                "event_name" => $approve_status,
                "log_datetime" => "NOW()",
            ];
            $insertLog = $db->Insert("register_log", $arrayLog);
            $queryLog = $conn_main->query($insertLog);
            $resp = [
                "status_code" => 200,
                "msg" => "แก้ไขข้อมูลเรียบร้อย",
                "type" => "success",
            ];
        }
    } else {
        $resp = [
            "status_code" => 400,
            "msg" => $conn_main->error,
            "type" => "error",
            "sql_error" => $updateRegister
        ];
    }
    echo json_encode($resp);
}
