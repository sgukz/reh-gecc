<?php
$track = "";
if (isset($_GET["track"])) {
    $track = $_GET["track"];
}
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card mt-2 mb-3">
                <div class="card-body">
                    <form id="formCheck" class="needs-validation">
                        <div class="row">
                            <div class="col-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border text-info">ตรวจสอบสถานะคำร้อง</legend>
                                    <div class="row">
                                        <div class="col-12 mb-3 mt-2">
                                            <label class="grey-text" for="track">
                                                กรอกหมายเลขที่คำร้อง [ตัวอย่าง : A6500001] / เลขบัตรประชาชนผู้ยื่นคำร้อง
                                            </label>
                                            <input type="text" class="form-control" name="track" id="track" value="" />
                                            <div class="invalid-feedback">
                                                โปรดระบุหมายเลขคำร้อง หรือ เลขบัตรประชาชนผู้ยื่นคำร้อง
                                            </div>
                                        </div>
                                        <button class="btn btn-info btn-sm ml-4" type="submit"><i class="fas fa-search mr-1"></i> ค้นหา</button>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-12">
                            <div id="searchDetail"></div>
                            <div id="tableSearch"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <?php
                            echo $_GET["track"];
                            if ($track !== "") {
                                $get_log = $patient->getRegisterDocumentByID($track);
                                $query_log = $conn_main->query($get_log);
                            ?>
                                <div id="tracking">
                                    <div class="text-center tracking-status-intransit">
                                        <p class="tracking-status text-tight">
                                            <?= "เลขที่คำร้อง " . $track ?>
                                        </p>
                                    </div>
                                    <div class="tracking-list">
                                        <?php
                                        while ($dataLog = $query_log->fetch_assoc()) {
                                            $dateEvent = DateTimeThai($dataLog["log_datetime"], 2);
                                            $timeEvent = DateTimeThai($dataLog["log_datetime"], 3);
                                            $appointmentDate = $dataLog["appointment_date"] !== "" ? DateTimeThai($dataLog["appointment_date"], 1) : "";
                                        ?>
                                            <div class="tracking-item">
                                                <div class="tracking-icon status-intransit">
                                                    <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                        <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                                                    </svg>
                                                    <!-- <i class="fas fa-circle"></i> -->
                                                </div>
                                                <div class="tracking-date"><?= $dateEvent ?><span><?= $timeEvent ?></span></div>
                                                <div class="tracking-content">
                                                    <?php

                                                    if ($dataLog["event_name"] === "Add") {
                                                        echo "<strong class='text-warning'>รอการตรวจสอบข้อมูล</strong>";
                                                    } else if ($dataLog["event_name"] === "approve_accept") {
                                                        echo "<strong class='text-info'>เจ้าหน้าที่รับเรื่องแล้ว</strong>";
                                                    } else if ($dataLog["event_name"] === "approve_success") {
                                                        echo "<strong class='text-success'>เตรียมเอกสารเรียบร้อย</strong>";
                                                        echo "<br>วันที่นัดรับเอกสาร " . $appointmentDate;
                                                        echo "<span>กรุณาติดต่อรับเอกสารได้ที่ ศูนย์ราชการสะดวกจุฬาภรณ์ ชั้น 1 เบอร์ 18 ในวันเวลาราชการ 08.00 - 16.00 น.<br><b class='text-danger'>*<u>หมายเหตุ</u>*</b> กำหนดรับเอกสารภายใน 10 วันทำการ <br>หรือสามารถติดต่อสอบถามได้ที่ <a href='tel: 043518200'>043-518200 ต่อ 7130</a> ในวันเวลาราชการ</span>";
                                                    } else if ($dataLog["event_name"] === "approve_consult") {
                                                        echo "<strong class='text-success'>กรุณาติดต่อเจ้าหน้าที่</strong>";
                                                        echo "<span>สามารถติดต่อได้ที่ ศูนย์ราชการสะดวกจุฬาภรณ์ ชั้น 1 เบอร์ 18 ในวันเวลาราชการ 08.00 - 16.00 น.<br><b class='text-danger'>*<u>หมายเหตุ</u>*</b>สามารถติดต่อสอบถามได้ที่ <a href='tel: 043518200'>043-518200 ต่อ 7130</a> ในวันเวลาราชการ</span>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>


                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>