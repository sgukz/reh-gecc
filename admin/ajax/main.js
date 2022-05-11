let date_now = getDateNow()
// fetchData(date_now);
let showAll = window.localStorage.getItem("showAll")
if (showAll) {
    if (showAll === "all") {
        $("#showDataAll").addClass("btn-danger").removeClass("btn-info")
        $("#labelShowAll").text("ยกเลิกแสดงทั้งหมด")
        fetchData("all");
    } else {
        $("#showDataAll").addClass("btn-info").removeClass("btn-danger")
        $("#labelShowAll").text("แสดงทั้งหมด")
        fetchData(date_now);
    }
} else {
    $("#showDataAll").addClass("btn-info").removeClass("btn-danger")
    $("#labelShowAll").text("แสดงทั้งหมด")
    fetchData(date_now);
}
function approveStatus(st) {
    let status;
    switch (st) {
        case "0":
            status = "<span class='badge badge-pill badge-warning text-sm'>รอดำเนินการ</span>"
            break;
        case "1":
            status = "<span class='badge badge-pill badge-info text-sm'>เจ้าหน้าที่รับเรื่องแล้ว</span>"
            break;
        case "2":
            status = "<span class='badge badge-pill badge-success text-sm'>เตรียมเอกสารเรียบร้อย</span>"
            break;
        case "3":
            status = "<span class='badge badge-pill badge-success text-sm'>ดำเนินการเรียบร้อย</span>"
            break;
        case "9":
            status = "<span class='badge badge-pill badge-danger text-sm'>กรุณาติดต่อเจ้าหน้าที่</span>"
            break;
        default:
            status = ""
    }
    return status
}

$("#searchSelectDate").click(function () {
    let selectDate = $("#selectDate").val()
    if (selectDate !== "") {
        let arrayDate = selectDate.split("/")
        let strDate = `${arrayDate[2]}-${arrayDate[1]}-${arrayDate[0]}`
        $("#showData").DataTable().destroy();
        fetchData(strDate);
    } else {
        $("#showData").DataTable().destroy();
        fetchData(date_now);
    }
})

$("#showDataAll").click(function () {
    let showAll = window.localStorage.getItem("showAll")
    if (showAll) {
        if (showAll === "all") {
            window.localStorage.setItem("showAll", "")
            $("#showDataAll").addClass("btn-info").removeClass("btn-danger")
            $("#labelShowAll").text("แสดงทั้งหมด")
            $("#showData").DataTable().destroy();
            fetchData(date_now);
        } else {
            window.localStorage.setItem("showAll", "all")
            $("#showDataAll").addClass("btn-danger").removeClass("btn-info")
            $("#labelShowAll").text("ยกเลิกแสดงทั้งหมด")
            $("#showData").DataTable().destroy();
            fetchData("all");
        }
    } else {
        window.localStorage.setItem("showAll", "all")
        $("#showDataAll").addClass("btn-danger").removeClass("btn-info")
        $("#labelShowAll").text("ยกเลิกแสดงทั้งหมด")
        $("#showData").DataTable().destroy();
        fetchData("all");
    }
})

