<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of doctors
 *
 * @author Sayan
 */
class doctors extends database {

    function __construct() {
        parent::__construct();
    }
    
    function addDoc($post){
        
        $val="";
        $result = $this->dbRowReplaceInsert("doc_details", $post);
        return $result;
    }
    function getList($field, $param){
        $req = "select distinct `$field` from `doc_details` where `$field` like'%" . $param . "%' ";
       
        $query = $this->conn->query($req);

        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array('label' => $row[$field]);
        }
        echo json_encode($results);
    }
    function allDoctors(){
        $req = "SELECT dd.`id`,dd.`doc_reg`, dd.`doc_name`, "
                . "if(dd.`dept_id`=0,'Anesthetist',dp.`dept_name`) `dept_name`, "
                . "dd.`contact_no`, dd.`doc_address`, dd.`doct_quli`, "
                . "dd.`remarks`, dd.`doj`, dd.`dor`, dd.`status` FROM "
                . "`doc_details` dd LEFT JOIN `department_details` dp "
                . "ON dd.`dept_id` = dp.`id`";
        $result = $this->conn->query($req);
        $typeArray = array();
        while ($row = $result->fetch_assoc()) {
            $typeArray[] = array("id" => $row['id'],
                "doc_reg" => $row['doc_reg'],
                "doc_name" => $row['doc_name'],
                "dept_name" => $row['dept_name'],
                "contact_no" => $row['contact_no'],
                "doc_address" => $row['doc_address'],
                "doct_quli" => $row['doct_quli'],
                "remarks" => $row['remarks'],
                "doj" => $row['doj'],
                "dor" => $row['dor'],
                "status" => $row['status']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }
    function docAttend(){
        $req = "SELECT c.`dept_name`,b.`doc_name`,a.* "
                . "FROM `doc_attendance` a INNER JOIN `doc_details` b ON a.`doc_id` = b.`id` INNER JOIN `department_details` c ON b.`dept_id` = c.`id` "
                . "WHERE b.`status` = 1";
        $result = $this->conn->query($req);
        $typeArray = array();
        while ($row = $result->fetch_assoc()) {
            $typeArray[] = array("id" => $row['id'],
                "dept_name" => $row['dept_name'],
                "doc_name" => $row['doc_name'],
                "date" => $row['date'],
                "in_time" => $row['in_time'],
                "out_time" => $row['out_time'],
                "status" => $row['status']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }
    function docList($dept){
        $req = "SELECT `id`,`doc_name`"
                . "FROM `doc_details` WHERE `dept_id` = $dept AND doc_type = 'D'";
        $result = $this->conn->query($req);
        $typeArray = array();
        while ($row = $result->fetch_assoc()) {
            $typeArray['doc_details'][] = array("id" => $row['id'],
                "doc_name" => $row['doc_name']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }
	function docListAll(){
        $req = "SELECT `id`,`doc_name`"
                . "FROM `doc_details` WHERE doc_type = 'D'";
        $result = $this->conn->query($req);
        $typeArray = array();
        while ($row = $result->fetch_assoc()) {
            $typeArray[] = array("id" => $row['id'],
                "doc_name" => $row['doc_name']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }
	function ansthList(){
        $req = "SELECT `id`,`doc_name`"
                . "FROM `doc_details` WHERE `doc_type` = 'A'";
        $result = $this->conn->query($req);
        $typeArray = array();
        while ($row = $result->fetch_assoc()) {
            $typeArray['doc_details'][] = array("id" => $row['id'],
                "doc_name" => $row['doc_name']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }
    
    function allSister(){
        $req = "SELECT id, if(`emp_middlename`=null,concat(`emp_firstname`,' ',`emp_lastname`), "
                . "concat(`emp_firstname`,' ',`emp_middlename`,' ',`emp_lastname`)) `doc_name` FROM `employee_details` WHERE `emp_type`='S'";
        $result = $this->conn->query($req);
        $rowcount=mysqli_num_rows($result);
        $typeArray = array();
        if($rowcount>0){
            while ($row = $result->fetch_assoc()) {
            $typeArray['doc_details'][] = array("id" => $row['id'],
                "doc_name" => $row['doc_name']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
        }
        
    }
    /*function allAssist(){
        $req = "SELECT id, if(`emp_middlename`=null,concat(`emp_firstname`,' ',`emp_lastname`), "
                . "concat(`emp_firstname`,' ',`emp_middlename`,' ',`emp_lastname`)) `doc_name` FROM `employee_details` WHERE `emp_type`='S'";
        $result = $this->conn->query($req);
        $rowcount=mysqli_num_rows($result);
        $typeArray = array();
        if($rowcount>0){
            while ($row = $result->fetch_assoc()) {
            $typeArray['doc_details'][] = array("id" => $row['id'],
                "doc_name" => $row['doc_name']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
        }
        
    }*/
    function setStatus($post) {
        extract($post);
        $user_id = $this->conn->real_escape_string($id);
        $status = $this->conn->real_escape_string($status);
        $sql = $this->conn->query("UPDATE `doc_details` SET `status`='$status' WHERE id='$id'");
    }
    function chngAttend($post){
        extract($post);
        $user_id = $this->conn->real_escape_string($id);
        $status = $this->conn->real_escape_string($status);
        $query="";
        if($status){
            $query = "UPDATE `doc_attendance` SET `date`='".date("Y-m-d")."', `in_time`='".date("H:i:s")."', `status`='$status' WHERE id='$id'";
        }else{
            $query = "UPDATE `doc_attendance` SET `date`='".date("Y-m-d")."', `out_time`='".date("H:i:s")."', `status`='$status' WHERE id='$id'";
        }
        
        $sql = $this->conn->query($query);
    }
    function getDocList($param){
        $req = "select * from `doc_details` where `doc_reg`='" . $param . "'";
        //echo $req;
        $query = $this->conn->query($req);
        $row = mysqli_fetch_assoc($query);
        $results = "";
        foreach ($row as $key => $val) {
            $results[$key] = $val;
        }
        echo json_encode($results);
    }
	function getDocAmount($param){
		$req = "select (SELECT sum(amount_paid) from `doctor_dr` WHERE `atd_doctor` = $param GROUP BY `atd_doctor`) AS `amtodoc`, 
(SELECT sum(amount_paid) from `doctor_cr` WHERE `atd_doctor` = $param GROUP BY `atd_doctor`) AS `amtonhm`,
(SELECT sum(amount_paid) from `doctor_adv` WHERE `atd_doctor` = $param GROUP BY `atd_doctor`) AS `amtadv`,
(SELECT sum(amount_paid) from `nshm_adv` WHERE `atd_doctor` = $param GROUP BY `atd_doctor`) AS `amtadvn`;";
        /*echo $req;
		die;*/
        $query = $this->conn->query($req);
		$count = mysqli_num_rows($query);
		if($count){
			$row = mysqli_fetch_assoc($query);
			$results = "";
			$valPrev = $valNext = 0;
			foreach ($row as $key => $val) {
				$results[$key] = ($val)?$val:0;
			}
			$results['success'] = 1;
			echo json_encode($results);
		}else{
			$arr = array('success'=>0);	
			echo json_encode($arr);
		}
	}
	function getDocAmountRange($param,$fd,$td){
		$from = ($fd != null)?$fd:date('Y-m-d', strtotime(date('Y-m-1')));
        $to = ($td != null)?$td:date('Y-m-d');
		$req = "select (SELECT sum(amount_paid) from `doctor_dr` WHERE `atd_doctor` = $param AND `payment_date` BETWEEN '$from' AND '$to' GROUP BY `atd_doctor`) AS `amtodoc`, 
(SELECT sum(amount_paid) from `doctor_cr` WHERE `atd_doctor` = $param AND `payment_date` BETWEEN '$from' AND '$to' GROUP BY `atd_doctor`) AS `amtonhm`, 
(SELECT sum(amount_paid) from `doctor_adv` WHERE `atd_doctor` = $param AND `payment_date` BETWEEN '$from' AND '$to' GROUP BY `atd_doctor`) AS `amtadv`,
(SELECT sum(amount_paid) from `nshm_adv` WHERE `atd_doctor` = $param AND `payment_date` BETWEEN '$from' AND '$to' GROUP BY `atd_doctor`) AS `amtadvn`;";
        //echo $req;
		//die;
        $query = $this->conn->query($req);
		$count = mysqli_num_rows($query);
		if($count){
			$row = mysqli_fetch_assoc($query);
			$results = "";
			$valPrev = $valNext = 0;
			foreach ($row as $key => $val) {
				$results[$key] = ($val)?$val:0; 
			}
			$results['from_date'] = $from;
			$results['to_date'] = $to;
			$results['success'] = 1;
            $results['dr_list'] = $this->getDRList($param,$from,$to);
            $results['cr_list'] = $this->getCRList($param,$from,$to);
            $results['adv_list'] = $this->getAdvList($param,$from,$to);
            $results['advn_list'] = $this->getAdvNhmList($param,$from,$to);
			echo json_encode($results);
		}else{
			$arr = array('success'=>0);	
			echo json_encode($arr);
		}
	}

    function getDRList($id,$fd,$td){
        $from = ($fd != null)?$fd:date('Y-m-d', strtotime(date('Y-m-1')));
        $to = ($td != null)?$td:date('Y-m-d');
        $req = "Select ptd.reg_no,ptd.admit_date,ptd.first_name,ptd.middle_name,ptd.last_name,dr.payment_date,dr.amount_paid from `doctor_dr` dr 
                JOIN `patient_details` ptd ON dr.patient_id = ptd.id 
                WHERE dr.payment_date BETWEEN '$from' AND '$to' AND dr.atd_doctor = $id ORDER BY dr.payment_date ASC";
        $result = $this->conn->query($req);
        $rowcount=mysqli_num_rows($result);
        $typeArray = array();
        $sno = 1;
        if($rowcount>0){
            while ($row = $result->fetch_assoc()) {
            $typeArray[] = array( "sno"=>$sno,
                                  "reg_no" => $row['reg_no'],
                                  "pt_name" => ($row['middle_name'])?$row['first_name']." ".$row['middle_name']." ".$row['last_name']:$row['first_name']." ".$row['last_name'],
                                  "admit_date" => date('d-m-Y',strtotime($row['admit_date'])),
                                  "amount_paid" => $row['amount_paid'],
                                  "payment_date" => date('d-m-Y',strtotime($row['payment_date'])));
            $sno++;
            }   
        }
        return $typeArray;
    }
    function getCRList($id,$fd,$td){
        $from = ($fd != null)?$fd:date('Y-m-d', strtotime(date('Y-m-1')));
        $to = ($td != null)?$td:date('Y-m-d');
        $req = "Select ptd.reg_no,ptd.admit_date,ptd.first_name,ptd.middle_name,ptd.last_name,cr.payment_date,cr.amount_paid from `doctor_cr` cr 
                JOIN `patient_details` ptd ON cr.patient_id = ptd.id 
                WHERE cr.payment_date BETWEEN '$from' AND '$to' AND cr.atd_doctor = $id ORDER BY cr.payment_date ASC";
        $result = $this->conn->query($req);
        $rowcount=mysqli_num_rows($result);
        $typeArray = array();
        $sno = 1;
        if($rowcount>0){
            while ($row = $result->fetch_assoc()) {
            $typeArray[] = array("sno"=>$sno,"reg_no" => $row['reg_no'],
                "pt_name" => ($row['middle_name'])?$row['first_name']." ".$row['middle_name']." ".$row['last_name']:$row['first_name']." ".$row['last_name'],
                "admit_date" => date('d-m-Y',strtotime($row['admit_date'])),
                "amount_paid" => $row['amount_paid'],
                "payment_date" => date('d-m-Y',strtotime($row['payment_date'])));
            $sno++;
            }   
        }
        return $typeArray;
    }
    function getAdvList($id,$fd,$td){
        $from = ($fd != null)?$fd:date('Y-m-d', strtotime(date('Y-m-1')));
        $to = ($td != null)?$td:date('Y-m-d');
        $req = "Select * from `doctor_adv` WHERE payment_date BETWEEN '$from' AND '$to' AND atd_doctor = $id ORDER BY payment_date ASC";
        $result = $this->conn->query($req);
        $rowcount=mysqli_num_rows($result);
        $typeArray = array();
        $sno = 1;
        if($rowcount>0){
            while ($row = $result->fetch_assoc()) {
            $typeArray[] = array("sno"=>$sno,
                "amount_paid" => $row['amount_paid'],
                "payment_date" => date('d-m-Y',strtotime($row['payment_date'])),
                "remarks" => $row['remarks']
                );
            $sno++;
            }   
        }
        return $typeArray;
    }
    function getAdvNhmList($id,$fd,$td){
        $from = ($fd != null)?$fd:date('Y-m-d', strtotime(date('Y-m-1')));
        $to = ($td != null)?$td:date('Y-m-d');
        $req = "Select * from `nshm_adv` WHERE payment_date BETWEEN '$from' AND '$to' AND atd_doctor = $id ORDER BY payment_date ASC";
        $result = $this->conn->query($req);
        $rowcount=mysqli_num_rows($result);
        $typeArray = array();
        $sno = 1;
        if($rowcount>0){
            while ($row = $result->fetch_assoc()) {
            $typeArray[] = array("sno"=>$sno,
                "amount_paid" => $row['amount_paid'],
                "payment_date" => date('d-m-Y',strtotime($row['payment_date'])));
            $sno++;
            }   
        }
        return $typeArray;
    }
}
