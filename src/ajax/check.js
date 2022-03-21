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

$.validator.setDefaults({
    submitHandler: function () {
        $.ajax({
            method: "POST",
            url: "src/ajax/getRegisterDocumentByTrack.php",
            data: $("#formCheck").serialize(),
            dataType: "json",
        })
            .done((response) => {
                let resp = response
                // console.log(resp);
                if (resp.status_code === 200) {
                    $("#tracking").addClass("hidden");
                    let searchDetail = `<div class="ml-3">
                                            <span>คำที่ค้นหา "${$("#track").val()}" ผลลัพธ์ ${resp.data.length} รายการ</span>
                                        </div>`
                    $("#searchDetail").html(searchDetail)
                    if (resp.data.length > 0) {
                        let table = `<table class="table table-bordered">
                                <thead>
                                    <tr class="bg-info">
                                        <th class="text-center" width="25%">วันที่</th>
                                        <th class="text-center" width="75%">รายละเอียด</th>
                                    </tr>
                                </thead>
                                <tbody>`
                        resp.data.map(val => {
                            table += `<tr>
                                        <td class="text-center"><b>${DateTimeThai(val.created_date, 0)}</b></td>
                                        <td>
                                            <strong><a href="?page=check&track=${val.track_id}">เลขที่คำร้อง ${val.track_id}</a></strong>
                                            <div>
                                                <span><b>ประเภทคำร้อง :</b> ${val.petition_name}</span><br>
                                                <span><b>ผู้ยื่นคำร้อง :</b> ${val.request_name}</span><br>
                                                <span><b>วันที่ยื่นคำร้อง :</b> ${DateTimeThai(val.created_date, 3)}</span><br>
                                                <span><b>สถานะ :</b> ${approveStatus(val.approve_status)}</span><br>
                                                <span>${val.approve_status === "2" ? "<b>วันที่นัดรับเอกสาร :</b>" + DateTimeThai(val.appointment_date, 0) : ""}<span><br>
                                                <a href="?page=check&track=${val.track_id}" class="text-primary font-weight-bold mt-2">ดูรายละเอียดเพิ่มเติม</a>
                                            </div>
                                        </td>
                                    </tr>`
                            return true
                        })
                        table += `</tbody></table>`
                        $("#tableSearch").html(table)
                    } else {
                        let tableSearch = `<div class="text-center text-danger"><span>ไม่พบข้อมูลทะเบียนคำร้อง!</span></div>`
                        $("#tableSearch").html(tableSearch)
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
});

$("#formCheck").validate({
    rules: {
        track: "required",
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
        $(element).addClass("is-valid").removeClass("is-invalid"); 18
    }
});