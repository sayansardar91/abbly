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

$brt_sno = $reg;
$db = new database();
$req = "select * from baby_details where baby_id = '$reg'";

$query = $db->conn->query($req);


$dompdf = new DOMPDF();
$dompdf->set_option('enable_html5_parser', TRUE);
$dompdf->set_paper(array(0,0,591,827), 'landscape');

$bb_sex = null;

$html = '<html>
<head>
    <style>
    @page { margin: 0px; }
    img {margin:0px;padding:0px}
      #dob {
            position: absolute;
            top: 120px;
            left: 350px;
            font-weight: bold;
            font-size: 15px;
         }
        #bbsex {
            position: absolute;
            top: 140px;
            left: 350px;
            font-weight: bold;
         }
        #bbname {
            position: absolute;
            top: 155px;
            left: 230px;
            font-weight: bold;
         }
         #bbfather {
            position: absolute;
            top: 215px;
            left: 280px;
            font-weight: bold;
         }
         #f_adhar{
            position: absolute;
            top: 250px;
            left: 130px;
            font-weight: bold;
            width: 305px;
         }
         #bbmather {
            position: absolute;
            top: 275px;
            left: 280px;
            font-weight: bold;
         }
         #m_adhar{
            position: absolute;
            top: 310px;
            left: 130px;
            font-weight: bold;
            width: 305px;
         }

         #bbadd2 {
            position: absolute;
            top: 370px;
            left: 200px;
            font-weight: bold;
            width: 300px;
         }
         #bbad2 {
            position: absolute;
            top: 430px;
            left: 200px;
            font-weight: bold;
            width: 300px;
         }
         #pobh {
            position: absolute;
            top: 335px;
            left: 200px;
         }
         #pobi {
            position: absolute;
            top: 520px;
            left: 135px;
         }
         #pobhi_add{
            position: absolute;
            top: 510px;
            left: 255px;
            width: 200px;
            font-size: 14px;
            font-weight: bold;
         }
         #pobhs {
            position: absolute;
            top: 544px;
            left: 140px;
         }
         #pobhs_add{
            position: absolute;
            top: 549px;
            left: 320px;
            width: 100px;
         }
         #pobo {
            position: absolute;
            top: 335px;
            left: 340px;
         }
         #addpbl1 {
            position: absolute;
            top: 370px;
            left: 250px;
            font-weight: bold;
         }
         #addpbl2 {
            position: absolute;
            top: 390px;
            left: 80px;
            font-weight: bold;
         }
         #addinf1 {
            position: absolute;
            top: 410px;
            left: 250px;
            font-weight: bold;
         }
         #addinf2 {
            position: absolute;
            top: 430px;
            left: 80px;
            font-weight: bold;
         }
         
         #vil {
            position: absolute;
            top: 320px;
            left: 650px;
         }
         #town {
            position: absolute;
            top: 320px;
            left: 550px;
         }
         #add {
            position: absolute;
            top: 247px;
            left: 700px;
            font-weight: bold;
            width:120px;
         }
         #dist {
            position: absolute;
            top: 337px;
            left: 700px;
            font-weight: bold;
         }
         #state {
            position: absolute;
            top: 357px;
            left: 700px;
            font-weight: bold;
         }
         #hindu {
            position: absolute;
            top: 395px;
            left: 532px;
            
         }
         #muslim {
            position: absolute;
            top: 395px;
            left:600px;
         }
         #chr {
            position: absolute;
            top: 395px;
            left:664px;
         }
         #fedu {
            position: absolute;
            top: 450px;
            left:700px;
            font-weight: bold;
         }
         #medu {
            position: absolute;
            top: 520px;
            left:700px;
            font-weight: bold;
         }
         #focu {
            position: absolute;
            top: 580px;
            left:700px;
            font-weight: bold;
         }
         #mocu {
            position: absolute;
            top: 125px;
            left:1030px;
            font-weight: bold;
         }
         #mage {
            position: absolute;
            top: 170px;
            left:1030px;
            font-weight: bold;
         }
         #cage {
            position: absolute;
            top: 230px;
            left:1030px;
            font-weight: bold;
         }
         #nchd {
            position: absolute;
            top: 275px;
            left:1030px;
            font-weight: bold;
         }
         #gov {
            position: absolute;
            top: 359px;
            left:856px;
         }
         #pvt {
            position: absolute;
            top: 383px;
            left:856px;
         }
         #dnt {
            position: absolute;
            top: 399px;
            left:856px;
         }
         #tba {
            position: absolute;
            top: 419px;
            left:856px;
         }
         #roo {
            position: absolute;
            top: 442px;
            left:856px;
         }
         #norm {
            position: absolute;
            top: 500px;
            left:874px;
         }
         #cs {
            position: absolute;
            top: 522px;
            left:874px;
         }
         
         #fv {
            position: absolute;
            top: 542px;
            left:874px;
         }
         #wtg {
            position: absolute;
            top: 565px;
            left:1040px;
            font-weight: bold;
         }
         #wk {
            position: absolute;
            top: 595px;
            left:1040px;
            font-weight: bold;
         }
		 #bbsex1{
            position: absolute;
            top: 690px;
            left:925px;
            font-weight: bold;
         }
		 #dob1{
            position: absolute;
            top: 674px;
            left:858px;
            font-weight: bold;
         }
		 #pobi1{
			position: absolute;
            top: 730px;
            left:750px;
            font-weight: bold;
	     }
         #brt_left{
            position: absolute;
            top: 40px;
            left: 200px;
            font-weight: bold;
         }
         #brt_right{
            position: absolute;
            top: 48px;
            left:640px;
            font-weight: bold;
        }
    </style>
  </head>
  <body>
  <!--<img src="../images/new_birth.jpeg" width="100%" height="100%"/>-->
  <div id="brt_left"> S/No. - SKNH/'.$brt_sno.'</div>'
        . '<div id="brt_right"> S/No. - SKNH/'.$brt_sno.'</div>';
