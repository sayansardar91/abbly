<?php
ini_set('max_execution_time', 3000);
ini_set('memory_limit','200M');
set_include_path("../dompdf");
require_once "../lib/config.php";
require_once "../lib/database.php";
require_once '../lib/MyDateTime.php';
require_once "dompdf_config.inc.php";
$mdate = new MyDateTime();
$mdate->setDate(date('Y'), date('m'), date('d'));
$result = $mdate->fiscalYear();
$start = $result['start']->format('Y');
$end = $result['end']->format('y');
$finyear = $start . "-" . $end;
$docCherg = null;
$chrgTp = 0;
session_start();
if (!((isset($_GET['pg']) or ( isset($_SESSION['user']))))) {
    header("Location: ../index.php");
}
if($_SESSION['type'] != 1){
    $docCherg = " AND `chrg_type` <> 1 ";
    $chrgTp = 1;
}
$_POST = array_filter($_POST);
$db = new database();

$qr_string = null;
$where_string = null;
$head_field = null;
$row_field = null;
$qr_string = "select CASE 
                       WHEN `chrg_type` = 1 THEN 'Doctor' 
                       WHEN `chrg_type` = 2 THEN 'Marketing'
                       WHEN `chrg_type` = 3 THEN 'Cooking'
                       WHEN `chrg_type` = 4 THEN 'Gas'
                       WHEN `chrg_type` = 5 THEN 'Anaesthetist'
                       WHEN `chrg_type` = 6 THEN 'Employee'
                       WHEN `chrg_type` = 7 THEN 'Electric'
                       WHEN `chrg_type` = 8 THEN 'Patient'
                       WHEN `chrg_type` = 9 THEN 'Building Maintenance'
                       WHEN `chrg_type` = 10 THEN 'OT Maintenance'
                       WHEN `chrg_type` = 11 THEN 'OT Other Expense'
                       WHEN `chrg_type` = 12 THEN 'Medicine Expense'
                       WHEN `chrg_type` = 13 THEN 'Other Expense'
                       END  `chrg_type`, 
                       `tot_expense`, `chrg_remarks`,`exp_date`,`exp_month`,`fin_year` from nhm_expense";
if (isset($_POST['date_daily'])) {
    $qr_string .= " where `exp_date` = '" . $_POST['date_daily'] . "'";
    $head_field = '<th>Expense Details</th>';
} else if (isset($_POST['date_from']) && isset($_POST['date_to'])) {
    $db->conn->query("Call sp_vExp(".$chrgTp.");");
    $where_string = "BETWEEN '" . $_POST['date_from'] . "' AND '" . $_POST['date_to'] . "'".$docCherg;
    //$qr_string = "select *from nhm_expense where `exp_date` " . $where_string;
    $qr_string .= " where `exp_date` " . $where_string;
    $head_field = '<th>Expense Details</th>';
} else if (isset($_POST['exp_month']) && !isset($_POST['exp_year'])) {
    $db->conn->query("Call sp_vExp(".$chrgTp.");");
    $qr_string .= " where `exp_month` = '" . $_POST['exp_month'] . "' AND `fin_year` = '" . $finyear . "'";
    $head_field = '<th>Expense Details</th>';
} else if (isset($_POST['exp_month']) && isset($_POST['exp_year'])) {
    $db->conn->query("Call sp_vExp(".$chrgTp.");");
    $qr_string .= " where `exp_month` = '" . $_POST['exp_month'] . "' AND `fin_year` = '" . $_POST['exp_year'] . "'";
    $head_field = '<th>Expense Details</th>';
}else if(isset($_POST['exp_year'])){
    $db->conn->query("Call sp_vExp(".$chrgTp.");");
    $qr_string = "SELECT * FROM (select GROUP_CONCAT(Distinct CASE 
                       WHEN `chrg_type` = 1 THEN 'Doctor' 
                       WHEN `chrg_type` = 2 THEN 'Marketing'
                       WHEN `chrg_type` = 3 THEN 'Cooking'
                       WHEN `chrg_type` = 4 THEN 'Gas'
                       WHEN `chrg_type` = 5 THEN 'Anaesthetist'
                       WHEN `chrg_type` = 6 THEN 'Employee'
                       WHEN `chrg_type` = 7 THEN 'Electric'
                       WHEN `chrg_type` = 8 THEN 'Patient'
                       WHEN `chrg_type` = 9 THEN 'Building Maintenance'
                       WHEN `chrg_type` = 10 THEN 'OT Maintenance'
                       WHEN `chrg_type` = 11 THEN 'OT Other Expense'
                       WHEN `chrg_type` = 12 THEN 'Medicine Expense'
                       WHEN `chrg_type` = 13 THEN 'Other Expense'
                       END SEPARATOR ',') chrg_type,sum(tot_expense) tot_expense,exp_month,fin_year from nhm_expense where fin_year = '".$_POST['exp_year']."' GROUP BY exp_month) result 
                      ORDER BY FIELD(exp_month,'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec')";
}

