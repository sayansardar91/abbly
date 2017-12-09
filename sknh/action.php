<?php

session_start();
date_default_timezone_set('Asia/Kolkata');




require_once 'lib/config.php';
require_once 'lib/database.php';
require_once 'lib/admission.php';
require_once 'lib/accounts.php';
require_once 'lib/department.class.php';
require_once 'lib/nhmdetails.class.php';
require_once 'lib/Guid.php';
require_once 'lib/doctors.php';
require_once 'lib/discharge.php';
require_once 'lib/expense.php';
require_once 'lib/employee.php';
require_once 'lib/userclass.php';
require_once 'lib/payment.php';
require_once 'lib/MyDateTime.php';


$action = filter_input(INPUT_GET, 'action');
if (isset($action)) {
    switch ($action) {
        case "getusertype":
            echo $_SESSION['type'];
            break;
        case "reg":
            $atc = new admission();
            $atc->getRegNo();
            break;
        case "reg_blg":

            $atc = new admission();
            $date1 = new DateTime($_POST["date"]);
            $date2 = new DateTime("now");

            $diff = $date2->diff($date1)->format("%a");
            if ($diff) {
                $atc->getRegNoBLG(SHORT_Name, $_REQUEST['date']);
            } else {
                $atc->getRegNo(SHORT_Name);
            }

            break;
        case "adm_reg":
            $atc = new admission();

            $reg_no = $_POST['reg_no'];
            $date1 = new DateTime($_POST["admit_date"]);
            $date2 = new DateTime("now");

            $diff = $date2->diff($date1)->format("%a");

            if ($diff) {
                $_POST['bk_lg'] = 1;
            }

            $_POST["admit_time"] = $_POST["hr"] . ":" . $_POST["min"] . " " . $_POST["meridian"];
            unset($_POST["hr"]);
            unset($_POST["min"]);
            unset($_POST["meridian"]);
            unset($_POST["submit"]);
            unset($_POST['id']);
            unset($_POST['regno']);
            //echo "<pre>";
            //print_r($_POST);
            foreach ($_POST as $key => $value) {
                if ($value == "") {
                    $_POST[$key] = " ";
                }
            }
            $result = $atc->dbRowInsert("patient_details", $_POST);
            if ($result) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = $reg_no . " has been added successfully.";
                $_SESSION['reg_no'] = $reg_no;
            } else {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = $reg_no . " has not been added.";
            }

            header("Location: index.php?pg=admission");
            break;
        case "actv":
            $dpt = new department();
            $dpt->setStatus($_POST);
            break;
        case "add_dept":
            $dpt = new department();
            $rs = $dpt->addDept($_POST);
            if (isset($_POST['dept_group'])) {
                header("Location: index.php?pg=emp_department");
            } else {
                header("Location: index.php?pg=departments");
            }

            break;
        case "get_dpt":
            $dpt = new department();
            $rs = $dpt->allDept();
            break;
        case "get_empdpt":
            $dpt = new department();
            $rs = $dpt->allEmpDept();
            break;
        case "add_bcat":
            $nhmd = new nhmdetails();
            $rs = $nhmd->addBedCategory($_POST);
            header("Location: index.php?pg=beds");
            break;
        case "get_tp":
            $nhmd = new nhmdetails();
            $rs = $nhmd->allBedCategory();
            break;
        case "get_bd":
            $nhmd = new nhmdetails();
            $rs = $nhmd->allBedTypes();
            break;
        case "dpt_list":
            $dpt = new department();
            $group = 0;
            if (isset($_GET['group'])) {
                $group = 1;
            }
            $dpt->deptList($group);
            break;
        case "get_bdcat":
            $nhmd = new nhmdetails();
            $nhmd->listBedCat();
            break;
        case "get_bdt":
            $nhmd = new nhmdetails();
            $nhmd->listAvailBed($_REQUEST['id']);
            break;
        case "get_bdta":
            $nhmd = new nhmdetails();
            $nhmd->listAllBed($_REQUEST['id']);
            break;
        case "get_bdchrg":
            $nhmd = new nhmdetails();
            $nhmd->getBedCharge($_REQUEST['id']);
            break;
        case "add_doc":
            unset($_POST['submit']);
            $_POST['contact_no'] = implode(",<br>", $_POST['contact_no']);
            $doc = new doctors();
            $result = $doc->addDoc(array_filter($_POST));
            if ($result) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = "Dr. " . $_POST['doc_name'] . "'s details has been added successfully.";
            } else {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "Dr. " . $_POST['doc_name'] . "'s details has not been added.";
            }
            header("Location: index.php?pg=doctors");
            break;
        case "doc_reg":
            $guid = new Guid();
            echo trim($guid->toString());
            break;
        case "doc_list":
            $doc = new doctors();
            $doc->allDoctors();
            break;
        case "doc_actv":
            $doc = new doctors();
            $doc->setStatus($_POST);
            break;
        case "doc_atnd":
            $doc = new doctors();
            $doc->docAttend();
            break;
        case "doc_ats":
            $doc = new doctors();
            $doc->chngAttend($_POST);
            break;
        case "doc_lst":
            $doc = new doctors();
            $doc->docList($_REQUEST['id']);
            break;
        case "atd_ansth":
            $doc = new doctors();
            $doc->ansthList();
            break;
        case "add_prov":
            $nhm = new nhmdetails();
            $nhm->addProv($_POST);
            header("Location: index.php?pg=provisional");
            break;
        case "get_prov":
            $nhm = new nhmdetails();
            $nhm->getProv();
            break;
        case "prov_list":
            $nhm = new nhmdetails();
            $nhm->listProv();
            break;
        case "get_pt":
            $adm = new admission();
            $adm->getPatient($_REQUEST['id']);
            break;
        case "adm_update":
            $adm = new admission();
            $id = $_POST['id'];
            $reg_no = $_POST['regno'];
            unset($_POST['id']);
            unset($_POST['regno']);
            unset($_POST['submit']);
            $result = $adm->dbRowUpdate("patient_details", $_POST, '`id`=' . $id);
            if ($result) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = $reg_no . " has been updated successfully.";
            } else {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = $reg_no . " has not been updated.";
            }
            header("Location: index.php?pg=admission");
            break;
        case "del_session":
            unset($_SESSION['success']);
            unset($_SESSION['msg']);
            if (isset($_SESSION['reg_no'])) {
                unset($_SESSION['reg_no']);
            }
            break;
        case "patient_list":
            $adm = new admission();
            if (isset($_GET['dName'])) {
                $adm->getPtientListByDoc($_GET['dName']);
            } else {
                $adm->getPtientList();
            }
            break;
        case "rcppatient_list":
            $adm = new admission();
            $adm->getPtientListRCP();
            break;
        case "did":
            $dcchrg = new discharge();
            echo $dcchrg->getDID();
            break;
        case "dchrg":
            $dcchrg = new discharge();
            $_POST = array_filter($_POST);

            $reg_no = $_POST['patient_id'];
            $result = $dcchrg->dbRowInsert("patient_discharge", $_POST);
            if ($result) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = $reg_no . " has been Discharged.";
            } else {
                $_SESSION['success'] = false;
                if (mysqli_errno($dcchrg->conn) == 1452) {
                    $_SESSION['msg'] = $reg_no . " is not a valid Patient ID.";
                } else {
                    $_SESSION['msg'] = $reg_no . " data has not been entered.";
                }
            }
            header("Location: index.php?pg=discharge");
            break;
        case "dchrg_pt":
            $dcchrg = new discharge();
            $dcchrg->getDchrgList();
            break;
        case "atd_nurse":
            $doc = new doctors();
            $doc->allSister();
            break;
        case "pt_acc":

            $cherg_array = $_POST['chrg'];
            $result = null;
            $docAmount = null;
            $pt_act = new admission();
            $totOrg = $totPtnr = null;
            $idFound = null;
            $payFlag = false;
            foreach ($cherg_array as $key => $value) {
                if ($value['id'] != 0) {
                    if ($idFound == null) {
                        $idFound = $value['id'];
                    } else {
                        $idFound = $idFound . "," . $value['id'];
                    }
                    $payFlag = true;
                }
            }
            if ($idFound != null) {
                $ptID = '(Select id from patient_details WHERE reg_no = "' . $_POST['reg_no'] . '")';
                $pt_act->dbRowDelete('patient_account', 'id NOT IN (' . $idFound . ') AND patient_id = ' . $ptID);
            }
            foreach ($cherg_array as $key => $value) {
                //echo $value['chrg_type'];
                if ($value['chrg_type'] == 10) {
                    $value['remarks'] = $value['bedDays'] . "x" . $value['bedChrg'];
                    unset($value['bedDays']);
                    unset($value['bedChrg']);
                } else if ($value['chrg_type'] == 11) {
                    $value['remarks'] = $value['bedExtDays'] . "x" . $value['bedExtChrg'];
                    unset($value['bedExtDays']);
                    unset($value['bedExtChrg']);
                } else if ($value['chrg_type'] == 12) {
                    $value['remarks'] = $value['atdNo'] . "x" . $value['atdDays'] . "x" . $value['atdChrg'];
                    unset($value['atdNo']);
                    unset($value['atdDays']);
                    unset($value['atdChrg']);
                }
                $value['entry_date'] = date('Y-m-d', strtotime($_POST['entry_date']));
                if ($value['doc']) {
                    $docAmount = $docAmount + $value['org_chrg'];
                }
                $docAmnt = array('amount_paid' => $docAmount, 'payment_date' => $value['entry_date']);

                $result = $pt_act->addPatientAcct("patient_account", $value, $_POST['reg_no']);

                if (($result) && ($value['chrg_type'] == 1)) {
                    $dAmnt = array('amount_paid' => $value['org_chrg'], 'payment_date' => $value['entry_date']);
                    $result = $pt_act->nshmToDoc("doctor_dr", $dAmnt, $_POST['reg_no']);
                }
                if (($result) && ($docAmount != null)) {
                    $result = $pt_act->docToNshm("doctor_cr", $docAmnt, $_POST['reg_no']);
                }
                $totOrg = $totOrg + $value['org_chrg'];
                $totPtnr = $totPtnr + $value['chrg_prt'];
            }
            if ($result) {
                if ($payFlag) {
                    $payArr = array('total_amount' => $totOrg);
                    $result = $pt_act->dbRowUpdate("patient_payment", $payArr, " reg_no = '" . $_POST['reg_no'] . "'");
                } else {
                    $payArr = array('reg_no' => $_POST['reg_no'], 'total_amount' => $totOrg);
                    $result = $pt_act->dbRowInsert("patient_payment", $payArr);
                }
            }
            if ($result) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = "Account Details for Reg.No. : " . $_POST['reg_no'] . " has been added successfully.";
            } else {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "Account Details for Reg.No. : " . $_POST['reg_no'] . " has not been added successfully.";
            }
            /*$exp = new expense();
            $exp->updateIncome();*/
            header("Location: index.php?pg=patient_account");
            break;
        case "get_ptd":
            $adm1 = new admission();
            $adm1->getPatientAccount($_REQUEST['id']);
            break;
        case "daily_exp":
            $exp = new expense();
            $result = $exp->addExpenses($_POST);

            if ($result) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = "Expense for Date : " . $_POST['exp_date'] . " has been Added or Updated successfully.";
            } else {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "Expense for Date : " . $_POST['exp_date'] . " has not been Added or Updated successfully.";
            }
            /*$exp->updateIncome();*/
            header("Location: index.php?pg=expense");
            break;
        case "get_exp":
            $exp = new expense();
            $exp->getExp($_GET['date']);
            break;
        case "adm_emp":
            unset($_POST['submit']);
            $emp = new employee();
            $chk = array($_POST['emp_firstname'], $_POST['emp_lastname'], $_POST['emp_middlename']);
            /* echo $emp->checkExists($chk);
              die; */
            $rs = $emp->checkExists($chk);
            if ($rs['count']) {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "Employee named " . $_POST['emp_firstname'] . " " . $_POST['emp_middlename'] . " " . $_POST['emp_lastname'] . " Employee ID : " .
                        $rs['empid'] . " already exists.";
            } else {
                $result = $emp->dbRowInsert('employee_details', $_POST);
                if ($result) {
                    $_SESSION['success'] = true;
                    $_SESSION['msg'] = "Employee Details For the Employee ID " . $_POST['emp_id'] . " has been added successfully.";
                } else {
                    $_SESSION['success'] = false;
                    $_SESSION['msg'] = "Employee Details For the Employee ID " . $_POST['emp_id'] . " has not been added successfully.";
                }
            }

            header("Location: index.php?pg=employee");
            break;
        case "emp_auto":
            $atc = new employee();
            $atc->getList($_REQUEST["id"], $_REQUEST['term']);
            break;
        case "doc_auto":
            $atc = new doctors();
            $atc->getList($_REQUEST["id"], $_REQUEST['term']);
            break;
        case "empid":
            $atc = new employee();
            echo SHORT_Name . " - " . "E" . $atc->getEmpID();
            break;
        case "get_emp":
            $atc = new employee();
            $atc->getEmp($_REQUEST['emp_id']);
            break;
        case "get_empsal":
            $atc = new employee();
            $atc->getEmpSal($_REQUEST['emp_id']);
            break;
        case "get_empname":
            $atc = new employee();
            $atc->getEmpName($_REQUEST['emp_id']);
            break;
        case "get_empid":
            $arr = explode(" ", $_REQUEST['emp_name']);
            $atc = new employee();
            echo $atc->getID($arr);
            break;
        case "emp_update":
            unset($_POST['submit']);
            $emp = new employee();
            $result = $emp->dbRowUpdate('employee_details', $_POST, '`emp_id`="' . $_POST['emp_id'] . '"');
            if ($result) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = "Employee Details For the Employee ID " . $_POST['emp_id'] . " has been update successfully.";
            } else {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "Employee Details For the Employee ID " . $_POST['emp_id'] . " has not been updated successfully.";
            }
            header("Location: index.php?pg=employee");
            break;
        case "emp_sal":
            $emp = new employee();
            unset($_POST['submit']);
            unset($_POST['emp_firstname']);
            unset($_POST['emp_dept']);
            unset($_POST['emp_doj']);

            $mdate = new MyDateTime();
            $mdate->setDate(date('Y', strtotime($_POST['sal_date'])), date('m', strtotime($_POST['sal_date'])), date('d', strtotime($_POST['sal_date'])));
            $result = $mdate->fiscalYear();
            $start = $result['start']->format('Y');
            $end = $result['end']->format('y');
            $finyear = $start . "-" . $end;
            $_POST['fin_year'] = $finyear;

            $chkArr = array($_POST['emp_id'], $_POST['sal_month']);
            $_POST['sal_date'] = date('Y-m-d', strtotime($_POST['sal_date']));
            if ($emp->chkPayment($chkArr)) {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "Payment Already Done For the Employee ID " . $_POST['emp_id'] . " for the Month " . $_POST['sal_month'];
            } else {
                $result = $emp->dbRowInsert('emp_salary', array_filter($_POST));
                if ($result) {
                    $_SESSION['success'] = true;
                    $_SESSION['msg'] = "Payment Done For the Employee ID " . $_POST['emp_id'];
                } else {
                    $_SESSION['success'] = false;
                    $_SESSION['msg'] = "Payment Not Done For the Employee ID " . $_POST['emp_id'];
                }
            }
            header("Location: index.php?pg=emp_payment");
            break;
        case 'emp_exp':
            $emp = new employee();
            $emp->getEmpExp($_REQUEST['exp_date']);
            break;
        case 'add_baby':
            $adm = new admission();
            $_POST = array_filter($_POST);
            //$_POST['baby_tob'] = $_POST['hr'] . ":" . $_POST['min'] . ":" . $_POST['sec'] . " " . $_POST['merd'];
            $_POST['baby_tob'] = trim($_POST['hr']) . ":" . trim($_POST['min']) . ":" . trim($_POST['sec']) . trim($_POST['merd']);
            unset($_POST['hr']);
            unset($_POST['min']);
            unset($_POST['sec']);
            unset($_POST['merd']);
            $_POST['baby_tob'] = date('H:i:s', strtotime($_POST['baby_dob'] . ' ' . $_POST['baby_tob']));

            $result = $adm->dbRowReplaceInsert("baby_details", $_POST);
            if ($result) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = "Birth Certificate Details have been added successfully.";
                $_SESSION['reg_no'] = $_POST['baby_id'];
            } else {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "Birth Certificate Details have not been added successfully.";
            }
            header("Location: index.php?pg=birth_certificate");
            break;
        case 'bct':
            $bct = new nhmdetails();
            $bct->bctStatus($_POST);
            break;
        case 'bd':
            $bct = new nhmdetails();
            $bct->bdStatus($_POST);
            break;
        case 'add_user':

            $_POST = array_filter($_POST);

            $create_type = 0;
            if (isset($_POST['create_type'])) {
                $create_type = $_POST['create_type'];
                unset($_POST['create_type']);
            }
            if (isset($_POST['create_user'])) {
                unset($_POST['create_user']);
            }

            $_POST['user_passwdstr'] = $_POST['user_passwd'];
            $_POST['user_passwd'] = md5($_POST['user_passwd']);

            $user = new UserClass();
            $charr = array($_POST['emp_id'], $_POST['user_type']);
            if ($user->checkExists($charr)) {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "User already created for this Employee. ID : " . $_POST['emp_id'];
            } else {
                $result = $user->dbRowInsert("user_details", $_POST);
                if ($result) {
                    $_SESSION['success'] = true;
                    $_SESSION['msg'] = "User has created successfully. User Name : " . $_POST['user_name'] .
                            " and Password : " . $_POST['user_passwdstr'];
                } else {
                    $_SESSION['success'] = false;
                    $_SESSION['msg'] = "User has not created.";
                }
            }
            if ($create_type) {
                header("Location: index.php");
            } else {
                header("Location: index.php?pg=usergroup");
            }
            break;
        case 'user_list':
            $user = new UserClass();
            $user->getUsers();
            break;
        case 'user_actv':
            $user = new UserClass();
            $user->setStatus($_POST);
            break;
        case 'amnt_toword':
            echo ucfirst(convert_number_to_words($_POST['amount']));
            break;
        case 'bill_no':
            $atc = new payment();
            echo $atc->getBillNo();
            break;
        case 'pt_name':
            $pmnt = new payment();
            $pmnt->getPatientName($_REQUEST['id']);
            break;
        case 'pt_total':
            $pmnt = new payment();
            $pmnt->getTotalAmount($_REQUEST['id']);
            break;
        case 'pmt_list':
            $pmnt = new payment();
            $pmnt->getPaymentDetails($_REQUEST['id']);
            break;
        case 'pt_payment':
            $pmnt = new payment();
            unset($_POST['patient_name']);
            unset($_POST['amount_paid']);
            unset($_POST['bed_chrg']);
            $_POST = array_filter($_POST);

            $mydate = new MyDateTime();
            $mydate->setDate(date("Y", strtotime($_POST['payment_date'])), date("m", strtotime($_POST['payment_date'])), date("d", strtotime($_POST['payment_date'])));
            $result = $mydate->fiscalYear();
            $start = $result['start']->format('Y');
            $end = $result['end']->format('y');
            $fyear = $start . "-" . $end;
            $_POST['fin_year'] = $fyear;
            $_POST['payment_month'] = date("M", strtotime($_POST['payment_date']));
            $result = $pmnt->dbRowInsert("patient_bill", $_POST);
            if ($result) {

                $_SESSION['success'] = true;
                $_SESSION['msg'] = "Payment Done for Patient ID : " . $_POST['reg_no'];
                $_SESSION['bill_no'] = $_POST['bill_no'];
            } else {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "Payment Not Done for Patient ID : " . $_POST['reg_no'];
            }
            header("Location: index.php?pg=payment");
            break;
        case 'add_charge':
            $pmnt = new payment();
            $pmnt->getAddCharge($_REQUEST['id']);
            break;
        case 'del_adm':

            $adm = new admission();
            $result = $adm->dbRowDelete('patient_details', 'reg_no= "' . $_POST['id'] . '"');
            if ($result) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = "Patient ID : " . $_POST['id'] . " has been deleted.";
            } else {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "Patient ID : " . $_POST['id'] . " has not been deleted.";
            }
            break;
        case 'del_doc':
            $adm = new admission();
            echo $result = $adm->dbRowDelete('doc_details', 'id= "' . $_POST['id'] . '"');
            exit;
            if ($result) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = "Doctor's Details Has Been Deleted.";
            } else {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "Doctor's Details Has Not Been Deleted.";
            }
            break;
        case 'sister_list':
            $emp = new employee();
            $emp->getSisters();
            break;
        case 'baby_id':
            $emp = new admission();
            $emp->getBabyID($_REQUEST["action"], $_REQUEST['term']);
            break;
        case 'baby_id_no':
            $emp = new admission();
            $emp->getBID();
            break;
        case "get_baby":
            $atc = new admission();
            $atc->getBaby($_REQUEST['baby_id']);
            break;
        case "birth_list":
            $atc = new admission();
            $atc->getBabyList();
            break;
        case 'del_baby':
            $adm = new admission();
            echo $result = $adm->dbRowDelete('baby_details', 'baby_id= "' . $_POST['id'] . '"');
            exit;
            if ($result) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = "Baby Details Has Been Deleted.";
            } else {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "Baby Details Has Not Been Deleted.";
            }
            break;
        case 'del_dept':
            $adm = new admission();
            echo $result = $adm->dbRowDelete('department_details', 'id= "' . $_POST['id'] . '"');
            exit;
            if ($result) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = "Department Name Has Been Deleted.";
            } else {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "Department Name Has Not Been Deleted.";
            }
            break;
        case 'del_dedcg':
            $adm = new admission();
            $result = $adm->dbRowDelete('bed_category', 'id= "' . $_POST['id'] . '"');
            if ($result) {
                $result = $adm->dbRowDelete('bed_details', 'bed_type= "' . $_POST['id'] . '"');
                if ($result) {
                    $_SESSION['success'] = true;
                    $_SESSION['msg'] = "Bed Category And Bed Details Has Been Deleted.";
                }
            } else {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "Bed Category Has Not Been Deleted.";
            }
            break;
        case 'del_dig':
            $adm = new admission();
            echo $result = $adm->dbRowDelete('prov_diag', 'id= "' . $_POST['id'] . '"');
            exit;
            if ($result) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = "Provisional Diagnosis Has Been Deleted.";
            } else {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "Provisional Diagnosis Has Not Been Deleted.";
            }
            break;
        case 'emp_list':
            $emp = new employee();
            $emp->getOthers();
            break;
        case 'get_doc':
            $doc = new doctors();
            $doc->getDocList($_REQUEST['doc_reg']);
            break;
        case 'get_parent':
            $prt = new admission();
            $prt->getParent($_REQUEST['patient_reg_no']);
            break;
        case 'del_dch':
            $dsc = new discharge();
            $dsc->dbRowDelete('patient_discharge', 'discharge_id= "' . $_POST['id'] . '"');
            break;
        case 'bill_list':
            $pbill = new payment();
            $pbill->getPatientBill();
            break;
        case 'bed_auto':
            $atc = new nhmdetails();
            $atc->getList($_REQUEST["id"], $_REQUEST['term']);
            break;
        case 'get_beds':
            $atc = new nhmdetails();
            $atc->getBeds($_REQUEST['bed_type']);
            break;
        case 'del_emp':
            $dsc = new employee();
            $dsc->dbRowDelete('employee_details', 'id= "' . $_POST['id'] . '"');
            break;
        case 'del_ded':
            $dsc = new nhmdetails();
            $bed_cat = $dsc->getBedCat($_POST['id']);
            //$result = $dsc->dbRowDelete('bed_details', 'id= "' . $_POST['id'] . '"');
            
            $count = array('bed_del' => 1);
            $result = $dsc->dbRowUpdate("bed_details", $count, '`id`=' . $_POST['id']);
            
            if ($result) {
                $req = "SELECT count(*) AS count from bed_details WHERE `bed_type` = $bed_cat AND bed_del = 0";
                $result = $dsc->conn->query($req);
                $count = "";
                while ($row = $result->fetch_assoc()) {
                    $count = $row['count'];
                }
                $count = array('bed_no' => $count);
                $result = $dsc->dbRowUpdate("bed_category", $count, '`id`=' . $bed_cat);
            }
            break;
        case 'get_days':
            $addm = new admission();
            $addm->getDays($_REQUEST["id"]);
            break;
        case 'final_bill':
            $pmnt = new payment();
            echo $pmnt->getFinalBillNo();
            break;
        case 'chk_bill':
            $pmnt = new payment();
            $result = $pmnt->chkFinalBillNo($_REQUEST['id']);
            $res = null;
            if ($result) {
                $res = array('exist' => "yes");
            } else {
                $res = array('exist' => "no");
            }
            echo json_encode($res);
            break;
        case 'addbill':
            $_POST = array_filter($_POST);
            $pmnt = new payment();
            $result = $pmnt->dbRowInsert('final_bill', $_POST);
            if ($result) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = "Bill has been generated for Patient ID : " . $_POST['reg_no'];
                $_SESSION['bill_no'] = $_POST['bill_no'];
            } else {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "Bill has been generated for Patient ID : " . $_POST['reg_no'];
            }
            header("Location: index.php?pg=finalbill");
            break;
        case 'fbill_list':
            $dcrg = new discharge();
            $dcrg->getFbillList();
            break;
        case 'add_word':
            $nhmtools = new nhmdetails();
            $result = $nhmtools->dbRowReplaceInsert('wordpad', $_POST);
            if ($result) {
                echo $_POST['file_name'] . " has been saved.";
            } else {
                echo $_POST['file_name'] . " has not been saved.";
            }
            break;
        case 'get_wordpad':
            $nhmtools = new nhmdetails();
            $nhmtools->getWordpad();
            break;
        case 'get_file':
            $nhmtools = new nhmdetails();
            $nhmtools->getFile($_REQUEST['id']);
            break;
        case 'del_wordpad':
            $nhmtools = new nhmdetails();
            $nhmtools->dbRowDelete('wordpad', 'id= "' . $_POST['id'] . '"');
            break;
        case 'diog_name':
            $emp = new nhmdetails();
            $emp->getDiog($_REQUEST["action"], $_REQUEST['term']);
            break;
        case 'get_diog':
            $prt = new nhmdetails();
            $prt->getDiogDetails($_REQUEST['diog_name']);
            break;
        case 'get_admdt':
            $admdt = new admission();
            $admdt->getAdmdt();
            break;
        case 'get_dchrgdt':
            $admdt = new admission();
            $admdt->getDchrgdt();
            break;
        case 'get_beddt':
            $admdt = new admission();
            $admdt->getBedDt();
            break;
        case 'get_tot':
            $admdt = new admission();
            $admdt->getTot($_REQUEST['id']);
            break;
        case 'add_acttype':
            $exptype = new accounts();
            $exptype->dbRowReplaceInsert('accounts_type', array_filter($_POST));
            header("Location: index.php?pg=add_expenses");
            break;
        case 'get_accttype':
            $exp_type = new accounts();
            $exp_type->getAcctTypeTB();
            break;
        case 'get_actname':
            $expname = new accounts();
            $expname->getActName($_POST['id']);
            break;
        case 'get_doctall':
            $docall = new doctors();
            $docall->docListAll();
            break;
        case 'by_doc':
            $byDoc = new admission();
            $byDoc->getPatbydoc($_REQUEST['id']);
            break;
        case 'payment':
            $doc_pay = new accounts();
            $table = ($_GET['tp'] == 'dr') ? "doctor_dr" : "doctor_adv";
            $return = ($_GET['tp'] == 'dr') ? "paydoc" : "paynshm";
            $result = $doc_pay->dbRowReplaceInsert($table, array_filter($_POST));
            if ($result) {
                $_SESSION['success'] = true;
                $_SESSION['msg'] = "Payment has been addedd successfully.";
                /*$doc_pay->updateAccount();*/
            } else {
                $_SESSION['success'] = false;
                $_SESSION['msg'] = "Payment has not been addedd successfully.";
            }
            header("Location: index.php?pg=" . $return);
            break;
        case 'docamount':
            $docamount = new doctors();
            $docamount->getDocAmount($_GET['id']);
            break;
        case 'docamntrng':
            $docamount = new doctors();
            $docamount->getDocAmountRange($_GET['id'], null, null);
            break;
        case 'datechange':
            $docamount = new doctors();
            $docamount->getDocAmountRange($_GET['id'], $_GET['from'], $_GET['to']);
            break;
        case 'get_bdcrg':
            $bedChrg = new admission();
            $bedChrg->getBedCharge($_GET['id']);
            break;
        case 'getPtd':
            $ptd = new discharge();
            $ptd->getPtd($_REQUEST['id']);
            break;
        case 'pton':
            $pton = new accounts();
            $pton->getDoctorAdv();
            /*$exp = new expense();
            $exp->updateIncome();*/
            break;
        case 'del_payment':
            $pmnt_doc = new accounts();
            $pmnt_doc->dbRowDelete('doctor_adv', 'id= "' . $_POST['id'] . '"');
            /*$pmnt_doc->updateAccount();*/
            break;
        default:
            $atc = new admission();
            $atc->getList($_REQUEST["action"], $_REQUEST['term']);
            break;
    }
}

