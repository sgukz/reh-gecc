<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Administrator - ศูนย์ราชการสะดวก โรงพยาบาลร้อยเอ็ด</title>
    <link rel="shortcut icon" href="../src/assets/img/logo.png"> -->

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" href="../src/assets/img/logo.ico">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <!-- Google Fonts Roboto -->
    <link href="https://fonts.googleapis.com/css?family=Kanit:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="../src/assets/css/bootstrap.min.css">
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="../src/assets/css/fluid-gallery.css">
    <link rel="stylesheet" href="../src/assets/css/mdb.min.css">
    <!-- DataTable -->
    <link rel="stylesheet" href="../src/assets/css/jquery.dataTables.min.css">

    <!-- Your custom styles (optional) -->
    <link rel="stylesheet" href="../src/assets/css/style.css">
    <link rel="stylesheet" href="../src/assets/css/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/report.css">
</head>

<body class="flyout blue lighten-5">
    <?php
    session_start();
    date_default_timezone_set('Asia/Bangkok');
    include '../src/models/_config_db.php';
    include '../src/models/PatientModel.php';
    include '../src/functions/DateTime.php';
    include 'data/_month.php';

    $patient = new Patients();
    ?>
    <!--Navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark  blue lighten-1">

        <!-- Navbar brand -->
        <a class="navbar-brand font-weight-bold" href="index.php">
            <img src="../src/assets/img/logo.png" width="40" alt="ศูนย์ราชการสะดวก GECC"> ศูนย์ราชการสะดวก GECC
        </a>

        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="basicExampleNav">

            <!-- Links -->
            <ul class="navbar-nav mr-auto">
                <?php
                if (isset($_SESSION['userName'])) {
                ?>
                    <li class="nav-item <?= isset($_GET["page"]) ? "" : "active" ?>">
                        <a class="nav-link" href="#">
                            <span class="sr-only">(current)</span> <?= $_SESSION['userName'] . " (" . $_SESSION['userShortname'] . ")" ?>
                        </a>
                    </li>
                    <li class="nav-item <?= !isset($_GET["page"]) ? "active" : "" ?>">
                        <a class="nav-link" href="index.php">รายการคำร้องทั้งหมด</a>
                    </li>
                    <li class="nav-item <?= (isset($_GET["page"]) && $_GET["page"] === "register") ? "active" : "" ?>">
                        <a class="nav-link" href="index.php?page=register">ลงทะเบียนคำร้อง</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">รายงาน</a>
                        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="?page=report">ทะเบียนนำส่งใบรายงานแพทย์</a>
                            <a class="dropdown-item" href="?page=report-proccess">รายงานสรุปดำเนินการ</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="logout">ออกจากระบบ</a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
        <!-- Collapsible content -->

    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mt-2 mb-3">
                    <div class="card-body">
                        <?php
                        // echo strtoupper(md5("reh"."naeng"."gecc")); 
                        if (isset($_GET["page"])) {
                            if ($_GET["page"] === "report") {
                        ?>
                                <div class="row">
                                    <div class="col-12">
                                        <h4>รายการลงทะเบียนคำร้องเอกสาร</h4>
                                        <form id="formReport">
                                            <div class="row mb-2">
                                                <div class="col-md-6 col-sm-12">
                                                    <label class="grey-text" for="startDate">
                                                        เลือกวันที่เริ่ม
                                                    </label>
                                                    <input type="text" class="form-control" name="startDate" id="startDate" />
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <label class="grey-text" for="endDate">
                                                        เลือกวันที่สิ้นสุด
                                                    </label>
                                                    <input type="text" class="form-control" name="endDate" id="endDate" disabled />
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-6 col-sm-12">
                                                    <label class="grey-text" for="petition_type">
                                                        ประเภทคำร้อง
                                                    </label>
                                                    <select class="browser-default custom-select" id="petition_type" name="petition_type">
                                                        <option value="" selected disabled>เลือกประเภทคำร้อง</option>
                                                        <?php
                                                        $get_register_petition = $patient->getRegisterPetitionAll();
                                                        $query_register_petition = $conn_main->query($get_register_petition);
                                                        while ($dataPetition = $query_register_petition->fetch_assoc()) {
                                                        ?>
                                                            <option value="<?= $dataPetition['petition_id'] ?>">
                                                                <?= $dataPetition['petition_name'] ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <label class="grey-text" for="doctor_name">
                                                        แพทย์ผู้รักษา
                                                    </label>
                                                    <select class="browser-default custom-select" id="doctor_name" name="doctor_name">
                                                        <option value="" selected disabled>เลือกแพทย์ผู้รักษา</option>
                                                        <?php
                                                        $get_register_doctor = $patient->getRegisterDocumentDoctorName();
                                                        $query_register_doctor = $conn_main->query($get_register_doctor);
                                                        while ($dataDoctor = $query_register_doctor->fetch_assoc()) {
                                                        ?>
                                                            <option value="<?= $dataDoctor['doctor_name'] ?>">
                                                                <?= $dataDoctor['doctor_name'] ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-info btn-sm">
                                                        ดูรายงงาน
                                                    </button>
                                                    <button type="reset" class="btn btn-danger btn-sm">
                                                        reset
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12">
                                        <div id="showReportPrint"></div>
                                    </div>
                                </div>

                            <?php
                            } elseif ($_GET["page"] === "report-proccess") {
                                $paramDate = isset($_GET["reportDateSelect"]) ? $_GET["reportDateSelect"] : date("Y-m-d");
                                $arrayParaDate = explode("-", $paramDate);
                                $month = $arrayParaDate[1];
                            ?>
                                <div class="row">
                                    <div class="col-12">
                                        <h4 id="title-show-document">รายงานสรุปดำเนินการ</h4>
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="grey-text" for="reportDateSelect">
                                                    เลือกเดือน
                                                </label><br>
                                                <select class="browser-default custom-select col-4" name="reportDateSelect" id="reportDateSelect">
                                                    <?php
                                                    foreach ($arrayMonth as $key => $value) {
                                                    ?>
                                                        <option value="<?= $key ?>" <?= ($month === $key ? "selected" : "") ?>>
                                                            <?= $value ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-right">
                                                    <button type="button" class="btn aqua-gradient btn-sm font-weight-bold" onclick="printReport('reportProcess')">
                                                        <i class="fas fa-print fa-lg pr-1"></i> ปริ้นรายงาน
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="reportProcess">
                                            <div class="text-center font-thaisaraban header-report">รายงานสรุปดำเนินการ <?= $arrayMonth[$month] ?></div>
                                            <div class="text-right font-thaisaraban header-report">ข้อมูล ณ วันที่ <?= DateTimeThai(date("Y-m-d"), 1) ?></div>
                                            <table class="mt-3" width="100%" border="1" cellpadding="0" cellspacing="1">
                                                <thead>
                                                    <tr bgcolor="#e0e0e0">
                                                        <th class="text-center font-thaisaraban header-table py-3 header-table" width="5%"><span class="pl-1 pr-1">ลำดับ</span></th>
                                                        <th class="text-center font-thaisaraban header-table py-3 header-table" width="15%"><span class="pl-1 pr-1">ชื่อ - สกุล</span></th>
                                                        <th class="text-center font-thaisaraban header-table py-3 header-table" width="13%"><span class="pl-1 pr-1">วันที่ยื่นคำร้อง</span></th>
                                                        <th class="text-center font-thaisaraban header-table py-3 header-table" width="13%"><span class="pl-1 pr-1">วันที่นัดรับเอกสาร</span></th>
                                                        <th class="text-center font-thaisaraban header-table py-3 header-table" width="13%"><span class="pl-1 pr-1">วันที่เอกสารเสร็จ</span></th>
                                                        <th class="text-center font-thaisaraban header-table py-3 header-table" width="15%"><span class="pl-1 pr-1">จำนวนวันที่เอกสารเสร็จ</span></th>
                                                        <th class="text-center font-thaisaraban header-table py-3 header-table" width="20%"><span class="pl-1 pr-1">ชื่อผู้รับคำร้อง</span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $userId = $_SESSION['userId'];
                                                    $sql = "SELECT
                                                            d.request_name, 
                                                            d.created_date,
                                                            d.appointment_date,
                                                            d.completed_date,
                                                            d.approve_user
                                                        FROM
                                                            register_document d
                                                            LEFT JOIN register_tracking t ON d.id = t.doc_id
                                                            LEFT JOIN register_petition p ON p.petition_id = d.petition_id
                                                            LEFT JOIN register_status s ON d.approve_status = s.status_id 
                                                        WHERE
                                                            d.approve_status = 3 
                                                            AND d.created_date BETWEEN CONCAT(date_add(date_add(LAST_DAY('$paramDate'),interval 1 DAY),interval -1 MONTH), ' 00:00:00') 
                                                            AND CONCAT(LAST_DAY('$paramDate'), ' 23:59:59') 
                                                            -- AND d.approve_user = '$userId'
                                                        ORDER BY
                                                            d.created_date DESC";
                                                    $query_report = $conn_main->query($sql);
                                                    $num_rows_report = $query_report->num_rows;
                                                    $no = 1;
                                                    $fullNameUser = "";
                                                    $countLess = $countOver = 0;
                                                    if ($num_rows_report > 0) {
                                                        while ($dataReport = $query_report->fetch_assoc()) {
                                                            $get_username = "SELECT `name` FROM opduser WHERE loginname = '{$dataReport['approve_user']}'";
                                                            $query_get_username = $conn_hosxp->query($get_username);
                                                            $num = $query_get_username->num_rows;
                                                            if ($num > 0) {
                                                                $dataUser = $query_get_username->fetch_assoc();
                                                                $fullNameUser = $dataUser["name"];
                                                            }
                                                            $diff = abs(strtotime($dataReport['created_date']) - strtotime($dataReport['completed_date']));

                                                            $years = floor($diff / (365 * 60 * 60 * 24));
                                                            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                                            $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                                            if (($days + 1) <= 10) {
                                                                $countLess += 1;
                                                            } else {
                                                                $countOver += 1;
                                                            }
                                                    ?>
                                                            <tr height="35">
                                                                <td class="text-center font-thaisaraban data-report pl-1 pr-1">
                                                                    <?= $no ?>
                                                                </td>
                                                                <td class="font-thaisaraban data-report pl-1 pr-1">
                                                                    <?= $dataReport['request_name'] ?>
                                                                </td>
                                                                <td class="text-center font-thaisaraban data-report pl-1 pr-1">
                                                                    <?= DateTimeThai($dataReport['created_date'], 1) ?>
                                                                </td>
                                                                <td class="text-center font-thaisaraban data-report pl-1 pr-1">
                                                                    <?= DateTimeThai($dataReport['appointment_date'], 1) ?>
                                                                </td>
                                                                <td class="text-center font-thaisaraban data-report pl-1 pr-1">
                                                                    <?= DateTimeThai($dataReport['completed_date'], 1) ?>
                                                                </td>
                                                                <td class="text-center font-thaisaraban data-report pl-1 pr-1">
                                                                    <?= ($days) + 1 . " วัน" ?>
                                                                </td>
                                                                <td class="font-thaisaraban data-report pl-1 pr-1">
                                                                    <?= $fullNameUser ?>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                            $no++;
                                                        }
                                                        ?>

                                                        <tr>
                                                            <td class="text-right" colspan="7">
                                                                <div class="mt-2">
                                                                    <span class="font-weight-bold font-thaisaraban data-report">เอกสารเสร็จภายใน 10 วัน </span>
                                                                    <span class="font-weight-bold mr-3 font-thaisaraban data-report"><?= "<u>" . number_format($countLess) . "</u> คำร้อง " ?></u>ร้อยละ <?= (intval($countLess) * 100) / intval($num_rows_report) ?></span>
                                                                </div>
                                                                <div>
                                                                    <span class="font-weight-bold font-thaisaraban data-report">เอกสารเสร็จมากกว่า 10 วัน </span>
                                                                    <span class="font-weight-bold mr-3 font-thaisaraban data-report"><?= "<u>" . number_format($countOver) . "</u> คำร้อง " ?></u>ร้อยละ <?= (intval($countOver) * 100) / intval($num_rows_report) ?></span>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <span class="font-weight-bold font-thaisaraban data-report">คำร้องขอเอกสารทั้งหมด </span>
                                                                    <span class="font-weight-bold mr-3 font-thaisaraban data-report"><?= "<u>" . number_format($num_rows_report) . "</u> คำร้อง " ?></span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <tr height="35">
                                                            <td class="text-center" colspan="7">
                                                                ไม่พบข้อมูล
                                                            </td>
                                                        </tr>

                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            } elseif ($_GET['page'] === "register") {
                                include 'pages/register.php';
                            }
                        } else {
                            ?>
                            <div class="row">
                                <div class="col-12">
                                    <h4 id="title-show-document">รายการลงทะเบียนคำร้องเอกสารทั้งหมด</h4>
                                    <div>
                                        <a href="?page=register" target="_BLANK" class="btn btn-success btn-sm font-weight-bold">
                                            <i class="fas fa-plus"></i> ลงทะเบียนคำร้อง
                                        </a>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="grey-text" for="selectDate">
                                                เลือกวันที่
                                            </label>
                                            <input type="text" class="form-control" name="selectDate" id="selectDate" />
                                            <button type="button" class="btn btn-primary btn-sm" id="searchSelectDate">
                                                <i class="fas fa-search"></i> ค้นหา
                                            </button>
                                            <button type="button" class="btn btn-info btn-sm" id="showDataAll">
                                                <span id="labelShowAll">แสดงทั้งหมด</span>
                                            </button>
                                        </div>
                                    </div>
                                    <table class="table table-hover table-responsive-sm" width="100%" id="showData">
                                        <thead>
                                            <tr class="bg-info white-text">
                                                <th class="text-center py-4">วันที่</th>
                                                <th class="text-center py-4">เลขที่คำร้อง</th>
                                                <th class="text-center py-4">ประเภทคำร้อง</th>
                                                <th class="text-center py-4">ชื่อผู้ยื่นคำร้อง</th>
                                                <th class="text-center py-4">เบอร์โทร</th>
                                                <th class="text-center py-4">ชื่อผู้ป่วย</th>
                                                <th class="text-center py-4">วันที่นัดรับ</th>
                                                <th class="text-center py-4">สถานะ</th>
                                                <th class="text-center py-4">#</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="showDataRegister" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title text-primary font-weight-bold"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="changeStatus" class="needs-validation mt-3">
                        <div id="showTableDataRegister"></div>
                        <div class="row pt-3">
                            <div class="col-4">
                                <label class="grey-text" for="status_id">
                                    สถานะคำร้อง
                                </label>
                                <select class="browser-default custom-select" id="status_id" name="status_id">
                                    <option selected disabled>เลือกสถานะคำร้อง</option>
                                    <?php
                                    $get_register_status = $patient->getRegisterStatusAll();
                                    $query_register_status = $conn_main->query($get_register_status);
                                    while ($dataStatus = $query_register_status->fetch_assoc()) {
                                    ?>
                                        <option value="<?= $dataStatus['status_id'] ?>"><?= $dataStatus['status_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-4 hidden-el" id="section_app_date">
                                <label class="grey-text" for="appointment_date">
                                    วันที่นัดรับเอกสาร
                                </label>
                                <input type="date" class="form-control" name="appointment_date" id="appointment_date">
                                <div class="invalid-feedback">
                                    โปรดระบุวันที่นัดรับเอกสาร
                                </div>
                            </div>
                            <div class="col-4 hidden-el" id="section_receive_name">
                                <label class="grey-text" for="receive_name">
                                    ชื่อผู้รับเอกสาร
                                </label>
                                <input type="text" class="form-control" name="receive_name" id="receive_name">
                                <div class="invalid-feedback">
                                    โปรดระบุชื่อผู้รับเอกสาร
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <label class="grey-text" for="approve_details">
                                    หมายเหตุ
                                </label>
                                <textarea class="form-control rounded-0" id="approve_details" name="approve_details" rows="3"></textarea>
                            </div>
                        </div>
                        <button class="btn btn-info btn-sm" type="submit">
                            <i class="fas fa-save mr-1"></i> บันทึก
                        </button>
                        <input type="hidden" name="doc_id" id="doc_id">
                        <input type="hidden" name="approve_user" id="approve_user" value="<?= $_SESSION['userId'] ?>">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                            <i class="fas fa-times"></i> ปิด
                        </button>
                        <span id="printDocument"></span>
                        <span id="printAppointment"></span>
                    </form>
                    <hr>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <form id="formUploadEvidence" enctype="multipart/form-data">
                                <fieldset class="mt-2">
                                    <div class="file-input">
                                        <input type="file" id="fileToUpload" name="fileToUpload[]" class="file" accept="image/*, .pdf" multiple>
                                        <label for="fileToUpload" id="lebel-select">
                                            <i class="far fa-file-image pr-1"></i> แนบไฟล์หลักฐาน
                                        </label>
                                    </div>
                                    <div class="wrapper hidden-el" id="showPercent">
                                        <div class="d-flex justify-content-between">
                                            <p class="mb-2 text-primary percent"></p>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                                0%
                                            </div>
                                        </div>
                                    </div>
                                    <div id="show-image" class="col-lg-6 mt-2 show-up section-info" data-wow-duration="1s" data-wow-delay="0.3s">
                                        <div class="blog-post">
                                            <div class="thumb">
                                                <p class="file-name text-dark"></p>
                                                <a href="#"><img src="#" id="img_atk_confirm" alt="" width="80%"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn peach-gradient hidden-el" id="submitUpload">อัพโหลด</button>
                                    <div id="section-file" class="ml-2 hidden-el">
                                        <label class="text-primary font-weight-bold" style="width: 100%;">
                                            <hr>
                                            <i class="mdi mdi-attachment"></i> หลักฐาน
                                            <hr>
                                        </label>
                                        <div class="ml-2">
                                            <div id="attachment"></div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="uploadId" id="uploadId">
                                </fieldset>
                            </form>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
    <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title font-weight-bold white-text">เข้าสู่ระบบ</h5>
                </div>
                <form id="formLogin" class="needs-validation">
                    <div class="modal-body">
                        <div class="row py-3 px-3">
                            <div class="col-12">
                                <label class="font-weight-bold" for="user_name">
                                    ชื่อผู้ใช้งาน
                                </label>
                                <input type="text" class="form-control" name="user_name" id="user_name" autofocus>
                                <div class="invalid-feedback">
                                    โปรดระบุชื่อผู้ใช้งาน
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="font-weight-bold" for="pwd">
                                    รหัสผ่าน
                                </label>
                                <input type="password" class="form-control" name="pwd" id="pwd">
                                <div class="invalid-feedback">
                                    โปรดระบุรหัสผ่าน
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> ล็อคอิน</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <img id="image-gallery-image" class="img-responsive col-md-12" src="">
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script type="text/javascript" src="../src/assets/js/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="../src/assets/js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="../src/assets/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="../src/assets/js/mdb.min.js"></script>
    <script type="text/javascript" src="../src/assets/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="../src/assets/js/sweetalert2.js"></script>
    <script type="text/javascript" src="../src/assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../src/assets/js/gallery.modal.js"></script>
    <script type="text/javascript" src="../src/assets/js/jquery-ui.js"></script>
    <script type="text/javascript" src="../src/functions/DateTimeThai.js"></script>
    <script type="text/javascript" src="ajax/main.js"></script>
    <script type="text/javascript" src="ajax/login.js"></script>
    <script type="text/javascript" src="ajax/report.js"></script>
    <script type="text/javascript" src="ajax/registerAdmin.js"></script>
    <script type="text/javascript">
        function printReport(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        $(document).ready(function() {
            <?php
            if (!isset($_SESSION['userName'])) {
            ?>
                $('#modalLogin').modal({
                    backdrop: 'static',
                    keyboard: false
                })
                $('.firstBlur').addClass('modalBlur');
            <?php
            } else {
            ?>
                $('#modalLogin').modal('hide')
                $('.firstBlur').removeClass('modalBlur');
            <?php
            }
            ?>
            // dayNamesShort: ["อา.", "จ.", "อ.", "พ.", "พฤ.", "ศ.", "ส."],
            $("#admit_date_display").datepicker({
                monthNames: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
                dateFormat: "dd/mm/yy",
                changeYear: true,
                onSelect: function(date) {
                    $("#admit_date").val(formatDateEN(date, 1));
                }
            });
            $("#dhc_date_display").datepicker({
                monthNames: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
                dateFormat: "dd/mm/yy",
                changeYear: true,
                onSelect: function(date) {
                    $("#dhc_date").val(formatDateEN(date, 1));
                }
            });

            $("#startDate").datepicker({
                monthNames: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
                dateFormat: "dd/mm/yy",
                changeYear: true,
                onSelect: function(date) {
                    $("#endDate").attr("disabled", false)
                }
            });

            $("#endDate").datepicker({
                monthNames: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
                dateFormat: "dd/mm/yy",
                changeYear: true
            });

            $("#selectDate").datepicker({
                monthNames: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
                dateFormat: "dd/mm/yy",
                changeYear: true
            });

        })
        // success: function(data, textStatus, jqXHR) {
        //                 console.log(data); //*** returns correct json data
        //             },
        //             error: function(err) {
        //                 console.log(err);
        //             }
    </script>

</body>

</html>