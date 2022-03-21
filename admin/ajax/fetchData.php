<?php
include '../../src/models/_config_db.php';
include '../../src/functions/DateTime.php';
$columns = array("updated_date", "track_id", "petition_name", "request_name", "patient_name", "approve_status");

$getRegister = "SELECT * FROM register_document d
                LEFT JOIN register_tracking t ON d.id = t.doc_id
                LEFT JOIN register_status s ON d.approve_status = s.status_id
                LEFT JOIN register_petition p ON p.petition_id = d.petition_id";

if (isset($_POST["search"]["value"]) && $_POST["search"]["value"] !== "") {
    $getRegister .= " WHERE t.track_id LIKE '%" . $_POST["search"]["value"] . "%'";
    $getRegister .= " OR d.request_name LIKE '%" . $_POST["search"]["value"] . "%'";
    $getRegister .= " OR d.updated_date LIKE '%" . $_POST["search"]["value"] . "%'";
    $getRegister .= " OR p.petition_name LIKE '%" . $_POST["search"]["value"] . "%'";
    $getRegister .= " OR d.patient_name LIKE '%" . $_POST["search"]["value"] . "%'";
    $getRegister .= " OR d.hn LIKE '%" . $_POST["search"]["value"] . "%'";
    $getRegister .= " OR s.status_name LIKE '%" . $_POST["search"]["value"] . "%'";
}

if (isset($_POST["order"])) {
    $getRegister .= ' ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . '
    ';
} else {
    $getRegister .= ' ORDER BY d.updated_date DESC ';
}

$getRegister2 = "";

if ($_POST["length"] !== -1) {
    $getRegister2 = ' LIMIT ' . $_POST["start"] . ', ' . $_POST['length'];
}

$queryGetFilterRows = $conn_main->query($getRegister);
$filterRows = $queryGetFilterRows->num_rows;

$queryGetRegister = $conn_main->query($getRegister . $getRegister2);

$data = array();

while ($dataRegister = $queryGetRegister->fetch_array()) {
    $subArray = array();
    $subArray[] = '<span class="font-weight-bold">' . DateTimeThai($dataRegister["updated_date"], "") . '</span>';
    $subArray[] = '<span class="text-primary font-weight-bold">' . $dataRegister["track_id"] . '</span>';
    $subArray[] = '<span>' . $dataRegister["petition_name"] . '</span>';
    $subArray[] = '<span>' . $dataRegister["request_name"] . '</span>';
    $subArray[] = '<span class="font-weight-bold">' . $dataRegister["request_phone"] . '</span>';
    $subArray[] = '<span>' .$dataRegister["hn"].' '. $dataRegister["patient_name"] . '</span>';
    $subArray[] = '<span>' . approveStatus($dataRegister["approve_status"]) . '</span>';
    $subArray[] = '<span>
                        <button type="button" class="btn btn-primary btn-sm px-3" data-toggle="modal" data-regid='.$dataRegister['id'].' data-trackid='.$dataRegister['track_id'].' data-statusdoc='.$dataRegister['approve_status'].' data-target="#showDataRegister"  title="ดูเพิ่มเติม"><i class="fas fa-eye fa-lg pr-1"></i> ดูเพิ่มเติม</button>
                        <button type="button" class="btn btn-danger btn-sm px-3 deleteRegister" name="deleteRegister" id='.$dataRegister['id'].' title="ลบข้อมูล"><i class="fas fa-trash fa-lg pr-1"></i> ลบ</button>
                    </span>';
    $data[] = $subArray;
}

$sql = "SELECT * FROM register_document";
$query = $conn_main->query($sql);
$totalData = $query->num_rows;

$output = array(
    "draw" => intval($_POST["draw"]),
    "recordsTotal" => $totalData,
    "recordsFiltered" => $filterRows,
    "data" => $data
);



// print_r($output);

echo json_encode($output);
