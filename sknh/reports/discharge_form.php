<?php
ini_set('max_execution_time', 3000);
ini_set('memory_limit','16M');
set_include_path("../dompdf");
require_once "../lib/config.php";
require_once "../lib/database.php";
require_once "dompdf_config.inc.php";
session_start();
if (!((isset($_GET['pg']) or (isset($_SESSION['user']))))){
    header("Location: ../index.php");
}
$reg = (isset($_GET['reg_no']))?$_GET['reg_no']:"";

$db = new database();
//$req = "select * from view_dscrgform where discharge_id = '".$reg."'";
$req = "call sp_dchrgform('".$reg."');";

$query = $db->conn->query($req);
$reg_id = '';
$gd_name = '';
$add = '';
$patient_name = '';
$rel = '';
$po='';
$ps = '';
$dist='';
$baby_id=$baby_name=$baby_dob=$baby_tob='';
$baby_weight="";
$doc_name = $admit_time = $discharge_date = $doc_reg = '';
$isBr = false;
while ($row = mysqli_fetch_assoc($query)) {
    $reg_id = $row['patient_id'];
    $patient_name = $row['patient_name'];
    $rel = $row['relation'];
    $gd_name = (strlen($row['gurd_name'])<=11)?$row['gurd_name']:'';
    $gd_name1 = (strlen($row['gurd_name'])>11)?$row['gurd_name']:'&nbsp;';
	 $name_point = (strlen($row['gurd_name'])<=11)?95:112;
    //$add = $row['address'].", ".$row['state'].", Pin - ".$row['pin'];
    $add = $row['address'];
    $po = $row['po'];
    $ps = $row['ps'];
    $dist = $row['dist'];
    $baby_name = (isset($row['baby_name']))?$row['baby_name']:'N/A';
    $baby_id = (isset($row['baby_id']))?$row['baby_id']:'N/A';
    $baby_dob = (isset($row['baby_dob']))?date('d-m-Y',  strtotime($row['baby_dob'])):'N/A';
    $baby_tob = (isset($row['baby_tob']))?$row['baby_tob']:'N/A';
    //$baby_weight = ucfirst(convert_number_to_words($row['baby_weight']))." (".$row['baby_weight'].")";
	$baby_weight = (isset($row['baby_weight']))?$row['baby_weight']:'N/A';
    $doc_name = $row['doc_name'];
    $admit_time = date('d-m-Y',  strtotime($row['admit_time']));
    $discharge_date = $row['discharge_date'];
    $doc_reg = $row['doc_reg'];
}

$dompdf = new DOMPDF();
$dompdf->set_paper("A4", 'portrait');



