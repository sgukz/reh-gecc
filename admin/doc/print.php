<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
<link rel="stylesheet" href="../../src/assets/css/mdb.min.css">
<link rel="stylesheet" href="../font/THSarabunNew/fonts/thsarabunnew.css">
<style>
    body {
        /*background: rgb(204,204,204);*/
        background: rgb(255, 255, 255);
    }

    page {
        font-size: 0.9em;
        background: white;
        display: block;
        margin: 0 auto;
        margin-bottom: 0.5cm;
        box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }

    page[size="A4"] {
        width: 21cm;
        height: 29.7cm;
    }

    page[size="A4"][layout="portrait"] {
        width: 29.7cm;
        height: 21cm;
    }

    page[size="A3"] {
        width: 29.7cm;
        height: 42cm;
    }

    page[size="A3"][layout="portrait"] {
        width: 42cm;
        height: 29.7cm;
    }

    page[size="A5"] {
        width: 14.8cm;
        height: 21cm;
    }

    page[size="A5"][layout="portrait"] {
        width: 21cm;
        height: 14.8cm;
    }

    @media print {

        body,
        page[size="A4"] {
            margin: 0;
            box-shadow: 0;
            page-break-after: always;
            page-break-before: always;
        }
    }

    div.banner {
        margin: 0;
        font-weight: bold;
        line-height: 1.1;
        text-align: center;
        position: fixed;
        top: 2em;
        left: auto;
        width: 10cm;
        right: 0cm;
    }

    div.banner p {
        margin: 0;
        padding: 0.3em 0.4em;
        background: #900;
        border: thin outset #900;
        color: white;
    }

    .hidden-select {
        display: none;
    }
</style>
<div class="row thsarabunnew">
    <div class="col-md-12 text-right banner" style="margin-top: 0.2cm;margin-bottom: 0.2cm;">
        <button type="button" class="btn btn-primary" onclick="printDiv('printableArea')">
            <span class="font-weight-bold"><i class="fas fa-print"></i> Print</span>
        </button>
        <button type="button" class="btn btn-danger" onClick="window.close();">
            <span class="font-weight-bold"><i class="far fa-window-close"></i> ปิดหน้าต่าง</span>

        </button>
        <br>
    </div>