$query = null;
$rowcount = null;
if ($qr_string != null) {
    $query = $db->conn->query($qr_string);
    $rowcount = mysqli_num_rows($query);
}


$dompdf = new DOMPDF();
$dompdf->set_paper("A4", 'portrait');



$html = '
<html>
<head>
<title>Expense Report</title>
<link rel="icon" type="image/ico" href="' . FAV_ICON . '" />
 <style>
    h1, p {margin: 0;}
    h4, p {margin: 0;}
    h2, p {margin: 0;}
	span {font-style:italic; font-family:Arial, Helvetica, sans-serif;}
        table {
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black;
    margin-top: 10px;
}
#date {
            position: absolute;
            top: -20px;
            left:580px;
         }
</style>
</head>

<body>
    <div>
        <div id="date">Date : ' . date('d-m-Y') . '</div>
    	<div align="center"><h2>SWARNAKAMAL NURSING HOME</h2></div>
        <div>
            <div align="center"><h4>NAIHATI, P.O.- BADARTALA, NORTH 24 PARGANAS</h4></div>
            <div align="center" style="margin-top: 10px"><u>Expense Report</u></div>
        </div>
    </div>
	
	<table width="100%">
            <thead>
                <tr >
                    <th>S/No.</th>
                    <th>Expense Type</th>' . $head_field . '
                    <th>Total Expense</th>
                    <th>Expense Date</th>
                    <th>Expense Month</th>
                    <th>Financial Year</th>
                </tr>
            </thead>
            <tbody>';
$i = 1;
$total = 0;
$colspan = null;
$colspan1 = null;
$chrgRemarks = null;
if ($query != null) {
    if ($rowcount > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $chrgRemarks = null;
            if (isset($row['chrg_remarks'])) {
                if($row['chrg_type']== "Doctor"){
                    $rComa = explode(',', $row['chrg_remarks']);
                    foreach ($rComa as $key => $value) {
                        $rDash = explode('-', $value);
                        $qString = "SELECT `doc_name` FROM `doc_details` WHERE `id` = ".$rDash[0];
                        $qr = $db->conn->query($qString);
                        while ($rw = mysqli_fetch_assoc($qr)) {
                            $chrgRemarks .= ucwords(strtolower(trim($rw['doc_name'])))." - Rs.".trim($rDash[1])."/- <br/>";
                        }
                    }
                }else{
                    $chrgRemarks = $row['chrg_remarks'];
                }
                
                $html .=
                        '<tr>
            <td align="center">' . $i . '</td>
            <td align="center">' . $row['chrg_type'] . '</td>
            <td align="left" style="width: 220px;">' . $chrgRemarks . '</td>
            <td align="center">Rs.' . $row['tot_expense'] . '/-</td>
            <td align="center">' . date('d-m-y', strtotime($row['exp_date'])) . '</td>
            <td align="center">' . $row['exp_month'] . '</td>
            <td align="center">' . $row['fin_year'] . '</td>
          </tr>';
                $colspan = 3;
                $colspan1 = 3;
            } else if(isset($row['exp_date'])){
                $html .=
                        '<tr>
            <td align="center">' . $i . '</td>
            <td align="left">' . implode(",",  array_unique(explode(",",$row['chrg_type']))) . '</td>
            <td align="center">Rs.' . $row['tot_expense'] . '/-</td>
            <td align="center">' . date('d-m-Y', strtotime($row['exp_date'])) . '</td>
            <td align="center">' . $row['exp_month'] . '</td>
            <td align="center">' . $row['fin_year'] . '</td>
          </tr>';
                $colspan = 2;
                $colspan1 = 3;
            }else {
                $html .=
                        '<tr>
            <td align="center">' . $i . '</td>
            <td align="left">' . implode(",",  array_unique(explode(",",$row['chrg_type']))) . '</td>
            <td align="center">Rs.' . $row['tot_expense'] . '/-</td>
            <td align="center"> '.date('M-01', strtotime($row['exp_month'])).' to '.date('M-t', strtotime($row['exp_month'])).' </td>
            <td align="center">' . $row['exp_month'] . '</td>
            <td align="center">' . $row['fin_year'] . '</td>
          </tr>';
                $colspan = 2;
                $colspan1 = 3;
            }

            $total = $total + $row['tot_expense'];
            $i++;
        }
        $html .= '<tr><td colspan="' . $colspan . '" align="right">Total Expense :&nbsp;</td><td align="center">Rs.' . $total . '/-</td><td colspan="' . $colspan1 . '">&nbsp;</td></tr>';
    } else {
        $html .= '<tr><td colspan="7" align="center">No Records Found</td></tr>';
    }
} else {
    $html .= '<tr><td colspan="7" align="center">No Records Found</td></tr>';
}


$html .= '</tbody></table></div></body></html>';


$dompdf->load_html($html);
$dompdf->render();

$canvas = $dompdf->get_canvas();
$font = Font_Metrics::get_font("helvetica", "bold");
$canvas->page_text(280, 810, "{PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0, 0, 0));

$dompdf->stream("discharge.pdf", array('Attachment' => 0));
?>


