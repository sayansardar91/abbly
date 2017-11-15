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

$db = new database();
//$req = "select * from view_admission where reg_no = '$reg'";

$req = "SELECT *,(SELECT `bed_name` FROM `bed_details` WHERE `id` IN (Select bed_no FROM patient_details WHERE reg_no = '".$reg."')) AS `bed_no` FROM view_admission WHERE `reg_no` = '".$reg."'";

$query = $db->conn->query($req);
$reg_id=$cont_no=$patient_name=$address=$age=$m_age=$sex=$b_group=$pt_q=$rel =$gd_q =$po =$ps =$dist =$date_admit =$time_admit =$doc =$diog ="";

while ($row = mysqli_fetch_assoc($query)) {
     $reg_id = $row['reg_no'];
     $cont_no = $row['contact_no_1'];
     $bed_no = $row['bed_no'];
	 if(empty($row['middle_name'])){
		 $patient_name = $row['first_name']." ".$row['last_name'];
	 }else{
	 	$patient_name = $row['first_name']." ".$row['middle_name']." ".$row['last_name'];
	 }
	 $address = $row['address'].",".$row['pin'];
	 $age = ($row['age'] == 0)?"N/A":$row['age']." years";
	 $m_age = ($row['m_age'] == 0)?"N/A":$row['m_age']." years";
	 $sex = $row['sex'];
	 $b_group = $row['blood_group'];
	 $pt_q = (empty($row['patient_quali']))?"N/A":$row['patient_quali'];
     $rel = $row['relation']." ".$row['gurd_name'];
	 /*switch($row['relation']){
		 case 1:
		 	  $rel = "S/o ".$row['gurd_name'];
		      break;
		case 2:
		 	  $rel = "D/o ".$row['gurd_name'];
		      break;
		case 3:
		 	  $rel = "W/o ".$row['gurd_name'];
		      break;
		case 4:
		 	  $rel = "C/o ".$row['gurd_name'];
		      break;
	 }*/
	 $gd_q = (empty($row['gurd_quali']))?"N/A":$row['gurd_quali'];
	 $po = (empty($row['po']))?"N/A":$row['po'];
	 $ps = (empty($row['ps']))?"N/A":$row['ps'];
	 $dist = (empty($row['dist']))?"N/A":$row['dist'];
	 $date_admit = $row['admit_date'];
	 $time_admit = $row['admit_time'];
	 $doc = 'Dr. '.$row['doc_name'];
	 $diog = $row['diog_name'];
}


$dompdf = new DOMPDF();
$dompdf->set_paper("legal", 'portrait');



