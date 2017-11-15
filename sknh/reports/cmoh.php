<?php
ini_set('max_execution_time', 3000);
ini_set('memory_limit','16M');
set_include_path("../dompdf");
require_once "../lib/config.php";
require_once "../lib/database.php";
require_once "dompdf_config.inc.php";
date_default_timezone_set('Asia/Kolkata');
session_start();
if (!((isset($_GET['pg']) or (isset($_SESSION['user']))))){
    header("Location: ../index.php");
}
$month = $_POST['cmoh_month'];
$year = $_POST['cmoh_year'];
$from = $year.'-'.date('m',  strtotime($month."-".$year)).'-01';
$to = $year.'-'.date('m',  strtotime($month."-".$year)).'-'.date('t', strtotime($month." ".$year));


$db = new database();
$req = "CALL view_cmoh('".$from."', '".$to."')";

$query = $db->conn->query($req);
$total_admit=$total_dchrg = $gen_total = $cabin_total = $total_days = $total_dichrg = $tot_mejor = $tot_minor = $tot_delv = $total_livebirth = $report_month = null;
//var_dump($row = mysqli_fetch_assoc($query));
//die;
while ($row = mysqli_fetch_assoc($query)) {
	$report_month = $row['report_month'];
	$gen_total = $row['tot_admitgen'];
	$cabin_total = $row['tot_admitcab'];
	$total_days = $row['total_days'];
	$total_dichrg = $row['total_dichrg'];
	$tot_mejor = $row['tot_mejor'];
	$tot_minor = $row['tot_minor'];
	$tot_delv = $row['tot_delv'];
	$total_livebirth = $row['total_livebirth'];
	$total_admit = $gen_total + $cabin_total;
	$total_dchrg = $row['gen_total'] + $row['cabin_total'];
}

