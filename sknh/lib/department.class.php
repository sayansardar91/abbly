<?php

class department extends database {

    function __construct() {
        parent::__construct();
    }

    function allDept() {
        $req = "SELECT * FROM `department_details` where `dept_group`=0";
        $result = $this->conn->query($req);
        $typeArray = "";
        while ($row = $result->fetch_assoc()) {
            $typeArray[] = array("id" => $row['id'],
                "dept_name" => $row['dept_name'],
                "status" => $row['status']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }
    function allEmpDept() {
        $req = "SELECT * FROM `department_details` where `dept_group`=1";
        $result = $this->conn->query($req);
        $typeArray = "";
        $id = 1;
        while ($row = $result->fetch_assoc()) {
            $typeArray[] = array("id" => $row['id'],
                "sno" => $id++,
                "dept_name" => $row['dept_name'],
                "status" => $row['status']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }

    function deptList($dept_group) {
        $req = "SELECT `id`,dept_name FROM `department_details` where `status`=1 AND `dept_group`=$dept_group";
        $result = $this->conn->query($req);
        $typeArray = "";
        while ($row = $result->fetch_assoc()) {
            $typeArray[] = array("id" => $row['id'],
                "dept_name" => $row['dept_name']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }
    

    function getActiveList() {
        $req = "SELECT * FROM `department_details` where `status`=1";

        $result = $this->conn->query($req);
        $this->conn->close();
        return $result;
    }

    function addDept($post) {
        $result = false;
        if (!$this->checkExists($post['dept_name'])) {
            $post["create_date"] = date("d-m-Y");
            unset($post["submit"]);
            $result = $this->dbRowInsert("department_details", $post);
            $this->conn->close();
        }
        return $result;
    }

    function setStatus($post) {
        extract($post);
        $user_id = $this->conn->real_escape_string($id);
        $status = $this->conn->real_escape_string($status);
        $sql = $this->conn->query("UPDATE `department_details` SET `status`='$status' WHERE id='$id'");
    }

    function checkExists($param) {
        $req = "select count(*) `count` from `department_details` where `dept_name` like'%" . $param . "%' ";
        $result = $this->conn->query($req);
        $count = "";
        while ($row = $result->fetch_assoc()) {
            $count = $row['count'];
        }
        return $count;
    }
}

?>