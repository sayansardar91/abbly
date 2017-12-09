<?php
ini_set('max_execution_time', 3000);
ini_set('memory_limit','200M');
set_include_path("../dompdf");
require_once "../lib/config.php";
require_once "../lib/database.php";
require_once "../lib/MyDateTime.php";
require_once "dompdf_config.inc.php";
date_default_timezone_set('Asia/Kolkata');
session_start();
if (!((isset($_GET['pg']) or (isset($_SESSION['user']))))){
    header("Location: ../index.php");
}
if(isset($_POST)){
    $_POST = array_filter($_POST);
}

$qr_string = null;
$db = new database();
/*if(isset($_POST['bearth_month']) && isset($_POST['bearth_year'])){
    $from = $_POST['bearth_year']."-".date('m',  strtotime($_POST['bearth_month']))."-01";
    $to = $_POST['bearth_year']."-".date('m',  strtotime($_POST['bearth_month']))."-".date('t', strtotime($_POST['bearth_month']." ".$_POST['bearth_year']));
    $qr_string = "Select *from view_municipality WHERE baby_dob BETWEEN '$from' AND '$to'";
}else if(isset($_POST['bearth_year'])){
    $from = $_POST['bearth_year']."-01-01";
    $to = $_POST['bearth_year']."-12-31";
    $qr_string = "Select *from view_municipality WHERE baby_dob BETWEEN '$from' AND '$to'";
}else if(isset($_POST['bearth_month'])){
    $from = date('Y')."-".date('m',  strtotime($_POST['bearth_month']))."-01";
    $to = date('Y')."-".date('m',  strtotime($_POST['bearth_month']))."-".date('t', strtotime($_POST['bearth_month']." ".date('Y')));
    $qr_string = "Select *from view_municipality WHERE baby_dob BETWEEN '$from' AND '$to'";
}else{
    $qr_string = "Select *from view_municipality";
}*/

$qr_string = "call sp_municipality('".$_POST['baby_idfrom']."','".$_POST['baby_idto']."');";

$query = $db->conn->query($qr_string);
$dompdf = new DOMPDF();
$dompdf->set_option('enable_html5_parser', TRUE);
$dompdf->set_paper("legal", 'landscape');



$html = '
<html>
<head>
<title>Municipality Report</title>
<link rel="icon" type="image/ico" href="' . FAV_ICON . '" />
 <style>
    div {line-height: 1; font-weight:bold;}
    h1, p {margin: 0;}
    h4, p {margin: 0;}
    h2, p {margin: 0;}
	span {font-style:italic; font-family:Arial, Helvetica, sans-serif;}
        table {
    border-collapse: collapse;}
    body {
    margin-top: 100px;
    }
}

table, th, td {
    border: 1px solid black;
    margin-top: 10px;
    margin-left: 0px;
    margin-right: 0px;
}
</style>
</head>

<body>
    <table width="100%">
            <thead>
                <tr >
                    <th>S/No.</th>
                    <th>Reg. No</th>
                    <th>Date Of Birth</th>
                    <th>Father Name</th>
                    <th>Mother Name</th>
                    <th>Vill / Town</th>
                    <th>Police Station</th>
                    <th>Dist</th>
                    <th>State</th>
                    <th>Religion</th>
                    <th>Father Edu.</th>
                    <th>Mother Edu.</th>
                    <th>Father Occu.</th>
                    <th>Mother Occu.</th>
                    <th>Age Of Marrige</th>
                    <th>Age Of Mother</th>
                    <th>No. Of Child</th>
                    <th>Method Of Delivery*</th>
                    <th>Weight (kg)</th>
                    <th>Sex</th>
                    <th>Preg. Dur.</th>
                </tr>
            </thead>
            <tbody>';

$i=1;
$remarks = "On the basis of this certificate";
while ($row = mysqli_fetch_assoc($query)) {   
    $remarks = $row['baby_remarks'];
    $html .=
            '<tr align="center">
            <td >'.$i.'</td>
            <td width="8%">'.$row['reg_no'].'</td>
            <td width="8%">'.date('d-m-Y',strtotime($row['baby_dob'])).'</td>
            <td >'.$row['gurd_name'].'</td>
            <td >'.$row['mother_name'].'</td>
            <td >'.$row['address'].'</td>
            <td >'.$row['ps'].'</td>
            <td >'.$row['dist'].'</td>
            <td >'.$row['state'].'</td>
            <td >'.$row['religion'].'</td>
            <td >'.$row['gurd_quali'].'</td>
            <td >'.$row['patient_quali'].'</td>
            <td >'.$row['gurd_ocu'].'</td>
            <td >'.$row['patient_ocu'].'</td>
            <td >'.$row['m_age'].'</td>
            <td >'.$row['age'].'</td>
            <td >'.$row['baby_child_no'].'</td>
            <td >'.$row['baby_method_delivery'].'</td>
            <td >'.$row['baby_weight'].'</td>
            <td >'.$row['baby_sex'].'</td>
            <td >'.$row['baby_preg_dur'].'</td>
          </tr>';
    if($remarks != null){
        $html .= '<tr><td colspan="21">**** Note: '.$remarks.'</td></tr>';
    }
    $i++;
}   
$html .= '</tbody></table></div></body></html>';

$dompdf->load_html($html);
$dompdf->render();

$canvas = $dompdf->get_canvas();
$font = Font_Metrics::get_font("helvetica", "bold" , "underline");
$font_r = Font_Metrics::get_font("helvetica", "bold");
$canvas->page_text(350,20,'SWARNAKAMAL NURSING HOME',$font,19,array(0,0,0));
$canvas->page_text(358,45,'NAIHATI, P.O.- BADARTALA, NORTH 24 PARGANAS',$font,12,array(0,0,0));
$canvas->page_text(448,80,'MUNICIPALITY REPORT',$font_r,12,array(0,0,0));
$canvas->page_text(870, 18, "Date : ".date('d-M-Y'),$font, 12, array(0,0,0));
$canvas->page_text(870, 35, "Time : ".date('h:i:s A'),$font, 12, array(0,0,0));
$canvas->page_text(675, 80, "* Method Of Delivery : 1 - Normal, 2 - Caesarean, 3 - Forceps / Vacuum ",$font, 9, array(0,0,0));
$canvas->page_text(480, 578, "{PAGE_NUM} of {PAGE_COUNT}", $font, 12, array(0, 0, 0));

$dompdf->stream("discharge.pdf", array('Attachment' => 0));

function finYear($year_str){
    $mydate = new MyDateTime();
    $mydate->setDate(date("Y",  strtotime($year_str)), date("m",strtotime($year_str)), date("d",strtotime($year_str)));
    $result = $mydate->fiscalYear();
    $start = $result['start']->format('Y');
    $end = $result['end']->format('y');
    $fyear = $start . "-" . $end;
    return $fyear;
}
?>


