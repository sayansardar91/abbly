<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of discharge
 *
 * @author Sayan
 */
class discharge extends database{
    //put your code here
    function __construct() {
        parent::__construct();
    }
    function getDID(){
        $req = "SELECT `discharge_id` FROM `patient_discharge` order by `id` desc limit 1";
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
            $last_reg = $row["discharge_id"];
        }


        if ($last_reg) {
            $reg_arr = explode('/', $last_reg);
            if ($reg_arr[1] == $fyear) {
                $reg_arr[2] = sprintf("%'.04d\n",(int) $reg_arr[2] + 1);
            } else {
                $reg_arr[1] = $fyear;
                $reg_arr[2] = 1;
            }
            $reg = implode("/", $reg_arr);
        } else {
            $last_reg=23;
            $reg = "PT-D/" . $fyear . "/" . sprintf("%'.04d\n",$last_reg);
        }
        return $reg;
    }
    function getDchrgList(){
        $req = "SELECT * FROM `view_discharge` ORDER BY discharge_id desc";
        $query = $this->conn->query($req);
        $sno = 0;
        while($row = mysqli_fetch_assoc($query)){
            $results[] = array('id'=>++$sno,
                                'discharge_id' => $row['discharge_id'],
                                'patient_id' => $row['patient_id'],
                                'patient_name_add' => $row['patient_name_add'],
                                'discharge_date' => date('d-m-Y',strtotime($row['discharge_date'])),
                                'gurd_name' => $row['gurd_name'],
                                'admit_time' => date('d-m-Y h:i A',strtotime($row['admit_time'])),
                                'diog_name' => $row['diog_name'],
                                'doc_name' => "Dr. ".$row['doc_name'],);
        }
        echo json_encode($results);
    }
    function getFbillList(){
        $req = "SELECT * FROM `view_discharge` vd JOIN final_bill fb ON vd.patient_id = fb.reg_no";
        $query = $this->conn->query($req);
        $sno = 0;
        while($row = mysqli_fetch_assoc($query)){
            $results[] = array('id'=>++$sno,
                                'patient_id' => $row['patient_id'],
                                'patient_name_add' => $row['patient_name_add'],
                                'discharge_date' => $row['discharge_date'],
                                'gurd_name' => $row['gurd_name'],
                                'admit_time' => date('d-M-Y h:i A',strtotime($row['admit_time'])),
                                'diog_name' => $row['diog_name'],
                                'doc_name' => "Dr. ".$row['doc_name'],
                                'bill_no'=> $row['bill_no'],
                                'bill_date'=>date('d-M-Y',strtotime($row['bill_date']))
                                );
        }
        echo json_encode($results);
    }
    function getPtd($p_id){
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
        echo json_encode($txt);
    }
}
