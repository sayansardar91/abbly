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
    $gd_name = $row['gurd_name'];
    //$add = $row['address'].", ".$row['state'].", Pin - ".$row['pin'];
    $add = $row['address'];
    $po = $row['po'];
    $ps = $row['ps'];
    $dist = $row['dist'];
    $baby_name = $row['baby_name'];
    $baby_id = $row['baby_id'];
    $baby_dob = $row['baby_dob'];
    $baby_tob = $row['baby_tob'];
    //$baby_weight = ucfirst(convert_number_to_words($row['baby_weight']))." (".$row['baby_weight'].")";
	$baby_weight = $row['baby_weight'];
    $doc_name = $row['doc_name'];
    $admit_time = date('d-m-Y',  strtotime($row['admit_time']));
    $discharge_date = $row['discharge_date'];
    $doc_reg = $row['doc_reg'];
}
if(strpos($baby_tob,"&")){
	$isBr = true;
}




$dompdf = new DOMPDF();
$dompdf->set_option('enable_html5_parser', TRUE);
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
        #reg_no {
            position: absolute;
            top: 240px;
            left: 305px;
         }
        #name {
            position: absolute;
            top:305px;
            left:150px;
         }
        #relation {
            position: absolute;
            top:310px;
            left:505px;
         }
         #gurd_name {
            position: absolute;
            top:305px;
            left:540px;
         }
         #gurd_name_1 {
            position: absolute;
            top:340px;
            left:50px;
         }
         #address {
            position: absolute;
            top:340px;
            left:425px;
         }
         #address_1 {
            position: absolute;
            top:370px;
            left:50px;
         }
         #po {
            position: absolute;
            top:372px;
            left:73px;
         }
         #ps {
            position: absolute;
            top:372px;
            left:277px;
         }
         #dist {
            position: absolute;
            top:372px;
            left:512px;
         }
         #birth_of {
            position: absolute;
            top:405px;
            left:140px;
         }
         #baby {
            position: absolute;
            top:407px;
            left:440px;
         }
         #date {
            position: absolute;
            top:444px;
            left:90px;
         }';
		 
		if($isBr){
			$html .= '#time {
            position: absolute;
            top:444px;
            left:230px;
         }';
		} else{
			$html .= '#time {
            position: absolute;
            top:444px;
            left:277px;
         }';
		}

        if($isBr){
            $html .='#kg {
            position: absolute;
            top:444px;
            left:530px;
         }';
        } else{
            $html .= '#kg {
            position: absolute;
            top:444px;
            left:550px;
         }';
        }
         
		 
         $html .='#dr {
            position: absolute;
            top:475px;
            left:160px;
         }
         #admit {
            position: absolute;
            top:510px;
            left:420px;
         }
         #dcharg {
            position: absolute;
            top:510px;
            left:560px;
         }
         #doc_reg {
            position: absolute;
            top:694px;
            left:537px;
         }
</style>
</head>

<body>
    <div>
    <div><img src="../images/dForm.jpg" width="100%" height="100%"/></div>
    <div id="reg_no">'.$reg_id.'</div>
    <div id="name">'.$patient_name.'</div>
    <div id="relation"><strong>'.$rel.'</strong></div>';
    if(strlen($gd_name)>11){
        $html .= '<div id="gurd_name_1">'.$gd_name.'</div>';
    }else{
        $html .= '<div id="gurd_name">'.$gd_name.'</div>';
    }
    if(strlen($add)>35){
        $add1 = substr($add, 0,35);
        $add2 = substr($add, 36);
        $html .= '<div id="address">'.$add1.'</div>';
        $html .= '<div id="address_1">'.$add2.'</div>';
    }else{
        $html .= '<div id="address">'.$add.'</div>';
    }
    $html .= '<div id="po">'.$po.'</div>';
    $html .= '<div id="ps">'.$ps.'</div>';
    $html .= '<div id="dist">'.$dist.'</div>';
    $html .= '<div id="birth_of">'.$baby_name.'</div>';
    $html .= '<div id="baby">'.$baby_id.'</div>';
    $html .= '<div id="date">'.date('d-m-Y',  strtotime($baby_dob)).'</div>';
    $html .= '<div id="time">'.$baby_tob.'</div>';
    $html .= '<div id="kg">'.$baby_weight.'</div>';
    $html .= '<div id="dr">'.$doc_name.'</div>';
    $html .= '<div id="admit">'.$admit_time.'</div>';
    $html .= '<div id="dcharg">'.date('d-m-Y',  strtotime($discharge_date)).'</div>';
    $html .= '<div id="doc_reg">'.$doc_reg.'</div>';
    $html .= '
</div>
</body></html>';
$dompdf->load_html($html);
$dompdf->render();

//$canvas = $dompdf->get_canvas();
//$font = Font_Metrics::get_font("helvetica", "bold");
//$canvas->page_text(280,810 , "{PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));

$dompdf->stream($reg_id.".pdf", array('Attachment' => 0));?>