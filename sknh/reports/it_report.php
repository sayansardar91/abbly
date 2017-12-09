<?php

ini_set('max_execution_time', 0);
ini_set('memory_limit', '512M');
set_include_path("../dompdf");
require_once "../lib/config.php";
require_once "../lib/database.php";
require_once "../lib/admission.php";
require_once "dompdf_config.inc.php";
date_default_timezone_set('Asia/Kolkata');
session_start();
if (!((isset($_GET['pg']) or ( isset($_SESSION['user']))))) {
    header("Location: ../index.php");
}

$_POST = array_filter($_POST);


$from = $_POST['exp_from'];
$to = $_POST['exp_to'];


$adm = new admission();
$db = new database();
$req = "select *from view_itreport WHERE discharge_date BETWEEN '$from' AND '$to' ORDER BY discharge_date ASC";

$query = $db->conn->query($req);
$dompdf = new DOMPDF();
$dompdf->set_option('enable_html5_parser', TRUE);
$dompdf->set_paper("legal", 'landscape');
$html = '
<html>
<head>
<title>IT Report</title>
<link rel="icon" type="image/ico" href="' . FAV_ICON . '" />
 <style>
    div {line-height: 1; font-weight:bold;}
    h1, p {margin: 0;}
    h4, p {margin: 0;}
    h2, p {margin: 0;}
	span {font-style:italic; font-family:Arial, Helvetica, sans-serif;}
        table {
    border-collapse: collapse;
}
body {
    margin-top: 100px;
    }
table, th, td {
    border: 1px solid black;
    margin-top: 10px;
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
                    <th>No. of Issue</th>
                    <th>Under Dr.</th>
                    <th>Attd. Sister</th>
                    <th>Bed Charge</th>
                    <th>OT Rent</th>
                    <th>Total</th>
                    <th>Bill No.</th>
                    <th>Date Of Discharge</th>
                </tr>
            </thead>
            <tbody>';
$i = 1;
$count = 0;
$countmn = 0;
$total = 0;
$cntr = 1;
$total_ot = 0;
$total_bed = 0;
while ($row = mysqli_fetch_assoc($query)) {
    $str_ot = $row['ot_chrg'];
    preg_match_all('!\d+!', $str_ot, $matches);
    $total_ot = $total_ot + array_sum($matches[0]);
    $total_bed = $total_bed + $row['bed_charge'];
    $first = $emp_l = $emp = null;
    if (isset($row['emp_name'])) {
        $first = substr($row['emp_name'], 0, 1);
        $emp_l = explode("  ", $row['emp_name']);
        $emp = $first . ' ' . $emp_l[1];
    }else{
        $emp = "";
    }

    $html .=
            '<tr>
            <td align="center">' . $i . '</td>
            <td align="center" width="7%">' . substr($row['reg_no'], 5) . '</td>
            <td width="20%">' . $row['patient_name'] . '<br/>Vill-' . $row['address'] . ', PO - ' . $row['po'] . '<br/>PS - ' . $row['ps'] . ', ' . $row['dist'] . '</td>
            <td align="center">' . $row['sex'] . '</td>
            <td align="center">' . $row['age'] . '</td>
            <td align="center" width="8%">' . date('d-m-Y', strtotime($row['admit_date'])) . '<br/>' . $row['admit_time'] . '</td>
            <td align="left" width="9%">' . $row['treatment'] . '</td>
            <td align="center">' . substr($row['diog_name'], 0, 3) . '</td>
            <td align="center">' . 'Dr. ' . $row['doc_name'] . '</td>
            <td align="center">' . $emp . '</td>
            <td align="center" width="8%">Rs. ' . $row['bed_charge'] . '/-</td>
            <td align="center" width="7%">' . $row['ot_chrg'] . '</td>
            <td align="center" width="15%">Rs. ' . $row['tot_chrg'] . '/-</td>
            <td align="center">'.$adm->getBillNo($row['reg_no']).'</td>
            <td align="center">' . ($row['discharge_date'] != null ? date('d-M-Y', strtotime($row['discharge_date'])) : "") . '</td>
          </tr>';
    $total = $total + $row['tot_chrg'];
    $i++;
}

$html .= '<tr><td colspan="10" align="right">Total : </td>'
        . '<td align="center">Rs. ' . $total_bed . '/-</td>'
        . '<td align="center">Rs.' . $total_ot . '/-</td>'
        . '<td align="center" >Rs.' . $total . '/-</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
$html .= '</tbody></table></div></body></html>';


$dompdf->load_html($html);
$dompdf->render();

$canvas = $dompdf->get_canvas();
$font = Font_Metrics::get_font("helvetica", "bold", "underline");
$font_r = Font_Metrics::get_font("helvetica", "bold");
$canvas->page_text(350, 20, 'SWARNAKAMAL NURSING HOME', $font, 19, array(0, 0, 0));
$canvas->page_text(358, 45, 'NAIHATI, P.O.- BADARTALA, NORTH 24 PARGANAS', $font, 12, array(0, 0, 0));
$canvas->page_text(448, 80, 'IT - REPORT', $font_r, 12, array(0, 0, 0));
$canvas->page_text(870, 18, "Date : " . date('d-M-Y'), $font, 12, array(0, 0, 0));
$canvas->page_text(870, 35, "Time : " . date('h:i:s A'), $font, 12, array(0, 0, 0));
$canvas->page_text(480, 578, "{PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0, 0, 0));

$dompdf->stream("IT Report.pdf", array('Attachment' => 0));
?>




