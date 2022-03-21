<?php
include '../models/_config_db.php';
include '../models/PatientModel.php';
$patient = new Patients();

if ($_POST) {
    $track = trim($_POST["track"]);
    $resp = $arrayPatient = [];
    $get_patient_sys = $patient->getRegisterDocumentByTrack($track);
    $query_patient_sys = $conn_main->query($get_patient_sys);
    if ($query_patient_sys) {
        $num_rows_sys = $query_patient_sys->num_rows;
        if ($num_rows_sys > 0) {
            while ($dataPatient = $query_patient_sys->fetch_assoc()) {
                $patients = [];
                $patients["track_id"] = $dataPatient["track_id"];
                $patients["petition_name"] = $dataPatient["petition_name"];
                $patients["request_name"] = $dataPatient["request_name"];
                $patients["created_date"] = $dataPatient["created_date"];
                $patients["approve_status"] = $dataPatient["approve_status"];
                $patients["appointment_date"] = $dataPatient["appointment_date"];
                $arrayPatient[] = $patients;
                $resp = [
                    "status_code" => 200,
                    "data" => $arrayPatient,
                    "type" => "success"
                ];
            }
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
