<?php
ini_set('max_execution_time', 300);
require_once('../tcpdf/tcpdf.php');
require_once "../lib/config.php";
require_once "../lib/database.php";
require_once "../lib/MyDateTime.php";
date_default_timezone_set('Asia/Kolkata');
session_start();
if (!((isset($_GET['pg']) or (isset($_SESSION['user']))))){
    header("Location: ../index.php");
}
$start_time = time();
$_POST = array_filter($_POST);
$db = new database();
$rptdt = null;

if(isset($_POST['date_daily'])){
	$_SESSION['fromdate'] = $_SESSION['todate'] =  $_POST['date_daily'];
	$rptdt = ' for Month: ('.date('M',strtotime($_SESSION['fromdate'])).') Financial Year: '.finYear($_SESSION['fromdate']);
}else if(isset($_POST['date_from']) && isset($_POST['date_to'])){
	$_SESSION['fromdate'] = $_POST['date_from'];
	$_SESSION['todate'] = $_POST['date_to'];
	$frmMonth = date('M',strtotime($_SESSION['fromdate']));
	$toMonth = date('M',strtotime($_SESSION['todate']));
	if($frmMonth === $toMonth){
		$rptdt = ' from '.date('d-M-Y',strtotime($_SESSION['fromdate'])).' To '.date('d-M-Y',strtotime($_SESSION['todate'])).' Financial Year: '.finYear($_SESSION['fromdate']);
	}else{
		$rptdt = ' from Month: ('.date('M',strtotime($_SESSION['fromdate'])).' To '.date('M',strtotime($_SESSION['todate'])).') Financial Year: '.finYear($_SESSION['fromdate']);
	}
}

$qr_string = "Call sp_admreport('".$_SESSION['fromdate']."','".$_SESSION['todate']."');";

$query = $db->conn->query($qr_string);
$html = '
	
	<table width="100%" border="1" cellpadding="1">
            <thead>
                <tr >
                    <th align="center" width="5%">S/No.</th>
                    <th align="center">Reg. No</th>
                    <th align="center" width="13%">Pt. Name &amp; Address</th>
                    <th align="center" width="5%">SEX</th>
                    <th align="center" width="5%">AGE</th>
                    <th align="center">Admit Date &amp; Time</th>
                    <th align="center" width="20%">Case</th>
                    <th align="center" width="18%">Doctor/Anast./Assis./Sister</th>
                    <th align="center">Date Of Discharge</th>
                </tr>
            </thead>
            <tbody>';
$i=1;
while ($row = mysqli_fetch_assoc($query)) {
		  $html .=
            '<tr nobr="true">
            <td align="center" valign="middle" width="5%">'.$i.'</td>'.$row['reg_no'].$row['patient_name'].$row['sex'].$row['age'].$row['admit_time'].'
			<td width="20%">
				<table >
					<tr><td colspan="3">'.$row['prov_diog'].'</td></tr>
					<tr><td colspan="3">'.$row['treatment'].'</td></tr>'.str_replace(',','',$row['baby_details']).'					
				</table>
			</td>
			<td width="18%">
				<table width="100%">
					<tr>
						<td width="19%">Doc</td>
						<td width="81%" align="center">Dr. '.$row['atd_doc'].'</td>
					</tr>
					<tr>
						<td width="19%">Anast.</td>
						<td width="81%" align="center">Dr. '.$row['atd_anasth'].'</td>
					</tr>
					<tr>
						<td width="19%">Assist.</td>
						<td width="81%" align="center">'.$row['atd_assist'].'</td>
					</tr>
					<tr>
						<td width="19%">Sister.</td>
						<td width="81%" align="center">'.$row['atd_nurse'].'</td>
					</tr>
				</table></td><td align="center">'.$row['dscrg_date'].'</td></tr>';
    $i++;
}
$html .= '</tbody></table>';
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Swarnakamal Nursing Home');
$pdf->SetTitle('Admission Report');
$pdf->SetSubject('Admission Report');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(null, null, PDF_HEADER_TITLE.$rptdt, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 24);

// add a page
$pdf->AddPage('L','legal');

//$pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);

// -----------------------------------------------------------------------------

/*$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td rowspan="3">COL 1 - ROW 1<br />COLSPAN 3</td>
        <td>COL 2 - ROW 1</td>
        <td>COL 3 - ROW 1</td>
    </tr>
    <tr>
    	<td rowspan="2">COL 2 - ROW 2 - COLSPAN 2<br />text line<br />text line<br />text line<br />text line</td>
    	<td>COL 3 - ROW 2</td>
    </tr>
    <tr>
       <td>COL 3 - ROW 3</td>
    </tr>

</table>
EOD;*/

$pdf->writeHTML($html, true, false, false, false, '');
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('admission_report.pdf', 'I');

function finYear($year_str){
    $mydate = new MyDateTime();
    $mydate->setDate(date("Y",  strtotime($year_str)), date("m",strtotime($year_str)), date("d",strtotime($year_str)));
    $result = $mydate->fiscalYear();
    $start = $result['start']->format('Y');
    $end = $result['end']->format('y');
    $fyear = $start . "-" . $end;
    return $fyear;
}
?>
