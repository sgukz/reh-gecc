<?php
session_start();
$resp = array();
if ($_SESSION["userId"]) {
    session_destroy();
    $resp = [
        "status_code" => 200,
        "msg" => "ล็อคเอ้าท์สำเร็จ",
        "type" => "success",
    ];
}
echo json_encode($resp);
