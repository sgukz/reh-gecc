$("#formReport").submit(function (e) {
    $.ajax({
        method: "POST",
        url: "ajax/getReport.php",
        data: $("#formReport").serialize(),
        // dataType: "json",
    })
        .done((response) => {
            // console.log(response);
            $("#showReportPrint").html(response)
        })
        .fail((error) => {
            console.log(error);
        });
    e.preventDefault()
})