$dompdf = new DOMPDF();
$dompdf->set_paper("A4", 'portrait');
$html = '
<html>
<head>
<title>C.M.O.H - '.$report_month.' - '.$year.'</title>
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
	}
	#month{
		position: absolute;
		top: 125px;
		left: 300px;
	}
	#p_bed{
		position: absolute;
		top: 230px;
		left: 300px;
	}
	#f_bed{
		position: absolute;
		top: 247px;
		left: 300px;
	}
	#cb_bed{
		position: absolute;
		top: 264px;
		left: 300px;
	}
	#t_bed{
		position: absolute;
		top: 295px;
		left: 300px;
	}
	
	
	#p_bed1{
		position: absolute;
		top: 230px;
		left: 550px;
	}
	#f_bed1{
		position: absolute;
		top: 247px;
		left: 550px;
	}
	#cb_bed1{
		position: absolute;
		top: 264px;
		left: 550px;
	}
	#t_bed1{
		position: absolute;
		top: 295px;
		left: 550px;
	}
	#em_doc{
		position: absolute;
		top: 314px;
		left: 390px;
	}
        #tp_day{
            position: absolute;
		top: 348px;
		left: 250px;
        }
        #tot_drg{
            position: absolute;
		top: 365px;
		left: 390px;
        }
        #tot_6{
            position: absolute;
		top: 398px;
		left: 390px;
        }
        #tot_7{
            position: absolute;
		top: 415px;
		left: 420px;
        }
	#old1{
		position: absolute;
		top: 501px;
		left: 370px;	
	}
	#new1{
		position: absolute;
		top: 501px;
		left: 460px;	
	}
	#tot1{
		position: absolute;
		top: 501px;
		left: 550px;	
	}
	#old2{
		position: absolute;
		top: 535px;
		left: 370px;	
	}
	#new2{
		position: absolute;
		top: 535px;
		left: 460px;	
	}
	#tot2{
		position: absolute;
		top: 535px;
		left: 550px;	
	}
	#old3{
		position: absolute;
		top: 570px;
		left: 370px;	
	}
	#new3{
		position: absolute;
		top: 570px;
		left: 460px;	
	}
	#tot3{
		position: absolute;
		top: 570px;
		left: 550px;	
	}
	#old4{
		position: absolute;
		top: 600px;
		left: 370px;	
	}
	#new4{
		position: absolute;
		top: 600px;
		left: 460px;	
	}
	#tot4{
		position: absolute;
		top: 600px;
		left: 550px;	
	}
	#old5{
		position: absolute;
		top: 635px;
		left: 370px;	
	}
	#new5{
		position: absolute;
		top: 635px;
		left: 460px;	
	}
	#tot5{
		position: absolute;
		top: 635px;
		left: 550px;	
	}
	#old6{
		position: absolute;
		top: 670px;
		left: 370px;	
	}
	#new6{
		position: absolute;
		top: 670px;
		left: 460px;	
	}
	#tot6{
		position: absolute;
		top: 670px;
		left: 550px;	
	}
	#old7{
		position: absolute;
		top: 700px;
		left: 370px;	
	}
	#new7{
		position: absolute;
		top: 700px;
		left: 460px;	
	}
	#tot7{
		position: absolute;
		top: 700px;
		left: 550px;	
	}
	#old8{
		position: absolute;
		top: 735px;
		left: 370px;	
	}
	#new8{
		position: absolute;
		top: 735px;
		left: 460px;	
	}
	#tot8{
		position: absolute;
		top: 735px;
		left: 550px;	
	}
	#old9{
		position: absolute;
		top: 765px;
		left: 370px;	
	}
	#new9{
		position: absolute;
		top: 765px;
		left: 460px;	
	}
	#tot9{
		position: absolute;
		top: 765px;
		left: 550px;	
	}
	#old10{
		position: absolute;
		top: 800px;
		left: 370px;	
	}
	#new10{
		position: absolute;
		top: 800px;
		left: 460px;	
	}
	#tot10{
		position: absolute;
		top: 800px;
		left: 550px;	
	}
	#old11{
		position: absolute;
		top: 835px;
		left: 370px;	
	}
	#new11{
		position: absolute;
		top: 835px;
		left: 460px;	
	}
	#tot11{
		position: absolute;
		top: 835px;
		left: 550px;	
	}
	#old12{
		position: absolute;
		top: 870px;
		left: 370px;	
	}
	#new12{
		position: absolute;
		top: 870px;
		left: 460px;	
	}
	#tot12{
		position: absolute;
		top: 870px;
		left: 550px;	
	}
	#pt9{
		position: absolute;
		top: 85px;
		left: 460px;	
	}
	#pt10{
		position: absolute;
		top: 120px;
		left: 460px;	
	}
	#pt11{
		position: absolute;
		top: 155px;
		left: 460px;	
	}
	#pt12{
		position: absolute;
		top: 190px;
		left: 460px;	
	}
	#pt13{
		position: absolute;
		top: 225px;
		left: 460px;	
	}
	#pt14{
		position: absolute;
		top: 260px;
		left: 460px;	
	}
	#pt15{
		position: absolute;
		top: 295px;
		left: 460px;	
	}
	#pt16{
		position: absolute;
		top: 330px;
		left: 460px;	
	}
	#pt17{
		position: absolute;
		top: 365px;
		left: 460px;	
	}
	#pt18{
		position: absolute;
		top: 400px;
		left: 460px;	
	}
	#pt19{
		position: absolute;
		top: 435px;
		left: 460px;	
	}
	#pt20{
		position: absolute;
		top: 470px;
		left: 460px;	
	}
	#pt21{
		position: absolute;
		top: 505px;
		left: 460px;	
	}
	#pt22{
		position: absolute;
		top: 540px;
		left: 460px;	
	}
	#pt23{
		position: absolute;
		top: 575px;
		left: 460px;	
	}
	#pt24{
		position: absolute;
		top: 610px;
		left: 460px;	
	}
	#pt25{
		position: absolute;
		top: 645px;
		left: 460px;	
	}
	#pt26{
		position: absolute;
		top: 680px;
		left: 460px;	
	}
	#pt27{
		position: absolute;
		top: 715px;
		left: 460px;	
	}
	#pt28{
		position: absolute;
		top: 750px;
		left: 460px;	
	}
	#pt29{
		position: absolute;
		top: 785px;
		left: 460px;	
	}
        #pt30{
		position: absolute;
		top: 815px;
		left: 460px;	
	}
        #pt31{
		position: absolute;
		top: 855px;
		left: 460px;	
	}
        #partb_1{
            position: absolute;
		top: 210px;
		left: 150px;	
        }
        #partb_1_a{
            position: absolute;
		top: 210px;
		left: 460px;	
        }