function showDataRegister(event, $modal) {
    let Target = $(event.relatedTarget); // Button that triggered the modal
    let regid = parseInt(Target.data('regid'));
    let trackid = Target.data('trackid');
    let statusdoc = parseInt(Target.data('statusdoc'));
    showListFIle(regid)
    $(".modal-title").text(`เลขที่คำร้อง ${trackid}`)
    $("#doc_id").val(regid)
    $("#uploadId").val(regid)
    $('#status_id').val(statusdoc).change();
    $.ajax({
        method: "POST",
        url: "ajax/getRegisterDocumentByTrack.php",
        data: {
            track: trackid
        },
        dataType: "json",
    })
        .done((response) => {
            let resp = response
            if (resp.status_code === 200) {
                let table = ''
                resp.data.map(val => {
                    table = `<div class="border">
                                <h6 class="font-weight-bold text-info px-2 pt-3">ข้อมูลผู้ยื่นคำร้อง</h6>
                                <hr>
                                <div class="d-flex justify-content-between my-2">
                                    <span class="pl-2">วันที่ยื่นคำร้อง</span>
                                    <span class="pr-4 font-weight-bold">${DateTimeThai(val.created_date, 2)}</span>
                                </div>
                                <div class="d-flex justify-content-between my-3">
                                    <span class="pl-2">ประเภทคำร้อง</span>
                                    <span class="pr-4 font-weight-bold">${val.petition_name}</span>
                                </div>
                                <div class="d-flex justify-content-between my-3">
                                    <span class="pl-2">ชื่อ-สกุล(ผู้ยื่นคำร้อง)</span>
                                    <span class="pr-4 font-weight-bold">${val.request_name}</span>
                                </div>
                                <div class="d-flex justify-content-between my-3">
                                    <span class="pl-2">เลขบัตรประชาชน(ผู้ยื่นคำร้อง)</span>
                                    <span class="pr-4 font-weight-bold">${val.request_cid}</span>
                                </div>
                                <div class="d-flex justify-content-between my-3">
                                    <span class="pl-2">เกี่ยวข้องเป็น</span>
                                    <span class="pr-4 font-weight-bold">${val.about_name}</span>
                                </div>
                                <div class="d-flex justify-content-between my-3">
                                    <span class="pl-2">เบอร์โทร(ผู้ยื่นคำร้อง)</span>
                                    <span class="pr-4 font-weight-bold">${val.request_phone}</span>
                                </div>
                                <div class="d-flex justify-content-between my-3">
                                    <span class="pl-2">ที่อยู่ (ผู้ยื่นคำร้อง)</span>
                                    <span class="pr-4 font-weight-bold">${val.request_address}</span>
                                </div>
                                <div class="d-flex justify-content-between my-3">
                                    <span class="pl-2">เหตุผลการนำไปใช้ประโยชน์</span>
                                    <span class="pr-4 font-weight-bold">${val.request_details}</span>
                                </div>
                                <hr>
                                <h6 class="font-weight-bold text-info px-2 pb-2">ข้อมูลผู้ป่วย</h6>
                                <hr>
                                <div class="d-flex justify-content-between my-3">
                                    <span class="pl-2">HN</span>
                                    <span class="pr-4 font-weight-bold">${val.hn}</span>
                                </div>
                                <div class="d-flex justify-content-between my-3">
                                    <span class="pl-2">เลขบัตรประชาชน</span>
                                    <span class="pr-4 font-weight-bold">${val.patient_cid}</span>
                                </div>
                                <div class="d-flex justify-content-between my-3">
                                    <span class="pl-2">ชื่อ-สกุล</span>
                                    <span class="pr-4 font-weight-bold">${val.patient_name}</span>
                                </div>
                                <div class="d-flex justify-content-between my-3">
                                    <span class="pl-2">วันที่มารับบริการ</span>
                                    <span class="pr-4 font-weight-bold">${DateTimeThai(val.regdate, "")}</span>
                                </div>
                                ${val.dchdate !== null ? `<div class="d-flex justify-content-between my-3">
                                    <span class="pl-2">วันที่จำหน่าย</span>
                                    <span class="pr-4 font-weight-bold">${DateTimeThai(val.dchdate, "")}</span>
                                </div>` : ``}
                                
                                <div class="d-flex justify-content-between my-3">
                                    <span class="pl-2">ห้องตรวจ / หอผู้ป่วย</span>
                                    <span class="pr-4 font-weight-bold">${val.dep_name}</span>
                                </div>
                                <div class="d-flex justify-content-between my-3">
                                    <span class="pl-2">แพทย์ผู้รักษา</span>
                                    <span class="pr-4 font-weight-bold">${val.doctor_name}</span>
                                </div>
                                <div class="d-flex justify-content-between my-3">
                                    <span class="pl-2">สถานะ</span>
                                    <span class="pr-4 font-weight-bold">${approveStatus(val.approve_status)}</span>
                                </div>
                                ${val.appointment_date !== null ? `<div class="d-flex justify-content-between my-3">
                                    <span class="pl-2">วันที่นัดรับเอกสาร</span>
                                    <span class="pr-4 font-weight-bold">${DateTimeThai(val.appointment_date, 4)}</span>
                                </div>` : ``}
                                ${val.approve_user !== null ? `<div class="d-flex justify-content-between my-3">
                                    <span class="pl-2">ผู้รับเรื่อง</span>
                                    <span class="pr-4 font-weight-bold">${val.fullname}</span>
                                </div>` : ``}  
                            </div>`
                    if (val.appointment_date !== null) {
                        $("#appointment_date").val(val.appointment_date);
                        $("#receive_name").val(val.receive_name);
                        $("#printAppointment").html(`<button type="button" class="btn blue-gradient btn-sm printAppointment" id="${val.track_id}">
                                                        <i class="fas fa-print fa-lg"></i> พิมพ์บัตรนัด
                                                    </button>`)
                    }
                    $("#approve_details").val(val.approve_details);
                    $("#upload_id").val(val.approve_details);
                    $("#printDocument").html(`<button type="button" class="btn blue-gradient btn-sm printDocument" id="${val.track_id}">
                                                    <i class="fas fa-print fa-lg"></i> พิมพ์คำร้อง
                                                </button>`)
                    return true
                })
                $("#showTableDataRegister").html(table)
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
            console.log(error);
        });

}

$("#showDataRegister").on('show.bs.modal', function (event) {
    showDataRegister(event, $(this));
});

$('#showDataRegister').on('hidden.bs.modal', function (e) {
    // $("#showData").DataTable().destroy();
    // let showAll = window.localStorage.getItem("showAll")
    // if (showAll) {
    //     if (showAll === "all") {
    //         $("#showDataAll").addClass("btn-danger").removeClass("btn-info")
    //         $("#labelShowAll").text("ยกเลิกแสดงทั้งหมด")
    //         fetchData("all");
    //     } else {
    //         $("#showDataAll").addClass("btn-info").removeClass("btn-danger")
    //         $("#labelShowAll").text("แสดงทั้งหมด")
    //         fetchData(date_now);
    //     }
    // } else {
    //     $("#showDataAll").addClass("btn-info").removeClass("btn-danger")
    //     $("#labelShowAll").text("แสดงทั้งหมด")
    //     fetchData(date_now);
    // }
    $("#appointment_date").val("");
    $("#receive_name").val("");
    $("#approve_details").val("");
})

$('#status_id').change(function () {
    if ($(this).val() === "2" || $(this).val() === "3") {
        $("#section_app_date").removeClass("hidden-el")
        $("#section_receive_name").removeClass("hidden-el")
    } else {
        $("#section_receive_name").addClass("hidden-el")
        $("#section_app_date").addClass("hidden-el")
    }
});

function fetchData(dateNow) {
    let dataTable = $("#showData").DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "ajax/fetchData.php",
            type: "POST",
            data: {
                "date_select": dateNow
            },
            // success: function (data, textStatus, jqXHR) {
            //     console.log(data); //*** returns correct json data
            // }
        },
        "columnDefs": [{
            className: "dt-body-center",
            "targets": [0, 1, 4, 6, 7, 8]
        },
        {
            "orderable": false,
            "targets": [0, 6, 7, 8]
        },
        ],
        "lengthMenu": [
            [50, 100, -1],
            [50, 100, "ทั้งหมด"]
        ],
        "oLanguage": {
            "sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
            "sZeroRecords": "ไม่มีข้อมูล",
            "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ เร็คคอร์ด",
            "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
            "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
            "sSearch": "ค้นหา :",
            "oPaginate": {
                "sFirst": "หน้าแรก",
                "sLast": "หน้าสุดท้าย",
                "sNext": "ถัดไป",
                "sPrevious": "ย้อนกลับ",
            }
        },
    });
}

