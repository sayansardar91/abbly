<?php

class nhmdetails extends database {

    function __construct() {
        parent::__construct();
    }

    function allBedCategory() {
        $req = "SELECT * FROM `bed_category` WHERE `status`=1";
        $result = $this->conn->query($req);
        $typeArray = "";
		$sno = 1;
        while ($row = $result->fetch_assoc()) {
        	
				$reqst = "SELECT count(*) AS count from bed_details WHERE `bed_type` = ".$row['id']." AND bed_del = 0";
            $res = $this->conn->query($reqst);
                $count = "";
                while ($r = $res->fetch_assoc()) {
                    $count = $r['count'];
                }  	
        	
            $typeArray[] = array("sno" => $sno,
				"id" => $row['id'],
                "bed_type" => $row['bed_type'],
                /*"bed_no" => $row['bed_no'],*/
                "bed_no" => $count,
                "bed_chrg" => $row['bed_chrg'],
                "status" => $row['status']);
				$sno++;
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }

    function listBedCat() {
        $req = "SELECT `id`,`bed_type` FROM `bed_category` where `status`=1";
        $result = $this->conn->query($req);
        $typeArray = "";
        while ($row = $result->fetch_assoc()) {
            $typeArray[] = array("id" => $row['id'],
                "bed_type" => $row['bed_type']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }

    function listAvailBed($id) {
        $typeArray = "";
        $req = "SELECT `bed_no` FROM `bed_category` where `id`  = '$id'";
        $result = $this->conn->query($req);

        while ($row = $result->fetch_assoc()) {
            $typeArray['tot_beds'] = array("bed_no" => $row['bed_no']);
        }

        $req = "SELECT `id`,`bed_name` FROM `bed_details` where `bed_del`=0 AND `booked`=0 AND `status`=1 AND `bed_type`='$id' ORDER BY `bed_name` ASC";
        $result = $this->conn->query($req);

        while ($row = $result->fetch_assoc()) {
            $typeArray['bd_details'][] = array("id" => $row['id'],
                "bed_name" => $row['bed_name']);
        }
        $req = "SELECT count(`id`) avail FROM `bed_details` where `bed_del`=0 AND `booked`=0 AND `status`=1 AND `bed_type`='$id'";
        $result = $this->conn->query($req);

        while ($row = $result->fetch_assoc()) {
            $typeArray['beds_avail'] = array("avail" => $row['avail']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }

    function getBedCharge($id) {
        $req = "SELECT `bed_chrg` FROM `bed_category` where `id`=$id";
        $result = $this->conn->query($req);
        $typeArray = "";
        while ($row = $result->fetch_assoc()) {
            $typeArray["bed_chrg"] = array("bed_chrg" => $row['bed_chrg']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }

    function allBedTypes() {
        $req = "SELECT a.`id`, b.`bed_type`, a.`bed_name`,a.`status` FROM `bed_details` a, `bed_category` b WHERE a.bed_del = 0 AND a.`bed_type` = b.`id` ORDER BY a.`bed_name`";

        $result = $this->conn->query($req);
        $typeArray = "";
		$sno = 1;
        while ($row = $result->fetch_assoc()) {
            $typeArray[] = array("id"=>$row['id'],"sno" => $sno, "bed_type" => $row['bed_type'],
                "bed_name" => $row['bed_name'],
                "status" => $row['status']);
				$sno++;
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }

    function addBedCategory($post) {
        $result = "";
        $post = array_filter($post);
        //$bed_cat = array('id'=>$post['id'],'bed_type'=>$post['bed_type'],'bed_no'=>$post['bed_no'],'bed_chrg'=>$post['bed_chrg']);
        //$bed_cat = array('id' => $post['id'], 'bed_type' => $post['bed_type'], 'bed_chrg' => $post['bed_chrg']);
        $bedtype = "";
        $last_id = "";
        if(isset($post['bed_name']) && isset($post['id'])){
            $last_id = $post['id'];
            $bedtype = array('bed_type' => $last_id,
                'bed_name' => $post['bed_name']);
            $result = $this->dbRowInsert("bed_details", $bedtype);
            if ($result) {
                $req = "SELECT count(*) AS count from bed_details WHERE `bed_type` = $last_id";
                $result = $this->conn->query($req);
                $count = "";
                while ($row = $result->fetch_assoc()) {
                    $count = $row['count'];
                }
                $count = array('bed_no' => $count,'bed_type' => $post['bed_type']);
                $result = $this->dbRowUpdate("bed_category", $count, '`id`=' . $last_id);
            }
        }else if(isset($post['bed_name'])){
            $bed_cat = array('bed_type' => $post['bed_type'], 'bed_chrg' => $post['bed_chrg']);
            $result = $this->dbRowInsert("bed_category", $bed_cat);
            if ($result) {
                $last_id = $this->conn->insert_id;
                $bedtype = array('bed_type' => $last_id,
                    'bed_name' => $post['bed_name']);
                $result = $this->dbRowInsert("bed_details", $bedtype);
                if ($result) {
                    $req = "SELECT count(*) AS count from bed_details WHERE `bed_type` = $last_id";
                    $result = $this->conn->query($req);
                    $count = "";
                    while ($row = $result->fetch_assoc()) {
                        $count = $row['count'];
                    }
                    $count = array('bed_no' => $count,'bed_type' => $post['bed_type']);
                    $result = $this->dbRowUpdate("bed_category", $count, '`id`=' . $last_id);
                }
            }
        }else{
            $bed_cat = array('bed_type' => $post['bed_type'], 'bed_chrg' => $post['bed_chrg']);
            $result = $this->dbRowUpdate("bed_category", $bed_cat,'`id`=' . $post['id']);
        }
    }

    function addProv($post) {
        $this->dbRowReplaceInsert("prov_diag", array_filter($post));
    }

    function getProv() {
        $req = "select prov_diag.id,prov_diag.diog_name,prov_diag.status,department_details.dept_name from prov_diag LEFT JOIN department_details ON prov_diag.dept_id = department_details.id";

        $result = $this->conn->query($req);
        $typeArray = "";
		$sno = 0;
        while ($row = $result->fetch_assoc()) {
            $typeArray[] = array("sno" => ++$sno,
			    "id" => $row['id'],
				"dept_name" => $row['dept_name'],
                "diog_name" => $row['diog_name'],
                "status" => $row['status']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }

    function listProv() {
        $req = "SELECT * from prov_diag where status = 1";

        $result = $this->conn->query($req);
        $typeArray = "";
        while ($row = $result->fetch_assoc()) {
            $typeArray[] = array("id" => $row['id'],
                "diog_name" => $row['diog_name']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }

    function checkExists($param) {
        $req = "select count(*) `count` from `bed_category` where `bed_type` like'%" . $param . "%' ";
        $result = $this->conn->query($req);
        $count = "";
        while ($row = $result->fetch_assoc()) {
            $count = $row['count'];
        }
        return $count;
    }

    function checkProvExists($param) {
        $req = "select count(*) `count` from `prov_diag` where `diog_name` like'%" . $param . "%' ";
        $result = $this->conn->query($req);
        $count = "";
        while ($row = $result->fetch_assoc()) {
            $count = $row['count'];
        }
        return $count;
    }

    function listAllBed($id) {
        //$req = "select `id`,`bed_name` from `bed_details` where `bed_type`='" . $id . "' and `status`=1";
        $req = "select `id`,`bed_name` from `bed_details` where `bed_type`='" . $id . "'";
        $query = $this->conn->query($req);
        while ($row = mysqli_fetch_assoc($query)) {
            $results['bd_details'][] = array('id' => $row['id'], 'bed_name' => $row['bed_name']);
        }
        echo json_encode($results);
    }

    function bctStatus($post) {
        extract($post);
        $user_id = $this->conn->real_escape_string($id);
        $status = $this->conn->real_escape_string($status);
        $sql = $this->conn->query("UPDATE `bed_category` SET `status`='$status' WHERE id='$id'");
    }

    function bdStatus($post) {
        extract($post);
        $user_id = $this->conn->real_escape_string($id);
        $status = $this->conn->real_escape_string($status);

        $req = "SELECT `status` FROM `bed_category` WHERE `id` = (SELECT `bed_type` FROM `bed_details` WHERE `id` = " . $id . ")";
        $query = $this->conn->query($req);
        $stat = "";
        while ($row = mysqli_fetch_assoc($query)) {
            $stat = $row['status'];
        }
        if ($stat) {
            if($this->isBooked($id)){
                echo "This bed is Booked now. You can't activate it untill it's Unbooked.";
            }else{
                $sql = $this->conn->query("UPDATE `bed_details` SET `status`='$status' WHERE id='$id'");
            }
        } else {
            echo "Bed Type for this bed is already inactive.";
        }
    }

    function getList($field, $param) {
        $req = "";
        $req = "select distinct `$field` from `bed_category` where `$field` like'%" . $param . "%' ";
        //echo $req;
        $query = $this->conn->query($req);

        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array('label' => $row[$field]);
        }
        echo json_encode($results);
    }

    function getBeds($param) {
        $req = "";
        $req = "select * from view_bedcat where bed_type = '" . $param . "'";
        //echo $req;
        $query = $this->conn->query($req);
        $row = mysqli_fetch_assoc($query);
        $results = "";
        foreach ($row as $key => $val) {
            $results[$key] = $val;
        }
        echo json_encode($results);
    }

    function getBedCat($param) {
        $req = "";
        $req = "select `bed_type` from bed_details where id = '" . $param . "'";
        //echo $req;
        $query = $this->conn->query($req);
        $row = mysqli_fetch_assoc($query);
        return $row['bed_type'];
    }
    
    function getWordpad(){
        $req = "SELECT `id`, `file_name`,`file_content` FROM `wordpad`";
        $query = $this->conn->query($req);
        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array('id' => $row['id'], 'file_name' => $row['file_name'],'file_content'=>$row['file_content']);
        }
        echo json_encode($results);
    }
    function getFile($id){
        $req = "SELECT `id`, `file_name`,`file_content` FROM `wordpad` where `id` = ".$id;
        $query = $this->conn->query($req);
        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array('id' => $row['id'], 'file_name' => $row['file_name'],'file_content'=>$row['file_content']);
        }
        echo json_encode($results);
    }
	function getDiog($field, $param) {
        $req = "select distinct `$field` from `prov_diag` where `$field` like'%" . $param . "%' ";
        
        //echo $req;
        $query = $this->conn->query($req);

        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = array('label' => $row[$field]);
        }
        echo json_encode($results);
    }
	function getDiogDetails($diog_name){
		$req = "select * from prov_diag where `diog_name`='" . $diog_name . "'";
        //echo $req;
        $query = $this->conn->query($req);
        $row = mysqli_fetch_assoc($query);
        $results = "";
        foreach ($row as $key => $val) {
            $results[$key] = $val;
        }
        echo json_encode($results);
	}
    function isBooked($id){
        $sqlstr = "SELECT `booked` FROM `bed_details` WHERE `id`=$id";
        $query = $this->conn->query($sqlstr);
        $status = "";
        while ($obj=mysqli_fetch_object($query))
        {
            $status = $obj->booked;
        }
        return $status;
    }
}

?>