</div>
<div id="printableArea">
    <page size="A4" class="thsarabunnew" style="font-size: 11.5pt;">
        <div class="row">
            <div style="width: 18cm; margin: 0 auto; margin-top: 1cm; margin-left:2.5cm;">
                <div class="row" style="margin-left: 0.01cm;">
                    <div style="width: 5.0cm; font-weight: strong; font-size: 1em;">
                        <span style="margin-top: 2cm; display: inline-block;margin-top:2.5cm;">ที่ รอ ๐๐๓๒.๓๐๖/</span>
                    </div>
                    <div style="width: 7.0cm; font-weight: strong; font-size: 1em;" class="text-center">
                        <img src="../images/crout.png" alt="" style="width:3cm;height:3cm;">
                    </div>
                    <div style="width: 5.0cm; margin-left:1cm; font-weight: strong; font-size: 1em;" class="text-left">
                        <span style="margin-top: 1.8cm; display: inline-block;margin-top:2.5cm;"> </span>
                    </div>
                    <div style="width: 12.5cm; margin-top: 0.5cm;" class="text-right">
                        <span> </span>
                    </div>
                </div>
                <div class="row" style="margin-left: 0.01cm;">
                    <div style="width: 1.5cm; margin-top: 1cm;" class="text-left">
                        <span style="width: 2cm;">เรื่อง</span>
                    </div>
                    <div style="width: 15cm; margin-top: 1cm;" class="text-left">
                        <span style="width: 13.5cm;">ส่งแบบคำขอรับค่าบริการทางการแพทย์ของผู้ป่วยประกันสังคม</span>
                    </div>
                </div>

                <div class="row" style="margin-left: 0.01cm; margin-top: 0.25cm;">
                    <div style="width: 1.5cm;cursor:pointer;" class="text-left">
                        <span style="width: 2cm;">เรียน</span>
                    </div>
                    <div style="width: 15cm;cursor:pointer;" class="text-left">
                        <span style="width: 15.5cm;">
                            <span id="name">คลิกเพื่อกรอกข้อมูลสถานพยาบาลที่ต้องการ</span>
                        </span>
                    </div>
                </div>

                <div class="row" style="margin-left: 0.01cm; margin-top: 0.25cm;">
                    <div style="width:2.5cm;" class="text-left">
                        <span style="width: 2cm;">สิ่งที่ส่งมาด้วย</span>
                    </div>
                    <div style="width: 10cm;" class="text-left">
                        <span style="width:10cm;">๑.แบบคำขอรับค่าบริการทางการแพทย์ฯ</span>
                    </div>
                    <div style="width: 3cm;" class="text-left">
                        <span style="width: 3cm;">จำนวน ๑ ฉบับ</span>
                    </div>
                </div>
                <div class="row" style="margin-left: 0.01cm; margin-top: 0.25cm;">
                    <div style="width:2.5cm;" class="text-left">
                        <span style="width: 2cm;"></span>
                    </div>
                    <div style="width: 10cm;" class="text-left">
                        <span style="width:10cm;">๒.สรุปค่ารักษาพยาบาล</span>
                    </div>
                    <div style="width: 3cm;" class="text-left">
                        <span style="width: 3cm;">จำนวน ๑ ฉบับ</span>
                    </div>
                </div>
                <div class="row" style="margin-left: 0.01cm; margin-top: 0.25cm;">
                    <div style="width:2.5cm;" class="text-left">
                        <span style="width: 2cm;"></span>
                    </div>
                    <div style="width: 10cm;" class="text-left">
                        <span style="width:10cm;">๓.ใบรับรองแพทย์</span>
                    </div>
                    <div style="width: 3cm;" class="text-left">
                        <span style="width: 3cm;">จำนวน ๑ ฉบับ</span>
                    </div>
                </div>
                <div class="row" style="margin-left: 0.01cm; margin-top: 0.25cm;">
                    <div style="width:2.5cm;" class="text-left">
                        <span style="width: 2cm;"></span>
                    </div>
                    <div style="width: 10cm;" class="text-left">
                        <span style="width:10cm;">๔.แฟ้มประวัติการรักษาผู้ป่วย</span>
                    </div>
                    <div style="width: 3cm;" class="text-left">
                        <span style="width: 3cm;">จำนวน ๑ ฉบับ</span>
                    </div>
                </div>

                <div class="row" style="margin-left: 0.01cm; margin-top: 0.5cm;">
                    <div style="width: 18cm;" class="text-justify">
                        <span style="width: 17cm;display:inline-block;">
                            <span style="display:inline-block;margin-left:2cm;"></span>
                            ด้วย ขอส่งแบบคำขอรับค่าบริการทางการแพทย์ของผู้ป่วยประกันสังคม ดังรายละเอียดแนบมาพร้อมหนังสือนี้
                        </span>
                    </div>
                </div>

                <div class="row" style="margin-left: 0.01cm; margin-top: 0.5cm;">
                    <div style="width: 18cm;" class="text-justify">
                        <span style="width: 18cm;display:inline-block;">
                            <span style="display:inline-block;margin-left:2.5cm;"></span>
                            จึงเรียนมาเพื่อโปรดทราบ และดำเนินการต่อไป
                        </span>
                    </div>
                </div>
                <div class="row" style="margin-top: 2cm;">
                    <span style="width: 18cm;" class="text-center">ขอแสดงความนับถือ</span>
                </div>
                <div class="row" style="margin-top: 1.5cm;">
                    <span style="width: 18cm;" class="text-center"></span>
                </div>

                <div class="row" style="margin-top: 5px;">
                    <span style="width: 18cm;display: inline-block;" class="text-center">

                    </span>
                </div>
                <div class="row" style="margin-top: 5px;margin-bottom: 0px;">
                    <span style="width: 18cm;" class="text-center">
                    </span>
                </div>

                <div class="row" style="margin-left: 0.01cm;margin-top: 1.5cm;margin-bottom: 0px;">
                    <span style="width: 4cm;">
                        สำนักงานประกันสุขภาพ โทร ๐๔๓-๕๑๘๒๐๐ <br> ต่อ ๒๐๒๔
                    </span>
                </div>

            </div>
        </div>
    </page>
</div>

<script>
    function printDiv(divName) {
        // var print = divName.substring(0, 13);
        // var vn = divName.substring(13, 25);
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>