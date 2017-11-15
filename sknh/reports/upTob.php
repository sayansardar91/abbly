<?php
ini_set('max_execution_time', 300);
require_once "../lib/config.php";
require_once "../lib/database.php";

$result = "";
$db_up = new database();
$str = "UPDATE baby_details set `baby_tob` = TRIM(Replace(Replace(Replace(`baby_tob`,'\t',''),'\n',''),'\r',''))";
$result = $db_up->conn->query($str);
$count = 0;
if($result){
	$db = new database();
	$req = "SELECT bb_id,baby_tob FROM `baby_details`";
	$query = $db->conn->query($req);
	while ($row = mysqli_fetch_assoc($query)) {
		$row['baby_tob'] = date('H:i:s',strtotime($row['baby_tob']));
		$db1 = new database();
		$qstr = "UPDATE `baby_details` SET baby_tob='".$row['baby_tob']."' WHERE bb_id=".$row['bb_id'];
		$result =  $db1->conn->query($qstr);
		$count++;
	}
}
if($result){
	echo "Update Total : ".$count;
}else{
	echo "Update Not Done: Total : ".$count;
}
?>