$add = null;  

while($row = mysqli_fetch_assoc($query)){
    $add = explode(",",$row['baby_pm_address']);
    $html .= '<div id="dob">'.date("d-m-Y",  strtotime($row['baby_dob'])).'</div>';
	$html .= '<div id="dob1">'.date("d-m-Y",  strtotime($row['baby_dob'])).'</div>';
    switch ($row['baby_sex']){
        case 'M': 
            $html .= '<div id="bbsex">Male</div>';
			$html .= '<div id="bbsex1">Male</div>';
            break;
        case 'F':
		    
            $html .= '<div id="bbsex">Female</div>';
			$html .= '<div id="bbsex1">Female</div>';
            break;
    }
    $html .= '<div id="bbname">'.$row['baby_name'].'</div>';
    $html .= '<div id="bbfather">'.$row['baby_father_name'].'</div>';

    $html .= '<div id="f_adhar"><table width="100%"><tr>';

    $f_adhar = str_replace("-","",$row['baby_father_aadhar']);

    for($i=0;$i<=strlen( $f_adhar );$i++){
        $html .= '<td style="padding-left:10px;width:15px;text-align:center;">'.substr( $f_adhar, $i, 1 ).'</td>';
    }

    $html .= '</tr></table></div>';

    $html .= '<div id="bbmather">'.$row['baby_mother_name'].'</div>';
    $html .= '<div id="m_adhar"><table width="100%"><tr>';
    $m_adhar = str_replace("-","",$row['baby_mother_aadhar']);

    for($i=0;$i<=strlen( $m_adhar );$i++){
        $html .= '<td style="padding-left:10px;width:15px;text-align:center;">'.substr( $m_adhar, $i, 1 ).'</td>';
    }
    
    $html .= '</tr></table></div>';
    $html .= '<div id="bbadd2">'.$row['baby_pm_address'].'</div>';
    $html .= '<div id="bbad2">'.$row['baby_pr_address'].'</div>';
    switch($row['baby_pob']){
        case 1:
            $html .= '<div id="pobi"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            $html .= "<div id='pobhi_add'>Swarnakamal Nursing Home, Basirhat, 24 Pgs(N), WB</div>";
            break;
        case 2:
            $html .= '<div id="pobi"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            $html .= "<div id='pobhi_add'>Swarnakamal Nursing Home, Basirhat, 24 Pgs(N), WB</div>";
            break;
        case 3:
            $html .= '<div id="pobhs"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            $html .= "<div id='pobhs_add'>".$row['baby_pob_address']."</div>";
            break;
    }
    

    if($row['baby_res_place'] === "V"){
        $html .= '<div id="vil"><img src="../images/tick.png" width="18px" height="18px"/></div>';
    }

    if($row['baby_res_place'] === "T"){
        $html .= '<div id="town"><img src="../images/tick.png" width="18px" height="18px"/></div>';
    }

    $html .= '<div id="add">'.$add[0].', '.$add[2].'</div>';
    $html .= '<div id="dist">'.$row['baby_dist_name'].'</div>';
    $html .= '<div id="state">'.$row['baby_state_name'].'</div>';
    switch($row['baby_religion']){
        case 1:
            $html .= '<div id="hindu"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            break;
        case 2:
            $html .= '<div id="muslim"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            break;
        case 3:
            $html .= '<div id="chr"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            break;
    }
    
    $html .= '<div id="fedu">'.$row['baby_gurd_quali'].'</div>';
    $html .= '<div id="medu">'.$row['baby_patient_quali'].'</div>';
    
    $html .= '<div id="focu">'.($row['baby_gurd_ocu'] != ''?$row['baby_gurd_ocu']:'NILL').'</div>';
    $html .= '<div id="mocu">'.($row['baby_patient_ocu'] != ''?$row['baby_patient_ocu']:'NILL').'</div>';
    
    $html .= '<div id="mage">'.$row['baby_m_age'].'</div>';
    $html .= '<div id="cage">'.$row['baby_age'].'</div>';
    $html .= '<div id="nchd">'.$row['baby_child_no'].'</div>';
    switch ($row['baby_atn_delivery']){
        case 1:
            $html .= '<div id="gov"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            break;
        case 2:
            $html .= '<div id="pvt"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            break;
        case 3:
            $html .= '<div id="dnt"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            break;
        case 4:
            $html .= '<div id="tba"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            break;
        case 5:
            $html .= '<div id="roo"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            break;
    }
    switch ($row['baby_method_delivery']){
        case 1:
            $html .= '<div id="norm"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            break;
        case 2:
            $html .= '<div id="cs"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            break;
        case 3:
            $html .= '<div id="fv"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            break;
    }
    $html .= '<div id="wtg">'.($row['baby_weight'] != ''?$row['baby_weight']:'').' Kg</div>';
    $html .= '<div id="wk">'.$row['baby_preg_dur'].'</div>';
}

$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
$dompdf->load_html($html);
$dompdf->render();

//$canvas = $dompdf->get_canvas();
//$font = Font_Metrics::get_font("helvetica", "bold");
//$canvas->page_text(280,810 , "{PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));

$dompdf->stream($reg.".pdf", array('Attachment' => 0));?>