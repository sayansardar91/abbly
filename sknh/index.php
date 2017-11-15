<?php

include 'action.php';

if ((isset($_GET['pg']) or (isset($_SESSION['user'])))) {
    $page = isset($_GET['pg'])?$_GET['pg']:'home';
    $page_type = "";

    if ($_SESSION['type'] == 1) {
        $page_type = "superuser";
    } else if ($_SESSION['type'] == 2) {
        $page_type = "manager";
    }else if ($_SESSION['type'] == 3) {
        $page_type = "reception";
    }
	if($page == 'home' && $_SESSION['type'] == 3){
		$page = 'home_rcpt';
	}
	if($page == 'income' && $_SESSION['type'] == 2){
		$page = 'partner_income';
	}
	
    if($page == "doclist"){
        $page_title = "Doctors List";
    }else if($page == "docattend"){
        $page_title = "Doctor's Attendance";
    }else if($page == "admission_form"){
        $page_title = "Patient List";
    }else if($page == "birth_certificate"){
        $page_title = "Birth Certificate";
    }else if($page == "patient_account"){
        $page_title = "Patient Account";
    }else if($page == "emp_department"){
        $page_title = "Employee Type";
    }else if($page == "emp_payment"){
        $page_title = "Employee Payment";
    }else if($page == "expense_report"){
        $page_title = "Expense Report";
    }else if($page == "income_report"){
        $page_title = "Income Report";
    }else if($page == "partner_income" && $_SESSION['type'] == 1){
        $page_title = "Partner Income";
    }else if($page == "partner_income" && $_SESSION['type'] == 2){
        $page_title = "Income Report";
    }else if($page == "it_report"){
        $page_title = "IT Report";
    }else if($page == "discharge_report"){
        $page_title = "Discharge Report";
    }else if($page == "admission_report"){
        $page_title = "Admission Report";
    }else if($page == "birth_list"){
        $page_title = "Birth List";
    }else if($page == "bed_status"){
        $page_title = "Bed Status";
    }else if($page == "home_rcpt"){
		$page_title = "Home";
	}else if($page == "paydoc"){
		$page_title = "Pay To Doctor";
	}else if($page == "paynshm"){
		$page_title = "Pay To Nursing Home";
	}else if($page == "payReport"){
		$page_title = "Docotr's Payment Report";
	}else{
        $page_title = ucfirst($page);
    }
    
    

    $user_name = $_SESSION['user'];
    $log_segment = ucfirst($page_type);
    //$side_bar = 'views/' . $page_type . '/elements/menu.php';
    //$page_content = 'views/' . $page_type . "/" . $page . '.php';
    $side_bar = 'views/pages/elements/menu.php';
    $page_content = 'views/pages/' . $page . '.php';
    include('layouts/master.php');
} else {
    $user = new UserClass();
    if($user->getUserCount()){
        $page_title = "Login";
        $page_content = 'views/users/login.php';
        $user->appTrial();
        include('layouts/login_master.php');
        
    }else{
        $page_title = "Create User";
        $page_content = 'views/users/create_user.php';
        include('layouts/login_master.php');
    }
    
}
