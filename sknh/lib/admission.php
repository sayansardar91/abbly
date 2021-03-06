<?php



class admission extends database {

    function __construct() {
        parent::__construct();
    }

    function getList($field, $param) {
        $req = "";
        if ($field === "reg_no_dchrg") {
            $field = 'reg_no';
            $req = "select distinct `reg_no` from `patient_details` where `reg_no` like'%" . $param . "%' AND `is_dschrg`=0";
        }else if($field ==="reg_no_fbill"){
            $field = 'reg_no';
            $req = "select distinct `reg_no` from `patient_details` where `reg_no` like'%" . $param . "%' "
                    . "AND `reg_no` NOT IN (Select `reg_no` FROM `final_bill`)";
        } else {
            $req = "select distinct `$field` from `patient_details` where `$field` like'%" . $param . "%' ";
        }
        //echo $req;
        $query = $this->conn->query($req);

        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array('label' => $row[$field]);
        }
        echo json_encode($results);
    }
    function getBabyID($field, $param) {
        $req = "select distinct `$field` from `baby_details` where `$field` like'%" . $param . "%' ";
        
        //echo $req;
        $query = $this->conn->query($req);

        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array('label' => $row[$field]);
        }
        echo json_encode($results);
    }
    function getBID() {
        $req = "SELECT `baby_id` FROM `baby_details` order by `bb_id` desc limit 1";
        $query = $this->conn->query($req);
        $last_reg = 0;
        $reg_arr = "";
        $reg = "";
        $mydate = new MyDateTime();
        $mydate->setDate(date("Y"), date("m"), date("d"));
        $result = $mydate->fiscalYear();
        $start = $result['start']->format('Y');
        $end = $result['end']->format('y');
        $fyear = $start . "-" . $end;
        while ($row = mysqli_fetch_assoc($query)) {
            $last_reg = $row["baby_id"];
        }


        if ($last_reg) {
            $reg_arr = explode('/', $last_reg);
            if ($reg_arr[2] == $fyear) {
                $reg_arr[1] = (int) $reg_arr[1] + 1;
            } else {
                $reg_arr[2] = $fyear;
                $reg_arr[1] = 1;
            }
            $reg = implode("/", $reg_arr);
        } else {
            $last_reg++;
            //$reg = "PT-R/" . $fyear . "/" . sprintf("%'.04d\n",$last_reg);
            $reg = "BB/".$last_reg."/".$fyear;
        }
        echo $reg;
    }

    function getRegNo() {
        //$req = "SELECT `reg_no` FROM `patient_details` where `bk_lg`=0 order by `id` desc limit 1";
		$req = "SELECT `reg_no` FROM `patient_details` order by `id` desc limit 1";
        $query = $this->conn->query($req);
        $last_reg = 0;
        $reg_arr = "";
        $reg = "";
        $mydate = new MyDateTime();
        $mydate->setDate(date("Y"), date("m"), date("d"));
        $result = $mydate->fiscalYear();
        $start = $result['start']->format('Y');
        $end = $result['end']->format('y');
        $fyear = $start . "-" . $end;
        while ($row = mysqli_fetch_assoc($query)) {
            $last_reg = $row["reg_no"];
        }


        if ($last_reg) {
            $reg_arr = explode('/', $last_reg);
            if ($reg_arr[2] == $fyear) {
                $reg_arr[1] = (int) $reg_arr[1] + 1;
            } else {
                $reg_arr[2] = $fyear;
                $reg_arr[1] = 1;
            }
            $reg = implode("/", $reg_arr);
        } else {
            $last_reg++;
            //$reg = "PT-R/" . $fyear . "/" . sprintf("%'.04d\n",$last_reg);
            $reg = SHORT_Name."/".$last_reg."/".$fyear;
        }
        echo $reg;
    }

    function getRegNoBLG($short, $reg_date) {
        $req = "SELECT `reg_no` FROM `patient_details` where `admit_date`='$reg_date' order by `id` desc limit 1";
        $query = $this->conn->query($req);
        $last_reg = 0;
        $reg_arr = "";
        $reg = "";
        $reg_date = explode('-', $reg_date);
        $mydate = new MyDateTime();
        $mydate->setDate($reg_date[2], $reg_date[1], $reg_date[0]);
        $result = $mydate->fiscalYear();
        $start = $result['start']->format('Y');
        $end = $result['end']->format('y');
        $fyear = $start . "-" . $end;
        while ($row = mysqli_fetch_assoc($query)) {
            $last_reg = $row["reg_no"];
        }
        if ($last_reg) {
            $reg_arr = explode('/', $last_reg);
            if (isset($reg_arr[3])) {
                $reg_arr[3] = (int) $reg_arr[3] + 1;
            } else {
                $reg_arr[3] = 1;
            }
            $reg = implode("/", $reg_arr);
        } else {
            $last_reg++;
            $reg = $short . "/" . $fyear . "/" . $last_reg;
        }
        echo $reg;
    }

    function getPatient($regno) {
        $req = "select * from `patient_details` where `reg_no`='" . $regno . "' ";

        $query = $this->conn->query($req);
        $row = mysqli_fetch_assoc($query);
        foreach ($row as $key => $val) {
            if ($key === "admit_time") {
                $timestamp = strtotime($val);
                $results["hr"] = date('h', $timestamp);
                $results["min"] = date('i', $timestamp);
                $results["meridian"] = date('A', $timestamp);
            } else {
                $results[$key] = $val;
            }
        }
        echo json_encode($results);
    }

    function getPtientList() {
        //$req = "select * from `patient_details` order by `id` desc";
        $req = "select ptd.*,bd.bed_name,dd.doc_name from `patient_details` ptd 
                LEFT JOIN bed_details bd ON ptd.bed_no = bd.id 
                LEFT JOIN doc_details dd ON ptd.atd_doctor = dd.id order by `id` desc";

        $query = $this->conn->query($req);

        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array("id" => $row['reg_no'],
                "reg_no" => substr($row['reg_no'],5),
                "name" => (empty($row['middle_name'])) ? $row['first_name'] . " " . $row['last_name'] : $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'],
                "sex" => $row['sex'],
                "age" => $row['age'],
                "contact_no_1" => $row['contact_no_1'],
                "admit_time" => date('d-m-Y',strtotime($row['admit_date'])) . "<br/>" . $row['admit_time'],
                "bed_no" =>$row['bed_name'],
                "doc_ref" => ($row['doc_ref'] == "2")?"By DR":"By NH",
                "tot_chrg" => ($row['tot_charge'] == "0")?"N/A":$row['tot_charge'],
                "doc_name" => "Dr. ".$row['doc_name']);
        }
        echo json_encode($results);
    }

    function getPtientListByDoc($docName) {
        //$req = "select * from `patient_details` order by `id` desc";
        $req = "select ptd.*,bd.bed_name,dd.doc_name from `patient_details` ptd 
                LEFT JOIN bed_details bd ON ptd.bed_no = bd.id 
                JOIN doc_details dd ON ptd.atd_doctor = dd.id AND dd.doc_name LIKE '%".$docName."%' order by `id` desc";

        $query = $this->conn->query($req);

        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array("id" => $row['reg_no'],
                "reg_no" => substr($row['reg_no'],5),
                "name" => (empty($row['middle_name'])) ? $row['first_name'] . " " . $row['last_name'] : $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'],
                "sex" => $row['sex'],
                "age" => $row['age'],
                "contact_no_1" => $row['contact_no_1'],
                "admit_time" => date('d-m-Y',strtotime($row['admit_date'])) . "<br/>" . $row['admit_time'],
                "bed_no" =>$row['bed_name'],
                "doc_ref" => ($row['doc_ref'] == "2")?"By DR":"By NH",
                "tot_chrg" => ($row['tot_charge'] == "0")?"N/A":$row['tot_charge'],
                "doc_name" => "Dr. ".$row['doc_name']);
        }
        echo json_encode($results);
    }
     function getPtientListRCP() {
        //$req = "select * from `patient_details` order by `id` desc";
        $req = "select ptd.*,bd.bed_name from `patient_details` ptd "
                . "LEFT JOIN bed_details bd ON ptd.bed_no = bd.id "
                . "WHERE ptd.reg_no NOT IN (Select patient_id from patient_discharge) "
                . "order by `ptd`.`id` DESC;";

        $query = $this->conn->query($req);

        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array("id" => $row['reg_no'],
                "name" => (empty($row['middle_name'])) ? $row['first_name'] . " " . $row['last_name'] : $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'],
                "sex" => $row['sex'],
                "contact_no_1" => $row['contact_no_1'],
                "admit_time" => $row['admit_date'] . " " . $row['admit_time'],
                "bed_no" =>$row['bed_name']);
        }
        echo json_encode($results);
    }

    function getPatientAccount($p_id) {
        //$req = "select * from `patient_account` where `reg_no`='" . $p_id . "' AND `acc_date`='".$a_day."'";
        $req = "Call pt_accnt('".$p_id."');";
        $query = $this->conn->query($req);
        $rowcount=$pt_array = $row = null;
        $rowcount=mysqli_num_rows($query);
        if($rowcount == 1){
            $row = mysqli_fetch_assoc($query);
            foreach ($row as $key => $val) {
                $pt_array['pt_details'][] = array('id'=>'','chrg_type'=>'','chrg_remarks'=>$val,'chrg_amount'=>'','acc_date'=>  date('Y-m-d'));
            }
        }else{
            while ($row = mysqli_fetch_assoc($query)) {
                if($row['chrg_type'] == 4){
                    $chrg_rm = explode("X", $row['chrg_remarks']);
                    $atd_no = trim($chrg_rm[0]);
                    $atd_days = trim($chrg_rm[1]);
                    $atd_chrg = trim($chrg_rm[2]);
                    $pt_array['pt_details'][] = array('id'=>$row['id'],'chrg_type'=>$row['chrg_type'],
                                        'atd_no'=>$atd_no,'atd_days'=>$atd_days,'atd_chrg' => $atd_chrg,
                                        'chrg_amount'=>$row['chrg_amount'],'acc_date'=>$row['acc_date']);
                }else{
                    $pt_array['pt_details'][] = array('id'=>$row['id'],'chrg_type'=>$row['chrg_type'],'chrg_remarks'=>$row['chrg_remarks'],'chrg_amount'=>$row['chrg_amount'],'acc_date'=>$row['acc_date']);
                }
            }
        }
        echo json_encode($pt_array);
    }
	function getTot($p_id){
		$req = "select ptd.first_name,ptd.middle_name,ptd.last_name, ptd.tot_charge,ptd.doc_ref,dd.doc_name FROM patient_details ptd JOIN doc_details dd ON ptd.atd_doctor = dd.id WHERE reg_no = '".$p_id."'";
        $query = $this->conn->query($req);
		$txt = null;
		while ($row = mysqli_fetch_array($query)) {
            $name = ($row['middle_name'] == null)?$row['first_name']." ".$row['last_name']:$row['first_name']." ".$row['middle_name']." ".$row['last_name'];
			if($row['doc_ref'] == 1){
				$txt['pt_admtdt'] = $name.' is admitted to Nursing Home under Dr. '.$row['doc_name'].'. Total Contact : Rs. '.$row['tot_charge'].'/-';
			}else if($row['doc_ref'] == 2){
				$txt['pt_admtdt'] = $name.' is admitted to Nursing Home referenced by Dr.'.$row['doc_name'];
			}
		}


        $sql_str = "Select distinct `entry_date` from `patient_account` WHERE patient_id = (Select id from patient_details WHERE reg_no = '".$p_id."')";
        $query = $this->conn->query($sql_str);
        while ($row = mysqli_fetch_array($query)) {
            $txt['entry_date'] = date('d-m-Y',strtotime($row['entry_date']));
        }

        
        $sql_str = "Select *from `patient_account` WHERE patient_id = (Select id from patient_details WHERE reg_no = '".$p_id."')";
        $qr = $this->conn->query($sql_str);
        $rowcount=mysqli_num_rows($qr);
        if($rowcount > 0){
            while ($row = mysqli_fetch_array($qr)) {
                if(($row['chrg_type'] == 10) || ($row['chrg_type'] == 11)){
                    $rmk = explode('x', $row['remarks']);
                    if($row['chrg_type'] == 10){
                        $txt['pt_acount'][] = array("chrgTp" => $row['chrg_type'],
                                            "hdChrgID_".$row['chrg_type'] => $row['id'],
                                            "txtOrg_".$row['chrg_type'] => $row['org_chrg'],
                                            "chkDr_".$row['chrg_type'] => $row['doc'],
                                            "txtPtnr_".$row['chrg_type'] => $row['chrg_prt'],
                                            "txtBedDays" => $rmk[0],
                                            "txtBedCheg" => $rmk[1]);
                    }
                    if($row['chrg_type'] == 11){
                        $txt['pt_acount'][] = array("chrgTp" => $row['chrg_type'],
                                            "hdChrgID_".$row['chrg_type'] => $row['id'],
                                            "txtOrg_".$row['chrg_type'] => $row['org_chrg'],
                                            "chkDr_".$row['chrg_type'] => $row['doc'],
                                            "txtPtnr_".$row['chrg_type'] => $row['chrg_prt'],
                                            "txtExtBedDays" => $rmk[0],
                                            "txtBedChegExt" => $rmk[1]);
                    }
                    
                }else if($row['chrg_type'] == 12){
                    $rmk = explode('x', $row['remarks']);
                    $txt['pt_acount'][] = array("chrgTp" => $row['chrg_type'],
                                            "hdChrgID_".$row['chrg_type'] => $row['id'],
                                            "txtOrg_".$row['chrg_type'] => $row['org_chrg'],
                                            "chkDr_".$row['chrg_type'] => $row['doc'],
                                            "txtPtnr_".$row['chrg_type'] => $row['chrg_prt'],
                                            "txtAtdNo" => $rmk[0],
                                            "txtAtdDays" => $rmk[1],
                                            "txtAtdChrg" => $rmk[2]);
                }else{
                    $txt['pt_acount'][] = array("chrgTp" => $row['chrg_type'],
                                            "hdChrgID_".$row['chrg_type'] => $row['id'],
                                            "txtOrg_".$row['chrg_type'] => $row['org_chrg'],
                                            "chkDr_".$row['chrg_type'] => $row['doc'],
                                            "txtPtnr_".$row['chrg_type'] => $row['chrg_prt'],
                                            "txtRmk_".$row['chrg_type'] => $row['remarks']);
                }
            }
        }
		echo json_encode($txt);
	}
    function getBaby($param) {

        $req = "select * from `baby_details` where `baby_id`='" . $param . "'";
        //echo $req;
        $query = $this->conn->query($req);
        $row = mysqli_fetch_assoc($query);
        $results = array();
        foreach ($row as $key => $val) {
            if($key == 'baby_tob'){
                //$timestamp = strtotime($val);
                $val = date('h:i:s A',strtotime($val));
                $time_arr = explode(":", $val);
                $med = explode(" ", $time_arr[2]);
                $results["hr"] = $time_arr[0];
                $results["min"] = $time_arr[1];
                $results["sec"] = $med[0];
                $results["merd"] = $med[1];
            }
            $results[$key] = $val;
        }
        echo json_encode($results);
    }
    function getBabyList() {
        $req = "select * from `baby_details` order by `bb_id` desc";

        $query = $this->conn->query($req);
        $i = 1;
        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array(
                "sno" => $i,
                "id" => $row['baby_id'],
                "reg_no" => $row['patient_reg_no'],
                "baby_dob" => date('d-m-Y',strtotime($row['baby_dob'])),
                "baby_weight" => $row['baby_mother_name']);
				$i++;
        }
        echo json_encode($results);
    }
    function getParent($param){
        $req = "select * from view_parent where `patient_reg_no`='" . $param . "'";
        //echo $req;
        $query = $this->conn->query($req);
        $row = mysqli_fetch_assoc($query);
        $results = array();
        foreach ($row as $key => $val) {
            $results[$key] = $val;
        }
        echo json_encode($results);
    }
    function getDays($reg_no){
        $req = "select bed_chrg from patient_details WHERE reg_no = '".$reg_no."';";

        $query = $this->conn->query($req);

        while ($row = mysqli_fetch_assoc($query)) {
            $results = array("bed_chrg" => $row['bed_chrg']);
        }
        echo json_encode($results);
    }
	function getAdmdt() {
        $req = "select admit_date, count(id) as adm_no FROM patient_details WHERE admit_date BETWEEN '".date("Y-m-01")."' AND '".date("Y-m-d")."' GROUP BY admit_date ORDER BY admit_date;";

        $query = $this->conn->query($req);
        $i = 1;
        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array(
                "sno" => $i,
                "adm_date" => date("d-M-Y",strtotime($row['admit_date'])),
                "adm_no" => $row['adm_no']);
				$i++;
        }
        echo json_encode($results);
    }
	
	function getDchrgdt() {
        $req = "select discharge_date AS dschrg_date, count(id) as dschrg_no FROM patient_discharge WHERE discharge_date BETWEEN '".date("Y-m-01")."' AND '".date("Y-m-d")."' GROUP BY discharge_date ORDER BY discharge_date;";

        $query = $this->conn->query($req);
        $i = 1;
        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array(
                "sno" => $i,
                "dschrg_date" => date("d-M-Y",strtotime($row['dschrg_date'])),
                "dschrg_no" => $row['dschrg_no']);
				$i++;
        }
        echo json_encode($results);
    }
	function getBedDt() {
        //$req = "Select (select count(id) from bed_details) AS tot_bed,(select count(id) from bed_details WHERE status = 1) AS tot_avl,(select count(id) from bed_details WHERE status = 0)as tot_bkd;";
	    $req = "Select (select count(id) from bed_details WHERE `bed_del`=0) AS tot_bed,(select count(id) from bed_details WHERE status = 1 AND `booked`=0 AND `bed_del`=0) AS tot_avl,(select count(id) from bed_details WHERE `booked` = 1 AND `bed_del`=0)as tot_bkd";
        $query = $this->conn->query($req);
        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array(
                "tot_bed" => $row['tot_bed'],
                "tot_avl" => $row['tot_avl'],
                "tot_bkd" => $row['tot_bkd']);
        }
        echo json_encode($results);
    }
	function getPatbydoc($atd){
		$req = "SELECT `id`, `reg_no`, `first_name`, `middle_name`, `last_name` FROM `patient_details` WHERE id NOT IN (SELECT `patient_id` FROM `doctor_dr`) AND `atd_doctor`=".$atd;
		
        $query = $this->conn->query($req);
		$rowcount=mysqli_num_rows($query);
		if($rowcount>0){
			 while ($row = mysqli_fetch_assoc($query)) {
			 $results[] = array(
					"id" => $row['id'],
					"patient_name" => "(".$row['reg_no'].")-".
					(($row['middle_name']=="")?$row['first_name']." ".$row['last_name']:
											  $row['first_name']." ".$row['middle_name']." ".$row['last_name']));
			}
		}else{
			$results[] = array(
					"id" => "",
					"patient_name" => "No Patient Found");
		}
        echo json_encode($results);
	}
    function addPatientAcct($table_name, $form_data,$reg_id){
        $fields = array_keys($form_data);

            // build the query
            $sql = "REPLACE INTO " . $table_name . "
        (`" . implode('`,`', $fields) . "`,`patient_id`)
        VALUES('" . implode("','", $form_data) . "',(SELECT `id` FROM `patient_details` WHERE `reg_no` = '$reg_id'))";
            //echo $sql;
            //die;
            // run and return the query result resource
            return $this->conn->query($sql);

    }
    function docToNshm($table_name, $form_data,$reg_id){
        $fields = array_keys($form_data);

            // build the query
            $sql = "REPLACE INTO " . $table_name . "
        (`" . implode('`,`', $fields) . "`,`patient_id`,`atd_doctor`)
        VALUES('" . implode("','", $form_data) . "',(SELECT `id` FROM `patient_details` WHERE `reg_no` = '$reg_id'),(SELECT `atd_doctor` FROM `patient_details` WHERE `reg_no` = '$reg_id'))";
            //echo $sql;
            //die;
            // run and return the query result resource
            return $this->conn->query($sql);

    }
    function nshmToDoc($table_name, $form_data,$reg_id){
        $fields = array_keys($form_data);

            // build the query
            $sql = "REPLACE INTO " . $table_name . "
        (`" . implode('`,`', $fields) . "`,`patient_id`,`atd_doctor`)
        VALUES('" . implode("','", $form_data) . "',(SELECT `id` FROM `patient_details` WHERE `reg_no` = '$reg_id'),(SELECT `atd_doctor` FROM `patient_details` WHERE `reg_no` = '$reg_id'))";
            //echo $sql;
            //die;
            // run and return the query result resource
            return $this->conn->query($sql);

    }
    function getBedCharge($id) {
        $req = "SELECT `bed_chrg` FROM `patient_details` where `reg_no`='$id'";
        $result = $this->conn->query($req);
        $typeArray = "";
        while ($row = $result->fetch_assoc()) {
            $typeArray = array("txtBedCheg" => $row['bed_chrg']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }
    
	 function getBillNo($id) {
        $req = "SELECT `bill_no` FROM `final_bill` where `reg_no`='$id'";
        $result = $this->conn->query($req);
        $typeArray = "";
        while ($row = $result->fetch_assoc()) {
            $typeArray = $row['bill_no'];
        }
        return $typeArray;
    }    
    
    function updateNSHAct($totOrg,$totPtnr,$amntDate){
        $sql = "Call sp_accounts($totOrg,$totPtnr,'$amntDate');";
        return $this->conn->query($sql);
    }
}

?>
