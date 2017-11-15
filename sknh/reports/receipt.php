<?php

set_include_path("../dompdf");
require_once "../lib/config.php";
require_once "../lib/database.php";
require_once "dompdf_config.inc.php";
session_start();
if (!((isset($_GET['pg']) or ( isset($_SESSION['user']))))) {
    header("Location: ../index.php");
}
$bill_no = $_GET['bill_no'];

$chrg_array = array( '1' => "Doctor Charge", '2' => "OT Major", '3' => "OT Minor",
                     '4' => "OT Ortho",'5' => "OT C-ARM", '6' => "Medicine (OT + Ward + Other)",
                     '7' => "Baby Doctor Charge", '8' => "Baby Medicine",'9' => "Baby Other Charge",
                     '10' => "Bed Charge",'11' => "Extra Bed Charge",'12' => "Private Attendent",
                     '13' => "Labour Room Charge",'14' => "Nursing Home Charge",'15' => "Others Charge");

$db = new database();
$req = "select distinct fb.bill_date,fb.reg_no,vadm.patient_name,vadm.doc_name,pmt.total_amount,pmt.amount_paid from final_bill fb "
        . " LEFT JOIN view_admreport vadm ON fb.reg_no = vadm.reg_no"
        . " LEFT JOIN patient_payment pmt ON fb.reg_no = pmt.reg_no"
        . " WHERE fb.bill_no = '".$bill_no."';";
$query = $db->conn->query($req);
$reg_no = $pt_name = $doc_name = $total_amount = $amount_paid = $due_amount = $amt_paid =  $bill_date = null;
while ($row = mysqli_fetch_assoc($query)) {
    $reg_no = $row['reg_no'];
    $pt_name = $row['patient_name'];
    $doc_name = "Dr. ".$row['doc_name'];
    $total_amount = 'Rs. '.$row['total_amount'].' /-';
    //$amount_paid = 'Rs. '.$row['amount_paid'].' /-';
    $amt_paid = ucfirst(convert_number_to_words($row['total_amount']));
    $bill_date = $row['bill_date'];
    //$due_amount = ($total_amount == $amount_paid)?'Full Paid': 'Rs. '.($row['total_amount'] - $row['amount_paid']).' /-';
}



$dompdf = new DOMPDF();
$dompdf->set_paper("A4", 'portrait');



$html = '
<html>
<head>
<title>Patient Bill-'.$bill_no.'</title>
 <style>
    //div {line-height: 1;color:#0033FF;}
    h1, p {margin: 0;}
    h4, p {margin: 0;}
    h2, p {margin: 0;}
	span {font-style:italic; font-family:Arial, Helvetica, sans-serif;}
    
    #reg_label {
            position: absolute;
            top: 130px;
         }
    #reg_no {
            position: absolute;
            top: 127px;
            left:120px;
         }
    #reg_blank {
            position: absolute;
            top: 130px;
            left:112px;
         }
    #name_label {
            position: absolute;
            top: 155px;
         }
    #name {
            position: absolute;
            top: 150px;
            left:135px;
         }
    #name_blank{
            position: absolute;
            top: 155px;
            left:114px;
         }
    #doc_name_label {
            position: absolute;
            top: 155px;
            left: 305px
         }
    #doc_name {
            position: absolute;
            top: 150px;
            left:375px;
         }
    #doc_name_blank{
            position: absolute;
            top: 155px;
            left:355px;
         }
         table, th, td {
    //border: 1px solid black;
    margin-top: 100px;
}
</style>
</head>

<body>
    <div>
    	<div align="center"><h1>SWARNAKAMAL NURSING HOME</h1></div>
        <div>
            <div align="center"><h4>NAIHATI, P.O.-BADARTALA, NORTH 24 PARGANAS</h4></div>
        </div>
        <div>&nbsp;</div>
        <div>
        	 <div align="center"><h2><strong><u>Patient Bill</u></strong></h2></div>
        </div>
    </div>
        
    	<div id="reg_label">Registration No :</div>
        <div id="reg_no"><span style="color:black;">'.$reg_no.'</span></div>
        <div id="reg_blank">..............................................</div>
        <div id="name_label">Name of Patient : </div>
        <div id="name"><span style="color:black;">'.$pt_name.'</span></div>
        <div id="name_blank">..............................................</div>
        <div id="doc_name_label">Under </div>
        <div id="doc_name"><span style="color:black;">'.$doc_name.'</span></div>
        <div id="doc_name_blank">..............................................</div>
        <table width="100%">
            <thead>
                <tr >
                    <td align="center"><b><u>S/No.</u></b></td>
                    <td><b><u>Charge Type</u></b></td>
                    <td><b><u>Charge Details</u></b></td>
                    <td><b><u>Charges</u></b></td>
                </tr>
            </thead>
            <tbody>';
$req = "select * from patient_account WHERE patient_id IN ( Select id FROM patient_details WHERE reg_no = '".$reg_no."') ORDER BY `chrg_type` ";

$query = $db->conn->query($req);
$i = 1;
while ($row = mysqli_fetch_assoc($query)) {
            $html .= '<tr>
            <td align="center">'.$i.'</td>
            <td align="left">'.$chrg_array[$row['chrg_type']].'</td>
            <td align="left">'.$row['remarks'].'</td>
            <td align="left">Rs. '.$row['org_chrg'].'/-</td>
            </tr>';
            $i++;
}

$html .= '<tr><td colspan="3" align="right">Total Charge :</td><td align="left">'.$total_amount.'</td></tr>';
$html .= '<tr><td colspan="3" align="right">Amount Paid :</td><td align="left">'.$total_amount.'</td></tr>';
//$html .= '<tr><td colspan="3" align="right">Amount Due :</td><td align="left">'.$due_amount.'</td></tr>';
$html .= '<tr><td colspan="3">&nbsp;</td></tr>';
$html .= '<tr><td colspan="3">Paid Amount In Words : Rupees '.$amt_paid.' Only </td></tr>';
$html .= '</tbody></table></body></html>';
$dompdf->load_html($html);
$dompdf->render();

$canvas = $dompdf->get_canvas();
$font = Font_Metrics::get_font("helvetica", "bold");
$canvas->page_text(480, 20, "Bill Date : " . date('d-M-Y',strtotime($bill_date)), $font, 10, array(0, 0, 0));
$canvas->page_text(20, 20, "Bill No : " . $bill_no, $font, 10, array(0, 0, 0));
$canvas->page_text(480, 750, "Authority Sign", $font, 10, array(0, 0, 0));

$dompdf->stream($bill_no . ".pdf", array('Attachment' => 0));
?>


