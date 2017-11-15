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
$_POST = array_filter($_POST);
$db = new database();

$fromDate = $toDate = null;
if(isset($_POST['date_daily'])){
	$fromDate = $toDate = $_POST['date_daily'];
}else if(isset($_POST['date_from']) && isset($_POST['date_to'])){
	$fromDate = $_POST['date_from'];
	$toDate = $_POST['date_to'];
}

$qr_string = "Call sp_admreport('".$fromDate."','".$toDate."');";
/*if (isset($_POST['date_daily'])) {
    $qr_string = "select * from view_admreport WHERE admit_date = '".$_POST['date_daily']."' ORDER BY id ASC";
} else if (isset($_POST['date_from']) && isset($_POST['date_to'])) {
    $qr_string = "select * from view_admreport WHERE "
            . "admit_date BETWEEN '".$_POST['date_from']."' AND '".$_POST['date_to']."' ORDER BY id ASC";
}*/
$query = $db->conn->query($qr_string);
$dompdf = new DOMPDF();
$dompdf->set_paper("legal", 'landscape');
$html = '
<html>
<head>
<title>Admission Report</title>
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
                    <th>Pt. Name &amp; Address</th>
                    <th>SEX</th>
                    <th>AGE</th>
                    <th>Admit Date &amp; Time</th>
                    <th>Case</th>
                    <th>Under Dr.</th>
                    <th>Assis.</th>
                    <th>Anast.</th>
                    <th>Attd. Sister</th>
                    <th>Date Of Discharge</th>
                    <th>Month</th>
                    <th>Fin. Year</th>
                </tr>
            </thead>
            <tbody>';
$i=1;
while ($row = mysqli_fetch_assoc($query)) {
    /*$case = null;
    $wd = null;
    if($row['baby_dob']==null){
        $case = $row['diog_name'].' / '.$row['treatment'];
    }else{
        $case = $row['diog_name'].' / '.$row['treatment'].' on <br/>'.date('d-m-Y',strtotime($row['baby_dob'])).' at '.$row['baby_tob'].' Sex - '.$row['baby_sex'].' Wet - '.$row['baby_weight'].' Kg';
        $wd = 'width="16%"';
    }*/
    /*$html .=
            '<tr>
            <td align="center">'.$i.'</td>
            <td align="center" width="8%">'.substr($row['reg_no'],5).'</td>
            <td width="15%">'.$row['patient_name'].'<br/>Vill-'.$row['address'].', PO - '.$row['po'].'<br/>PS - '.$row['ps'].', '.$row['dist'].'</td>
            <td align="center">'.$row['sex'].'</td>
            <td align="center">'.$row['age'].'</td>
            <td align="center" width="7%">'.date('d-M-Y',  strtotime($row['admit_date'])).'<br/>'.$row['admit_time'].'</td>
            <td '.$wd.'>'.$case.'</td>
            <td align="center" width="8%">Dr. '.$row['doc_name'].'</td>
            <td align="center">'.$row['assist'].'</td>
            <td align="center">Dr. '.$row['atd_anasth'].'</td>
            <td align="center">'.$row['atd_nurse'].'</td>
            <td align="center">'.($row['discharge_date'] == NULL?"Not Discharged":date('d-M-Y',  strtotime($row['discharge_date']))).'</td>
            <td align="center">'.date('M',  strtotime($row['admit_date'])).'</td>
            <td align="center" width="8%">'.  finYear($row['admit_date']).'</td>
          </tr>';*/
		  $html .=
            '<tr>
            <td align="center">'.$i.'</td>
            <td align="center" width="8%">'.$row['reg_no'].'</td>
            <td >'.$row['patient_name'].'</td>
            <td align="center">'.$row['sex'].'</td>
            <td align="center">'.$row['age'].'</td>
            <td align="center" width="7%">'.$row['admit_time'].'</td>
            <td width="16%">&nbsp;</td>
            <td align="center" width="8%">Dr. &nbsp</td>
            <td align="center">&nbsp</td>
            <td align="center">Dr. &nbsp</td>
            <td align="center">&nbsp</td>
            <td align="center">&nbsp</td>
            <td align="center">&nbsp</td>
            <td align="center" width="8%">&nbsp</td>
          </tr>';
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
$canvas->page_text(448,80,'ADMISSION REPORT',$font_r,12,array(0,0,0));
$canvas->page_text(870, 18, "Date : ".date('d-M-Y'),$font, 12, array(0,0,0));
$canvas->page_text(870, 35, "Time : ".date('h:i:s A'),$font, 12, array(0,0,0));
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