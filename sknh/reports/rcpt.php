<?php

set_include_path("../dompdf");
require_once "../lib/config.php";
require_once "../lib/database.php";
require_once "dompdf_config.inc.php";
date_default_timezone_set('Asia/Kolkata');
session_start();
if (!((isset($_GET['pg']) or (isset($_SESSION['user']))))){
    header("Location: ../index.php");
}
$bill_no = $_GET['bill_no'];


$db = new database();
$req = "select * from view_bill WHERE bill_no = '".$bill_no."';";

$query = $db->conn->query($req);

$reg_no=$patient_name = $bed_name = $billno = $payment_date = $payble_amount = $total_amount = $amount_paid = $new_bal = null;

while ($row = mysqli_fetch_assoc($query)) {
    $reg_no = $row['reg_no'];
    $patient_name = $row['patient_name'];
    $bed_name = $row['bed_name'];
    $billno = $row['bill_no'];
    $payment_date = date('d-M-Y',  strtotime($row['payment_date']));
    $payble_amount = $row['payble_amount'];
    $total_amount = $row['total_amount'];
    $amount_paid = $row['amount_paid'];
    $new_bal = $row['new_bal'];
}

$dompdf = new DOMPDF();
$dompdf->set_paper("A4", 'portrait');
$html = '
<html>
<head>
<title>Cash Receipt</title>
<link rel="icon" type="image/ico" href="' . FAV_ICON . '" />
 <style>
    h1, p {margin: 0;}
    h4, p {margin: 0;}
    h2, p {margin: 0;}
    body{
		margin-top: 0px;	
	}
	div{
		font-size:13px;
		font-weight: bold;
                font-family: "Times New Roman", Times, serif;
	}
        #date{
		position: absolute;
		top: 133px;
		left: 190px;
	}
        #date1{
		position: absolute;
		top: 568px;
		left: 190px;
	}
        #rcpt{
		position: absolute;
		top: 133px;
		left: 500px;
	}
        #rcpt1{
		position: absolute;
		top: 568px;
		left: 500px;
	}
        #pmtof{
		position: absolute;
		top: 161px;
		left: 350px;
	}
        #pmtof1{
		position: absolute;
		top: 596px;
		left: 350px;
	}
        #ptid{
		position: absolute;
		top: 190px;
		left: 225px;
	}
        #ptid1{
		position: absolute;
		top: 625px;
		left: 225px;
	}
        #bed{
		position: absolute;
		top: 190px;
		left: 455px;
	}
        #bed1{
		position: absolute;
		top: 625px;
		left: 455px;
	}
        #amtpaid{
		position: absolute;
		top: 220px;
		left: 300px;
	}
        #amtpaid1{
		position: absolute;
		top: 655px;
		left: 300px;
	}
        #amtword{
		position: absolute;
		top: 248px;
		left: 225px;
	}
        #amtword1{
		position: absolute;
		top: 683px;
		left: 225px;
	}
        #amtdue{
		position: absolute;
		top: 283px;
		left: 225px;
	}
        #amtdue1{
		position: absolute;
		top: 718px;
		left: 225px;
	}
        #amtpd{
		position: absolute;
		top: 300px;
		left: 225px;
	}
        #amtpd1{
		position: absolute;
		top: 735px;
		left: 225px;
	}
        #newbal{
		position: absolute;
		top: 330px;
		left: 225px;
	}
        #newbal1{
		position: absolute;
		top: 765px;
		left: 225px;
	}
	#whiteDIV{
		width: 200px;
		height: 80px;
		position: absolute;
		top: 280px;
		left: 149px;
		background-color: white;
	}
	#whiteDIV2{
		width: 200px;
		height: 80px;
		position: absolute;
		top: 716px;
		left: 149px;
		background-color: white;
	}
</style>
</head>

<body style="font-weight: bold">
<img src="../images/rcpt1.png" width="100%" height="100%"/>
<div id="date">'.$payment_date.'</div>
<div id="date1">'.$payment_date.'</div>
<div id="rcpt">'.$billno.'</div>
<div id="rcpt1">'.$billno.'</div>
<div id="pmtof">'.$patient_name.'</div>
<div id="pmtof1">'.$patient_name.'</div>
<div id="ptid">'.$reg_no.'</div>
<div id="ptid1">'.$reg_no.'</div>
<div id="bed">'.$bed_name.'</div>
<div id="bed1">'.$bed_name.'</div>
<div id="amtpaid">Rs. '.$payble_amount.' /-</div>
<div id="amtpaid1">Rs. '.$payble_amount.' /-</div>
<div id="amtword">'.ucfirst(convert_number_to_words($payble_amount)).'</div>
<div id="amtword1">'.ucfirst(convert_number_to_words($payble_amount)).'</div>
<div id="amtdue">'.$total_amount.' /-</div>
<div id="amtdue1">'.$total_amount.' /-</div>
<div id="amtpd">'.$amount_paid.' /-</div>
<div id="amtpd1">'.$amount_paid.' /-</div>
<div id="newbal">'.$new_bal.' /-</div>
<div id="newbal1">'.$new_bal.' /-</div>
<div id="whiteDIV"></div>
<div id="whiteDIV2"></div>
</body></html>';

$dompdf->load_html($html);
$dompdf->render();
//
//$canvas = $dompdf->get_canvas();
//$font = Font_Metrics::get_font("helvetica", "bold" , "underline");
//$canvas->page_text(298, 800, "{PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0, 0, 0));

$dompdf->stream("cashreceipt.pdf", array('Attachment' => 0));
?>