$("#changeStatus").submit(function (e) {
    let formData = {}
    let validate = false
    if ($('#status_id').val() !== "2" && $('#status_id').val() !== "3") {
        formData = {
            id: $("#doc_id").val(),
            approve_status: $('#status_id').val(),
            approve_datetime: $('#status_id').val() === '1' ? "NOW()" : "null",
            approve_details: $('#approve_details').val(),
            appointment_date: 'null',
            receive_name: 'null',
            approve_user: $("#approve_user").val(),
            completed_date: 'null'
        }
        validate = true
    } else {
        if ($("#appointment_date").val() !== "") {
            $("#appointment_date").addClass("is-valid").removeClass("is-invalid");
            formData = {
                id: $("#doc_id").val(),
                approve_status: $('#status_id').val(),
                approve_user: $("#approve_user").val(),
                approve_details: $('#approve_details').val(),
                appointment_date: $("#appointment_date").val(),
                receive_name: $("#receive_name").val(),
                completed_date: $('#status_id').val() === "3" ? "NOW()" : "null"
            }
            validate = true
        } else {
            $("#appointment_date").addClass("is-invalid").removeClass("is-valid");
            validate = false
        }
    }

    if (validate) {
        $.ajax({
            method: "POST",
            url: "ajax/changeStatus.php",
            data: formData,
            dataType: "json",
        })
            .done((response) => {
                let resp = response
                if (resp.status_code === 200) {
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
                            $("#showDataRegister").modal('hide');
                            $("#showData").DataTable().destroy();
                            fetchData(date_now);
                        }
                    })
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
                console.log(error);
            });
    }

    e.preventDefault()
})