$html = '
<html>
<head>
<title>Application Form</title>
 <style>
    div {line-height: 1;color:#0033FF;}
    h1, p {margin: 0;}
    h4, p {margin: 0;}
    h2, p {margin: 0;}
	span {font-style:italic; font-family:Arial, Helvetica, sans-serif;}
    
    #reg_label {
            position: absolute;
            top: 130px;
         }
    #reg_no {
            position: absolute;
            top: 127px;
            left:120px;
         }
    #reg_blank {
            position: absolute;
            top: 130px;
            left:112px;
         }
    #bed_label {
            position: absolute;
            top: 130px;
            left: 330px;
         }
    #bed_no {
            position: absolute;
            top: 127px;
            left:395px;
         }
    #bed_blank {
            position: absolute;
            top: 130px;
            left:390px;
         }
    #mob_label {
            position: absolute;
            top: 130px;
            left: 470px;
         }
    #mob_no {
            position: absolute;
            top: 127px;
            left:560px;
         }
    #mob_blank {
            position: absolute;
            top: 130px;
            left:555px;
         }
    #name_label {
            position: absolute;
            top: 155px;
         }
    #name {
            position: absolute;
            top: 150px;
            left:135px;
         }
    #name_blank{
            position: absolute;
            top: 155px;
            left:130px;
         }
    #age_label{
            position: absolute;
            top: 155px;
            left:500px;
        }
    #age{
            position: absolute;
            top: 150px;
            left:550px;
        }
    #age_blank{
            position: absolute;
            top: 155px;
            left:535px;
        }
    #mage_label{
            position: absolute;
            top: 180px;
        }
    #mage{
            position: absolute;
            top: 177px;
            left:130px;
        }
    #mage_blank{
        position: absolute;
         top: 180px;
         left:125px;
    }
    #gen_label{
         position: absolute;
         top: 180px;
         left:220px;
    }
    #gen{
         position: absolute;
         top: 177px;
         left:270px;
    }
    #gen_blank{
        position: absolute;
         top: 180px;
         left:252px;
    }
    #bgroup_label{
        position: absolute;
         top: 180px;
         left:300px;
    }
    #bgroup{
        position: absolute;
         top: 177px;
         left:395px;
    }
    #bgroup_blank{
        position: absolute;
         top: 180px;
         left:392px;
    }
    #quli_label {
        position: absolute;
         top: 180px;
         left:460px;
    }
    #quli {
        position: absolute;
         top: 177px;
         left:560px;
    }
    #quli_blank {
        position: absolute;
         top: 180px;
         left:554px;
    }
    #rel_label {
        position: absolute;
         top: 210px;
    }
    #rel {
        position: absolute;
         top: 206px;
         left: 150px;
    }
    #rel_blank {
        position: absolute;
         top: 210px;
         left: 128px;
    }
    #gurd_label{
        position: absolute;
         top: 210px;
         left:400px;
    }
    #gurd{
        position: absolute;
         top: 206px;
         left:500px;
    }
    #gurd_blank{
        position: absolute;
         top: 210px;
         left:493px;
    }
    #add_label {
        position: absolute;
        top: 235px;
    }
    #add{
        position: absolute;
        top: 230px;
        left:120px;
    }
    #add_blank{
        position: absolute;
        top: 235px;
        left:112px;
    }
    #po_label {
        position: absolute;
        top: 265px;
        left:16px;
    }
    #po{
        position: absolute;
        top: 260px;
        left:80px;
    }
    #po_blank {
        position: absolute;
        top: 265px;
        left:45px;
    }
    #ps_label {
        position: absolute;
        top: 265px;
        left:250px;
    }
    #ps{
        position: absolute;
        top: 260px;
        left:300px;
    }
    #ps_blank{
        position: absolute;
        top: 265px;
        left:276px;
    }
    #dist_label {
        position: absolute;
        top: 265px;
        left:400px;
    }
    #dist{
        position: absolute;
        top: 260px;
        left:450px;
    }
    #dist_blank{
        position: absolute;
        top: 265px;
        left:433px;
    }
    #adm_label {
        position: absolute;
        top: 295px;
    }
    #adm{
        position: absolute;
        top: 290px;
        left:150px;
    }
    #adm_blank{
        position: absolute;
        top: 295px;
        left:146px;
    }
    #time_label {
        position: absolute;
        top: 295px;
        left:500px;
    }
    #time{
        position: absolute;
        top: 290px;
        left:550px;
    }
    #time_blank{
        position: absolute;
        top: 295px;
        left:543px;
    }
    #doc_label {
        position: absolute;
        top: 320px;
    }
    #doc{
        position: absolute;
        top: 316px;
        left:150px;
    }
    #doc_blank{
        position: absolute;
        top: 320px;
        left:135px;
    }
    #dia_label {
        position: absolute;
        top: 345px;
    }
    #dia{
        position: absolute;
        top: 340px;
        left:165px;
    }
    #dia_blank{
        position: absolute;
        top: 345px;
        left:163px;
    }
    #treat_label {
        position: absolute;
        top: 370px;
    }
    #treat_blank{
        position: absolute;
        top: 370px;
        left:168px;
    }
    #ag_label {
        position: absolute;
        top: 600px;
    }
    #agr_label {
        position: absolute;
        top: 650px;
    }
    #agr_label2 {
        position: absolute;
        top: 20px;
    }
    #dec_img {
        position: absolute;
        top: 270px;
    }
    #sign_label1{
        position: absolute;
        top: 330px;
    }
    #sign1{
        position: absolute;
        top: 330px;
        left:70px;
    }
    #dt_label{
        position: absolute;
        top: 330px;
        left:290px;
    }
    #dt{
        position: absolute;
        top: 330px;
        left:330px;
    }
    #tt_label{
        position: absolute;
        top: 330px;
        left:480px;
    }
    #tt{
        position: absolute;
        top: 330px;
        left:530px;
    }
    
    #dob_label{
        position: absolute;
        top:445px;
    }
    #dob_blank{
        position: absolute;
        top:445px;
        left:104px;
    }
    #dth_label{
        position: absolute;
        top:468px;
    }
    #dth_blank{
        position: absolute;
        top:468px;
        left:170px;
    }
    #dthc_label{
        position: absolute;
        top:495px;
    }
    #dthc_blank{
        position: absolute;
        top:495px;
        left:126px;
    }
    #dtc_label{
        position: absolute;
        top:520px;
    }
    #dtc_blank{
        position: absolute;
        top:520px;
        left:142px;
    }
    #dot_label{
        position: absolute;
        top:445px;
        left:237px;
    }
    #dot_blank{
        position: absolute;
        top:445px;
        left:325px;
    }
    #dos_label{
        position: absolute;
        top:445px;
        left:460px;
    }
    #dos_blank{
        position: absolute;
        top:445px;
        left:486px;
    }
    #dow_label{
        position: absolute;
        top:445px;
        left:578px;
    }
    #dow_blank{
        position: absolute;
        top:445px;
        left:627px;
    }
    #nm_label{
        position: absolute;
        top: 360px;
    }
    #nm{
        position: absolute;
        top: 360px;
        left:50px;
    }
    #rl_label{
        position: absolute;
        top: 360px;
        left:270px;
    }
    #rl{
        position: absolute;
        top: 360px;
        left:365px;
    }
    #add_label1{
        position: absolute;
        top: 380px;
    }
    #add_line1{
        position: absolute;
        top: 380px;
        left:65px;
    }
    #add_line2{
        position: absolute;
        top: 400px;
        left:65px;
    }
    #add_line3{
        position: absolute;
        top: 430px;
        left:65px;
    }
    #wt{
        position: absolute;
        top: 500px;
    }
    #nm_label1{
        position: absolute;
        top: 500px;
        left: 150px;
    }
    #nm1{
        position: absolute;
        top: 500px;
        left: 200px;
    }
    #rl_label1{
        position: absolute;
        top: 530px;
        left: 150px;
    }
    #rl1{
        position: absolute;
        top: 530px;
        left: 240px;
    }
    #add1{
        position: absolute;
        top: 550px;
        left: 150px;
    }
    #addl1{
        position: absolute;
        top: 550px;
        left: 215px;
    }
    #decl{
        position: absolute;
        top: 590px;
    }
    #sig_label{
        position: absolute;
        top: 660px;
        left: 215px;
    }
    #sig{
        position: absolute;
        top: 660px;
        left: 285px;
    }
    #rltn_label{
        position: absolute;
        top: 690px;
        left: 215px;
    }
    #rltn{
        position: absolute;
        top: 690px;
        left: 310px;
    }
    #signet_l{
        position: absolute;
        top: 880px;
    }
    #signet{
        position: absolute;
        top: 880px;
        left: 80px;
    }
    #box{
        position: absolute;
        top: 755px;
        left: 200px;
    }
    #lp{
        position: absolute;
        top:900px;
        left: 80px;
    }
    
