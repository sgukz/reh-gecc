<?php
include '../../src/models/_config_db.php';
include '../../src/models/ManageModel.php';
$db = new DB();

if ($_POST) {
    $resp = array();
    $target_dir = "../files/images/";
    $id = $_POST["uploadId"];
    $fileToUpload = $_FILES["fileToUpload"]["name"];
    $countfiles = count($fileToUpload);
    if ($fileToUpload) {
        for ($index = 0; $index < $countfiles; $index++) {
            if (isset($fileToUpload[$index]) && $fileToUpload[$index] != '') {
                $filename = $fileToUpload[$index];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $newFileName = "img_" . $id . "_" . ($index + 1) . "_" . date("YmdHis");
                $valid_ext = array("png", "jpeg", "jpg");
                if (in_array($ext, $valid_ext)) {
                    $path = $target_dir . $newFileName . "." . $ext;
                    $dataImg = [
                        "doc_id" => $id,
                        "img_file_name" => $newFileName,
                        "img_file_ext" => $ext,
                        "created_date_img" => "NOW()",
                    ];

                    $sql_file = $db->Insert("register_files", $dataImg);
                    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'][$index], $path)) {
                        $query_file = $conn_main->query($sql_file);
                    } else {
                        $resp = [
                            "status_code" => 400,
                            "msg" => "Sorry, Can't Upload file > " . $filename,
                            "type" => "error",
                        ];
                    }
                    $resp = [
                        "status_code" => 200,
                        "msg" => "บันทึกข้อมูลเรียบร้อย",
                        "type" => "success",
                        "doc_id" => $id
                    ];
                } else {
                    $resp = [
                        "status_code" => 400,
                        "msg" => "ไฟล์รูปภาพประเภท " . $ext . " ไม่สามารถอัพโหลดได้ กรุณาลองใหม่อีกครั้ง!",
                        "type" => "error"
                    ];
                }
            }
        }
    } else {
        $resp = [
            "status_code" => 400,
            "msg" => "โปรดเลือกไฟล์ก่อนบันทึก",
            "type" => "error",
        ];
    }
    echo json_encode($resp);
}
