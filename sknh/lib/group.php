<?php

class group extends database {

    function __construct() {
        parent::__construct();
    }

    function allGroup() {
        $req = "SELECT * FROM `group_details` where `group_group`=0";
        $result = $this->conn->query($req);
        $typeArray = "";
        while ($row = $result->fetch_assoc()) {
            $typeArray[] = array("id" => $row['id'],
                "group_name" => $row['group_name'],
                "status" => $row['status']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }
    
    function groupList() {
        $req = "SELECT `id`,group_name FROM `group_details` where `status`=1";
        $result = $this->conn->query($req);
        $typeArray = "";
        while ($row = $result->fetch_assoc()) {
            $typeArray[] = array("id" => $row['id'],
                "group_name" => $row['group_name']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }

    function getActiveList() {
        $req = "SELECT * FROM `group_details` where `status`=1";

        $result = $this->conn->query($req);
        $this->conn->close();
        return $result;
    }

    function addGroup($post) {
        $result = false;
        if (!$this->checkExists($post['group_name'])) {
            $post["create_date"] = date("d-m-Y");
            unset($post["submit"]);
            $result = $this->dbRowInsert("group_details", $post);
            $this->conn->close();
        }
        return $result;
    }

    function setStatus($post) {
        extract($post);
        $user_id = $this->conn->real_escape_string($id);
        $status = $this->conn->real_escape_string($status);
        $sql = $this->conn->query("UPDATE `group_details` SET `status`='$status' WHERE id='$id'");
    }

    function checkExists($param) {
        $req = "select count(*) `count` from `group_details` where `group_name` like'%" . $param . "%' ";
        $result = $this->conn->query($req);
        $count = "";
        while ($row = $result->fetch_assoc()) {
            $count = $row['count'];
        }
        return $count;
    }
}

?>