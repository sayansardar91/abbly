
<?php 
ini_set('max_execution_time', 3000);
ini_set('memory_limit','500M');
set_include_path("../dompdf");
require_once "dompdf_config.inc.php";
session_start();
	$dompdf = new DOMPDF();
	$dompdf->set_option('enable_html5_parser', TRUE);
	$dompdf->set_paper("legal", 'landscape');
	$dompdf->load_html($_SESSION['pdfcontent']);
	$dompdf->render();
	$canvas = $dompdf->get_canvas();
	$font = Font_Metrics::get_font("helvetica", "bold" , "underline");
	$font_r = Font_Metrics::get_font("helvetica", "bold");
	$canvas->page_text(350,20,'SWARNAKAMAL NURSING HOME',$font,19,array(0,0,0));
	$canvas->page_text(358,45,'NAIHATI, P.O.- BADARTALA, NORTH 24 PARGANAS',$font,12,array(0,0,0));
	$canvas->page_text(448,80,'ADMISSION REPORT',$font_r,12,array(0,0,0));
	$canvas->page_text(870, 18, "Date : ".date('d-M-Y'),$font, 12, array(0,0,0));
	$canvas->page_text(870, 35, "Time : ".date('h:i:s A'),$font, 12, array(0,0,0));
	$canvas->page_text(480, 578, "{PAGE_NUM} of {PAGE_COUNT}", $font, 12, array(0, 0, 0));
	$dompdf->stream("AdmissionReport.pdf", array('Attachment' => 0));