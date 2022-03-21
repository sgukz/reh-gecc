<?php
include '../models/_config_db.php';
include '../models/PatientModel.php';
$patient = new Patients();

if ($_POST) {
    $vstdate = $_POST["vstdate"];
    $hn = $_POST["hn"];
    $resp = $arrayPatient = [];
    $get_patient_sys = $patient->getPatientByVstdateAndHN($vstdate, $hn);
    $query_patient_sys = $conn_hosxp->query($get_patient_sys);
    if ($query_patient_sys) {
        $num_rows_sys = $query_patient_sys->num_rows;
        if ($num_rows_sys > 0) {
            while ($dataPatient = $query_patient_sys->fetch_assoc()) {
                $patients = [];
                $patients["vn"] = $dataPatient["vn"];
                $patients["an"] = $dataPatient["an"];
                $patients["visitDate"] = $dataPatient["visitDate"];
                $patients["dchDate"] = $dataPatient["dchDate"];
                $patients["dep_name"] = $dataPatient["dep_name"];
                $patients["DoctorName"] = $dataPatient["DoctorName"];
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