</style>
</head>

<body>
    <div>
    	<div align="center"><h1>SWARNAKAMAL NURSING HOME</h1></div>
        <div>
            <div align="center"><h4>NAIHATI, P.O.-BADARTALA, NORTH 24 PARGANAS</h4></div>
        </div>
        <div>&nbsp;</div>
        <div>
        	 <div align="center"><h2><strong><u>ADMISSION FORM</u></strong></h2></div>
        </div>
    </div>
        
    	<div id="reg_label">Registration No :</div>
        <div id="reg_no"><span style="color:black;">'.$reg_id.'</span></div>
        <div id="reg_blank">..............................................</div>
        <div id="bed_label">Bed No :</div>
        <div id="bed_no"><span style="color:black;">'.$bed_no.'</span></div>
        <div id="bed_blank">...........</div>
        <div id="mob_label">Contact No :</div>
        <div id="mob_no"><span style="color:black;">'.$cont_no.'</span></div>
        <div id="mob_blank">..............................................</div>
        <div id="name_label">1. Name of Patient : </div>
        <div id="name"><span style="color:black;">'.$patient_name.'</span></div>
        <div id="name_blank">............................................................................................</div>
        <div id="age_label">Age : </div>
        <div id="age"><span style="color:black;">'.$age.'</span></div>
        <div id="age_blank">...................................................</div>
        <div id="mage_label">2. Age of Marrige : </div>
        <div id="mage"><span style="color:black;">'.$m_age.'</span></div>
        <div id="mage_blank">.......................</div>
	<div id="gen_label">Sex : </div>
        <div id="gen"><span style="color:black;">'.$sex.'</span></div>
        <div id="gen_blank">...........</div>
	<div id="bgroup_label">Blood Group : </div>
        <div id="bgroup"><span style="color:black;">'.$b_group.'</span></div>
        <div id="bgroup_blank">................</div>
        <div id="quli_label">Qualification : </div>
        <div id="quli"><span style="color:black;">'.$pt_q.'</span></div>
        <div id="quli_blank">...............................................</div>
        <div id="rel_label">3. S/o,D/o,W/o,C/o : </div>
        <div id="rel"><span style="color:black;">'.$rel.'</span></div>
        <div id="rel_blank">....................................................................</div>
        <div id="gurd_label">Qualification : </div>
        <div id="gurd"><span style="color:black;">'.$gd_q.'</span></div> 
        <div id="gurd_blank">..............................................................</div>
        <div id="add_label">4. Address : Vill. </div>
        <div id="add"><span style="color:black;">'.$address.'</span></div>
        <div id="add_blank">.............................................................................................................................................................</div>
        <div id="po_label">P.O:</div>
	<div id="po"><span style="color:black;">'.$po.'</span></div>
        <div id="po_blank">..................................................</div>
        <div id="ps_label">P.S:</div>
	<div id="ps"><span style="color:black;">'.$ps.'</span></div>   
        <div id="ps_blank">..............................</div>
        <div id="dist_label">Dist:</div>
        <div id="dist"><span style="color:black;">'.$dist.'</span></div>
        <div id="dist_blank">.............................................................................</div>
        <div id="adm_label">5. Date of Admission : </div>
        <div id="adm"><span style="color:black;">'.$date_admit.'</span></div>
        <div id="adm_blank">........................................................................................</div>
        <div id="time_label">Time : </div>
	<div id="time"><span style="color:black;">'.$time_admit.'</span></div>
        <div id="time_blank">.................................................</div>
        <div id="doc_label">6. Attending Doctor: </div>
        <div id="doc"><span style="color:black;">'.$doc.'</span></div>
        <div id="doc_blank">.......................................................................................................................................................</div>
        <div id="dia_label">7. Provisional Diagnosis: </div>
        <div id="dia"><span style="color:black;">'.$diog.'</span></div>
        <div id="dia_blank">................................................................................................................................................</div>
        <div id="treat_label">8. Treatment / Operation : </div>
        <div id="treat"><span style="color:black;"></span></div>
        <div id="treat_blank">...............................................................................................................................................</div>
        <div id="dob_label">9. Date of Birth</div>
        <div id="dob_blank">.................................</div>
        <div id="dot_label">Date of Time</div>
        <div id="dot_blank">.................................</div>
        <div id="dos_label">Sex</div>
        <div id="dos_blank">.......................</div>
        <div id="dow_label">Weight</div>
        <div id="dow_blank">............................</div>
        <div id="dth_label">10. Date &amp; Time of Death </div>
        <div id="dth_blank">..............................................................................................................................................</div>
        <div id="dthc_label">11. Cause of Death </div>
        <div id="dthc_blank">.........................................................................................................................................................</div>
        <div id="dtc_label">12. Date of Discharge </div>
        <div id="dtc_blank">.....................................................................................................................................................</div>
	<div style="width:100%" align="center" id="ag_label">
		<strong>AGREEMENT WITH NURSING HOME &amp; AUTHORISATION FOR</strong><br />
		<strong>MEDICAL AND / OR SURGICAL TREATMENT / PROCEDURE</strong>
	</div>
	<div style="width:100%"align="justify" id="agr_label">
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I do hearby declare that I have at my sole risk and responsibility admitted myself / my ward this day at this nursing home at my will.</p>
		<p>&nbsp;</p>
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I myself and on behalf of my patient hearby agree to abide by the rules and regulations of this nursing home.</p>
		<p>&nbsp;</p>
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Further I agree and undertake to bear all the expenses of seat rents, messing charges, surgical fees, nurses charges, cost of medicines and or any other expenses that will be necessary for the treatment of myself / my ward till I / my ward be discharged.</p>
		<p>&nbsp;</p>
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I hereby authorise my attending Doctor <span style="color:black;">'.$doc.'</span> and his team (inclusive) of Anesthetosts and whoever he / she may designate as his / her assistants / colleagues. to administer such treatment and / or to perform the operations / procedures as necessary on myself / my ward at this nursing home.</p>
		<p>&nbsp;</p>
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I am aware of the sterilization, anaesthesia, resuscitation and other facilities at this nursing home.</p>
		<p>&nbsp;</p>
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I have had the opportunities of seeking clarifications regarding the hazards of synaesthesia, operation / or any other procedures and any untoward complication that may arise and have received satisfactory clarifications.</p>
		<p>&nbsp;</p>
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I have discussed the type of anaesthesia with the Anaesthetist and consent that the type of anaesthesia and the choice of anaesthetic agents be decided by the attending anaesthesiologist. I am aware that the anaesthetic agents in a small percentage of patients are to produce allegic reactions, central nervous, cardiovascular depression, systemic diseses and ever death.</p>
		<p>&nbsp;</p>
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The propsed aim of the procedure / treatment / operation have been discussed in details through no gurantee has been given for any aspect to the results. Any sort of compilations like intention bleeding or any other charges including a recurrence of disease is possible after treatment due to factors beyond doctor'."'".'s control. Though guidance will be given on further management, the doctors and authority of this nursing home disclaim all responsibilities final of otherwise the same.</p>
		<div style="width:100%; font-style:italic;" align="right"><strong>Continued................</strong></div>
		<div style="page-break-after: always;"></div>
	</div>
	
        <div id="agr_label2">
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I further authorised the doctors and authority of this nursing home to take any such steps that the / may consider necessary in the even of an emergency or if any other doctors, performing other additional operations / procedures including transfusion of blood should the situation so demand and the possible complication of blood transfusion including even death has also been properly explained to me.</p>
		<p>&nbsp;</p>
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I also authorise to conduct vaginal delevery by medical officer or trained nurse in emergency or in absence of attending doctor.</p>
		<p>&nbsp;</p>
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I hereby authorise the authority of nursing home to use its agents or its devices to dispose off any removed tissues and any amputated member of my / my ward'."'".'s body in any manner deemed proper by the nursing home.</p>
		<p>&nbsp;</p>
		<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;All the above points have been explained to me is Bengali / English / Hindi / Nepali that understand and am fully aware of the implications.</p>
        </div>
        
	<div style="width:100%" align="center" id="dec_img">
		<img src="../images/BC003.png" width="70%" height="30px" />
	</div>
        <div id="sign_label1">Signature:</div>
        <div id="sign1">......................................................</div>
        <div id="dt_label">Date:</div>
        <div id="dt">....................................</div>
        <div id="tt_label">Time:</div>
        <div id="tt">....................................</div>
        <div id="nm_label">Name : </div>
        <div id="nm">......................................................</div>
        <div id="rl_label">Relationship : </div>
        <div id="rl">...............................................................................</div>
        <div id="add_label1">Address : </div>
        <div id="add_line1">..............................................................................................................................................................</div>
        <div id="add_line2">..............................................................................................................................................................</div>
        <div id="add_line3"><p>
                <strong>(Authorisation must be signed by patient or nearest relative in the case of minor or when the patient is physically or mentally incompetent.)</strong>
        </p></div>
        <div id="wt">Witness: </div>
        <div id="nm_label1">Name : </div>
        <div id="nm1">...............................................................................</div>
        <div id="rl_label1">Relationship : </div>
        <div id="rl1">......................................................................</div>
        <div id="add1">Address : </div>
        <div id="addl1">......................................................................</div>
        <div id="decl">
		<p>Consent of sterilization operation - </p>
		<p>&nbsp;&nbsp;&nbsp;We both husband &amp; wife have discussed among our selves and have decided to under go Tube to my / Vasectomy operation on myself / my spouse and giving consent to the operation.</p>
	</div>
        <div id="sig_label">Signature : </div>
        <div id="sig">......................................................................</div>
        <div id="rltn_label">Relationship : </div>
        <div id="rltn">..................................................................</div>
        <div id="signet_l">Signature : </div>
        <div id="signet">..................................................................</div>
        <div style="width:50%;float:right;" id="box">
                <img src="../images/note.png" width="90%"/>
        </div>
        <div id="lp">(At the time of Discharge)</div>
        	
</body></html>';

$dompdf->load_html($html);
$dompdf->render();

$canvas = $dompdf->get_canvas();
$font = Font_Metrics::get_font("helvetica", "bold");
$canvas->page_text(870, 18, "Date : ".date('d-M-Y'),$font, 12, array(0,0,0));
$canvas->page_text(870, 35, "Time : ".date('h:i:s A'),$font, 12, array(0,0,0));
$canvas->page_text(280,985 , "{PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));

$dompdf->stream($reg_id.".pdf", array('Attachment' => 0));?>