$(document).on('click', '.printDocument', function () {
    let trackid = $(this).attr("id")
    popWin(b64EncodeUnicode(trackid))
})

$(document).on('click', '.printAppointment', function () {
    let trackid = $(this).attr("id")
    popWinPrintAppointment(b64EncodeUnicode(trackid))
})

function popWin(id) {
    mypopup = window.open(
        'prints/page/view-report.php?id=' + id,
        // 'prints/pdf/printDocument.php?id=' + id,
        'mypopup',
        'nenuber=no,toorlbar=no,location=no,scrollbars=no, status=no,resizable=no,width=1200,height=700,top=50,left=200 '
    );
    mypopup.focus();
};

function popWinPrintAppointment(id) {
    mypopup = window.open(
        'prints/pdf/printAppointment.php?id=' + id,
        'mypopup',
        'nenuber=no,toorlbar=no,location=no,scrollbars=no, status=no,resizable=no,width=1200,height=700,top=50,left=200 '
    );
    mypopup.focus();
};

function b64EncodeUnicode(str) {
    return btoa(encodeURIComponent(str));
};

$(document).on('click', '.deleteRegister', function () {
    let id = $(this).attr("id")
    let trackid = $(this).attr("name")
    Swal.fire({
        title: 'ต้องการลบข้อมูลใช่หรือไม่?',
        text: `เลขที่คำร้อง ${trackid}`,
        icon: "question",
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonColor: '#00C851',
        cancelButtonColor: '#ff4444',
        confirmButtonText: 'ตกลง',
        cancelButtonText: `ยกเลิก`,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                method: "POST",
                url: "ajax/deleteRegister.php",
                dataType: "json",
            })
                .done((response) => {
                    let resp = response
                    if (resp.status_code === 200) {
                        let timerInterval
                        Swal.fire({
                            title: 'ลบข้อมูลเรียบร้อย',
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
                            if (result.dismiss === Swal.DismissReason.timer) {
                                $("#showData").DataTable().destroy();
                                fetchData(date_now);
                            }
                        })
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
                    console.log(error);
                });
        }
    })
})

const file = document.querySelector('#fileToUpload');
file.addEventListener('change', (e) => {
    $("#show-image").removeClass("section-info");
    $("#submitUpload").removeClass("hidden-el");
    // Get the selected file
    const [file] = e.target.files;
    if (Object.keys(e.target.files).length > 1) {
        $(".file-name").text("เอกสารที่เลือกทั้งหมด " + Object.keys(e.target.files).length + " ไฟล์");
        img_atk_confirm.src = ""
    } else {
        const {
            name: fileName,
            size
        } = file;
        // Convert size in bytes to kilo bytes
        const fileSize = (size / 1000).toFixed(2);
        // Set the text content
        const fileNameAndSize = `${fileName} - ${fileSize}KB`;
        document.querySelector('.file-name').textContent = fileNameAndSize;
        img_atk_confirm.src = URL.createObjectURL(e.target.files[0]);
    }
    // Get the file name and size
});

