<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of payment
 *
 * @author Sayan
 */
class payment extends database{
    //put your code here
    function __construct() {
        parent::__construct();
    }
    function getBillNo() {
        $req = "SELECT `bill_no` FROM `patient_bill` ORDER BY `id` DESC LIMIT 1 ";
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
            $last_reg = $row["bill_no"];
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
            $last_reg=1;
            $reg = "RCPT/" . $fyear . "/" . sprintf("%'.04d\n",$last_reg);
        }
        return $reg;
    }
    function getFinalBillNo() {
        $req = "SELECT `bill_no` FROM `final_bill` ORDER BY `id` DESC LIMIT 1 ";
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
            $last_reg = $row["bill_no"];
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
            $last_reg=1;
            $reg = "BL/" . $fyear . "/" . sprintf("%'.04d\n",$last_reg);
        }
        return $reg;
    }
    function chkFinalBillNo($id){
        $req = 'SELECT count(`bill_no`) AS noof_bill FROM `final_bill` where `reg_no`="'.$id.'"';
        $chkBill = 0;
        $query = $this->conn->query($req);
        while ($row = mysqli_fetch_assoc($query)) {
            $chkBill = $row["noof_bill"];
        }
        return $chkBill;
    }
    function getPatientName($id){
        $req = 'SELECT if(`middle_name`="",concat(`first_name`," ",`last_name`), '
                    . 'concat(`first_name`," ",`middle_name`," ",`last_name`)) '
                    . '`patient_name`, `bed_chrg` FROM `patient_details` where `reg_no`="'.$id.'"';
        $myArray = array();
        if ($result = $this->conn->query($req)) {
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                $myArray = $row;
            }
            echo json_encode(array_filter($myArray));
        }
    }
    
    function getTotalAmount($id){
        $req = 'SELECT `total_amount`,`amount_paid`,(`total_amount` - `amount_paid`)`amount_due` FROM `patient_payment` where `reg_no`="'.$id.'"';
        $myArray = array();
        if ($result = $this->conn->query($req)) {
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                $myArray = $row;
            }
            echo json_encode($myArray);
        }
    }
    
    function getPaymentDetails($id){
        $req = "SELECT `payble_amount`,`payment_date` FROM `patient_bill` where `reg_no`='".$id."'";
        $myArray = array();
        if ($result = $this->conn->query($req)) {
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                $myArray[] = $row;
            }
            echo json_encode(array_filter($myArray));
        }
    }
    
    function getAddCharge($p_id) {
        $req = "select SUM(`bed_days`) `bed_days`,SUM(`bed_total_charge`) `bed_total_charge`, "
                . "SUM(`pvtatd_days`) `pvtatd_days `, `pvtatd_charge`, "
                . "SUM(`pvtatd_total_charge`)`pvtatd_total_charge` from `patient_bill` where `reg_no`='" . $p_id . "'";
        
        $myArray = array();
        if ($result = $this->conn->query($req)) {
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                $myArray[] = $row;
            }
            echo json_encode(array_filter($myArray));
        }
    }
    function getPatientBill(){
        $req = "SELECT `id`,`bill_no`, "
                . "`reg_no`, `total_amount`, `payble_amount`, `payment_date`, "
                . "`payment_month`, `fin_year` FROM `patient_bill`";
        //echo $req;
        $query = $this->conn->query($req);
        $results = "";
        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array('bill_no'=>$row['bill_no'],'reg_no'=>$row['reg_no'],'total_amount'=>$row['total_amount'],
                               'payble_amount'=>$row['payble_amount'],'payment_date' => $row['payment_date'],
                              'payment_month'=>$row['payment_month'],'fin_year'=>$row['fin_year']);
        }
        echo json_encode($results);
    }
}
