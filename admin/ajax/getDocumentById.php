<?php
include '../../src/models/_config_db.php';
include '../../src/models/PatientModel.php';

$patient = new Patients();
if ($_POST) {
    $resp = $arrayDocument = array();
    $id = trim($_POST['doc_id']);
    $sql_get_document = $patient->getDocumentById($id);
    $query_get_document = $conn_main->query($sql_get_document);
    if ($query_get_document) {
        $num_rows_document = $query_get_document->num_rows;
        if ($num_rows_document > 0) {
            while ($dataDocument = $query_get_document->fetch_assoc()) {
                $documents = [];
                $documents["files_id"] = $dataDocument["files_id"];
                $documents["doc_id"] = $dataDocument["doc_id"];
                $documents["file_name"] = $dataDocument["img_file_name"].".".$dataDocument["img_file_ext"];
                $documents["img_file_ext"] = $dataDocument["img_file_ext"];
                $documents["created_date_img"] = $dataDocument["created_date_img"];
                $arrayDocument[] = $documents;
            }
            $resp = array(
                "status_code" => 200,
                "data" => $arrayDocument,
                "type" => "success",
            );
        } else {
            $resp = array(
                "status_code" => 200,
                "data" => [],
                "type" => "success",
            );
        }
    } else {
        $resp = array(
            "status_code" => 400,
            "msg" => $conn_main->error,
            "type" => "error",
            "sql_error" => $sql_get_document
        );
    }
    echo json_encode($resp);
}