$("#formUploadEvidence").submit(function (e) {
    $.ajax({
        xhr: function () {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function (evt) {
                $("#showPercent").removeClass("hidden-el");
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                    $('.progress-bar').width(percentComplete + '%');
                    $('.progress-bar').html(percentComplete + '%');
                    if (percentComplete < 100) {
                        $('.percent').html('กำลังอัพโหลด... ' + percentComplete + '%');
                    } else {
                        $('.percent').html('อัพโหลดสำเร็จ ' + percentComplete + '%');
                    }
                }
            }, false);
            return xhr;
        },
        method: "POST",
        url: "ajax/uploadFiles.php",
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
    })
        .done((response) => {
            let resp = response
            if (resp.status_code === 200) {
                setTimeout(() => {
                    $("#showPercent").addClass("hidden-el");
                    $("#show-image").addClass("hidden-el");
                    $("#submitUpload").addClass("hidden-el");
                    showListFIle(resp.doc_id)
                }, 1500)
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
            console.log(error);
        });
    e.preventDefault()
});

function showListFIle(id) {
    let base_url = "ajax/getDocumentById.php";
    $.ajax({
        method: "POST",
        url: base_url,
        dataType: "json",
        data: {
            doc_id: id,
        },
    })
        .done((response) => {
            let resp = response;
            if (resp.status_code === 200) {
                if (resp.data.length > 0) {
                    $("#section-file").removeClass("hidden-el")
                    let html = `<div class="row"><div class="col-lg-12"><table class='table' width='400' border='0'>
                                <thead class='thead-dark'>
                                <tr>
                                    <th style='padding: 5px;'>ไฟล์</th>
                                    </tr>
                                    </thead><tbody>`
                    resp.data.map(val => {
                        html += `<tr>`
                        html += `<td style='padding: 5px;'>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4">
                                            <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title=""
                                                data-image="files/images/${val.file_name}" data-target="#image-gallery">
                                                 <img class="img-thumbnail" src="files/images/${val.file_name}" width="150">
                                            </a>
                                            <button type="button" class="btn btn-danger px-3" title='ลบ' onclick='deleteFile(${val.files_id})'>
                                                <i class="fas fa-trash" aria-hidden="true"></i>
                                            </button>
                                            </div>
                                        </div>
                                </td>`
                        html += `</tr>`
                    })
                    html += "</tboby></table></div></div>"
                    $("#attachment").html(html)
                } else {
                    $("#section-file").addClass("hidden-el")
                    $("#attachment").html('')
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
            console.log(error);
        });
}

function deleteFile(fileId) {
    $.ajax({
        method: "POST",
        url: "ajax/deleteFile.php",
        dataType: "json",
        data: {
            file_id: fileId,
        },
    })
        .done((response) => {
            let resp = response
            if (resp.status_code === 200) {
                showListFIle(resp.doc_id)
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
            console.log(error);
        });
}

function getDateNow() {
    const toTwoDigits = (num) => (num < 10 ? "0" + num : num);
    let today = new Date();
    let year = today.getFullYear();
    let month = toTwoDigits(today.getMonth() + 1);
    let day = toTwoDigits(today.getDate());
    let date_now = `${year}-${month}-${day}`;
    return date_now
}


$('#reportDateSelect').change(function () {
    let dateNow = new Date();
    let year = dateNow.getFullYear();
    let fullMonth = `${year}-${$(this).val()}-01`
    window.location = 'index.php?page=report-proccess&reportDateSelect=' + fullMonth;
    // Window.location = "index.php?page=report-proccess&reportDateSelect=" + fullMonth
});

// setInterval(() => {
//     let showAll = window.localStorage.getItem("showAll")
//     $("#showData").DataTable().destroy();
//     if (showAll) {
//         if (showAll === "all") {
//             $("#showDataAll").addClass("btn-danger").removeClass("btn-info")
//             $("#labelShowAll").text("ยกเลิกแสดงทั้งหมด")
//             fetchData("all");
//         } else {
//             $("#showDataAll").addClass("btn-info").removeClass("btn-danger")
//             $("#labelShowAll").text("แสดงทั้งหมด")
//             fetchData(date_now);
//         }
//     } else {
//         $("#showDataAll").addClass("btn-info").removeClass("btn-danger")
//         $("#labelShowAll").text("แสดงทั้งหมด")
//         fetchData(date_now);
//     }
// }, 10000)