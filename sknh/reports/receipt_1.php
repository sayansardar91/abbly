<?php

set_include_path("../dompdf");
require_once "../lib/config.php";
require_once "../lib/database.php";
require_once "dompdf_config.inc.php";
session_start();
if (!((isset($_GET['pg']) or ( isset($_SESSION['user']))))) {
    header("Location: ../index.php");
}

$dompdf = new DOMPDF();
$dompdf->set_paper("A4", 'portrait');
$html = '
<html>
<head>
<title>Patient Bill</title>
 <style>
    //div {line-height: 1;color:#0033FF;}
    h1, p {margin: 0;}
    h4, p {margin: 0;}
    h2, p {margin: 0;}
	span {font-style:italic; font-family:Arial, Helvetica, sans-serif;}
        body{
            margin: 0px;
        }
</style>
</head>

<body>
    <img src="../images/FinalBill.jpg" width="100%" height="100%"/>
</body></html>';

$dompdf->load_html($html);
$dompdf->render();

$dompdf->stream("FinalBill.pdf", array('Attachment' => 0));



