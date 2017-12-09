<?php
ini_set('max_execution_time', 3000);
ini_set('memory_limit','200M');
set_include_path("../dompdf");
require_once "../lib/config.php";
require_once "../lib/database.php";
require_once "dompdf_config.inc.php";
session_start();
if (!((isset($_GET['pg']) or (isset($_SESSION['user']))))){
    header("Location: ../index.php");
}
$from = (isset($_GET['from']))?date('Y-m-d',  strtotime($_GET['from'])):"";
$to = (isset($_GET['to']))?date('Y-m-d',  strtotime($_GET['to'])):$from;

$db = new database();
$req = "select * from view_discharge where date(`discharge_date`) between date('".$from."') and date('".$to."')";

$query = $db->conn->query($req);
$dompdf = new DOMPDF();
$dompdf->set_option('enable_html5_parser', TRUE);
$dompdf->set_paper("A4", 'landscape');



$html = '
<html>
<head>
<title>Discharge Report</title>
<link rel="icon" type="image/ico" href="'.FAV_ICON.'" />
 <style>
    div {line-height: 1; font-weight:bold;}
    h1, p {margin: 0;}
    h4, p {margin: 0;}
    h2, p {margin: 0;}
	span {font-style:italic; font-family:Arial, Helvetica, sans-serif;}
        table {
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black;
}
</style>
</head>

<body>
    <div>
    	<div align="center"><h2>SWARNAKAMAL NURSING HOME</h2></div>
        <div>
            <div align="center"><h4>NAIHATI, P.O.- BADARTALA, NORTH 24 PARGANAS</h4></div>
            <div align="center" style="margin-top: 10px"><u>DISCHARGE REPORT</u></div>
        </div>
    </div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<table width="100%">
            <thead>
                <tr >
                    <th data-field="id" data-halign="center" data-align="center" >S/No.</th>
                    <th data-field="discharge_id" data-halign="center" data-align="center">Discharge ID</th>
                    <th data-field="patient_id" data-halign="center" data-align="center" >Registration No</th>
                    <th data-field="patient_name_add" data-halign="center" data-align="center">Patient <br/> Name &amp; Address</th>
                    <th data-field="discharge_date" data-halign="center" data-align="center" >Discharge Date</th>
                    <th data-field="gurd_name" data-halign="center" data-align="center" >Guardian Name</th>
                    <th data-field="admit_time" data-halign="center" data-align="center">Admission <br/> Date &amp; Time</th>
                    <th data-field="diog_name" data-halign="center" data-align="center" >Case</th>
                    <th data-field="doc_name" data-halign="center" data-align="center" >Attending Doctor</th>
                </tr>
            </thead>
            <tbody>';
            $x=1;
            while ($row = mysqli_fetch_assoc($query)) {
                $html .= 
                '<tr data-index="0">
                    <td style="text-align: center; ">'.$x.'</td>
                    <td style="text-align: center; ">'.$row['discharge_id'].'</td>
                    <td style="text-align: center; ">'.$row['patient_id'].'</td>
                    <td style="text-align: left;" width="22%">'.$row['patient_name_add'].'</td>
                    <td style="text-align: center; ">'.date('d-m-Y',  strtotime($row['discharge_date'])).'</td>
                    <td style="text-align: center; ">'.$row['gurd_name'].'</td>
                    <td style="text-align: center; ">'.$row['admit_time'].'</td>
                    <td style="text-align: center; ">'.$row['diog_name'].'</td>
                    <td style="text-align: center; ">Dr. '.$row['doc_name'].'</td>
                </tr>';
                $x++;
            }
                
            $html .= '</tbody></table></div></body></html>';

$dompdf->load_html($html);
$dompdf->render();

$canvas = $dompdf->get_canvas();
$font = Font_Metrics::get_font("helvetica", "bold");
$canvas->page_text(390,565 , "{PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));

$dompdf->stream("discharge.pdf", array('Attachment' => 0));?>


