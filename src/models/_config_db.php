<?php


$conn_main = new mysqli(
    $HOST,
    $USER,
    $PASS,
    $DBNAME
);

$conn_hosxp = new mysqli(
    $HOST_HOS,
    $USER_HOS,
    $PASS_HOS,
    $DBNAME_HOS
);

//Connection Database Hospital
#### Check connection to database ####
if ($conn_main->connect_error) {
    //Error connection
    die("Connection error message: " . $conn_main->connect_error);
    exit;
} else {
    //Correct connection
    $conn_main->query("SET NAMES UTF8");
    // echo "Connected database hospital...";
}

//Connection Database Hosxp
#### Check connection to database ####
if ($conn_hosxp->connect_error) {
    //Error connection
    die("Connection error message: " . $conn_hosxp->connect_error);
    exit;
} else {
    //Correct connection
    $conn_hosxp->query("SET NAMES UTF8");
    // echo "Connected database Hosxp...";
}

function typeFileIcon($typefile)
{
    $icon = "";
    switch ($typefile) {
        case "pdf":
            $icon = "<i class='fa fa-file-pdf-o' aria-hidden='true'></i>";
            break;
        case "docx":
            $icon = "<i class='fa fa-file-word-o' aria-hidden='true'></i>";
            break;
        case "doc":
            $icon = "<i class='fa fa-file-word-o' aria-hidden='true'></i>";
            break;
        case "xls":
            $icon = "<i class='fa fa-file-excel-o' aria-hidden='true'></i>";
            break;
        case "xlsx":
            $icon = "<i class='fa fa-file-excel-o' aria-hidden='true'></i>";
            break;
        case "zip":
            $icon = "<i class='fa fa-file-zip-o' aria-hidden='true'></i>";
            break;
        case "rar":
            $icon = "<i class='fa fa-file-zip-o' aria-hidden='true'></i>";
            break;
        default:
            $icon = "<i class='fa fa-file' aria-hidden='true'></i>";
    }
    return $icon;
}

function approveStatus($st)
{
    $status = "";
    switch ($st) {
        case "0":
            $status = "<span class='badge badge-pill badge-warning text-sm'>รอดำเนินการ</span>";
            break;
        case "1":
            $status = "<span class='badge badge-pill badge-info text-sm'>เจ้าหน้าที่รับเรื่องแล้ว</span>";
            break;
        case "2":
            $status = "<span class='badge badge-pill badge-success text-sm'>เตรียมเอกสารเรียบร้อย</span>";
            break;
        case "3":
            $status = "<span class='badge badge-pill badge-success text-sm'>ดำเนินการเรียบร้อย</span>";
            break;
        case "9":
            $status = "<span class='badge badge-pill badge-danger text-sm'>กรุณาติดต่อเจ้าหน้าที่</span>";
            break;
        default:
            $status = "";
    }
    return $status;
}
