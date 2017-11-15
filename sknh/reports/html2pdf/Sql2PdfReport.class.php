<?php
/**
* SQL2PDFReport Generator Class
*
* @author  :  MA Razzaque Rupom <rupom_315@yahoo.com>, <rupom.bd@gmail.com>
*             Moderator, phpResource Group(http://groups.yahoo.com/group/phpresource/)
*             URL: http://www.rupom.info  
* @version :  1.0
* @date       06/05/2006
* Purpose  :  Generating Pdf Report from SQL Query
*/

class Sql2PdfReport
{   
   private $reportData;
   private $htmlPath;
   private $htmlUrl;
   private $rowColors  = array();
   private $pdfWidth   = 850;
   private $remoteApp  = "http://services.phpresgroup.org/pdf/public_html/html2ps.php";
   private $pdfVersion = '1.3'; //default PDF Version (for acrobat reader)
   
   /**
   * Sets path where the report data will be saved temporarily
   * @param absolute path of the temp file to be created
   * @return none
   */ 
   function setHtmlPath($htmlPath)
   {
      $this->htmlPath = $htmlPath;
   }
   
   /**
   * Sets URL where the temp report file will be available temporarily
   * @param URL of the temp report file
   * @return none
   */ 
   function setHtmlUrl($htmlUrl)
   {
      $this->htmlUrl = $htmlUrl;
   }
   
   /**
   * Sets width of the report PDF
   * @param Integer pdf width
   * @return none
   */ 
   function setPdfWidth($pdfWidth)
   {
   	  if(is_numeric($pdfWidth))
      {
         $this->pdfWidth = $pdfWidth;	
      }
   }

   /**
   * Sets PDF version (added on 06/23/2006 by Rupom)
   * @param Integer pdf version
   * @return none
   */ 
   function setPdfVersion($pdfVersion)
   {
   	  /*
   	  $pdfVersion = 1.3 for Adobe Acrobat Reader 4
   	  $pdfVersion = 1.4 for Adobe Acrobat Reader 5
   	  $pdfVersion = 1.5 for Adobe Acrobat Reader 6
   	  */
      $this->pdfVersion = $pdfVersion;	
   }   

   /**
   * Initializes row colors of the report 
   * @param Array row colors
   * @return none
   */    
   function initRowColors($rowColors = array())
   {
      $this->rowColors = array_merge(array(), $rowColors);	
   }

   /**
   * Generates/prepares report data
   * @param String mySQL query
   * @return none
   */       
   function generateReport($query)
   {
      
      $resultSet = mysql_query($query) or die('Can not execute query');
      
      if(mysql_num_rows($resultSet))
      {
      	 $data = array();
      	 
      	 $columns = array();
      	 
      	 $j = 0; 
         
         //Traversing and storing the result resource
         while($row = mysql_fetch_array($resultSet))
         {
            foreach($row as $i=>$v)
            {
               	if(!is_numeric($i))
               	{
               	   if($j==0)
               	   {
               	      $columns[] = $i;	
               	   }
               	   
               	   $data[$j][$i] = $v;         	   
                }          
            }
            $j++;   
            
         }//end of while	
         
         //Generating report data table
         $string = '';         
         $string .= $this->createTable();
         $string .= $this->createHeaders($columns);
         $string .= $this->createRows($data);
         $string .= $this->closeTable();
                                             
         if(strlen($this->reportData)>29) //if report data is already initialized
         {
            $this->reportData = $this->reportData.'<p>'.$string.'</p>'; //append current data to previous 
         }
         else
         {
            $this->reportData = $string;
         }
      }//End of if_0
      
   }//EO Method

   /**
   * Gets PDF report
   * @param none
   * @return none
   */       
   function getPdfReport()
   {
      //Saving report data to temporary file         
      $this->saveReportData();
      
      $htmlUrl = $this->htmlUrl;
      $pdfFileName = basename($htmlUrl).'.pdf';
      
      // Outputting PDF Report
      header("Content-type: application/pdf");
               
      // It will be called basename($this->htmlUrl).pdf         
      header("Content-Disposition: attachment; filename=".$pdfFileName);
      
      // The PDF source is the returned value of method generatePdfReport()      
      echo $this->generatePdfReport();    
      
      //Removing the temporary html file
      unlink($this->htmlPath);
	
   }//EO Method
   
