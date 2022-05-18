let queryString = window.location.search;
let arrayUrl = queryString.split("&id=")
let regisId = arrayUrl[1]
if(regisId !== undefined){
    let cid = $("#cid").val();
    getPatient(cid)
}
$.validator.setDefaults({
    submitHandler: function () {
        $.ajax({
            method: "POST",
            url: "controllers/RegisterController.php",
            data: $("#formRegister").serialize(),
            dataType: "json",
        })
            .done((response) => {
                let resp = response
                if (resp.status_code === 200) {
                    let trackid = resp.track_id
                    let timerInterval
                    Swal.fire({
                        title: 'บันทึกข้อมูลเรียบร้อย',
                        text: 'กำลังโหลดข้อมูล...',
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            // $("#submitRegister").attr("disabled", true)
                            $("#resetFormRegister").removeClass("hidden-el")
                            $("#printDocument").html(`<button type="button" class="btn peach-gradient printDocument" id="${trackid}">
                                            <i class="fas fa-print fa-lg"></i> พิมพ์คำร้อง
                                        </button>`)
                            $("#printAppointment").html(`<button type="button" class="btn aqua-gradient printAppointment" id="${trackid}">
                                                            <i class="fas fa-print fa-lg"></i> พิมพ์บัตรนัด
                                                        </button>`)
                        }
                    })
                } else {
                    // Swal.fire({
                    //     title: 'แจ้งเตือน',
                    //     text: resp.msg,
                    //     icon: resp.type,
                    // })
                    console.log(resp);
                }
            })
            .fail((error) => {
                console.log(error);
            });
    }
});

$("#formRegister").validate({
    rules: {
        petition_type: "required",
        petition_name: "required",
        petition_cid: "required",
        about_patient: "required",
        petition_phone: "required",
        petition_address: "required",
        patient_name: "required",
        hn: "required",
        cid: "required",
        request_details: "required",
        appointment_date_admin: "required",
    },
    errorElement: "em",

    errorPlacement: function (error, element) {
        // Add the `invalid-feedback` class to the error element
        error.addClass("invalid-feedback");
        error.insertAfter(element.next(".pmd-textfield-focused"));
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).addClass("is-valid").removeClass("is-invalid");
    }
});

$('#about_patient').change(function () {
    if ($(this).val() !== "1") {
        $("#showCid").removeClass("hidden-el")
        $("#hn").val("");
        $("#cid").val("");
        $("#patient_name").val("");
    } else {
        if ($("#petition_cid").val() !== "") {
            $("#showCid").addClass("hidden-el")
            getPatient($("#petition_cid").val())
        }
    }
});

function getPatient(cid) {
    $.ajax({
        method: "POST",
        url: "../src/ajax/getPatientByCID.php",
        data: {
            cid: cid
        },
        dataType: "json",
    })
        .done((response) => {
            let resp = response
            if (resp.status_code === 200) {
                if (resp.data.length > 0) {
                    $("#hn").val(resp.data[0].hn);
                    $("#cid").val(resp.data[0].cid);
                    $("#patient_name").val(resp.data[0].full_name);
                    // $("#cid").val(resp.data[0].cid);
                    resp.data.map(val => {
                        let textOption = DateTimeThai(val.vstDate)
                        let valueOption = (val.an === null) ? val.vstDate + ", hn, " + val.hn : val.vstDate + ", an, " + val.an
                        $('#vstdate').append($('<option>', {
                            value: valueOption,
                            text: textOption
                        }));
                    })
                } else {
                    Swal.fire({
                        title: "แจ้งเตือน",
                        text: "ไม่พบข้อมูลรับบริการ กรุณาตรวจสอบข้อมูลให้ถูกต้อง",
                        icon: "error"
                    })
                }
            } else {
                Swal.fire({
                    title: 'แจ้งเตือน',
                    text: resp.msg,
                    icon: resp.type,
                })
                console.log(resp);
            }
        })
        .fail((error) => {
            Swal.fire({
                title: "แจ้งเตือน",
                text: "เกิดข้อผิดพลาด! :  " + JSON.stringify(error),
                icon: "error"
            })
            console.log(error);
        });
}

$("#handleOnClickSearch").click(function () {
    let cid = $("#search_cid").val()
    getPatient(cid)
})

function getVstdate(vstdate, section, hnORan) {
    let jsonData = {}
    let bash_url = ""
    if (section === "hn") {
        jsonData = {
            vstdate: vstdate,
            hn: hnORan,
        }
        bash_url = "../src/ajax/getPatientByVstdateAndHN.php"
    } else {
        jsonData = {
            an: hnORan,
        }
        bash_url = "../src/ajax/getPatientByAN.php"
    }
    $.ajax({
        method: "POST",
        url: bash_url,
        data: jsonData,
        dataType: "json",
    })
        .done((response) => {
            let resp = response
            if (resp.status_code === 200) {
                if (resp.data.length > 0) {
                    $("#vn").val(resp.data[0].vn);
                    $("#an").val(resp.data[0].an);
                    $("#admit_date").val(resp.data[0].visitDate);
                    $("#dhc_date").val(resp.data[0].dchDate);
                    $("#ward_name").val(resp.data[0].dep_name);
                    $("#doctor_name").val(resp.data[0].DoctorName);
                    $("#admit_date_display").val(formatDateEN(resp.data[0].visitDate, 2));
                    if(resp.data[0].dchDate !== ""){
                        $("#dhc_date_display").val(formatDateEN(resp.data[0].dchDate, 2));
                    }else{
                        $("#dhc_date_display").val("");
                    }
                } else {
                    Swal.fire({
                        title: "แจ้งเตือน",
                        text: "ไม่พบข้อมูลรับบริการ กรุณาตรวจสอบข้อมูลให้ถูกต้อง",
                        icon: "error"
                    })
                }
            } else {
                Swal.fire({
                    title: 'แจ้งเตือน',
                    text: resp.msg,
                    icon: resp.type,
                })
                console.log(resp);
            }
        })
        .fail((error) => {
            Swal.fire({
                title: "แจ้งเตือน",
                text: "เกิดข้อผิดพลาด! :  " + JSON.stringify(error),
                icon: "error"
            })
            console.log(error);
        });
}

$('#vstdate').change(function () {
    let optionDate = $(this).val().split(",");
    let vstdate = optionDate[0].trim();
    let section = optionDate[1].trim();
    let hnORan = optionDate[2].trim();
    $("#vst_date").val(vstdate);
    getVstdate(vstdate, section, hnORan)
});