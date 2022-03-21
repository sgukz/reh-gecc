<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Administrator - ศูนย์ราชการสะดวก โรงพยาบาลร้อยเอ็ด</title>
    <!-- MDB icon -->
    <link rel="icon" href="../src/assets/img/logo.png" type="image/x-icon">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <!-- Google Fonts Roboto -->
    <link href="https://fonts.googleapis.com/css?family=Kanit:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="../src/assets/css/bootstrap.min.css">
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="../src/assets/css/mdb.min.css">
    <!-- DataTable -->
    <link rel="stylesheet" href="../src/assets/css/jquery.dataTables.min.css">

    <!-- Your custom styles (optional) -->
    <link rel="stylesheet" href="../src/assets/css/style.css">
</head>

<body class="flyout blue lighten-5">
    <?php
    session_start();
    date_default_timezone_set('Asia/Bangkok');
    include '../src/models/_config_db.php';
    include '../src/models/PatientModel.php';
    include '../src/functions/DateTime.php';
    $patient = new Patients();
    ?>
    <!--Navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark  blue lighten-1">

        <!-- Navbar brand -->
        <a class="navbar-brand font-weight-bold" href="#">
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
                        <a class="nav-link" href="index.php">
                            <span class="sr-only">(current)</span> <?= $_SESSION['userName'] . " (" . $_SESSION['userShortname'] . ")" ?>
                        </a>
                    </li>
                    <li class="nav-item <?= isset($_GET["page"]) ? "active" : "" ?>">
                        <a class="nav-link" href="?page=report">รายงาน</a>
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
                        // echo strtoupper(md5("reh"."1234"."gecc")); 
                        if (isset($_GET["page"])) {
                        ?>
                            <h4>รายการลงทะเบียนคำร้องเอกสารทั้งหมด</h4>
                        <?php
                        } else {
                        ?>
                            <button onclick="popWin(b64EncodeUnicode(12345))" class="btn btn-info btn-sm" style="cursor: pointer;"><i class="fas fa-sign-in-alt"> </i> ดูข้อมูล
                            </button>
                            <h4>รายการลงทะเบียนคำร้องเอกสารทั้งหมด</h4>
                            <table class="table table-hover table-responsive-sm" width="100%" id="showData">
                                <thead>
                                    <tr class="bg-info white-text">
                                        <th class="text-center py-4">วันที่</th>
                                        <th class="text-center py-4">เลขที่คำร้อง</th>
                                        <th class="text-center py-4">ประเภทคำร้อง</th>
                                        <th class="text-center py-4">ชื่อผู้ยื่นคำร้อง</th>
                                        <th class="text-center py-4">เบอร์โทร</th>
                                        <th class="text-center py-4">ผู้ป่วย</th>
                                        <th class="text-center py-4">สถานะ</th>
                                        <th class="text-center py-4">#</th>
                                    </tr>
                                </thead>
                            </table>
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
                    <div id="showTableDataRegister"></div>
                    <form id="changeStatus" class="needs-validation mt-3">
                        <div class="row">
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
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <label class="grey-text" for="approve_details">
                                    หมายเหตุ <span class="text-danger ml-1">*</span>
                                </label>
                                <textarea class="form-control rounded-0" id="approve_details" name="approve_details" rows="3"></textarea>
                            </div>
                        </div>
                        <button class="btn btn-info btn-sm" type="submit">
                            <i class="fas fa-save mr-1"></i> บันทึก
                        </button>
                        <input type="hidden" name="doc_id" id="doc_id">
                        <input type="hidden" name="approve_user" id="approve_user" value="<?= $_SESSION['userId'] ?>">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">ปิด</button>
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
                                <input type="text" class="form-control" name="user_name" id="user_name">
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
    <script type="text/javascript" src="../src/functions/DateTimeThai.js"></script>
    <script type="text/javascript" src="ajax/main.js"></script>
    <script type="text/javascript" src="ajax/login.js"></script>
    <script type="text/javascript">
        function popWin(id) {
            mypopup = window.open(
                'doc/print.php?id=' + id,
                'mypopup',
                'nenuber=no,toorlbar=no,location=no,scrollbars=no, status=no,resizable=no,width=1200,height=700,top=50,left=200 '
            );
            mypopup.focus();
        };

        function b64EncodeUnicode(str) {
            return btoa(encodeURIComponent(str));
        };

        function UnicodeDecodeB64(str) {
            return decodeURIComponent(atob(str));
        };

        $(document).ready(function() {
            console.log(UnicodeDecodeB64("MTIzNDU="));
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