<?php

class accounts extends database {

    function __construct() {
        parent::__construct();
    }

    function getAcctTypeTB() {
        $req = "SELECT * FROM `accounts_type` ";

        $result = $this->conn->query($req);
        $typeArray = "";
        $sno = 0;
        while ($row = $result->fetch_assoc()) {
            $typeArray[] = array("sno" => ++$sno,
                "id" => $row['id'],
                "accounts_name" => $row['accounts_name'],
                "status" => $row['status']);
        }
        $this->conn->close();
        echo json_encode($typeArray);
    }

    function getActName($id) {
        $req = "SELECT * FROM `accounts_type` where id='$id'";
        $result = $this->conn->query($req);
        $typeArray = "";
        while ($row = $result->fetch_assoc()) {
            $typeArray[] = array(
                "id" => $row['id'],
                "accounts_name" => $row['accounts_name']
            );
        }
        echo json_encode($typeArray);
    }

    function getDoctorAdv() {
        $req = "SELECT dav.`id`,dd.`doc_name`,dav.`amount_paid`,dav.`payment_date`,dav.`remarks` FROM `doctor_adv` dav JOIN doc_details dd ON dd.id = dav.`atd_doctor` ORDER BY dav.`payment_date` DESC";
        $result = $this->conn->query($req);
        $typeArray = "";
        $sno = 1;
        while ($row = $result->fetch_assoc()) {
            $typeArray[] = array(
                "sno" => $sno++,
                "id" => $row['id'],
                "doc_name" => 'Dr.' . $row['doc_name'],
                "amount_paid" => 'Rs.' . $row['amount_paid'] . "/-",
                "remarks" => $row['remarks'],
                "payment_date" => date('d-m-Y', strtotime($row['payment_date']))
            );
        }
        echo json_encode($typeArray);
    }

    /*function updateAccount() {

        $req = "SELECT DISTINCT `exp_date` FROM `nhm_expense` ORDER BY `exp_date`;";

        $query = $this->conn->query($req);
        $rowcount = mysqli_num_rows($query);

        if ($rowcount == 0) {
            $pdrq = "SELECT `payment_date` FROM `nshm_ptnraccount` ORDER BY `payment_date`";
            $pdquery = $this->conn->query($pdrq);
            $pdcount = mysqli_num_rows($pdquery);
            if ($pdcount >= 1) {
                while ($r = mysqli_fetch_assoc($pdquery)) {
                    $spResponse = $this->conn->query("Call sp_accountUpdate(0,0,'" . $r['payment_date'] . "');");
                }
            }
        }

        if ($rowcount > 0) {
            if ($rowcount == 1) {
                //echo "One Row";
                while ($row = mysqli_fetch_assoc($query)) {
                    $spResponse = $this->conn->query("Call sp_accountUpdate(0,0,'" . $row['exp_date'] . "');");
                    $pdrq = "SELECT `payment_date` FROM `nshm_ptnraccount` WHERE `payment_date` NOT IN ('" . $row['exp_date'] . "')";
                    $pdquery = $this->conn->query($pdrq);
                    $pdcount = mysqli_num_rows($pdquery);
                    if ($pdcount >= 1) {
                        while ($r = mysqli_fetch_assoc($pdquery)) {
                            $spResponse = $this->conn->query("Call sp_accountUpdate(0,0,'" . $r['payment_date'] . "');");
                        }
                    }
                }
            } else {
                while ($row = mysqli_fetch_assoc($query)) {
                    $spResponse = $this->conn->query("Call sp_accountUpdate(0,0,'" . $row['exp_date'] . "');");
                }
            }
        }
        return $spResponse;
    }*/
    function updateAccount() {
        $req = "SELECT DISTINCT `payment_date` FROM `nshm_account` ORDER BY `payment_date`;";
        $lastExpDate = null;
        $query = $this->conn->query($req);
        while ($r = mysqli_fetch_assoc($query)) {
            $spResponse = $this->conn->query("Call sp_accountUpdate(0,0,'" . $r['payment_date'] . "');");
        }
		
		if(!$spResponse){
			die($this->conn->error);
		}
		
        return $spResponse;
    }
}
