<?php
class Patients
{
    function getPatientByCID($cid)
    {
        $sql = "SELECT 
                    p.cid, 
                    p.hn, 
                    o.vn, 
                    o.an, 
                    CONCAT(p.pname, p.fname, ' ', p.lname) as full_name, 
                    o.vstDate, 
                    o.doctor, 
                    i.regdate, 
                    i.dchdate, 
                    i.dch_doctor 
                FROM patient p
                    JOIN ovst o ON p.hn = o.hn
                    LEFT JOIN ipt i ON o.vn = i.vn
                WHERE p.cid = '$cid'
                    ORDER BY o.vstdate DESC";
        return $sql;
    }

    function getPatientByVstdateAndHN($vsdate, $hn){    
        $sql =  "SELECT o.vn,
                    o.an,
                    o.vstdate as visitDate, 
                    '' as dchDate,
                    dep.department as dep_name, 
                    d.`name` as DoctorName 
                FROM ovst o
                    LEFT JOIN doctor d ON o.doctor = d.`code`
                    LEFT JOIN kskdepartment dep ON o.main_dep = dep.depcode
                WHERE o.vstdate = '$vsdate' AND o.hn = '$hn'
                ORDER BY o.vstdate DESC";
        return $sql;
    }

    function getPatientByAN($an){    
        $sql =  "SELECT i.an, 
                    i.vn,
                    i.regdate as visitDate, 
                    i.dchdate as dchDate, 
                    w.`name` as dep_name, 
                    d.`name` as DoctorName 
                FROM ipt i
                    LEFT JOIN doctor d ON i.dch_doctor = d.`code`
                    LEFT JOIN ward w ON i.ward = w.ward
                WHERE i.an = '$an'";
        return $sql;
    }

    function getRegisterDocumentAll(){
        $sql = "SELECT * FROM register_document ORDER BY updated_date DESC";
        return $sql;
    }

    function getRegisterDocumentByTrackAdmin($trackId){
        $sql = "SELECT * FROM register_document d
                    LEFT JOIN register_tracking t ON d.id = t.doc_id
                    LEFT JOIN register_petition p ON p.petition_id = d.petition_id
                    LEFT JOIN register_about a ON d.request_about_id = a.about_id
                    LEFT JOIN register_member m ON d.approve_user = m.userId
                WHERE t.track_id = '$trackId' OR d.request_cid = '$trackId'
                ORDER BY d.updated_date DESC";
        return $sql;
    }

    function getRegisterDocumentByTrack($trackId){
        $sql = "SELECT * FROM register_document d
                    LEFT JOIN register_tracking t ON d.id = t.doc_id
                    LEFT JOIN register_petition p ON p.petition_id = d.petition_id
                    LEFT JOIN register_about a ON d.request_about_id = a.about_id
                WHERE t.track_id = '$trackId' OR d.request_cid = '$trackId'
                ORDER BY d.updated_date DESC";
        return $sql;
    }

    function getRegisterDocumentByID($trackId){
        $sql = "SELECT * FROM register_document d
                    LEFT JOIN register_tracking t ON d.id = t.doc_id
                    LEFT JOIN register_log l ON l.track_id = t.track_id
                WHERE t.track_id = '$trackId'
                ORDER BY l.log_datetime DESC";
        return $sql;
    }

    function getRegisterAboutAll(){
        $sql = "SELECT * FROM register_about ORDER BY about_id";
        return $sql;
    }

    function getRegisterPetitionAll(){
        $sql = "SELECT * FROM register_petition ORDER BY petition_id";
        return $sql;
    }

    function getRegisterLogAll(){
        $sql = "SELECT * FROM register_log ORDER BY log_datetime DESC";
        return $sql;
    }

    function getRegisterStatusAll(){
        $sql = "SELECT * FROM register_status ORDER BY status_id";
        return $sql;
    }
    
    function getRegisterLog($trackId){
        $sql = "SELECT * FROM register_log WHERE track_id = '$trackId' ORDER BY log_datetime DESC";
        return $sql;
    }

    function getUserLogin($user, $pwd){
        $sql = "SELECT * FROM register_member WHERE `user_name` = '$user' AND pwd = '$pwd' AND is_active = 1 LIMIT 1";
        return $sql;
    }
}
