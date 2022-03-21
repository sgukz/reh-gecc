<?php
session_start();
include '../../src/models/_config_db.php';
include '../../src/models/PatientModel.php';
$patient = new Patients();

$resp = array();
if ($_POST) {
    $user = trim($_POST['user_name']);
    $pwd = trim($_POST['pwd']);
    $encypt_pwd = strtoupper(md5("reh" . $pwd . "gecc"));

    $sqlLogin = $patient->getUserLogin($user, $encypt_pwd);
    $qeuryLogin = $conn_main->query($sqlLogin);
    if ($qeuryLogin) {
        $num_rows = $qeuryLogin->num_rows;
        if ($num_rows > 0) {
            $dataLogin = $qeuryLogin->fetch_assoc();
            $_SESSION['userId'] = $dataLogin["userId"];
            $_SESSION['userShortname'] = $dataLogin["shortname"];
            $_SESSION['userName'] = $dataLogin["fullname"];
            $resp = [
                "status_code" => 200,
                "msg" => "ล็อคอินสำเร็จ",
                "type" => "success",
                "data" => "ok"
            ];
        } else {
            $resp = [
                "status_code" => 400,
                "msg" => "ล็อคอินล้มเหลว กรุณาลองใหม่อีกครั้ง",
                "type" => "error",
            ];
        }
    } else {
        $resp = [
            "status_code" => 400,
            "msg" => $conn_main->error,
            "type" => "error",
            "sql_error" => $sqlLogin
        ];
    }
    echo json_encode($resp);
}