$html = '
<html>
<head>
<title>Discharge Form</title>
 <style>
    div {line-height: 1;color:black;font-weight: bold;}
    h1, p {margin: 0;}
    h4, p {margin: 0;}
    h2, p {margin: 0;}
	span {font-style:italic; font-family:Arial, Helvetica, sans-serif;}
	.mob_no{
				text-align: right;			
			}
	.heading{
				text-transform: uppercase;
				background-color:black;
				color: white;
				font-style: italic;
				font-family: sans-serif;
				padding: 10px;
				text-align: center;
				border-radius: 5px;
				font-size: 40px;
			}
			.address_line{
				margin: 0 auto;
				text-align: center;
				margin-top: 5px;
				margin-bottom: 5px;	
				font-style: italic;
				font-family: sans-serif;	
			}
			.reg_no{
				margin: 0 auto;
				text-align: center;
				margin-top: 5px;
				margin-bottom: 5px;	
				font-style: italic;
				font-family: sans-serif;	
			}
			.dscrg_box{
				border: 2px solid #000;
				border-radius: 5px;
				margin: 0 auto;
				text-align: center;
				width: 30%;
				margin-top: 5px;
				margin-bottom: 5px;	
				font-style: italic;
				font-family: sans-serif;	
				padding: 5px;
				font-size: 20px;	
			}
			.reg_1{
				text-align: right;
				padding: 5px;
				float: left;
				width: 43%;	
			}
			.reg_2{
				float: left;
				width: 57%;	
				padding: 5px;	
			}
			.reg_id{
				border-bottom: 2px dotted #000;			
			}
			.reg_wrap{
				width:100%;		
			}
			.wrap_line_1{
				clear: left;	
			}
			.l1-col-1{
				float: left;
				width: 15%;
				margin-top: 100px;
				text-align: right;
				padding-right: 5px;
			}
			.l1-col-2{
				float: left;
				text-align: center;
				width: 55%;
				margin-top: 95px;
				border-bottom: 2px solid #000;
			}
			.l1-col-3{
				float: left;
				width: 5%;
				text-align: center;
				margin-top: 100px;
			}
			.l1-col-4{
				float: left;
				width: 25%;
				margin-top: '.$name_point.'px;
				text-align: center;
				border-bottom: 2px solid #000;
			}
			
			
			.wrap_line_2{
				clear: left;	
			}
			.l2-col-1{
				float: left;
				width: 50%;
				margin-top: 20px;
				text-align: center;
				padding-right: 5px;
				border-bottom: 2px solid #000;
				margin-left: 12px;
			}
			.l2-col-2{
				float: left;
				text-align: left;
				width: 8%;
				margin-top: 24px;
				padding-left: 10px;
			}
			.l2-col-3{
				float: left;
				width: 39%;
				text-align: center;
				margin-top: 20px;
				border-bottom: 2px solid #000;
			}
			
			.wrap_line_3{
				clear: left;	
			}
			.l3-col-1{
				float: left;
				width: 6%;
				margin-top: 24px;
				text-align: right;
				padding-right: 5px;
			}
			.l3-col-2{
				float: left;
				text-align: center;
				width: 25%;
				margin-top: 20px;
				border-bottom: 2px solid #000;
			}
			.l3-col-3{
				float: left;
				width: 5%;
				text-align: center;
				margin-top: 24px;
			}
			.l3-col-4{
				float: left;
				width: 25%;
				text-align: center;
				margin-top: 20px;
				padding-left: 5px;
				border-bottom: 2px solid #000;
			}
			.l3-col-5{
				float: left;
				width: 5%;
				text-align: left;
				margin-top: 24px;
				padding-left: 5px;
			}
			.l3-col-6{
				float: left;
				width: 32%;
				text-align: center;
				margin-top: 20px;
				padding-left: 5px;
				border-bottom: 2px solid #000;
			}
			.wrap_line_4{
				clear: left;	
			}
			.l4-col-1{
				float: left;
				width: 14%;
				margin-top: 24px;
				text-align: right;
				padding-right: 5px;
			}
			.l4-col-2{
				float: left;
				text-align: center;
				width: 40%;
				margin-top: 20px;
				border-bottom: 2px solid #000;
			}
			.l4-col-3{
				float: left;
				width: 8%;
				text-align: center;
				margin-top: 24px;
			}
			.l4-col-4{
				float: left;
				width: 37.5%;
				text-align: center;
				margin-top: 20px;
				padding-left: 5px;
				border-bottom: 2px solid #000;
			}
			.wrap_line_5{
				clear: left;	
			}
			.l5-col-1{
				float: left;
				width: 4%;
				margin-top: 24px;
				text-align: right;
				padding-right: 5px;
			}
			.l5-col-2{
				float: left;
				text-align: center;
				width: 20%;
				margin-top: 20px;
				border-bottom: 2px solid #000;
			}
			.l5-col-3{
				float: left;
				width: 4%;
				text-align: center;
				margin-top: 24px;
			}
			.l5-col-4{
				float: left;
				width: 37.5%;
				text-align: center;
				margin-top: 20px;
				padding-left: 5px;
				border-bottom: 2px solid #000;
			}
			.l5-col-5{
				float: left;
				width: 10%;
				text-align: center;
				margin-top: 24px;
			}
			.l5-col-6{
				float: left;
				width: 20%;
				text-align: center;
				margin-top: 20px;
				border-bottom: 2px solid #000;
			}
			.l5-col-7{
				float: left;
				width: 5%;
				text-align: center;
				margin-top: 24px;
			}
			.wrap_line_6{
				clear: left;	
			}
			.l6-col-1{
				float: left;
				width: 18%;
				margin-top: 24px;
				text-align: right;
				padding-right: 5px;
				margin-left: 2px;
			}
			.l6-col-2{
				float: left;
				text-align: center;
				width: 82%;
				margin-top: 20px;
				border-bottom: 2px solid #000;
			}
			
			.wrap_line_7{
				clear: left;	
			}
			.l7-col-1{
				float: left;
				width: 49.5%;
				margin-top: 24px;
				text-align: right;
				padding-right: 5px;
			}
			.l7-col-2{
				float: left;
				text-align: center;
				width: 25%;
				margin-top: 20px;
				border-bottom: 2px solid #000;
			}
			.l7-col-3{
				float: left;
				text-align: center;
				width: 4%;
				margin-top: 24px;
			}
			.l7-col-4{
				float: left;
				text-align: center;
				width: 22%;
				margin-top: 20px;
				border-bottom: 2px solid #000;
			}
			.wrap_line_8{
				clear: left;	
			}
			.l8-col-1{
				float: left;
				width: 15%;
				margin-top: 24px;
				text-align: right;
				padding-right: 5px;
				margin-left: 2px;
			}
			.l8-col-2{
				float: left;
				text-align: center;
				width: 85%;
				margin-top: 20px;
				border-bottom: 2px solid #000;
			}
			.wrap_line_9{
				clear: left;	
			}
			.l9-col-1{
				float: left;
				width: 40%;
				margin-top: 180px;
				text-align: center;
				padding-right: 5px;
				margin-left: 2px;
			}
			.wrap_line_10{
				clear: left;	
			}
			.l10-col-1{
				float: right;
				width: 32.5%;
				margin-top: 30px;
				text-align: center;
			}
			.wrap_line_11{
				clear: left;
			}
			.l11-col-1{
				float: left;
				width: 55%;
				margin-top: 50px;
				text-align: right;
				padding-right: 5px;
				margin-left: 2px;
			}
			.l11-col-2{
				float: left;
				text-align: center;
				width: 45%;
				margin-top: 50px;
			}
			.l11-col-2-1{
				float:left;
				width:50%;
				text-align: left;
				margin-left: 80px;
				margin-top: 5px;
			}
			.l11-col-2-2{
				float:right;
				width:50%;
				text-align: center;
				margin-left: 10px;
				border-bottom: 2px solid #000;
			}
			
			.wrap_line_12{
				clear: left;
			}
			.l12-col-1{
				float: left;
				width: 55%;
				margin-top: 20px;
				text-align: right;
				padding-right: 5px;
				margin-left: 2px;
			}
			.l12-col-2{
				float: left;
				text-align: center;
				width: 45%;
				margin-top: 20px;
			}
			.l12-col-2-1{
				float:left;
				width:50%;
				text-align: left;
				margin-left: 80px;
				margin-top: 5px;
			}
			.l12-col-2-2{
				float:right;
				width:50%;
				text-align: center;
				margin-left: 10px;
				border-bottom: 2px solid #000;
			}
			.wrap_line_13{
				clear: left;
			}
			.l13-col-1{
				float: left;
				width: 40%;
				margin-top: 25px;
				text-align: center;
				padding-right: 5px;
				margin-left: 2px;
			}
			.wrap_line_14{
				clear: left;
			}
			.l14-col-1{
				float: left;
				width: 40%;
				margin-top: 30px;
				text-align: center;
				padding-right: 5px;
				margin-left: 2px;
			}
			.left_logo{
				position: absolute;
            top: 110px;
            left: 30px;
            width: 100px;
            height: 100px;			
			}
			.right_logo{
				position: absolute;
            top: 110px;
            left: 570px;
            width: 100px;
            height: 100px;			
			}
