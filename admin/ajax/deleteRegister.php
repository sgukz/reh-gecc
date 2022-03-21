<?php
include '../../src/models/_config_db.php';
include '../../src/models/ManageModel.php';
$db = new DB();

$resp = array();
if ($_POST) {
    $id = $_POST["id"];
    $pad_id = str_pad($id, 5, '0', STR_PAD_LEFT);
    $getTrackId = "SELECT track_id FROM register_tracking WHERE track_id LIKE '%$pad_id'";
    $queryGetTrackId = $conn_main->query($getTrackId);
    if ($queryGetTrackId) {
        $dataTrack = $queryGetTrackId->fetch_array();
        if ($dataTrack['track_id']) {
            $arrayLog = [
                "track_id" => $dataTrack['track_id'],
                "event_name" => "Deleted",
                "log_datetime" => "NOW()",
            ];
            $insertLog = $db->Insert("register_log", $arrayLog);
            $queryLog = $conn_main->query($insertLog);
            if ($queryLog) {
                $deleteRegister = $db->Delete("register_document", "id =" . $id);
                $queryDeleteRegister = $conn_main->query($deleteRegister);
                if ($queryDeleteRegister) {
                    $resp = array(
                        "status_code" => 200,
                        "msg" => "ลบข้อมูลเรียบร้อย",
                        "type" => "success",
                    );
                } else {
                    $resp = array(
                        "status_code" => 400,
                        "msg" => $conn_main->error,
                        "type" => "error",
                        "sql_error" => $deleteRegister
                    );
                }
            }
        }
    } else {
        $resp = array(
            "status_code" => 400,
            "msg" => $conn_main->error,
            "type" => "error",
            "sql_error" => $getTrackId
        );
    }
    echo json_encode($resp);
}
