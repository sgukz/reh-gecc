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
                                        <option value="<?= $dataPetition['petition_id'] ?>">
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
                                            <p class="date_now"><?php echo DateTimeThai(date("Y-m-d"), 1); ?></p>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label class="grey-text" for="petition_name">
                                                ชื่อ-สกุล<span class="text-danger ml-1">*</span><br>
                                                <span class="small-text">(ผู้ยื่นคำร้อง)</span>
                                            </label>
                                            <input type="text" class="form-control" name="petition_name" id="petition_name" />
                                            <div class="invalid-feedback">
                                                โปรดระบุชื่อ-สกุลของผู้ยื่นคำร้อง
                                            </div>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <label class="grey-text" for="petition_cid">
                                                เลขบัตรประชาชน <span class="text-danger ml-1">*</span><br>
                                                <span class="small-text">(ผู้ยื่นคำร้อง)</span>
                                            </label>
                                            <input type="text" class="form-control" name="petition_cid" id="petition_cid" />
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
                                                    <option value="<?= $dataAbout['about_id'] ?>"><?= $dataAbout['about_name'] ?></option>
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
                                            <input type="text" class="form-control" name="petition_phone" id="petition_phone" />
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
                                            <input type="text" class="form-control" name="petition_address" id="petition_address" />
                                            <div class="invalid-feedback">
                                                โปรดระบุที่อยู่ของผู้ยื่นคำร้อง
                                            </div>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <label class="grey-text" for="request_details">
                                                เพื่อใช้ประกอบการ <span class="text-danger ml-1">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="request_details" id="request_details" />
                                            <div class="invalid-feedback">
                                                โปรดเลือกความเกี่ยวข้องกับผู้ป่วย
                                            </div>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <label class="grey-text" for="request_detail_2">
                                                เพื่อยื่นต่อ <span class="small-text">(ไม่ระบุก็ได้)</span>
                                            </label>
                                            <input type="text" class="form-control" name="request_detail_2" id="request_detail_2" />
                                            <div class="invalid-feedback">
                                                โปรดเลือกความเกี่ยวข้องกับผู้ป่วย
                                            </div>
                                        </div>
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
                                                <input type="text" class="form-control" readonly name="hn" id="hn" />
                                                <input type="hidden" name="an" id="an" />
                                                <input type="hidden" name="vn" id="vn" />
                                                <input type="hidden" name="vst_date" id="vst_date" />
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <label class="grey-text" for="cid">
                                                    เลขบัตรประชาชน
                                                </label>
                                                <input type="text" class="form-control" readonly name="cid" id="cid" />
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <label class="grey-text" for="patient_name">
                                                    ชื่อ-สกุล (ผู้ป่วย) <span class="text-danger ml-1">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="patient_name" id="patient_name" />
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <label class="grey-text" for="vstdate">
                                                    วันที่มารับบริการ <span class="text-danger ml-1">*</span>
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
                                                <input type="text" class="form-control" name="admit_date_display" id="admit_date_display" />
                                                <input type="hidden" name="admit_date" id="admit_date" />
                                            </div>
                                            <div class="col-6 mb-2">
                                                <label class="grey-text" for="dhc_date_display">
                                                    วันที่จำหน่าย
                                                </label>
                                                <input type="text" class="form-control" name="dhc_date_display" id="dhc_date_display" />
                                                <input type="hidden" name="dhc_date" id="dhc_date" />
                                            </div>
                                            <div class="col-6 mb-2">
                                                <label class="grey-text" for="ward_name">
                                                    ห้องตรวจ / หอผู้ป่วย
                                                </label>
                                                <input type="text" class="form-control" readonly name="ward_name" id="ward_name" />
                                            </div>
                                            <div class="col-6 mb-2">
                                                <label class="grey-text" for="doctor_name">
                                                    แพทย์ผู้รักษา
                                                </label>
                                                <input type="text" class="form-control" readonly name="doctor_name" id="doctor_name" />
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button class="btn btn-info ml-4" type="submit"><i class="fas fa-save mr-1"></i> บันทึก</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>