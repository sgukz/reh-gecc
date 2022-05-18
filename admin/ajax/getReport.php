<?php
include '../../src/models/_config_db.php';
include '../../src/models/PatientModel.php';
include '../../src/functions/DateTime.php';
$patient = new Patients();

if ($_POST) {
    $resp = $arrayReport = array();
    $sql = $conditionStartDate = $conditionEndDate = $conditionPetition = $conditionDoctor = $section = "";
    $condition = "d.approve_status = 3 ";
    $orderBy = " ORDER BY d.approve_status = 3 ";
    $startDate = $_POST["startDate"] !== "" ? $_POST["startDate"] : "";
    $endDate = isset($_POST["endDate"]) ? $_POST["endDate"] : "";
    $petition_id = isset($_POST["petition_type"]) ? ($_POST["petition_type"] !== "" ? $_POST["petition_type"] : "") : "";
    $doctor_name = isset($_POST["doctor_name"]) ? ($_POST["doctor_name"] !== "" ? $_POST["doctor_name"] : "") : "";

    $strStartDate = $startDate !== "" ? explode("/", $startDate) : "";
    $newStartDate = $startDate !== "" ? $strStartDate[2] . "-" . $strStartDate[1] . "-" . $strStartDate[0] : "";

    $strEndDate = $endDate !== "" ? explode("/", $endDate) : "";
    $newEndDate = $endDate !== "" ? $strEndDate[2] . "-" . $strEndDate[1] . "-" . $strEndDate[0] : "";

    if (
        $startDate !== "" ||
        $endDate !== "" ||
        $petition_id !== "" ||
        $doctor_name !== ""
    ) {
        if ($newStartDate !== "" && $newEndDate !== "") {
            $section = ($newStartDate === $newEndDate ? "วันที่ยื่นคำร้อง " . DateTimeThai($newStartDate, 1) : "วันที่ยื่นคำร้อง " . DateTimeThai($newStartDate, 1) . " ถึง " . DateTimeThai($newEndDate, 1));
            $conditionStartDate = " AND d.created_date BETWEEN '$newStartDate 00:00:00' AND '$newEndDate 23:59:59' ";
        } else {
            $section = ($newEndDate !== "" ? "วันที่ยื่นคำร้อง " . DateTimeThai($newStartDate, 1) . " ถึง " . DateTimeThai($newEndDate, 1) : "วันที่ยื่นคำร้อง " . DateTimeThai($newStartDate, 1));
            if ($newStartDate !== "") {
                $conditionStartDate = " AND d.created_date BETWEEN '$newStartDate 00:00:00' AND '$newStartDate 23:59:59' ";
            } else {
                $conditionStartDate = "";
            }

            if ($newEndDate !== "") {
                $conditionStartDate = " AND d.created_date BETWEEN '$newEndDate 00:00:00' AND '$newEndDate 23:59:59' ";
            } else {
                $conditionEndDate = "";
            }
        }


        if ($petition_id !== "") {
            $conditionPetition = " AND d.petition_id = '$petition_id' ";
        } else {
            $conditionPetition = "";
        }

        if ($doctor_name !== "") {
            $conditionDoctor = " AND d.doctor_name = '$doctor_name' ";
        } else {
            $conditionDoctor = "";
        }
    }
    $condition .= $conditionStartDate . $conditionEndDate . $conditionPetition . $conditionDoctor;


    $sql = "SELECT * FROM register_document d
            LEFT JOIN register_tracking t ON d.id = t.doc_id
            LEFT JOIN register_petition p ON p.petition_id = d.petition_id
            LEFT JOIN register_status s ON d.approve_status = s.status_id
            WHERE $condition
            ";


    $query_report = $conn_main->query($sql);
    if ($query_report) {
        $num_rows = $query_report->num_rows;
        if ($num_rows > 0) {
?>
            <hr>
            <div class="text-right">
                <button type="button" class="btn aqua-gradient btn-sm font-weight-bold" onclick="printReport('report')">
                    <i class="fas fa-print fa-lg pr-1"></i> ปริ้นรายงาน
                </button>
            </div>
            <div id="report">
                <div class="text-center font-thaisaraban header-report">ทะเบียนนำส่งใบรายงานแพทย์</div>
                <div class="text-center font-thaisaraban header-report"><?= $section ?></div>
                <div class="text-right font-thaisaraban header-report">ข้อมูล ณ วันที่ <?= DateTimeThai(date("Y-m-d"), 1) ?></div>
                <table class="mt-3" width="100%" border="1" cellpadding="0" cellspacing="1">
                    <thead>
                        <tr bgcolor="#e0e0e0">
                            <th class="text-center font-thaisaraban header-table py-3 header-table"><span class="pl-1 pr-1">ลำดับ</span></th>
                            <th class="text-center font-thaisaraban header-table py-3 header-table"><span class="pl-1 pr-1">เลขที่คำร้อง</span></th>
                            <th class="text-center font-thaisaraban header-table py-3 header-table"><span class="pl-1 pr-1">วันที่ยื่นคำร้อง</span></th>
                            <th class="text-center font-thaisaraban header-table py-3 header-table"><span class="pl-1 pr-1">ชื่อผู้ป่วย</span></th>
                            <th class="text-center font-thaisaraban header-table py-3 header-table"><span class="pl-1 pr-1">ที่อยู่จัดส่งเอกสาร</span></th>
                            <th class="text-center font-thaisaraban header-table py-3 header-table"><span class="pl-1 pr-1">เอกสารที่ขอ</span></th>
                            <th class="text-center font-thaisaraban header-table py-3 header-table"><span class="pl-1 pr-1">การนำไปใช้ประโยชน์</span></th>
                            <th class="text-center font-thaisaraban header-table py-3 header-table"><span class="pl-1 pr-1">ชื่อผู้ยื่นคำร้อง</span></th>
                            <th class="text-center font-thaisaraban header-table py-3 header-table"><span class="pl-1 pr-1">เบอร์โทรติดต่อ</span></th>
                            <th class="text-center font-thaisaraban header-table py-3 header-table"><span class="pl-1 pr-1">วันที่นัดรับ</span></th>
                            <th class="text-center font-thaisaraban header-table py-3 header-table"><span class="pl-1 pr-1">หมายเหตุ</span></th>
                            <th class="text-center font-thaisaraban header-table py-3 header-table"><span class="pl-1 pr-1">ผู้รับ</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($dataReport = $query_report->fetch_assoc()) {
                        ?>
                            <tr height="35">
                                <td class="text-center font-thaisaraban data-report pl-1 pr-1"><?= $no ?></td>
                                <td class="text-center font-thaisaraban data-report pl-1 pr-1"><?= $dataReport['track_id'] ?></td>
                                <td class="text-center font-thaisaraban data-report pl-1 pr-1"><?= DateTimeThai($dataReport['created_date'], 2) ?></td>
                                <td class="data-report font-thaisaraban pl-1 pr-1"><?= $dataReport['patient_name'] ?></td>
                                <td class="data-report font-thaisaraban pl-1 pr-1"><?= $dataReport['request_address'] ?></td>
                                <td class="text-center data-report font-thaisaraban pl-1 pr-1"><?= $dataReport['petition_name'] ?></td>
                                <td class="text-center data-report font-thaisaraban pl-1 pr-1"><?= $dataReport['request_details'] ?></td>
                                <td class="data-report font-thaisaraban pl-1 pr-1"><?= $dataReport['request_phone'] ?></td>
                                <td class="text-center data-report font-thaisaraban pl-1 pr-1"><?= $dataReport['request_phone'] ?></td>
                                <td class="text-center data-report font-thaisaraban pl-1 pr-1"><?= ($dataReport['appointment_date'] !== null ? DateTimeThai($dataReport['appointment_date'], 2) : "") ?></td>
                                <td class="data-report font-thaisaraban pl-1 pr-1"><?= $dataReport['approve_details'] ?></td>
                                <td class="data-report font-thaisaraban pl-1 pr-1"><?= $dataReport['receive_name'] ?></td>
                            </tr>
                        <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
        } else {
        ?>
            <hr>
            <div class="text-center">
                <span class="text-danger font-weight-bold">ไม่พบข้อมูล...</span>
            </div>
        <?php
        }
    } else {
        ?>
        <hr>
        <div class="text-center">
            <span class="text-warning font-weight-bold"><?= "Error >> " . $conn_main->error ?></span>
        </div>
<?php
    }
    // echo json_encode($resp);
}