</style>
</head>

<body>
    <div>
    <img src="../images/left_logo.png" class="left_logo"/>
    <img src="../images/right_logo.png" class="right_logo"/>
    <div class="mob_no">Mob. : 8759388830</div>
	 <div class="heading">Swarnakamal Nursing Home</div>
	 <div class="address_line">Vill. - Naihati, P.O. - Badartala, P.S. - Basirhat</div>
	 <div class="address_line">Dist. - 24 Pgs. (N), Pin - 743413</div>
	 <div class="reg_no">Reg. No. - 846/N/2003</div>
	 <div class="dscrg_box">Discharge Certificate</div>
	 <div class="address_line">(In case of Child Birth / Other Cases)</div>
	 <div class="reg_wrap">
	 	<div class="reg_1">Reg. No. : </div>
	 	<div class="reg_2"><span class="reg_id">'.$reg_id.'</span></div>
	 </div>
    <div class="wrap_line_1">
			<div class="l1-col-1">Certified that </div> 
			<div class="l1-col-2">'.$patient_name.'</div>
			<div class="l1-col-3"><strong>'.$rel.'</strong></div>
			<div class="l1-col-4">'.$gd_name.'</div>
	 </div>';
    $html .= '<div class="wrap_line_2">
			<div class="l2-col-1">'.$gd_name1.'</div> 
			<div class="l2-col-2">of Vill.</div>
			<div class="l2-col-3"><strong>'.$add.'</strong></div>
	 </div>';
	 
	 $html .= '<div class="wrap_line_3">
			<div class="l3-col-1">P.O.</div> 
			<div class="l3-col-2">'.$po.'</div>
			<div class="l3-col-3">P.S.</div>
			<div class="l3-col-4">'.$ps.'</div> 
			<div class="l3-col-5">Dist.</div>
			<div class="l3-col-6">'.$dist.'</div>
	 </div>';
	 
	 $html .= '<div class="wrap_line_4">
			<div class="l4-col-1">gave Birth of </div> 
			<div class="l4-col-2">'.$baby_name.'</div>
			<div class="l4-col-3">(baby)</div>
			<div class="l4-col-4">'.$baby_id.'</div> 
	 </div>';
	 
	 $html .= '<div class="wrap_line_5">
			<div class="l5-col-1">on </div> 
			<div class="l5-col-2">'.$baby_dob.'</div>
			<div class="l5-col-3">at</div>
			<div class="l5-col-4">'.$baby_tob.'</div> 			
			<div class="l5-col-5"> weighing </div>
			<div class="l5-col-6">'.$baby_weight.'</div>
			<div class="l5-col-7">Kg</div> 
	 </div>';
	 
	 $html .= '<div class="wrap_line_6">
			<div class="l6-col-1">under Doctor Dr. </div> 
			<div class="l6-col-2">'.$doc_name.'</div>
	 </div>';
	 
	 $html .= '<div class="wrap_line_7">
			<div class="l7-col-1">in this SWARNAKAML NURSING HOME from</div> 
			<div class="l7-col-2">'.$admit_time.'</div>
			<div class="l7-col-3">to</div>
			<div class="l7-col-4">'.date('d-m-Y',  strtotime($discharge_date)).'</div>
	 </div>';
	 
	 $html .= '<div class="wrap_line_8">
			<div class="l8-col-1">suffering from </div> 
			<div class="l8-col-2">&nbsp;</div>
	 </div>';
	
	 $html .= '<div class="wrap_line_9">
			<div class="l9-col-1">Signature of father / Guardian</div> 
	 </div>';
	 $html .= '<div class="wrap_line_10">
			<div class="l10-col-1">Signature of Doctor</div> 
	 </div>';
	 $html .= '<div class="wrap_line_11">
	 		<div class="l11-col-1">&nbsp;</div>
			<div class="l11-col-2">
					<div class="l11-col-2-1">Regn. No.:</div>
					<div class="l11-col-2-2">'.$doc_reg.'</div>
			</div> 
	 </div>';
	 
	 $html .= '<div class="wrap_line_12">
	 		<div class="l12-col-1">&nbsp;</div>
			<div class="l12-col-2">
					<div class="l12-col-2-1">Date:</div>
					<div class="l12-col-2-2">&nbsp;</div>
			</div> 
	 </div>';
    
    $html .= '<div class="wrap_line_13">
			<div class="l13-col-1">Attested</div> 
	 </div>';
	 
	 $html .= '<div class="wrap_line_14">
			<div class="l14-col-1">Signature of Doctor</div> 
	 </div>';
	 
    $html .= '</div></body></html>';
$dompdf->load_html($html);
$dompdf->render();

//$canvas = $dompdf->get_canvas();
//$font = Font_Metrics::get_font("helvetica", "bold");
//$canvas->page_text(280,810 , "{PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));

$dompdf->stream($reg_id.".pdf", array('Attachment' => 0));?>