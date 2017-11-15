<?php
/**
* SQL2PDFReport Generator Class
*
* @author  :  MA Razzaque Rupom <rupom_315@yahoo.com>, <rupom.bd@gmail.com>
*             Moderator, phpResource Group(http://groups.yahoo.com/group/phpresource/)
*             URL: http://www.rupom.info  
* @version :  1.0
* @date       06/05/2006 (modified on 06/23/2006)
* Purpose  :  Generating Pdf Report from SQL Query
*/

require_once('Sql2PdfReport.class.php');

//make sure the DB connection is ok
mysql_connect('localhost','root','rootadmin');
mysql_select_db('book');

//queries whose output will be used as report data
$query_1 = "SELECT * FROM book";
$query_2 = "SELECT title,author FROM book";
$query_3 = "SELECT book_id,publisher,reader FROM book";

$obj = new Sql2PdfReport();

//sets absolute path where temporary report HTML file will be saved (should be under doc_root so that its URL can be set)
$obj->setHtmlPath("http://localhost:85/reports/html2pdf/first_test.html"); //change this according to your Path

//sets URL of the temporary report HTML file
$obj->setHtmlUrl("http://localhost:85/reports/html2pdf/first_test.html");//change this according to your URL

//inits row colors. colors will be repeated automatically
$obj->initRowColors(array('#336699','#f5f5f5'));

//generates report from $query_1
$obj->generateReport($query_1);

//changes row colors for the second report.
$obj->initRowColors(array('#f8f8f8','#336699','#353535'));

//generates report from $query_2 and appends it to previous report data
$obj->generateReport($query_2);

//generates report from $query_3 and appends it to previous report data
$obj->generateReport($query_3);

//pdf version
$pdfVersion = '1.4'; //change it according to your need
/*
$pdfVersion = 1.3 for Acrobat Reader 4
$pdfVersion = 1.4 for Acrobat Reader 5
$pdfVersion = 1.5 for Acrobat Reader 6
*/

//sets PDF version
$obj->setPdfVersion($pdfVersion);

//gets the pdf report of all the report data        
$obj->getPdfReport(); 
?>