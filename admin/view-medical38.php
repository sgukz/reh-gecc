<?php
@session_start();
if (isset($_SESSION['session_id']) == '') {
    header("location:../login");
    exit(0);
}
?>
<?php include_once('../config/connect_hos.php'); ?>
<?php include_once('../config/connect.php'); ?>
<?php include_once('../config/setting_hosname.php'); ?>
<?php include_once('../config/function_thdate.php'); ?>
<?php include_once('../config/function_thaibath.php'); ?>
<?php include_once('../header.php'); ?>
<?php include_once('../script/css/css.php'); ?>
<title>
    <?= $title1 . ' ' . $hos_name; ?>
</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<link href="../font/THSarabunNew/fonts/thsarabunnew.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../fontawesome-free-5.0.7/web-fonts-with-css/css/fontawesome-all.min.css">
<link rel="shortcut icon" href="../image/jatuhos.png">

<style>
    body {
        background: rgb(204, 204, 204);
    }

    page {
        font-size: 0.9em;
        background: white;
        display: block;
        margin: 0 auto;
        margin-bottom: 0.5cm;
        box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
        font-fa
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
    .hidden-select{
        display: none;
    }
</style>
<div class="row thsarabunnew">
    <div class="col-md-12 text-right banner" style="margin-top: 0.2cm;margin-bottom: 0.2cm;">
        <input type="button" class="btn btn-primary" onclick="printDiv('printableArea<?php echo base64_decode($_GET['VN']); ?>')" value="Print" style="cursor: pointer;" />
        <a href="#" class="btn btn-danger" onClick="window.close();" style="cursor: pointer;">ปิดหน้าต่าง</a>
        <BR>
    </div>
</div>
<?php
try {
    $stmt = $hos_conn->prepare("SELECT vn.vn, vn.hn,vn.vstdate ,concat(p.pname,p.fname,' ',p.lname) as fullname,p.cid,pt.name AS 'pttype',
                                    hs.name AS 'hosname',SUM(vn.income) AS 'income',p.pname,concat(p.fname,' ',p.lname) as fname,
                                    dc.name AS 'doctor_name',dc.licenseno,
                                    dc.licenseno,r.referout_id,r.refer_date,r.refer_number,r.refer_hospcode,hs2.name AS 'hosname_refer'
                                    FROM vn_stat vn
                                    LEFT OUTER JOIN patient p ON p.hn=vn.hn
                                    LEFT OUTER JOIN pttype pt ON pt.pttype=vn.pttype
                                    LEFT OUTER JOIN doctor dc ON dc.code=vn.dx_doctor
                                    LEFT OUTER JOIN referout r on r.vn=vn.vn
                                    LEFT OUTER JOIN hospcode hs ON hs.hospcode=vn.hospmain
                                    LEFT OUTER JOIN hospcode hs2 ON hs2.hospcode=r.refer_hospcode
                                    WHERE vn.vn=:vn"); //vn.pttype IN ('35','34','38')
    $stmt->bindParam(':vn', base64_decode($_GET['VN']), PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount()) {
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        /*if($rows['refer_hospcode']){
                            $refer='700';
                        }else{
                            $refer='0';
                        }*/
    }
} catch (PDOException $e) {
    return $e;
}

/*##################### ที่อยู่ โรงพยาบาล ########################*/

try {
    $stmt_hospital = $db_conn->prepare("SELECT * FROM setting_hospital WHERE status = 'Y'");
    $stmt_hospital->execute();
    $rows_hospital = $stmt_hospital->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    return $e->getMessage();
}
?>

<div id="printableArea" class="pt-5">
    <page size="A4" class="thsarabunnew" style="font-size: 11.5pt;">
        <div class="row">
            <div style="width: 18cm; margin: 0 auto; margin-top: 1cm; margin-left:2.5cm;">
                <div class="row" style="margin-left: 0.01cm;">
                    <div style="width: 5.0cm; font-weight: strong; font-size: 1em;">
                        <span style="margin-top: 2cm; display: inline-block;margin-top:2.5cm;">ที่ รอ ๐๐๓๒.๓๐๖/</span>
                    </div>
                    <div style="width: 7.0cm; font-weight: strong; font-size: 1em;" class="text-center">
                        <img src="../image/crout.png" alt="" style="width:3cm;height:3cm;">
                    </div>
                    <div style="width: 5.0cm; margin-left:1cm; font-weight: strong; font-size: 1em;" class="text-left">
                        <span style="margin-top: 1.8cm; display: inline-block;margin-top:2.5cm;"> <?= $rows_hospital['hosname']; ?> อ.<?= $rows_hospital['hosamphur']; ?> จ.<?= $rows_hospital['hosprovince']; ?> <?= thainumDigit($rows_hospital['hospostcode']); ?></span>
                    </div>
                    <div style="width: 12.5cm; margin-top: 0.5cm;" class="text-right">
                        <span> <?= thainumDigit(thdate(date('Y-m'), 'lm')) ?> </span>
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
                    <div style="width: 1.5cm;cursor:pointer;" class="text-left" onclick="return click_name()" title="คลิกเพื่อกรอกข้อมูลสถานพยาบาลที่ต้องการ">
                        <span style="width: 2cm;">เรียน</span>
                    </div>
                    <div style="width: 15cm;cursor:pointer;" class="text-left" onclick="return click_name()" title="คลิกเพื่อกรอกข้อมูลสถานพยาบาลที่ต้องการ">
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
                            ด้วย<?= $rows_hospital['hosname']; ?> ขอส่งแบบคำขอรับค่าบริการทางการแพทย์ของผู้ป่วยประกันสังคม <?= $rows['fullname']; ?> ดังรายละเอียดแนบมาพร้อมหนังสือนี้
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

                <?php
                try {
                    $stmt_director = $db_conn->prepare("SELECT CONCAT(director_pname,director_fname,' ',director_lname) AS director_name,director_hospital 
                                                                FROM director 
                                                                WHERE director_status='Y' 
                                                                LIMIT 1");
                    $stmt_director->execute();
                    $rows_director = $stmt_director->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                ?>


                <div class="row" style="margin-top: 2cm;">
                    <span style="width: 18cm;" class="text-center">ขอแสดงความนับถือ</span>
                </div>
                <div class="row" style="margin-top: 1.5cm;">
                    <span style="width: 18cm;" class="text-center"></span>
                </div>

                <div class="row" style="margin-top: 5px;">

                    <span style="width: 18cm;display: inline-block;" class="text-center">
                        (<?= $rows_director['director_name']; ?>)
                    </span>
                </div>
                <div class="row" style="margin-top: 5px;margin-bottom: 0px;">

                    <span style="width: 18cm;" class="text-center"><?= $rows_director['director_hospital']; ?></span>
                </div>

                <div class="row" style="margin-left: 0.01cm;margin-top: 1.5cm;margin-bottom: 0px;">
                    <span style="width: 4cm;">
                        สำนักงานประกันสุขภาพ โทร ๐๔๓-๕๑๘๒๐๐ <br> ต่อ ๒๐๒๔
                    </span>
                </div>

            </div>
        </div>
    </page>
    <page size="A4" class="thsarabunnew">

        <BR>
        <div class="row">
            <div class="col-md-12 text-right">
                <span style="margin-right: 15px; font-weight: bold;"> สปส. 2-19 </span>
            </div>
        </div>




        <div class="border border-dark border-bottom-0" style="width: 20.5cm; margin: 0 auto; margin-top: 0.1cm;">
            <div class="row" style="margin-left: 0.01cm; height: 2.7cm;">
                <div class="border border-dark border-left-0 border-right-0 border-top-0" style="width: 2.5cm;">
                    <span style="margin-left: 0.1cm;"> <img src="../image/1.png" width="90" height="90" alt=""> </span>
                </div>

                <div class="border border-dark border-left-0  border-top-0" style="width: 11.5cm; font-weight: bold;">
                    <p></p>
                    <p class="text-center"> แบบคำขอรับค่าบริการทางการแพทย์ของผู้ป่วยประกันตนที่ทุพพลภาพ </p>
                    <p class="text-center" style="margin-top: -0.2cm;"> กองทุนประกันสังคม </p>
                    <p class="text-center" style="margin-top: -0.2cm;"> (สำหรับสถานพยาบาล) </p>
                </div>
                <div class="border border-dark border-left-0 border-right-0 border-top-0" style="width: 6.5cm;">
                    <p style="margin-top: 5px;margin-left: 0.1cm;"><u>สำหรับเจ้าหน้าที่</u></p>
                    <p style="margin-top: -15px;margin-left: 0.1cm;">เลขที่รับ<span style="border-bottom: black 1px dotted; width: 5cm;display: inline-block;"></span></p>
                    <p style="margin-top: -13px;margin-left: 0.1cm;">วันที่รับ<span style="border-bottom: black 1px dotted; width: 5.1cm;display: inline-block;"></span></p>
                    <p style="margin-top: -13px;margin-left: 0.1cm;">ผู้รับ<span style="border-bottom: black 1px dotted; width: 5.6cm;display: inline-block;"></span></p>
                </div>
            </div>
            <div class="row" style="margin-left: 0.1cm;margin-top:0.2cm;">
                <span style="width: 2.5cm;margin-top: 5px;">1.โรงพยาบาล</span>
                <span style="margin-top: 5px;margin-left:-0.3cm; border-bottom: black 1px dotted;width: 10.5cm; font-weight: bold;display: inline-block;">
                    &nbsp;&nbsp;&nbsp;<?= $rows_hospital['shotname']; ?>
                </span>
                <span style="width: 8cm;margin-top: 5px;">ขอรับค่ารักษาพยาบาลของผู้ป่วยประกันสังคม</span>
            </div>
            <div class="row" style="margin-left: 0.5cm;">
                <span style="width: 2.5cm;margin-top: 5px;">ชื่อ</span>
                <span style="margin-top: 5px;margin-left:-2cm; border-bottom: black 1px dotted;width: 7cm; font-weight: bold;display: inline-block;">
                    &nbsp;&nbsp;&nbsp;<?php echo $rows['fullname'] ?>
                </span>
                <span style="width: 4cm;margin-top: 5px;">เลขประจำตัวประชาชน : </span>
                <div>
                    <input type="text" class="text-center" value="<?php echo substr($rows['cid'], 0, 1); ?>" style="width: 0.4cm; height: 0.5cm; font-size: 14px;margin-top: 5px;"> -
                    <input type="text" class="text-center" value="<?php echo substr($rows['cid'], 1, 1); ?>" style="width: 0.4cm; height: 0.5cm; font-size: 14px;margin-top: 5px;">
                    <input type="text" class="text-center" value="<?php echo substr($rows['cid'], 2, 1); ?>" style="width: 0.4cm; height: 0.5cm; font-size: 14px;margin-top: 5px;">
                    <input type="text" class="text-center" value="<?php echo substr($rows['cid'], 3, 1); ?>" style="width: 0.4cm; height: 0.5cm; font-size: 14px;margin-top: 5px;">
                    <input type="text" class="text-center" value="<?php echo substr($rows['cid'], 4, 1); ?>" style="width: 0.4cm; height: 0.5cm; font-size: 14px;margin-top: 5px;"> -
                    <input type="text" class="text-center" value="<?php echo substr($rows['cid'], 5, 1); ?>" style="width: 0.4cm; height: 0.5cm; font-size: 14px;margin-top: 5px;">
                    <input type="text" class="text-center" value="<?php echo substr($rows['cid'], 6, 1); ?>" style="width: 0.4cm; height: 0.5cm; font-size: 14px;margin-top: 5px;">
                    <input type="text" class="text-center" value="<?php echo substr($rows['cid'], 7, 1); ?>" style="width: 0.4cm; height: 0.5cm; font-size: 14px;margin-top: 5px;">
                    <input type="text" class="text-center" value="<?php echo substr($rows['cid'], 8, 1); ?>" style="width: 0.4cm; height: 0.5cm; font-size: 14px;margin-top: 5px;">
                    <input type="text" class="text-center" value="<?php echo substr($rows['cid'], 9, 1); ?>" style="width: 0.4cm; height: 0.5cm; font-size: 14px;margin-top: 5px;"> -
                    <input type="text" class="text-center" value="<?php echo substr($rows['cid'], 10, 1); ?>" style="width: 0.4cm; height: 0.5cm; font-size: 14px;margin-top: 5px;">
                    <input type="text" class="text-center" value="<?php echo substr($rows['cid'], 11, 1); ?>" style="width: 0.4cm; height: 0.5cm; font-size: 14px;margin-top: 5px;"> -
                    <input type="text" class="text-center" value="<?php echo substr($rows['cid'], 12, 1); ?>" style="width: 0.4cm; height: 0.5cm; font-size: 14px;margin-top: 5px;">
                </div>
            </div>
            <div class="row" style="margin-left: 0.5cm;margin-top: 5px;">
                <span style="width: 5.2cm;">เข้ารับการรักษาพยาบาลประเภท </span>
                <span style="width: 2.5cm;">
                    <!--<input type="checkbox" checked style="width: 0.4cm; height: 0.4cm;">-->
                    <i class="far fa-check-square fa-lg" style="width: 0.4cm; height: 0.4cm;"> </i>
                    ผู้ป่วยนอก
                </span>
                <span style="width: 3.3cm;">
                    <!--<input type="checkbox" style="width: 0.4cm; height: 0.4cm;">-->
                    <i class="far fa-square fa-lg" style="width: 0.4cm; height: 0.4cm;"> </i>
                    ผู้ป่วยใน
                </span>
            </div>

            <div class="row" style="margin-left: 0.1cm;margin-top: 5px;">
                <span style="width: 4cm;">2.ข้อมูลสถานพยาบาล</span>
                <span style="width: 12cm;">
                    <!--<input type="checkbox" checked style="width: 0.4cm; height: 0.4cm;">-->
                    <i class="far fa-square fa-lg" style="width: 0.4cm; height: 0.4cm;"></i>
                    เป็น &nbsp;สถานพยาบาลที่ผู้ทุพพลภาพเลือกเข้ารับบริการทางการแพทย์
                </span>
            </div>
            <div class="row" style="margin-left: 0.1cm;margin-top: 5px;">
                <span style="width: 4cm;"></span>
                <span style="width: 12cm;">
                    <!--<input type="checkbox" style="width: 0.4cm; height: 0.4cm;">-->
                    <i class="far fa-check-square fa-lg" style="width: 0.4cm; height: 0.4cm;"></i>
                    ไม่เป็น &nbsp;สถานพยาบาลที่ผู้ทุพพลภาพเลือกเข้ารับบริการทางการแพทย์
                </span>
            </div>

            <div class="row" style="margin-left: 0.1cm;margin-top: 5px;">
                <span style="width: 8cm;">3.ชื่อโรคหรืออาการที่เข้ารับบริการทางการแพทย์</span>
                <span style="margin-left:-0.3cm; border-bottom: black 1px dotted;width: 12.5cm; font-weight: bold;display: inline-block;">
                    &nbsp;&nbsp;&nbsp;
                </span>
                <span style="margin-left: 0.5cm; border-bottom: black 1px dotted;width: 19.7cm; font-weight: bold;display: inline-block;">
                    &nbsp;&nbsp;&nbsp;
                </span>
            </div>

            <div class="row" style="margin-left: 0.1cm;margin-top: 5px;">
                <span style="width: 4cm;">4.วิธีการรักษาพยาบาล</span>
                <span style="margin-left:-0.3cm; border-bottom: black 1px dotted;width: 16.5cm; font-weight: bold;display: inline-block;">
                    &nbsp;&nbsp;&nbsp;
                </span>
                <span style="margin-left: 0.5cm; border-bottom: black 1px dotted;width: 19.7cm; font-weight: bold;display: inline-block;">
                    &nbsp;&nbsp;&nbsp;
                </span>
            </div>

            <div class="row" style="margin-left: 0.5cm;margin-top: 5px;">
                <span style="width: 8cm;">วัน เดือน ปี ที่เข้ารับการรักษาพยาบาล ตั้งแต่วันที่</span>
                <span style="margin-left:-0.3cm; border-bottom: black 1px dotted;width: 4cm; font-weight: bold;display: inline-block;">
                    &nbsp; <?php echo thdate($rows['vstdate'], 'lm'); ?>
                </span>
                <span style="width: 1.5cm;">ถึงวันที่</span>
                <span style="margin-left: 0.1cm; border-bottom: black 1px dotted;width: 4cm; font-weight: bold;display: inline-block;">
                    &nbsp; <?php echo thdate($rows['vstdate'], 'lm'); ?>
                </span>
            </div>

            <?php
            $stmtt_sumprice = $hos_conn->prepare("SELECT SUM(sum_price) AS sumprice
													FROM opitemrece
													WHERE vn='" . base64_decode($_GET['VN']) . "'");
            $stmtt_sumprice->execute();
            $rowss_sumprice = $stmtt_sumprice->fetch(PDO::FETCH_ASSOC);
            ?>

            <div class="row" style="margin-left: 0.5cm;margin-top: 5px;">
                <span style="width: 2cm;">รวมเป็นเงิน</span>
                <span style="margin-left:-0.3cm; border-bottom: black 1px dotted;width: 4cm; font-weight: bold;display: inline-block;" class="text-center">
                    <?php echo number_format($rowss_sumprice['sumprice'] + $refer, 2, '.', ','); ?>
                </span>
                <span style="width: 1cm;">บาท </span>
                (<span style="margin-left: 0.1cm; border-bottom: black 1px dotted;width: 12.7cm; font-weight: bold;display: inline-block;" class="text-center">
                    <?php if ($rows['income'] + $refer > '0') {
                        echo convert(number_format($rowss_sumprice['sumprice'] + $refer, 2, '.', ','));
                    } else {
                        echo '-';
                    } ?>
                </span>)
            </div>

            <div class="row" style="margin-left: 0.1cm;margin-top: 5px;">
                <span style="width: 2cm;">5.ขอรับเงิน </span>
                <span style="width: 4cm;">
                    <!--<input type="checkbox" style="width: 0.4cm; height: 0.4cm;">-->
                    <i class="far fa-square fa-lg" style="width: 0.4cm; height: 0.4cm;"> </i>
                    ที่สำนักประกันสังคม
                </span>
                <span style="width: 3.3cm;">
                    <!--<input type="checkbox" style="width: 0.4cm; height: 0.4cm;">-->
                    <i class="far fa-square fa-lg" style="width: 0.4cm; height: 0.4cm;"> </i>
                    ธนาณัติสั่งจ่าย
                </span>

                <!--##################### บัญชีธนาคาร ########################-->
                <?php
                try {
                    $stmt_bank = $db_conn->prepare("SELECT * FROM setting_bank_hospital WHERE status = 'Y'");
                    $stmt_bank->execute();
                    $rows_bank = $stmt_bank->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    return $e->getMessage();
                }
                ?>

                <span style="width: 3cm;">
                    <!--<input type="checkbox" checked style="width: 0.4cm; height: 0.4cm;">-->
                    <i class="far fa-check-square fa-lg" style="width: 0.4cm; height: 0.4cm;"> </i>
                    ธนาคาร
                </span>
                <span class="text-center" style="width: 8.9cm;margin-left: -1cm;border-bottom: black 1px dotted;font-weight: bold;display: inline-block;"><?= $rows_bank['bankname']; ?></span>
            </div>

            <div class="row" style="margin-left: 0.5cm;margin-top: 5px;">
                <span style="width: 2cm;">สาขา </span>
                <span class="text-center" style="width: 6cm;margin-left: -1cm;border-bottom: black 1px dotted;font-weight: bold;display: inline-block;"><?= $rows_bank['branch']; ?></span>
                <span style="width: 2.8cm;"> บัญชีเลขที่</span>
                <span class="text-center" style="width: 11cm;margin-left: -1cm;border-bottom: black 1px dotted;font-weight: bold;display: inline-block;"><?= $rows_bank['banknumber']; ?></span>
            </div>

            <div class="row" style="margin-left: 0.5cm;margin-top: 0px; font-weight: bold;">
                <span style="width: 10cm;"></span>
                <span style="width: 10cm;">(<?= $rows_bank['detail']; ?>)</span>
            </div>

            <div class="row" style="margin-left: 0.1cm;margin-top: 5px;">
                <span style="width: 6cm;">6.เอกสารประกอบการยื่นคำขอที่แนบ </span>
            </div>
            <div class="row" style="margin-left: 1cm;margin-top: 5px;">
                <span style="width: 4cm;">
                    <!--<input type="checkbox" checked style="width: 0.4cm; height: 0.4cm;">-->
                    <i class="far fa-check-square fa-lg" style="width: 0.4cm; height: 0.4cm;"> </i>
                    ใบรับรองแพทย์
                </span>
            </div>
            <div class="row" style="margin-left: 1cm;margin-top: 5px;">
                <span style="width: 8cm;">
                    <!--<input type="checkbox" checked style="width: 0.4cm; height: 0.4cm;">-->
                    <i class="far fa-check-square fa-lg" style="width: 0.4cm; height: 0.4cm;"> </i>
                    ใบสรุป / ใบแสดงผลรายการค่ารักษาพยาบาล
                </span>
            </div>

            <?php
            // try {
            //     $stmt_director = $db_conn->prepare("SELECT CONCAT(director_pname,director_fname,'  ',director_lname) AS director_name, director_hospital 
            //                                         FROM director
            //                                         WHERE director_status='Y'");
            //     $stmt_director->execute();
            //     if ($stmt_director->rowCount()) {
            //         $rows_director = $stmt_director->fetch(PDO::FETCH_ASSOC);
            //     }
            // } catch (PDOException $e) {
            //     return $e;
            // }

            ?>

            <div class="row" style="margin-left: 1cm;margin-top: 5px;font-weight: bold">
                <span style="width: 10cm;"></span>
                <span style="width: 1cm;">(ลงชื่อ)</span>
                <span style="width: 7cm;border-bottom: black 1px dotted;font-weight: bold;display: inline-block;"></span>
            </div>
            <div class="row" style="margin-left: 1cm;margin-top: 5px;font-weight: bold">
                <span style="width: 10.9cm;"></span>
                (<span style="width: 7cm;border-bottom: black 1px dotted;font-weight: bold;display: inline-block;" class="text-center"></span>)
            </div>
            <div class="row" style="margin-left: 1cm;margin-top: 5px;font-weight: bold">
                <span style="width: 3cm;"></span>
                <span style="width: 7cm;">ผู้อำนวยการโรงพยาบาล / ผู้รับมอบอำนาจ</span>
                <span style="width: 9cm;border-bottom: black 1px dotted;font-weight: bold;display: inline-block;" class="text-center"></span>
            </div>

            <div class="row border border-dark border-left-0 border-right-0" style="margin-left: 0.01cm;margin-top: 20px;font-weight: bold;height: 1cm;width: 20.5cm;">
                <span style="width: 20.5cm;margin-top: 0.2cm;" class="text-center"> คำรับรองของผู้ประกันตนที่ทุพพลภาพ </span>
            </div>

            <div class="row" style="margin-left: 1cm;margin-top: 5px;">
                <?php if ($rows['pname'] == 'นาย') {
                    $pname = '(นาย, <s>นาง</s>, <s>นางสาว</s>)';
                } else if ($rows['pname'] == 'นาง') {
                    $pname = '(<s>นาย</s>, นาง, <s>นางสาว</s>)';
                } else if ($rows['pname'] == 'นางสาว' || $rows['pname'] == 'น.ส.') {
                    $pname = '(<s>นาย</s>, <s>นาง</s>, นางสาว)';
                } else {
                    $pname = $rows['pname'];
                } ?>
                <span style="margin-left: 0.1cm;width: 4.5cm;margin-top: 0.1cm;">ข้าพเจ้า <?php echo $pname; ?> </span>
                <span style="width:11cm;margin-left:0cm;margin-top: 0.1cm;border-bottom: black 1px dotted;font-weight: bold;display: inline-block;" class="text-center">
                    <?php echo $rows['fname']; ?>
                </span>
                <span style="width:4cm;">
                    ขอรับรองว่า
                </span>
            </div>
            <div class="row" style="margin-left: 0.01cm;margin-top: 5px;">
                <span style="margin-left: 0.1cm;width: 20cm;">
                    ได้เข้ารับการรักษาพยาบาลตามระยะเวลาดังกล่าวจริง และยินยอมให้สถานพยาบาลเป็นผู้เบิกค่ารักษาพยาบาล
                </span>
            </div>

            <div class="row" style="margin-left: 1cm;margin-top: 5px;font-weight: bold">
                <span style="width: 10cm;"></span>
                <span style="width: 1cm;">(ลงชื่อ)</span>
                <span style="width: 7cm;border-bottom: black 1px dotted;font-weight: bold;display: inline-block;"></span>
            </div>
            <div class="row" style="margin-left: 1cm;margin-top: 5px;font-weight: bold">
                <span style="width: 10.9cm;"></span>
                (<span style="width: 7cm;border-bottom: black 1px dotted;font-weight: bold;display: inline-block;" class="text-center"><?php echo $rows['fullname']; ?></span>)
            </div>
            <div class="row" style="margin-left: 1cm;margin-top: 5px;font-weight: bold">
                <span style="width: 10cm;"></span>
                <span style="width: 1cm;">วันที่</span>
                <span style="width: 7cm;border-bottom: black 1px dotted;font-weight: bold;display: inline-block;" class="text-center"><?php echo thdate($rows['vstdate'], 'lm') ?></span>
            </div>

            <div class="row border border-dark border-left-0 border-right-0 border-top-0" style="margin-left: 0cm;margin-top: 20px;width: 20.5cm;">
            </div>


            <div class="row text-justify row border border-dark border-left-0 border-right-0 border-top-0" style="width: 20.5cm; height: 3cm; margin-left: 0cm; margin-top:5px;">
                <div style="width: 20cm; margin-left: 0.1cm;">
                    คำเตือน : ประมวลผลกฏหมายอาญามาตรา 341 ผู้ใดโดยทุจริต หลอกลวงผู้อื่นด้วยการแสดงข้อความอันเป็นเท็จ หรือปกปิดข้อความจริง ซึ่งควรบอกให้แจ้ง
                    และโดยการหลอกลวงดังว่านั้น ได้ไปซึ่งทรัพย์สินจากผู้ถูกหลอกลวง หรือบุคคลที่สามหรือทำให้ผู้ถูกหลอกลวงหรือบุคคลที่สามทำ ถอนหรือทำลายเอกสารสิทธิ
                    ผู้นั้นกระทำความผิดฐานฉ้อโกง ต้องระวางโทษจำคุกไม่เกินสามปี หรือปรับไม่เกินหกพันบาทหรือทั้งจำทั้งปรับ
                </div>
            </div>
        </div>
    </page>

    <page size="A4" class="thsarabunnew" style="font-size: 1em;">
        <BR>
        <div class="row" style="margin-left: 1cm;">
            <div style="width: 17.5cm; margin: 0 auto; margin-top: 0.1cm;">
                <div class="row" style="margin-left: 0.01cm;">
                    <div style="width: 17.5cm;">
                        <div class="text-center"> ใบสรุปค่ารักษาพยาบาล </div>
                    </div>
                    <div style="width: 17.5cm; margin-top: 15px;">
                        <div class="text-center"> <?= $rows_hospital['hosname']; ?> อำเภอ<?= $rows_hospital['hosamphur']; ?> จังหวัด<?= $rows_hospital['hosprovince']; ?> สรุปค่ารักษาพยาบาล </div>
                    </div>
                </div>

                <div class="row" style="margin-left: 0.01cm; margin-top: 10px;">
                    <div style="width: 3.0cm;">
                        <span> ผู้ป่วยประกันชื่อ </span>
                    </div>
                    <div style="width: 6.0cm; margin-left: -0.3cm; border-bottom: black 1px dotted;font-weight: bold;display: inline-block;" class="text-center">
                        <span> <?= $rows['fullname']; ?> </span>
                    </div>
                    <div style="width: 4.0cm;">
                        <span> เลขที่บัตรประกันสังคม </span>
                    </div>
                    <div style="width: 5.0cm; border-bottom: black 1px dotted;font-weight: bold;display: inline-block;" class="text-center">
                        <span> <?= $rows['cid']; ?> </span>
                    </div>
                </div>

                <div class="row" style="margin-left: 0.01cm; margin-top: 5px;">
                    <div style="width: 2.5cm;">
                        <span> ป่วยด้วยโรค </span>
                    </div>
                    <div style="width: 6.5cm; margin-left: -0.3cm; border-bottom: black 1px dotted;font-weight: bold;display: inline-block;" class="text-center">
                        <span> </span>
                    </div>
                    <div style="width: 4.0cm;">
                        <span> มารับการรักษาเมื่อวันที่ </span>
                    </div>
                    <div style="width: 5cm; border-bottom: black 1px dotted;font-weight: bold;display: inline-block;" class="text-center">
                        <?php //if($rows['vstdate']===$rows['lastdate']){
                        ?>
                        <span> <?= thdate($rows['vstdate'], 'lm'); ?> </span>
                        <?php //}else{
                        ?>
                        <!--<span> <?= thdate($rows['vstdate'], 'lm'); ?>-<?= thdate($rows['vstdate'], 'lm'); ?>  </span>-->
                        <?php // } 
                        ?>
                    </div>
                </div>

                <div class="row" style="margin-left: 0.01cm; margin-top: 5px;">
                    <div style="width: 7cm;">
                        <span> ซึ่งมีค่ารักษาพยาบาลรายละเอียดดังนี้</span>
                    </div>
                </div>

                <div class="row" style="margin-left: 0.01cm; margin-top: 5px;">
                    <div style="width: 17.5cm;">
                        <table style="width: 17.5cm;margin-top: 0.1cm;font-size: 0.9em;" border="1" cellspacing="1" cellpadding="1" class="">
                            <thead style="font-weight: bold;">
                                <th class="text-center" style="width: 1cm;">ลำดับ</th>
                                <th class="text-center" style="width: 16cm;">รายการ</th>
                                <th class="text-center" style="width: 2.5cm;">จำนวนเงิน</th>
                                <th class="text-center" style="width: 2.5cm;">หมายเหตุ</th>
                            </thead>
                            <tbody>


                                <?php
                                /*try{
                                    $stmt_bed = $hos_conn->prepare("select * from iptadm WHERE an=:an limit 1");
                                    $stmt_bed->bindParam(':an',base64_decode($_GET['AN']),PDO::PARAM_STR);
                                    $stmt_bed->execute();
                                    if($stmt_bed->rowCount()){
                                        $rows_bed = $stmt_bed->fetch(PDO::FETCH_ASSOC);
                                    }
                                }catch(PDOException $e){
                                    return $e;
                                }*/
                                ?>

                                <!--<tr>
                            <td>1. ค่าห้องและค่าอาหาร จำนวน <?php echo $rows_bed['admday']; ?> วัน วันละ <?php echo number_format($rows_bed['rate']); ?> บาท</td>
                            <td class="text-center"><?php echo number_format($rows_bed['rate'] * $rows_bed['admday']); ?></td>
                            <td class="text-center"></td>
                        </tr>-->

                                <?php
                                try {
                                    $i = 1;
                                    $stmt_std_group = $hos_conn->prepare("SELECT * FROM income_std_group WHERE std_group NOT IN ('01')");
                                    $stmt_std_group->execute();
                                    while ($rows_std_group = $stmt_std_group->fetch(PDO::FETCH_ASSOC)) {
                                        $stmtt = $hos_conn->prepare("SELECT ig.std_group, SUM(op.sum_price) AS sumprice
                                                                FROM opitemrece op
                                                                LEFT OUTER JOIN income ON income.income = op.income
                                                                LEFT OUTER JOIN income_std_group ig ON ig.std_group = income.std_group
                                                                LEFT OUTER JOIN vn_stat vn ON vn.vn = op.vn
                                                                WHERE vn.vn='" . base64_decode($_GET['VN']) . "' AND ig.std_group='" . $rows_std_group['std_group'] . "'
                                                                ");
                                        $stmtt->execute();
                                        $rowss = $stmtt->fetch(PDO::FETCH_ASSOC);
                                        if ($rows_std_group['std_group'] == $rowss['std_group']) {
                                            if ($rowss['sumprice'] > '0') {
                                                if ($rowss['std_group'] == '12') {
                                                    if ($rowss['sumprice'] > '500') {
                                                        try {
                                                            $stmt_refer = $db_conn->prepare("SELECT * 
                                                                                                FROM refer_price 
                                                                                                WHERE refer_place='OPD' 
                                                                                                LIMIT 1");
                                                            $stmt_refer->execute();
                                                            $rows_refer = $stmt_refer->fetch(PDO::FETCH_ASSOC);
                                                        } catch (PDOException $e) {
                                                            echo $e->getMessage();
                                                        }
                                                        $refer = $rows_refer['refer_price'];
                                                        $data = number_format($rowss['sumprice'] - $refer, 2, '.', ',');
                                                        //$refer = '500';
                                                        $sum_price1 = $data;
                                                    } else {
                                                        $data = number_format($rowss['sumprice'], 2, '.', ',');
                                                        $sum_price1 = $data;
                                                    }
                                                } else {
                                                    $data = number_format($rowss['sumprice'], 2, '.', ',');
                                                    $sum_price += $rowss['sumprice'];
                                                }
                                            } else {
                                                $data = '-';
                                            }
                                        } else {
                                            $data = '-';
                                        } ?>

                                        <tr>
                                            <td class="text-center"><?php echo $i++; ?></td>
                                            <td>&nbsp;<?php echo $rows_std_group['name']; ?></td>
                                            <td class="text-center"><?php echo $data; ?></td>
                                            <td class="text-center"></td>
                                        </tr>

                                <?php
                                    }
                                } catch (PDOException $e) {
                                    return $e;
                                }
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i; ?></td>
                                    <td>&nbsp;บริการอื่นๆ</td>
                                    <td class="text-center"><?php if ($refer) {
                                                                echo number_format($refer, 2, '.', ',');
                                                            } else {
                                                                echo '-';
                                                            } ?></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="font-weight: bold;" class="text-center">&nbsp;&nbsp;&nbsp;&nbsp; รวมทั้งสิ้น (ตัวหนังสือ)
                                        <span style="display: inline-block;border-bottom: black 1px dotted;">
                                            <?php if ($sum_price + $sum_price1 + $refer > '0') {
                                                echo convert(number_format($sum_price + $sum_price1 + $refer, 2, '.', ','));
                                            } ?>
                                        </span>
                                    </td>
                                    <td style="font-weight: bold;" class="text-center"><?php echo number_format($sum_price + $sum_price1 + $refer, 2, '.', ','); ?></td>
                                    <td class="text-center"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php
                $stmt_rec = $db_conn->prepare("SELECT CONCAT(rec_sum_pname,rec_sum_name) AS recorde_name,rec_sum_prosition FROM recorde_summary WHERE rec_sum_status='Y'");
                $stmt_rec->execute();
                $rows_rec = $stmt_rec->fetch(PDO::FETCH_ASSOC);
                ?>

                <div class="row" style="margin-left: 1cm;margin-top: 1cm;">
                    <span style="width: 8.5cm;"></span>
                    <span style="width: 1cm;">(ลงชื่อ)</span>
                    <span style="width: 7cm;border-bottom: black 1px dotted;display: inline-block;"></span>
                </div>
                <div class="row" style="margin-left: 1cm;margin-top: 5px;">
                    <span style="width: 10.4cm;"></span>
                    (<span style="width: 5cm;border-bottom: black 1px dotted;display: inline-block;" class="text-center"><?= $rows_rec['recorde_name']; ?></span>)
                </div>
                <div class="row" style="margin-left: 1cm;margin-top: 5px;">
                    <span style="width: 11.5cm;"></span>
                    <span style="width: 3cm;" class="text-center"><?= $rows_rec['rec_sum_prosition']; ?></span>
                </div>
                <div class="row" style="margin-left: 1cm;margin-top: 5px;">
                    <span style="width: 10.5cm;"></span>
                    <span style="width: 6.0cm;display: inline-block;" class="text-center">ผู้บันทึกและสรุปค่ารักษาพยาบาล</span>
                </div>

                <?php
                try {
                    $stmt_fc = $db_conn->prepare("SELECT CONCAT(finance_accounting_pname,finance_accounting_name) AS finance_accounting_name,finance_accounting_prosition FROM finance_accounting WHERE finance_accounting_status='Y'");
                    $stmt_fc->execute();
                    $rows_fc = $stmt_fc->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    return $e;
                }
                ?>

                <div class="row" style="margin-left: 0cm;margin-top: 0.5cm;">
                    <span style="width: 8.5cm;">ขอรับรองว่ารักษาพยาบาลถูกต้องตามที่เรียกเก็บ</span>
                </div>
                <div class="row" style="margin-left: 0cm;margin-top: 0.5cm;">
                    <span style="width: 1cm;">(ลงชื่อ)</span>
                    <span style="width: 7cm;border-bottom: black 1px dotted;display: inline-block;"></span>
                </div>
                <div class="row" style="margin-left: 1.5cm;margin-top: 5px;">
                    (<span style="width: 5cm;border-bottom: black 1px dotted;display: inline-block;" class="text-center"><?= $rows_fc['finance_accounting_name']; ?></span>)
                </div>
                <div class="row" style="margin-left: 0.6cm;margin-top: 5px;">
                    <span style="width: 7cm;" class="text-center"><?= $rows_fc['finance_accounting_prosition']; ?></span>
                </div>


            </div>
        </div>
    </page>

    <page size="A4" class="thsarabunnew" style="font-size: 11.2pt;">
        <BR>
        <div class="row" style=" margin-left: 1cm;">
            <div style="width: 17.5cm; margin: 0 auto;margin-top:0.1cm;">
                <div class="row" style="margin-left: 0.01cm;">
                    <div style="width: 17.5cm; font-weight: bold; font-size: 1.2em;" class="text-center">
                        <span> ใบรับรองแพทย์ </span>
                    </div>
                    <div style="width: 17.5cm; margin-top: 15px;" class="text-right">
                        <span> <?= $rows_hospital['hosname']; ?> </span>
                    </div>
                    <div style="width: 17.5cm; margin-top: 10px;" class="text-right">
                        <span> <?= displaydate($rows['vstdate']); ?> </span>
                    </div>
                </div>

                <div class="row" style="margin-left: 1cm; margin-top: 1cm;">
                    <div style="width: 7cm;">
                        <span>ข้าพเจ้า&nbsp;&nbsp; </span> <span id="doctor_name"></span>
                        <select name="doctor" id="doctor" onchange="myFunction()" class="border border-dark border-left-0 border-right-0 border-top-0 border-bottom-0">
                            <option value="">---เลือกแพทย์---</option>
                            <?php
                            try {
                                $sql_get_doctor = "SELECT *, account_disable FROM doctor d
                                                            JOIN opduser o ON d.`code` = o.doctorcode
                                                            WHERE o.account_disable <> 'Y' AND d.licenseno <> ''
                                                            AND d.position_id IN ('1','2')
                                                            ORDER BY d.`name`";
                                $stmt_select = $hos_conn->prepare($sql_get_doctor);
                                $stmt_select->execute();
                                while ($rows_select = $stmt_select->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                    <option value="<?= $rows_select['licenseno']; ?>:<?= $rows_select['name']; ?>"><?= $rows_select['name']; ?></option>

                            <?php
                                }
                            } catch (PDOException $e) {
                                echo $e->getMessage();
                            }
                            ?>
                        </select>
                    </div>
                    <div style="width: 9cm;">
                        <span> ใบอนุญาตประกอบวิชาชีพเวชกรรมเลขที่&nbsp;&nbsp; </span>
                        <span id="doctorb_licenseno" class="border border-dark border-left-0 border-right-0 border-top-0 border-bottom-0" size="7">

                    </div>
                </div>

                <div class="row" style="margin-left: 0cm; margin-top: 5px;">
                    <div style="width: 16cm;">
                        <span>ได้ทำการตรวจร่างกายของ&nbsp;&nbsp;<?= $rows['fullname']; ?></span>
                    </div>
                </div>
                <div class="row" style="margin-left: 0cm; margin-top: 5px;">
                    <div style="width: 4.5cm;">
                        <span>แล้วปรากฏว่าป่วยเป็นโรค</span>
                    </div>
                    <div style="width: 13.0cm;border-bottom: black 1px dotted;display: inline-block;">
                        <span></span>
                    </div>
                </div>

                <div class="row" style="margin-left: 0cm; margin-top: 25px;">
                    <div style="width: 17.5cm;border-bottom: black 1px dotted;display: inline-block;">
                        <span></span>
                    </div>
                </div>
                <div class="row" style="margin-left: 0cm; margin-top: 25px;">
                    <div style="width: 17.5cm;border-bottom: black 1px dotted;display: inline-block;">
                        <span></span>
                    </div>
                </div>
                <div class="row" style="margin-left: 0cm; margin-top: 25px;">
                    <div style="width: 17.5cm;border-bottom: black 1px dotted;display: inline-block;">
                        <span></span>
                    </div>
                </div>

                <div class="row" style="margin-left: 0cm; margin-top: 30px;width: 18.0cm;">
                    <div style="width: 18.0cm;" class="text-justify">
                        <span style="width: 17.5cm; display:inline-block;;">
                            จึงเห็นสมควรให้หยุดงาน/ราชการมีกำหนด...............วัน
                            นับตั้งแต่วันที่.........เดือน...............................พ.ศ.<?= date('Y') + 543; ?>
                            ถึงวันที่.........เดือน...............................พ.ศ.<?= date('Y') + 543; ?>
                        </span>
                    </div>

                    <div class="row" style="margin-left: 1cm;margin-top: 2cm;">
                        <span style="width: 8.5cm;"></span>
                        <span style="width: 1cm;">(ลงชื่อ)</span>
                        <span style="width: 7cm;border-bottom: black 1px dotted;display: inline-block;"></span>
                    </div>
                    <div class="row" style="margin-left: 1cm;margin-top: 5px;">
                        <span style="width: 10.4cm;"></span>
                        (<span style="width: 5cm;border-bottom: black 1px dotted;display: inline-block;" class="text-center" id="doctor_name1"></span>)
                    </div>
                    <div class="row" style="margin-left: 1cm;margin-top: 5px;margin-bottom: 0px;">
                        <span style="width: 11.5cm;"></span>
                        <span style="width: 3cm;" class="text-center">แพทย์ผู้ตรวจ</span>
                    </div>
                </div>
            </div>
    </page>
</div>




<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<?php //include_once ('../script/js/js.php'); 
?>
<script>
    /*$(document).ready(function() {

            $('#doctor').chang(function () {
                $('#doctora').text($(this).val());
                $('#doctorb').text($(this).val());
            });
        });*/
    swal({
        title: "กรอกข้อมูล",
        text: "",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        inputPlaceholder: "กรอกข้อมูลสถานพยาบาลที่คุณต้องการ"
    }, function(inputValue) {
        if (inputValue === false) return false;
        if (inputValue === "") {
            swal.showInputError("กรุณากรอกข้อความ...");
            return false
        }
        swal("สุดยอด!", inputValue, "success");
        document.getElementById("name").innerHTML = inputValue;
    });

    function click_name() {
        swal({
            title: "กรอกข้อมูล",
            text: "",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            inputPlaceholder: "กรอกข้อมูลสถานพยาบาลที่คุณต้องการ"
        }, function(inputValue) {
            if (inputValue === false) return false;
            if (inputValue === "") {
                swal.showInputError("กรุณากรอกข้อความ...");
                return false
            }
            swal("สุดยอด!", inputValue, "success");
            document.getElementById("name").innerHTML = inputValue;
        });
    }

    $("#doctor_name").click(function(){
        $("#doctor").removeClass("hidden-select");
    });

    function myFunction() {
        var doctor = document.getElementById("doctor").value;
        if(doctor !== ""){
            $("#doctor").addClass("hidden-select");
            var doctoy_split = doctor.split(':');
            
            document.getElementById("doctor_name").innerHTML = doctoy_split[1];
            document.getElementById("doctor_name1").innerHTML = doctoy_split[1];
            document.getElementById("doctorb_licenseno").innerHTML = doctoy_split[0];
        }
    }

    function printDiv(divName) {
        var print = divName.substring(0, 13);
        var vn = divName.substring(13, 25);

        //alert('print :'+print +' ,'+ ' hn :'+hn +' ,'+ ' stdate :'+stdate+' ,'+ 'endate :'+endate );

        /*var printContents = document.getElementById(print).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;*/
        if ($('#doctor').val() === '') {
            $('#doctor').focus();
            swal("กรุณาเลือกแพทย์ผู้ให้การรักษา ", "", "error");
            return false;
        } else {
            swal({
                    title: "Print VN : " + vn,
                    text: "คุณต้องการปริ้นเอกสารใช่ หรือ ไม่",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "",
                    confirmButtonText: "Yes, Print",
                    cancelButtonText: "No, Cancel",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            'type': 'GET',
                            'url': '../data/sync-medical.php',
                            'cache': false,
                            'data': {
                                VN: vn
                            },
                            'success': function(html) {
                                if (html) {
                                    swal({
                                        title: "Success",
                                        text: "ระบบบันทึกข้อมูล VN : " + vn + " เรียบร้อยแล้ว",
                                        type: "success"
                                    }, function() {
                                        var printContents = document.getElementById(print).innerHTML;
                                        var originalContents = document.body.innerHTML;
                                        document.body.innerHTML = printContents;
                                        window.print();
                                        document.body.innerHTML = originalContents;
                                    })
                                } else if (html.trim() == 'error') {
                                    swal("Cancelled", "ระบบไม่สามารถบันทึกข้อมูล VN : " + vn + " ได้", "error");
                                } else {
                                    alert(html);
                                }

                            },
                            'beforeSend': function() {
                                swal({
                                    type: 'info',
                                    title: 'กรุณารอสักครู่',
                                    text: 'ระบบกำลังดำเนินการ...',
                                    showConfirmButton: false
                                })
                            }

                        });

                    } else {
                        swal("Cancelled", "VN : " + vn, "error");
                    }
                })
        }

    }
</script>