   /**
   * Saves report data to given file
   * @param none
   * @return none
   */       
   function saveReportData()
   {
      if(strlen($this->reportData)>29) //if report data has atleast 1 row 
      {
         $fp = fopen($this->htmlPath, "w") OR die("Can not open file ".$this->htmlPath);
         fwrite($fp, $this->reportData) OR die("Can not write to file ".$this->htmlPath);;
         fclose($fp);   	
      }
      else
      {
         die('No Report Data Found');	
      }
            	
   }//EO Method

   /**
   * Generates PDF report from remote application
   * @param none
   * @return report data on PDF mode
   */          
   function generatePdfReport()
   {
        $remoteApp     = $this->remoteApp;
      	$waterMarkHtml = "phpresgroup.org";//change it according to your need 
      	$htmlUrl       = urlencode($this->htmlUrl);      	
      	$pdfWidth      = $this->pdfWidth;
      	$pdfVersion    = $this->pdfVersion;
      	
      	$requestString = "process_mode=single&URL=$htmlUrl&pixels=$pdfWidth&scalepoints=1&renderimages=1&renderlinks=1&renderfields=1&media=Letter&cssmedia=screen&leftmargin=10&rightmargin=10&topmargin=15&bottommargin=15&encoding=&headerhtml=&footerhtml=&watermarkhtml=$waterMarkHtml&method=fpdf&pdfversion=$pdfVersion&output=0&convert=Convert+File";             
      
        //Init the curl session 
        $ch = curl_init(); 
        // set the post-to url (do not include the ?query+string here!) 
        curl_setopt ($ch, CURLOPT_URL, $remoteApp);
        // Header control 
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        //Tell it to make a POST, not a GET 
        curl_setopt ($ch, CURLOPT_POST, 1);
        // Put the query string here starting without "?"
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $requestString);
        // This allows the output to be set into a variable
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        // execute the curl session and return the output to a variable $response        
        $response = curl_exec ($ch);
        // Close the curl session 
        curl_close ($ch);        
        
        return $response;      		
   }
   /**
   * Debugs dump/data
   * @param $dump
   * @return none
   */
   function dBug($dump)
   {
   	echo '<pre>';
   	print_r($dump);
   	echo '</pre>';
   }
   
   /** 
   * Creates table
   * @param none
   * @return String <table ...>
   */
   function createTable()
   {
      return '<table aign=center width=100% border=1>';	
   }
   
   /** 
   * Closes table
   * @param none
   * @return String </table>
   */   
   function closeTable()
   {
      return '</table>';	
   }
   
   /** 
   * Creates table headers (TH)
   * @param Array report columns
   * @return String TR & THs with data.
   */
   function createHeaders($array)
   {
   	 $string = '';	 
   	 $string .= '<tr>';	
      
      for($i=0;$i<sizeof($array); $i++)
      {
         $string .= "<th align=left>$array[$i]</th>";	
      }
      $string .= '</tr>';		
      
      return $string;
      
   }//EO Method

   /** 
   * Creates table rows (TR)
   * @param Array report row
   * @return String TRs
   */   
   function createRows($array)
   {
   	 $string = '';	 
   	 
   	 if(!count($this->rowColors))
   	 {
   	     array_unshift($this->rowColors, '#f5f5f5','#f5f5f5');	
   	 }   	 
   	 
   	 $numColors = count($this->rowColors);
   	  
     for($i=0; $i<sizeof($array); $i++)
     {
        $string .= "<tr bgcolor=".$this->rowColors[$i%$numColors].">";	      
        foreach($array[$i] as $v)
        {
           $string .= "<td>$v</td>";	
        }      
        $string .= '</tr>';		
      }
      
      return $string;
      
   }//EO Method
   
}//EO Class
?>