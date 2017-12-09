<?php
ini_set('max_execution_time', 3000);
ini_set('memory_limit','200M');
set_include_path("../dompdf");
require_once "../lib/config.php";
require_once "../lib/database.php";
require_once '../lib/MyDateTime.php';
require_once "dompdf_config.inc.php";
date_default_timezone_set('Asia/Kolkata');
$mdate = new MyDateTime();
$mdate->setDate(date('Y'), date('m'), date('d'));
$result = $mdate->fiscalYear();
$start = $result['start']->format('Y');
$end = $result['end']->format('y');
$finyear = $start . "-" . $end;
$statement = null;

session_start();
if (!((isset($_GET['pg']) or ( isset($_SESSION['user']))))) {
    header("Location: ../index.php");
}
$_POST = array_filter($_POST);

$opening_bal=$gross_bal=$from_date = $to_date = null;
$inc_statement = $tbName = null;
//print_r($_POST);
	if($_POST['rptType'] == 1){
		$tbName = "nshm_account";
	}else if($_POST['rptType'] == 2){
		$tbName = "nshm_ptnraccount";
	}
	if(isset($_POST["date_daily"])){
	  $statement = "= '".$_POST["date_daily"]."';";
	  $inc_statement = " for ".date('d-M-Y',strtotime($_POST["date_daily"]));
	}
	else if(isset($_POST["exp_month"]) && isset($_POST["exp_year"])){
		$month = (int)date("m",strtotime($_POST["exp_month"]));
		$year = explode("-",$_POST["exp_year"]);
		
		if($month >= 4 && $month <= 12){
			$from_date = $year[0]."-".date("m",strtotime($_POST["exp_month"]))."-01";
			$to_date = $year[0]."-".date("m",strtotime($_POST["exp_month"]))."-".date("t",strtotime($_POST["exp_month"]."-".$year[0]));
			$inc_statement = " for ".ucfirst($_POST["exp_month"])."-".$year[0];
		}else if($month >= 1 && $month <= 3){
			$from_date = $year[1]."-".date("m",strtotime($_POST["exp_month"]))."-01";
			$to_date = $year[1]."-".date("m",strtotime($_POST["exp_month"]))."-".date("t",strtotime($_POST["exp_month"]."-".$year[1]));
			$inc_statement = " for ".ucfirst($_POST["exp_month"])."-".$year[1];
		}
		$statement = "BETWEEN '".$from_date."' AND '".$to_date."' ORDER BY payment_date ASC;";
	}
	else if(isset($_POST["exp_year"])){
		$year = explode("-",$_POST["exp_year"]);
		$from_date = $year[0]."-04-01";
		$to_date = '20'.$year[1]."-03-31";
		$inc_statement = " for Financial Year ".$_POST["exp_year"];
		$statement = "BETWEEN '".$from_date."' AND '".$to_date."' ORDER BY payment_date ASC;";
	}else if(isset($_POST["date_from"]) && isset($_POST["date_to"])){
		$from_date = $_POST["date_from"];
		$to_date = $_POST["date_to"];
		$inc_statement = " from ".date("d-M-Y",strtotime($from_date))." To ".date("d-M-Y",strtotime($to_date));
		$statement = "BETWEEN '".$from_date."' AND '".$to_date."' ORDER BY payment_date ASC;";
	}
$db = new database();

$req = "select * from ".$tbName." where payment_date ".$statement;


$query = $db->conn->query($req);
$tot_inc = null;

$dompdf = new DOMPDF();
$dompdf->set_option('enable_html5_parser', TRUE);
$dompdf->set_paper("A4", 'portrait');
$html = '
<html>
<head>
<title>Income Sheet</title>
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
    /*border: 1px solid black;*/
    margin-top: 10px;
}
</style>
</head>

<body>
    <div>
    	<div align="center"><h2>SWARNAKAMAL NURSING HOME</h2></div>
        <div>
            <div align="center"><h4>NAIHATI, P.O.- BADARTALA, NORTH 24 PARGANAS</h4></div>
            <div align="center" style="margin-top: 10px"><strong><u>Income Statment'.$inc_statement.'</u></strong></div>
        </div>
		<table width="100%" border=1>
            <thead>
                <tr >
                    <th>S/No.</th>
                    <th>Payment Date</th>
                    <th>Opening Balance</th>
                    <th>Gross Income</th>
                    <th>Gross Expense</th>
                    <th>Net Income</th>
                </tr>
            </thead>
            <tbody>';
			$rowcount=mysqli_num_rows($query);
			$sno = 0;
			$totBal = 0;
			$totExp = 0;
			$totClosing = 0;
			if($rowcount > 0){
				while ($row = mysqli_fetch_assoc($query)) {
				$html .='<tr>
					<td align="center">'.++$sno.'</td>
					<td align="center">'.date("d-m-Y",strtotime($row['payment_date'])).'</td>
					<td align="right">Rs. '.$row['opening_bal'].' /-</td>
					<td align="right">Rs. '.$row['gross_bal'].' /-</td>
					<td align="right">Rs. '.$row['gross_exp'].' /-</td>
					<td align="right">Rs. '.$row['closing_bal'].' /-</td>
				</tr>';
				$totBal = $totBal + $row['gross_bal'];
				$totExp = $totExp + $row['gross_exp'];
				$totClosing = $totBal - $totExp;
				}
				/*$html .='<tr>
					<td colspan="3">&nbsp;</td>
					<td align="right">Total Rs. '.$totBal.' /-</td>
					<td align="right">Total Rs. '.$totExp.' /-</td>
					<td align="right">Total Rs. '.$totClosing.' /-</td>
				</tr>';*/
			}else{
				$html .= '<tr align="center"><td colspan="6">No Records Found</td></tr>';
			}
			
				
			
			$html .='</tbody>
		</table>
    </div>
	</body></html>';
$dompdf->load_html($html);
$dompdf->render();

$canvas = $dompdf->get_canvas();
$font = Font_Metrics::get_font("helvetica", "bold");
$canvas->page_text(480, 12, "Date : " . date('d-M-Y'), $font, 8, array(0, 0, 0));
$canvas->page_text(480, 22, "Time : " . date('h:i:s A'), $font, 8, array(0, 0, 0));
$canvas->page_text(280, 810, "{PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0, 0, 0));

$dompdf->stream("IncomeSheet.pdf", array('Attachment' => 0));
?>


