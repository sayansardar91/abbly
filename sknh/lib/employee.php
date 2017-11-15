<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of employee
 *
 * @author Sayan
 */
class employee extends database {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    function getEmpID() {
        $req = "SELECT `emp_id` FROM `employee_details` ORDER BY `id` DESC LIMIT 1 ";
        $query = $this->conn->query($req);
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $results = $row['emp_id'];
            }
        }
        $var = $this->get_numerics($results);
        $int_val = intval($var[0]);
        $int_val++;
        return sprintf("%'.04d\n", $int_val);
        //return $int_val;
    }
    function get_numerics ($str) {
        preg_match_all('/\d+/', $str, $matches);
        return $matches[0];
    }
    function getList($field, $param) {
        $req = "";
        if ($field == 'emp_firstname') {
            $req = 'SELECT if(`emp_middlename`="",concat(`emp_firstname`," ",`emp_lastname`), '
                    . 'concat(`emp_firstname`," ",`emp_middlename`," ",`emp_lastname`)) '
                    . '`emp_firstname` FROM `employee_details` where `emp_firstname` like "%' . $param . '%" OR `emp_lastname` like "%' . $param . '%" ';
        } else {
            $req = "select distinct `$field` from `employee_details` where `$field` like'%" . $param . "%' ";
        }
        //echo $req;
        $query = $this->conn->query($req);

        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array('label' => $row[$field]);
        }
        echo json_encode($results);
    }

    function checkExists($param) {
        $req = "select count(*) `count`,`emp_id` from `employee_details` where `emp_firstname`='" . $param[0] . "' "
                . "AND `emp_lastname`='" . $param[1] . "' OR `emp_firstname`='" . $param[2] . "'";
        $result = $this->conn->query($req);
        $count = "";
        while ($row = $result->fetch_assoc()) {
            $count['count'] = $row['count'];
            $count['empid'] = $row['emp_id'];
        }
        return $count;
    }

    function getEmp($param) {

        $req = "select * from `employee_details` where `emp_id`='" . $param . "'";
        //echo $req;
        $query = $this->conn->query($req);
        $row = mysqli_fetch_assoc($query);
        $results = "";
        foreach ($row as $key => $val) {
            $results[$key] = $val;
        }
        unset($results['id']);
        echo json_encode($results);
    }

    function getID($param) {
        $req = "";
        if (sizeof($param) == 3) {
            $req = "Select `emp_id` FROM `employee_details` WHERE `emp_firstname`='" . $param[0] . "' AND `emp_lastname`='" . $param[2] . "' AND `emp_middlename`='" . $param[1] . "'";
        } else {
            $req = "Select `emp_id` FROM `employee_details` WHERE `emp_firstname`='" . $param[0] . "' AND `emp_lastname`='" . $param[1] . "'";
        }
        $query = $this->conn->query($req);
        $empid = "";
        while ($row = mysqli_fetch_assoc($query)) {
            $empid = $row['emp_id'];
        }
        return $empid;
    }

    function getEmpSal($param) {

        $req = "SELECT 

if(`emp_middlename`=null,concat(`emp_firstname`,' ',`emp_lastname`),
                         concat(`emp_firstname`,' ',`emp_middlename`,' ',`emp_lastname`)) `emp_firstname`,
                         `emp_doj`,`basic_pay`,
                         (select `dept_name` FROM `department_details` where `id` = `emp_dept`)`emp_dept` 
                         FROM `employee_details` WHERE `emp_id`='" . $param . "'";
        //echo $req;
        $query = $this->conn->query($req);
        $row = mysqli_fetch_assoc($query);
        $results = "";
        foreach ($row as $key => $val) {
            $results[$key] = $val;
        }
        unset($results['id']);
        echo json_encode($results);
    }

    function getEmpName($param) {

        $req = "SELECT 

if(`emp_middlename`=null,concat(`emp_firstname`,' ',`emp_lastname`),
                         concat(`emp_firstname`,' ',`emp_middlename`,' ',`emp_lastname`)) `emp_name` ,
                         `emp_firstname` AS `emp_fname`, `emp_dob`
                         FROM `employee_details` WHERE `emp_id`='" . $param . "'";
        //echo $req;
        $query = $this->conn->query($req);
        $row = mysqli_fetch_assoc($query);
        $results = "";
        foreach ($row as $key => $val) {
            $results[$key] = $val;
        }
        unset($results['id']);
        echo json_encode($results);
    }

    function chkPayment($param) {
        $req = "Select count(*) `count` FROM `emp_salary` WHERE `emp_id`='" . $param[0] . "' AND `sal_month`='" . $param[1] . "'";

        $query = $this->conn->query($req);
        $count = "";
        while ($row = mysqli_fetch_assoc($query)) {
            $count = $row['count'];
        }
        return $count;
    }

    function getEmpExp($param) {
        $req = "Select `emp_id`,`net_amount` FROM `emp_salary` WHERE `sal_date`='" . $param . "'";

        $query = $this->conn->query($req);
        $count = "";
        while ($row = mysqli_fetch_assoc($query)) {
            $count[] = array('emp_id' => $row['emp_id'], 'net_amount' => $row['net_amount']);
        }
        echo json_encode($count);
    }
    function getSisters() {

        $req = "SELECT * FROM `view_sisters`";
        //echo $req;
        $query = $this->conn->query($req);
        $results = "";
        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array('id'=>$row['id'],'emp_id'=>$row['emp_id'],'emp_name'=>$row['emp_name'],
                               'emp_homephn'=>$row['emp_homephn'],'emp_workphn' => $row['emp_workphn'],
                              'emp_qualification'=>$row['emp_qualification'],'emp_doj'=>$row['emp_doj'],'status'=>$row['status']);
        }
        echo json_encode($results);
    }
    function getOthers() {

        $req = "select id,emp_id,
    if(emp_middlename=null,concat(emp_firstname,' ',emp_lastname),
              concat(emp_firstname,' ',emp_middlename,' ',emp_lastname)) `emp_name`,
    emp_homephn,emp_workphn,emp_qualification,emp_doj,status
from employee_details WHERE emp_type='E';";
        //echo $req;
        $query = $this->conn->query($req);
        $results = "";
        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array('id'=>$row['id'],'emp_id'=>$row['emp_id'],'emp_name'=>$row['emp_name'],
                               'emp_homephn'=>$row['emp_homephn'],'emp_workphn' => $row['emp_workphn'],
                              'emp_qualification'=>$row['emp_qualification'],'emp_doj'=>$row['emp_doj'],'status'=>$row['status']);
        }
        echo json_encode($results);
    }
}
