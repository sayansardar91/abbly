<?php

class UserClass extends database {

    function __construct() {
        parent::__construct();
    }
    function doLogin($post) {
        $return = "";
        $user_name = $post['user_name'];
        $user_pass = md5($post['password']);

        $req = "select * from `user_details` where `user_name`='" . $user_name . "' AND `user_passwd` = '" . $user_pass . "'";

        $result = $this->conn->query($req);
        $count = "";
        if (mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['status']) {
                    $_SESSION['user'] = $row['emp_name'];
                    $_SESSION['type'] = $row['user_type'];

                    $cookie_name = "login_date";
                    $cookie_value = date('d-m-Y');

                    if (!isset($_COOKIE[$cookie_name])) {
                        setcookie($cookie_name, $cookie_value, time() + (43200), "/");
                        $this->loginUpdate();
                    } else {
                        if ($_COOKIE[$cookie_name] < date('d-m-Y')) {
                            setcookie($cookie_name, $cookie_value, time() + (43200), "/");
                            $this->loginUpdate();
                        }
                    }
                    $return = array("success" => 1, "msg" => "Login Successful.");
                } else {
                    $return = array("success" => 0, "msg" => "Inactive User Name.");
                }
            }
        } else {
            $return = array("success" => 0, "msg" => "User Name or Password Invalid.");
        }
        return $return;
    }

    function doLogout() {
        session_unset();
        session_destroy();
        header("Location: index.php");
    }

    function getUsers() {
        $req = "select * from `view_users`";
        $qry = $this->conn->query($req);
        $result = "";
        $sno = 0;
        while ($row = $qry->fetch_assoc()) {
            $result[] = array('sno' => ++$sno, 'id' => $row['id'],
                'emp_id' => $row['emp_id'], 'user_name' => $row['user_name'],
                'user_type' => $row['user_type'], 'user_passwdstr' => $row['user_passwdstr'],
                'created_on' => $row['created_on'], 'status' => $row['status']);
        }
        echo json_encode($result);
    }

    function checkExists($param) {
        $req = "select count(*) `count` from `user_details` where `emp_id` = '" . $param[0] . "' AND `user_type`='" . $param[1] . "'";
        $result = $this->conn->query($req);
        $count = "";
        while ($row = $result->fetch_assoc()) {
            $count = $row['count'];
        }
        return $count;
    }

    function setStatus($post) {
        extract($post);
        $user_id = $this->conn->real_escape_string($id);
        $status = $this->conn->real_escape_string($status);
        $sql = $this->conn->query("UPDATE `user_details` SET `status`='$status' WHERE id='$id'");
    }

    function getUserCount() {
        $req = "select * from `user_details`";
        $result = $this->conn->query($req);
        $count = mysqli_num_rows($result);
        return $count;
    }

    function appTrial() {
        $today = date("d-M-Y H:i:s", time());
        //$trialPeriod = date('t') - 1;
        //$trialPeriod = date("Y-m-d", strtotime(date("Y-m-d", strtotime($StaringDate)) . " + 365 day"));
        $startDate = date("d-M-Y", time());
        //$getExpiryDate = strtotime('+' . $trialPeriod . "days 23 hours 59 minutes 59 seconds", strtotime($startDate));
        $expiryDate = date("d-M-Y H:i:s", strtotime(date("Y-m-d", strtotime($today)) . " + 364; days 23 hours 59 minutes 59 seconds"));
        //$expiryDate = date("d-M-Y H:i:s", $getExpiryDate);
        $activation_key = "";
        $enc_key = "";

        $req = "SELECT * FROM apptrial";
        $result = $this->conn->query($req);

        $post = array('StartDate' => $startDate, 'ExpiryDate' => $expiryDate);

        $checkStatus = mysqli_num_rows($result);
        if ($checkStatus == 0) {
            $this->dbRowInsert("apptrial", $post);
        } else {
            $req = "SELECT * FROM apptrial";
            $result = $this->conn->query($req);
            WHILE ($period = mysqli_fetch_object($result)) {
                $endOfTrial = $period->ExpiryDate;
            }
            //echo $today." >>>> ".$endOfTrial;

            $datetime1 = date_create($today);
            $datetime2 = date_create($endOfTrial);
            $interval = date_diff($datetime1, $datetime2);
            $intv = $interval->format('%R%a');

            IF (($intv === "-0") || ($intv < 0)) {

                echo "<html><title>" . SHORT_Name . "</title><link rel='icon' type='image/ico' href='" . FAV_ICON . "'><body><font size = '5' color = 'red'>
                        YOUR LICENSE PERIOD IS OVER.
                        IF YOU ENJOYED USING THIS PRODUCT, <br/>
                        CONTACT SAMIR FOR THE FULL VERSION.
                        THANK YOU.</font></body></html>";
                exit();
            }
        }
    }

    /*function loginUpdate() {

        $req = "SELECT DISTINCT `exp_date` FROM `nhm_expense` ORDER BY `exp_date`;";

        $lastExpDate = null;

        $query = $this->conn->query($req);
        $rowcount = mysqli_num_rows($query);

        if ($rowcount == 0) {
            $pdrq = "SELECT `payment_date` FROM `nshm_account` ORDER BY `payment_date`";
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
                    $pdrq = "SELECT `payment_date` FROM `nshm_account` WHERE `payment_date` NOT IN ('" . $row['exp_date'] . "')";
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
                    $now = strtotime($row['exp_date']);
                    $your_date = strtotime($lastExpDate);
                    $datediff = $now - $your_date;
                    $diff = floor($datediff/(60*60*24));
                    if($diff == 2){
                        $expDate = date('Y-m-d', strtotime('-1 day', strtotime($row['exp_date'])));
                        $spResponse = $this->conn->query("Call sp_accountUpdate(0,0,'" . $expDate . "');");
                        $lastExpDate = $row['exp_date'];
                    }else{
                        $spResponse = $this->conn->query("Call sp_accountUpdate(0,0,'" . $row['exp_date'] . "');");
                        $lastExpDate = $row['exp_date'];
                    }
                    //$spResponse = $this->conn->query("Call sp_accountUpdate(0,0,'" . $row['exp_date'] . "');");
                }
            }
        }
        return $spResponse;
    }*/
    function loginUpdate() {
        $req = "SELECT DISTINCT `payment_date` FROM `nshm_account` ORDER BY `payment_date`;";
        $lastExpDate = null;
        $query = $this->conn->query($req);
        while ($r = mysqli_fetch_assoc($query)) {
            $spResponse = $this->conn->query("Call sp_accountUpdate(0,0,'" . $r['payment_date'] . "');");
        }
        return $spResponse;
    }

}
