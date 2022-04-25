$.validator.setDefaults({
    submitHandler: function () {
        $.ajax({
            method: "POST",
            url: "ajax/checkLogin.php",
            data: $("#formLogin").serialize(),
            dataType: "json",
        })
            .done((response) => {
                let resp = response
                if (resp.status_code === 200) {
                    window.localStorage.setItem("login", resp.data)
                    let timerInterval
                    Swal.fire({
                        title: resp.msg,
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
                            window.location.reload()
                        }
                    })
                } else {
                    Swal.fire({
                        title: 'แจ้งเตือน',
                        text: resp.msg,
                        icon: resp.type,
                        focusConfirm: true,
                    })
                    // console.log(resp);
                }
            })
            .fail((error) => {
                console.log(error);
            });
    }
});


$("#formLogin").validate({
    rules: {
        user_name: "required",
        pwd: "required",
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

$("#logout").click(function () {
    $.ajax({
        method: "POST",
        url: "ajax/logout.php",
        data: "",
        dataType: "json",
    })
        .done((response) => {
            let resp = response
            if (resp.status_code === 200) {
                window.localStorage.clear();
                window.location.reload()
            } else {
                Swal.fire({
                    title: 'แจ้งเตือน',
                    text: resp.msg,
                    icon: resp.type,
                })
                // console.log(resp);
            }
        })
        .fail((error) => {
            console.log(error);
        });
})