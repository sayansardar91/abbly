<?php
/*ini_set('max_execution_time', 3000);
ini_set('memory_limit','16M');*/
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
$dompdf->set_paper(array(0,0,591,827), 'landscape');

$bb_sex = null;

$html = '<html>
    
  <head>
    <style>
    @page { margin: 0px; }
    img {margin:0px;padding:0px}
      #dob {
            position: absolute;
            top: 100px;
            left: 180px;
            font-weight: bold;
         }
        #bbsex {
            position: absolute;
            top: 140px;
            left: 220px;
            font-weight: bold;
         }
        #bbname {
            position: absolute;
            top: 155px;
            left: 220px;
            font-weight: bold;
         }
         #bbfather {
            position: absolute;
            top: 210px;
            left: 240px;
            font-weight: bold;
         }
         #bbmather {
            position: absolute;
            top: 230px;
            left: 240px;
            font-weight: bold;
         }
         #bbadd2 {
            position: absolute;
            top: 272px;
            left: 100px;
            font-weight: bold;
         }
         #bbad2 {
            position: absolute;
            top: 310px;
            left: 100px;
            font-weight: bold;
         }
         #pobh {
            position: absolute;
            top: 335px;
            left: 200px;
         }
         #pobi {
            position: absolute;
            top: 332px;
            left: 235px;
         }
         #pobhs {
            position: absolute;
            top: 335px;
            left: 300px;
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
            top: 210px;
            left: 540px;
         }
         #town {
            position: absolute;
            top: 210px;
            left: 500px;
         }
         #add {
            position: absolute;
            top: 210px;
            left: 580px;
            font-weight: bold;
         }
         #dist {
            position: absolute;
            top: 230px;
            left: 580px;
            font-weight: bold;
         }
         #state {
            position: absolute;
            top: 250px;
            left: 580px;
            font-weight: bold;
         }
         #hindu {
            position: absolute;
            top: 293px;
            left: 430px;
         }
         #muslim {
            position: absolute;
            top: 293px;
            left:550px;
         }
         #chr {
            position: absolute;
            top: 293px;
            left:680px;
         }
         #fedu {
            position: absolute;
            top: 335px;
            left:600px;
            font-weight: bold;
         }
         #medu {
            position: absolute;
            top: 395px;
            left:600px;
            font-weight: bold;
         }
         #focu {
            position: absolute;
            top: 460px;
            left:600px;
            font-weight: bold;
         }
         #mocu {
            position: absolute;
            top: 508px;
            left:600px;
            font-weight: bold;
         }
         #mage {
            position: absolute;
            top: 140px;
            left:975px;
            font-weight: bold;
         }
         #cage {
            position: absolute;
            top: 235px;
            left:975px;
            font-weight: bold;
         }
         #nchd {
            position: absolute;
            top: 285px;
            left:975px;
            font-weight: bold;
         }
         #gov {
            position: absolute;
            top: 315px;
            left:925px;
         }
         #pvt {
            position: absolute;
            top: 355px;
            left:975px;
         }
         #dnt {
            position: absolute;
            top: 350px;
            left:952px;
         }
         #tba {
            position: absolute;
            top: 370px;
            left:925px;
         }
         #roo {
            position: absolute;
            top: 388px;
            left:880px;
         }
         #norm {
            position: absolute;
            top: 465px;
            left:825px;
         }
         #cs {
            position: absolute;
            top: 465px;
            left:885px;
         }
         
         #fv {
            position: absolute;
            top: 465px;
            left:1055px;
         }
         #wtg {
            position: absolute;
            top: 490px;
            left:975px;
            font-weight: bold;
         }
         #wk {
            position: absolute;
            top: 520px;
            left:975px;
            font-weight: bold;
         }
         #bbsex1{
            position: absolute;
            top: 660px;
            left:1022px;
            font-weight: bold;
         }
         #dob1{
            position: absolute;
            top: 660px;
            left:850px;
            font-weight: bold;
         }
         #pobi1{
             position: absolute;
            top: 700px;
            left:806px;
            font-weight: bold;
         }
         #brt_left{
            position: absolute;
            top: 2px;
            left:130px;
            font-weight: bold;
         }
         #brt_right{
                position: absolute;
            top: 2px;
            left:650px;
            font-weight: bold;
            }
    </style>
  </head>
  <body>
  <!--<img src="../images/Scan1_1.jpg" width="100%" height="100%"/>-->
  <div id="brt_left"> S/No. - SKNH/'.$brt_sno.'</div>'
        . '<div id="brt_right"> S/No. - SKNH/'.$brt_sno.'</div>';
$add = null;  
while($row = mysqli_fetch_assoc($query)){
    $add = explode(",",$row['baby_pm_address']);
    $html .= '<div id="dob">'.date("d-m-y",  strtotime($row['baby_dob'])).'</div>';
    $html .= '<div id="dob1">'.date("d-m-y",  strtotime($row['baby_dob'])).'</div>';
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
    $html .= '<div id="bbmather">'.$row['baby_mother_name'].'</div>';
    $html .= '<div id="bbadd2">'.$row['baby_pm_address'].'</div>';
    $html .= '<div id="bbad2">'.$row['baby_pr_address'].'</div>';
    switch($row['baby_pob']){
        case 1:
            $html .= '<div id="pobh"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            break;
        case 2:
            $html .= '<div id="pobi"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            $html .= '<div id="pobi1"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            break;
        case 3:
            $html .= '<div id="pobhs"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            break;
        case 4:
            $html .= '<div id="pobo"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            break;
    }
    switch($row['baby_res_place']){
        case 1:
            $html .= '<div id="vil"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            break;
        case 2:
            $html .= '<div id="town"><img src="../images/tick.png" width="18px" height="18px"/></div>';
            break;
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
  $html .= '<div id="addpbl1">Swarnakamal</div>
  <div id="addpbl2">Nursing Home, Basirhat, 24 Pgs(N), WB</div>
  <div id="addinf1">Swarnakamal</div>
  <div id="addinf2">Nursing Home, Basirhat, 24 Pgs(N), WB</div>
  </body>
</html>
';
$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
$dompdf->load_html($html);
$dompdf->render();

//$canvas = $dompdf->get_canvas();
//$font = Font_Metrics::get_font("helvetica", "bold");
//$canvas->page_text(280,810 , "{PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));

$dompdf->stream($reg_id.".pdf", array('Attachment' => 0));?>