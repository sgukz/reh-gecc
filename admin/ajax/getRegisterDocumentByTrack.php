<?php
include '../../src/models/_config_db.php';
include '../../src/functions/DateTime.php';
include '../../src/models/PatientModel.php';

$patient = new Patients();

if ($_POST) {
    $track = trim($_POST["track"]);
    $resp = $arrayPatient = [];
    $get_patient_sys = $patient->getRegisterDocumentByTrackAdmin($track);
    $query_patient_sys = $conn_main->query($get_patient_sys);
    if ($query_patient_sys) {
        $num_rows_sys = $query_patient_sys->num_rows;
        if ($num_rows_sys > 0) {
            while ($dataPatient = $query_patient_sys->fetch_assoc()) {
                $patients = [];
                $patients["id"] = $dataPatient["id"];
                $patients["hn"] = $dataPatient["hn"];
                $patients["vn"] = $dataPatient["vn"];
                $patients["an"] = $dataPatient["an"];
                $patients["track_id"] = $dataPatient["track_id"];
                $patients["patient_cid"] = $dataPatient["patient_cid"];
                $patients["patient_name"] = $dataPatient["patient_name"];
                $patients["petition_name"] = $dataPatient["petition_name"];
                $patients["request_name"] = $dataPatient["request_name"];
                $patients["request_cid"] = $dataPatient["request_cid"];
                $patients["about_name"] = $dataPatient["about_name"];
                $patients["request_phone"] = $dataPatient["request_phone"];
                $patients["request_address"] = $dataPatient["request_address"];
                $patients["request_details"] = $dataPatient["request_details"];
                $patients["regdate"] = $dataPatient["regdate"];
                $patients["dchdate"] = $dataPatient["dchdate"];
                $patients["dep_name"] = $dataPatient["dep_name"];
                $patients["doctor_name"] = $dataPatient["doctor_name"];
                $patients["approve_user"] = $dataPatient["approve_user"];
                $patients["approve_datetime"] = $dataPatient["approve_datetime"];
                $patients["created_date"] = $dataPatient["created_date"];
                $patients["updated_date"] = $dataPatient["updated_date"];
                $patients["approve_status"] = $dataPatient["approve_status"];
                $patients["approve_details"] = $dataPatient["approve_details"];
                $patients["appointment_date"] = $dataPatient["appointment_date"];
                $patients["fullname"] = $dataPatient["fullname"];
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