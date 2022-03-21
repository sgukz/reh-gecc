fetchData();

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
        case "9":
            status = "<span class='badge badge-pill badge-danger text-sm'>กรุณาติดต่อเจ้าหน้าที่</span>"
            break;
        default:
            status = ""
    }
    return status
}

function showDataRegister(event, $modal) {
    let Target = $(event.relatedTarget); // Button that triggered the modal
    let regid = parseInt(Target.data('regid'));
    let trackid = Target.data('trackid');
    let statusdoc = parseInt(Target.data('statusdoc'));
    $(".modal-title").text(`เลขที่คำร้อง ${trackid}`)
    $("#doc_id").val(regid)
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
                                            ${val.dchdate !== "0000-00-00" ? `<div class="d-flex justify-content-between my-3">
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
                    }
                    $("#approve_details").val(val.approve_details);
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

$('#status_id').change(function () {
    if ($(this).val() === "2") {
        $("#section_app_date").removeClass("hidden-el")
    } else {
        $("#section_app_date").addClass("hidden-el")
    }
});

function fetchData() {
    let dataTable = "";
    dataTable = $("#showData").DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "ajax/fetchData.php",
            type: "POST",

        },
        "columnDefs": [{
            className: "dt-body-center",
            "targets": [0, 1, 4, 6, 7]
        },
        {
            "orderable": false,
            "targets": [6, 7]
        },
        ],
        "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "ทั้งหมด"]
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
    if ($('#status_id').val() !== "2") {
        formData = {
            id: $("#doc_id").val(),
            approve_status: $('#status_id').val(),
            approve_datetime: $('#status_id').val() === '1' ? "NOW()" : "",
            approve_details: $('#approve_details').val(),
            appointment_date: '',
            approve_user: $("#approve_user").val(),
            completed_date: ''
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
                completed_date: "NOW()"
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
                            fetchData();
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

$(document).on('click', '.deleteRegister', function () {
    let id = $(this).attr("id")
    Swal.fire({
        title: 'ต้องการลบข้อมูลใช่หรือไม่?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: 'ตกลง',
        cancelButtonText: `ยกเลิก`,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                method: "POST",
                url: "ajax/deleteRegister.php",
                data: {
                    id: id
                },
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
                                fetchData();
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



            // setInterval(() => {
            //     $("#showData").DataTable().destroy();
            //     fetchData();
            // }, 10000)