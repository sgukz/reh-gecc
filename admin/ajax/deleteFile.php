<?php
include '../../src/models/_config_db.php';
include '../../src/models/ManageModel.php';
include '../../src/models/PatientModel.php';
$db = new DB();
$patient = new Patients();
if ($_POST) {
    $resp = array();
    $doc_id = "";
    $target_dir = "../files/images/";
    $id = $_POST['file_id'];
    $sql_get_file = $patient->getDocumentByFileId($id);
    $query_get_file = $conn_main->query($sql_get_file);
    $num_rows = $query_get_file->num_rows;
    if ($num_rows > 0) {
        $dataFile = $query_get_file->fetch_assoc();
        $doc_id = $dataFile['doc_id'];
        $file_name = $dataFile["img_file_name"] . "." . $dataFile["img_file_ext"];
        if (unlink($target_dir . $file_name)) {
            $condition = "files_id = " . $id;
            $sql_delete_file = $db->Delete("register_files", $condition);
            $query_delete_file = $conn_main->query($sql_delete_file);
            if ($query_delete_file) {
                $resp = array(
                    "status_code" => 200,
                    "data" => "Deleted file.",
                    "type" => "success",
                    "doc_id" => $doc_id
                );
            } else {
                $resp = array(
                    "status_code" => 400,
                    "msg" => $conn_main->error,
                    "type" => "error",
                    "sql_error" => $sql_delete_file
                );
            }
        }
    }
    echo json_encode($resp);
}
