<?php
set_time_limit(0);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

session_start();
date_default_timezone_set('Asia/Kolkata');

require_once dirname(dirname(__FILE__)).'/lib/config.php';
require_once dirname(dirname(__FILE__)).'/lib/database.php';
require_once dirname(dirname(__FILE__)).'/lib/accounts.php';
require_once dirname(dirname(__FILE__)).'/lib/expense.php';

class AccountUpdate {

    function __construct() {
		self::processAccount();
    }

    private function processAccount(){
    	$acc = new accounts();
    	$exp = new expense();

    	if($acc->updateAccount()){
    		echo "Main Account Updated On [".date('d-m-Y h:i:s a')."]\n";
    		if($exp->updateIncome()){
    			echo "Expense Account Updated On [".date('d-m-Y h:i:s a')."]\n";
    		}else{
	    		echo "Expense Account Update Failed [".date('d-m-Y h:i:s a')."]\n";
	    	}
    	}else{
    		echo "Main Account Update Failed [".date('d-m-Y h:i:s a')."] \n";
    	}

    }
}

$acUpdate = new AccountUpdate();
