<?php
include '../models/_config_db.php';
include '../models/PatientModel.php';
$patient = new Patients();

$cid = $_POST["cid"];
$resp = $arrayPatient = [];
if ($cid) {
    $get_patient_sys = $patient->getPatientByCID($cid);
    $query_patient_sys = $conn_hosxp->query($get_patient_sys);
    if ($query_patient_sys) {
        $num_rows_sys = $query_patient_sys->num_rows;
        if ($num_rows_sys > 0) {
            while ($dataPatient = $query_patient_sys->fetch_assoc()) {
                $patients = [];
                $patients["cid"] = $dataPatient["cid"];
                $patients["hn"] = $dataPatient["hn"];
                $patients["vn"] = $dataPatient["vn"];
                $patients["an"] = $dataPatient["an"];
                $patients["full_name"] = $dataPatient["full_name"];
                $patients["vstDate"] = $dataPatient["vstDate"];
                $arrayPatient[] = $patients;
            }
            $resp = [
                "status_code" => 200,
                "data" => $arrayPatient,
                "type" => "success"
            ];
        } else {
            $resp = [
                "status_code" => 200,
                "data" => [],
                "type" => "success",
            ];
        }
    } else {
        $resp = [
            "status_code" => 400,
            "msg" => $conn_main->error,
            "type" => "error",
            "sql_error" => $get_patient_sys
        ];
    }
    echo json_encode($resp);
}
