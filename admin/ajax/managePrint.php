<?php
include '../../src/models/_config_db.php';
include '../../src/models/ManageModel.php';
$db = new DB();

if($_POST){
    $resp = array();
    $id = $_POST["doc_id"];
    $book_number = empty($_POST["book_number"]) ? "null" : $_POST["book_number"];
    $request_details = empty($_POST["request_details"]) ? "null" : $_POST["request_details"];
    
    $arrayData = array(
        "approve_book_number" => $book_number,
        "request_details" =>$request_details,
        "updated_date" => "NOW()"
    );
    $condition = "id = ".$id;

    $update_document = $db->Update("register_document", $arrayData, $condition);
    $query_update_document = $conn_main->query($update_document);
    if($query_update_document){
        $resp = array(
            "status_code" => 200,
            "msg" => "Updated",
            "type" => "succcess",
        );
    }else{
        $resp = array(
            "status_code" => 400,
            "msg" => "Update fail!",
            "type" => "error",
        );
    }
    echo json_encode($resp);
}