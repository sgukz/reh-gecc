<?php
$petition_id = "";
$petition_type = $created_date = $request_name = $request_cid = $request_about_id = "";
$request_phone = $request_address = $request_details = "";
$hn = $vn = $an = $vst_date = $cid = $patient_name = $vstdate = $regdate = $dchdate = "";
$ward_name = $doctor_name = $appointment_date = "";
$detail2 = "";
$displayDateRegis = "";
$displayDateDch = "";
$trackId = "";
$approve_status = "";
"";
if (isset($_GET['id'])) {
    $trackId = base64_decode($_GET['id']);
    $get_patient_sys = $patient->getRegisterDocumentByTrackAdmin($trackId);
    $query_patient_sys = $conn_main->query($get_patient_sys);
    if ($query_patient_sys) {
        $dataRegister = $query_patient_sys->fetch_array();
        $petition_id = $dataRegister['petition_id'];
        $created_date = $dataRegister['created_date'];
        $request_name = $dataRegister['request_name'];
        $request_cid = $dataRegister['request_cid'];
        $request_about_id = $dataRegister['request_about_id'];
        $request_phone = $dataRegister['request_phone'];
        $request_address = $dataRegister['request_address'];
        $request_details = $dataRegister['request_details'];
        $detail2 = $dataRegister['request_detail_2'];
        $hn =  $dataRegister['hn'];
        $vn =  $dataRegister['vn'];
        $an =  $dataRegister['an'];
        $vst_date =  $dataRegister['vstdate'];
        $cid =  $dataRegister['patient_cid'];
        $patient_name = $dataRegister['patient_name'];
        $appointment_date = $dataRegister['appointment_date'];
        $regdate = $dataRegister['regdate'];
        $dchdate = $dchdate !== null ? $dataRegister['dchdate'] : "null";
        $displayDateRegis = DateTimeThai($regdate, 1);
        $displayDateDch = $dchdate !== null ? DateTimeThai($dchdate, 1) : "";
        $ward_name =  $dataRegister['dep_name'];
        $doctor_name = $dataRegister['doctor_name'];
        $appointment_date = $dataRegister['appointment_date'];
        $approve_status = $dataRegister['approve_status'];
    }
}
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card mt-2 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-center font-weight-bold blue lighten-2 py-2 label-title-form white-text">
                                ลงทะเบียนคำร้องขอเอกสาร
                            </h5>
                        </div>
                    </div>
                    <form id="formRegister" class="needs-validation">
                        <div class="row mb-2">
                            <div class="col-12">
                                <label class="grey-text" for="petition_type">
                                    ประเภทคำร้อง
                                    <span class="text-danger ml-1">*</span>
                                </label>
                                <select class="browser-default custom-select" id="petition_type" name="petition_type">
                                    <option selected disabled>เลือกประเภทคำร้อง</option>
                                    <?php
                                    $get_register_petition = $patient->getRegisterPetitionAll();
                                    $query_register_petition = $conn_main->query($get_register_petition);
                                    while ($dataPetition = $query_register_petition->fetch_assoc()) {
                                    ?>
                                        <option value="<?= $dataPetition['petition_id'] ?>" <?= ($petition_id === $dataPetition['petition_id'] ? "selected" : "") ?>>
                                            <?= $dataPetition['petition_name'] . " (" . $dataPetition['petition_detail'] . ")" ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    โปรดเลือกประเภทคำร้อง
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border text-info">ข้อมูลผู้ยื่นคำร้อง</legend>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label class="grey-text">
                                                วันที่ยื่นคำร้อง
                                            </label>
                                            <p class="date_now">
                                                <?php echo ($created_date !== "" ? DateTimeThai($created_date, 1) : DateTimeThai(date("Y-m-d"), 1));  ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label class="grey-text" for="petition_name">
                                                ชื่อ-สกุล<span class="text-danger ml-1">*</span><br>
                                                <span class="small-text">(ผู้ยื่นคำร้อง)</span>
                                            </label>
                                            <input type="text" class="form-control" name="petition_name" id="petition_name" value="<?= $request_name ?>" />
                                            <div class="invalid-feedback">
                                                โปรดระบุชื่อ-สกุลของผู้ยื่นคำร้อง
                                            </div>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <label class="grey-text" for="petition_cid">
                                                เลขบัตรประชาชน <span class="text-danger ml-1">*</span><br>
                                                <span class="small-text">(ผู้ยื่นคำร้อง)</span>
                                            </label>
                                            <input type="text" class="form-control" name="petition_cid" id="petition_cid" value="<?= $request_cid ?>" />
                                            <div class="invalid-feedback">
                                                โปรดระบุเลขบัตรประชาชนของผู้ยื่นคำร้อง
                                            </div>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <label class="grey-text" for="about_patient">
                                                เกี่ยวข้องเป็น <span class="text-danger ml-1">*</span><br>
                                                <span class="small-text">(ผู้ยื่นคำร้อง)</span>
                                            </label>
                                            <select class="browser-default custom-select" id="about_patient" name="about_patient">
                                                <option selected disabled>กรุณาเลือกความเกี่ยวข้องกับผู้ป่วย</option>
                                                <?php
                                                $get_register_about = $patient->getRegisterAboutAll();
                                                $query_register_about = $conn_main->query($get_register_about);
                                                while ($dataAbout = $query_register_about->fetch_assoc()) {
                                                ?>
                                                    <option value="<?= $dataAbout['about_id'] ?>" <?= ($request_about_id === $dataAbout['about_id'] ? "selected" : "") ?>>
                                                        <?= $dataAbout['about_name'] ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                โปรดเลือกความเกี่ยวข้องกับผู้ป่วย
                                            </div>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <label class="grey-text" for="petition_phone">
                                                เบอร์โทร <span class="text-danger ml-1">*</span><br>
                                                <span class="small-text">(ผู้ยื่นคำร้อง)</span>
                                            </label>
                                            <input type="text" class="form-control" name="petition_phone" id="petition_phone" value="<?= $request_phone ?>" />
                                            <div class="invalid-feedback">
                                                โปรดระบุเลขบัตรประชาชนของผู้ยื่นคำร้อง
                                            </div>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <label class="grey-text" for="petition_address">
                                                ที่อยู่ (ผู้ยื่นคำร้อง)
                                                <span class="text-danger ml-1">*</span><br>
                                                <span class="text-warning small-text">
                                                    กรุณาระบุที่อยู่จริงตามบัตรประชาชน
                                                </span>
                                            </label>
                                            <input type="text" class="form-control" name="petition_address" id="petition_address" value="<?= $request_address ?>" />
                                            <div class="invalid-feedback">
                                                โปรดระบุที่อยู่ของผู้ยื่นคำร้อง
                                            </div>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <label class="grey-text" for="request_details">
                                                เพื่อใช้ประกอบการ <span class="text-danger ml-1">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="request_details" id="request_details" value="<?= $request_details ?>" />
                                            <div class="invalid-feedback">
                                                โปรดเลือกความเกี่ยวข้องกับผู้ป่วย
                                            </div>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <label class="grey-text" for="request_detail_2">
                                                เพื่อยื่นต่อ <span class="small-text">(ไม่ระบุก็ได้)</span>
                                            </label>
                                            <input type="text" class="form-control" name="request_detail_2" id="request_detail_2" value="<?= $detail2 ?>" />
                                            <div class="invalid-feedback">
                                                โปรดเลือกความเกี่ยวข้องกับผู้ป่วย
                                            </div>
                                        </div>
                                        <!-- <div class="col-12 mb-2">
                                            <label class="grey-text" for="details">
                                                เหตุผลการนำไปใช้ประโยชน์ <span class="text-danger ml-1">*</span>
                                            </label>
                                            <textarea class="form-control rounded-0" id="details" name="details" rows="3"></textarea>
                                            <div class="invalid-feedback">
                                                โปรดระบุเหตุผลการนำไปใช้ประโยชน์
                                            </div>
                                        </div> -->
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border text-info">ข้อมูลผู้ป่วย</legend>
                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <div class="control-group hidden-el" id="showCid">
                                                <label class="grey-text" for="phone" for="search_cid">
                                                    เลขบัตรประชาชน
                                                    <span class="text-danger ml-1">*</span>
                                                </label>
                                                <input type="number" class="form-control text-center" id="search_cid" name="search_cid" placeholder="เลขบัตรประชาชน" />
                                                <small class="text-warning pl-2 mt-3">
                                                    กรุณากดปุ่ม&nbsp;<kbd>ตรวจสอบ</kbd>
                                                    &nbsp;เพื่อตรวจสอบข้อมูล
                                                </small>
                                                <div class="invalid-feedback">
                                                    โปรดระบุเลขบัตรประชาชน
                                                </div>
                                                <br>
                                                <button type="button" class="btn btn-primary btn-sm mt-2 mb-3" id="handleOnClickSearch">
                                                    <i class="fas fa-search"></i> ตรวจสอบ
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="grey-text" for="hn">
                                                    HN
                                                </label>
                                                <input type="text" class="form-control" name="hn" id="hn" value="<?= $hn ?>" />
                                                <input type="hidden" name="an" id="an" value="<?= $an ?>" />
                                                <input type="hidden" name="vn" id="vn" value="<?= $vn ?>" />
                                                <input type="hidden" name="vst_date" id="vst_date" value="<?= $vst_date ?>" />
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <label class="grey-text" for="cid">
                                                    เลขบัตรประชาชน
                                                </label>
                                                <input type="text" class="form-control" name="cid" id="cid" value="<?= $cid ?>" />
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="grey-text" for="patient_name">
                                                    ชื่อ-สกุล (ผู้ป่วย) <span class="text-danger ml-1">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="patient_name" id="patient_name" value="<?= $patient_name ?>" />
                                            </div>
                                            <div class="col-6 mb-2">
                                                <label class="grey-text" for="vstdate">
                                                    วันที่มารับบริการ
                                                    <!-- <span class="text-danger ml-1">*</span> -->
                                                </label>
                                                <select class="browser-default custom-select" id="vstdate" name="vstdate">
                                                    <option selected disabled>เลือกวันที่มารับบริการ</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 mb-2">

                                                <label class="grey-text" for="admit_date_display">
                                                    วันที่รับการรักษา
                                                </label>
                                                <input type="text" class="form-control" name="admit_date_display" id="admit_date_display" value="<?= $displayDateRegis ?>" />
                                                <input type="hidden" name="admit_date" id="admit_date" value="<?= $regdate ?>" />
                                            </div>
                                            <div class="col-6 mb-2">
                                                <label class="grey-text" for="dhc_date_display">
                                                    วันที่จำหน่าย
                                                </label>
                                                <input type="text" class="form-control mt-1" name="dhc_date_display" id="dhc_date_display" value="<?= $displayDateDch ?>" />
                                                <input type="hidden" name="dhc_date" id="dhc_date" value="<?= $dchdate ?>" />
                                            </div>
                                            <div class="col-6 mb-2">
                                                <label class="grey-text" for="ward_name">
                                                    ห้องตรวจ / หอผู้ป่วย
                                                </label>
                                                <input type="text" class="form-control" readonly name="ward_name" id="ward_name" value="<?= $ward_name ?>" />
                                            </div>
                                            <div class="col-6 mb-2">
                                                <label class="grey-text" for="doctor_name">
                                                    แพทย์ผู้รักษา
                                                </label>
                                                <input type="text" class="form-control" readonly name="doctor_name" id="doctor_name" value="<?= $doctor_name ?>" />
                                            </div>
                                            <div class="col-6 mb-2">
                                                <label class="grey-text" for="appointment_date_admin">
                                                    วันที่นัดรับเอกสาร <span class="text-danger ml-1">*</span>
                                                </label>
                                                <input type="date" class="form-control" name="appointment_date_admin" id="appointment_date_admin" value="<?= $appointment_date ?>">
                                                <div class="invalid-feedback">
                                                    โปรดระบุวันที่นัดรับเอกสาร
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="grey-text" for="status_id">
                                                    สถานะคำร้อง
                                                </label>
                                                <select class="browser-default custom-select" id="status_id" name="status_id">
                                                    <option selected disabled value="">เลือกสถานะคำร้อง</option>
                                                    <?php
                                                    $get_register_status = $patient->getRegisterStatusAll();
                                                    $query_register_status = $conn_main->query($get_register_status);
                                                    while ($dataStatus = $query_register_status->fetch_assoc()) {
                                                    ?>
                                                        <option value="<?= $dataStatus['status_id'] ?>" <?= ($dataStatus['status_id'] === $approve_status ? "selected" : "") ?>><?= $dataStatus['status_name'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button class="btn btn-info ml-4" type="submit" id="submitRegister">
                                    <i class="fas fa-save mr-1"></i> บันทึก
                                </button>
                                <input type="hidden" name="trackId" id="trackId" value="<?= $trackId ?>">
                                <span id="printDocument"></span>
                                <span id="printAppointment"></span>
                                <span id="resetFormRegister" class="hidden-el">
                                    <a href="?page=register" class="btn btn-danger">
                                        <i class="fas fa-redo fa-lg"></i> Reload
                                    </a>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>