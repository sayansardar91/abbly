<?php

set_include_path("../dompdf");
require_once "dompdf_config.inc.php";



$dompdf = new DOMPDF();
$dompdf->set_option('enable_html5_parser', TRUE);
$dompdf->set_paper("A4", 'portrait');

$html = '
<html>
<head>
<title>Application Form</title>
 <style>
    div {line-height: 1;color:black;font-weight: bold;}
    h1, p {margin: 0;}
    h4, p {margin: 0;}
    h2, p {margin: 0;}
    span {font-style:italic; font-family:Arial, Helvetica, sans-serif;}
</style>
</head>

<body>
    <div>
    <div><img src="../images/BC004_1.jpg" width="100%" height="100%"/></div>
</div>
</body></html>';

$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("discharge_blank.pdf", array('Attachment' => 0));?>