</style>
</head>

<body style="font-weight: bold">
<img src="../images/CMOH_PARTA.jpg" width="100%" height="100%"/>
<div id="month">'.$report_month.' - '.$year.'</div>
<div id="p_bed">16</div>
<div id="f_bed">Nill</div>
<div id="cb_bed">4</div>
<div id="t_bed">20</div>
<div id="p_bed1">'.$gen_total.'</div>
<div id="f_bed1">Nill</div>
<div id="cb_bed1">'.$cabin_total.'</div>
<div id="t_bed1">'.$total_admit.'</div>
<div id="em_doc">Total patient admission with Dr. advice.</div>
<div id="tp_day">'.$total_days.' days.</div>'
. '<div id="tot_drg">'.$total_dichrg.'</div>'
        . '<div id="tot_6">'.$total_dichrg.'</div><div id="tot_7">Nill</div>';
for($i=1;$i<=12;$i++){
	$html .= '<div id="old'.$i.'">N/A</div>
			  <div id="new'.$i.'">N/A</div>
			  <div id="tot'.$i.'">N/A</div>';
}

$html .='<div style="page-break-after: always;"></div>
<img src="../images/CMOH2.jpg" width="100%" height="100%"/>
<div id="pt9">Nill</div>
<div id="pt10">'.$tot_mejor.'</div>
<div id="pt11">'.(($tot_minor)?$tot_minor:'Nill').'</div>
<div id="pt12">'.$tot_delv.'</div>
<div id="pt13">'.$total_livebirth.'</div>
<div id="pt14">Nill</div>';
for($i=15;$i<=25;$i++){
$html .= '<div id="pt'.$i.'">N/A</div>';
}
$html .='
<div id="pt26">&nbsp;</div>';
for($i=27;$i<=29;$i++){
$html .= '<div id="pt'.$i.'">N/A</div>';
}


$html .='<div id="pt30">N/A</div><div id="pt31">'.$total_admit.'</div><div style="page-break-after: always;"></div>
<img src="../images/CMOH_PARTB.jpg" width="100%" height="100%"/>';

$db = new database();
/*$req = "select distinct pdg.diog_name,count(pd.reg_no) AS no_of from prov_diag pdg 
LEFT JOIN patient_details pd ON pdg.id = pd.prov_diog 
WHERE pd.reg_no IN(Select patient_id from patient_discharge WHERE discharge_date BETWEEN '".$from."' AND '".$to."') GROUP BY pdg.id LIMIT 7";*/
$req = "select dpt.dept_name AS diog_name, count(ptd.reg_no) AS no_of from patient_details ptd 
LEFT JOIN prov_diag pdg ON ptd.prov_diog = pdg.id
LEFT JOIN department_details dpt ON pdg.dept_id = dpt.id
where ptd.reg_no IN(Select reg_no from view_itreport WHERE discharge_date BETWEEN '".$from."' AND '".$to."') GROUP BY pdg.dept_id ORDER BY dpt.dept_name asc";
$query = $db->conn->query($req);
$top = 210;
$total = 0;
while ($row = mysqli_fetch_assoc($query)) {
    //echo $row['diog_name']." => ".$row['no_of']."<br/>";
    $html .='<div style="position: absolute;top: '.$top.'px;left: 150px;">'.$row['diog_name'].'</div>'
            . '<div style="position: absolute;top: '.$top.'px;left: 460px;">'.$row['no_of'].'</div>';
    $total = $total + $row['no_of'];
    $top = $top + 35;
}

$html .='<div style="position: absolute;top: 450px;left: 460px;">'.$total.'</div></body></html>';
$dompdf->load_html($html);
$dompdf->render();

$canvas = $dompdf->get_canvas();
$font = Font_Metrics::get_font("helvetica", "bold" , "underline");
$canvas->page_text(298, 800, "{PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0, 0, 0));

$dompdf->stream($report_month.' - '.$year.".pdf", array('Attachment' => 0));
?>



