<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of expense
 *
 * @author Sayan
 */

class expense extends database{
    //put your code here
    function __construct() {
        parent::__construct();
    }
    function addExpenses($post){
        $mdate = new MyDateTime();
        $mdate->setDate(date('Y',strtotime($post['exp_date'])), date('m',strtotime($post['exp_date'])), date('d',strtotime($post['exp_date'])));
        $result = $mdate->fiscalYear();
        $start = $result['start']->format('Y');
        $end = $result['end']->format('y');
        $finyear = $start . "-" . $end;
        $chrg_type = "";
        $chrg_remarks = ""; $chk_arr="";
        $tot_chrg = "";
        $result = "";
        $delEmp = null;
        $delFlag = false;
        $chrgDel = null;
        $delAll = false;
        
        for($i=0;$i<sizeof($post['exp_type']);$i++){
            //echo $post['exp_type'][$i]."<br/>";
            
            switch ($post['exp_type'][$i]){
                case 1:
                    $nhmAdv = null;
                    $chrg_type = $post['exp_type'][$i];
                    $arr = array_filter($post['doc_name']);
                    if(!empty($arr)){
                        for($j=0;$j<sizeof($post['doc_name']);$j++){
                            if(!empty($post['doc_name'][$j])){
                                $chrg_remarks[] = $post['doc_name'][$j]." - ".$post['doc_chrg'][$j];
                                $nhmAdv[] = array('atd_doctor' => $post['doc_name'][$j], 'amount_paid' => $post['doc_chrg'][$j], 'payment_date' => $post['exp_date']);
                            }
                        }

                        $chrg_remarks = implode(",", $chrg_remarks);
                        $tot_chrg = $post['doc_totchrg'];
                        unset($post['doc_name']);
                        unset($post['doc_chrg']);
                        unset($post['doc_totchrg']);
                        $post['doc'] = array('fin_year'=>$finyear,'exp_date'=>$post['exp_date'],'exp_month'=>date('M',strtotime($post['exp_date'])),'chrg_type'=>$chrg_type,'chrg_remarks'=>$chrg_remarks,'tot_expense'=>$tot_chrg);
                        $chk_arr = array($post['exp_date'],$chrg_type,$finyear);
                        if($this->checkExists($chk_arr)){
                            $result = $this->dbRowUpdate('nhm_expense', $post['doc'],"`exp_date`='".$post['exp_date']."' AND `chrg_type`='".$chrg_type."'");
                        }else{
                            $result = $this->dbRowInsert('nhm_expense', $post['doc']);
                        }
                        $chrgDel = ($chrgDel == null)?$post['exp_type'][$i]:$chrgDel.",".$post['exp_type'][$i];
                        $docID = "";$paydate = "";
                        
                        if($result){
                            foreach ($nhmAdv as $value) {
                                $qrst = 'SELECT COUNT(*) AS `count` FROM `nshm_adv` WHERE `atd_doctor`='.$value["atd_doctor"].' AND `payment_date`="'.$value["payment_date"].'" ';
                                $rst = $this->conn->query($qrst);
                                $count = "";
                                while ($row = $rst->fetch_assoc()) {
                                    $count = $row['count'];
                                }
                                if($rst && $count == 1){
                                    $result = $this->dbRowUpdate('nshm_adv', array('amount_paid' => $value['amount_paid'] ),"`atd_doctor`='".$value['atd_doctor']."' AND `payment_date`='".$value['payment_date']."'");
                                    $docID[] = $value['atd_doctor'];
                                }else{
                                    $result = $this->dbRowInsert("nshm_adv",$value);
                                    $docID[] = $value['atd_doctor'];
                                }
                                $paydate = $value["payment_date"];
                            }
                            if($result){
                                $dID = "";
                                $qrst = 'SELECT `atd_doctor` FROM `nshm_adv` WHERE `payment_date`="'.$paydate.'" ';
                                $rst = $this->conn->query($qrst);
                                if($rst){
                                    $count = mysqli_num_rows($rst);
                                    if($count > 0){
                                        while ($rw = mysqli_fetch_assoc($rst)) {
                                            $dID[] = $rw['atd_doctor'];
                                        }
                                        $arr_dif=array_diff($dID,$docID);
                                        $res = false;
                                        foreach ($arr_dif as $value) {
                                            $res = $this->dbRowDelete('nshm_adv','`atd_doctor`='.$value.' AND `payment_date`="'.$paydate.'"');
                                        }
                                    }
                                    
                                }
                            }

                        }
                        $chrg_remarks = ""; $chk_arr="";$nhmAdv = "";
                    }
                    else{
                        $delAll = true;
                    } 
                    break;
                case 2:
                    $chrg_type = $post['exp_type'][$i];
                    $arr = array_filter($post['mrk_name']);
                    if(!empty($arr)){
                        for($j=0;$j<sizeof($post['mrk_name']);$j++){
                            if(!empty($post['mrk_name'][$j])){
                                $chrg_remarks[] = $post['mrk_name'][$j]." - ".$post['mrk_charge'][$j];
                            }
                        }
                        $chrg_remarks = implode(",", $chrg_remarks);
                        $tot_chrg = $post['mrk_totchrg'];
                        unset($post['mrk_name']);
                        unset($post['mrk_charge']);
                        unset($post['mrk_totchrg']);
                        $post['mrk'] = array('fin_year'=>$finyear,'exp_date'=>$post['exp_date'],'exp_month'=>date('M',strtotime($post['exp_date'])),'chrg_type'=>$chrg_type,'chrg_remarks'=>$chrg_remarks,'tot_expense'=>$tot_chrg);
                        $chk_arr = array($post['exp_date'],$chrg_type,$finyear);
                        if($this->checkExists($chk_arr)){
                            $result = $this->dbRowUpdate('nhm_expense', $post['mrk'],"`exp_date`='".$post['exp_date']."' AND `chrg_type`='".$chrg_type."'");
                        }else{
                            $result = $this->dbRowInsert('nhm_expense', $post['mrk']);
                        }
                        $chrgDel = ($chrgDel == null)?$post['exp_type'][$i]:$chrgDel.",".$post['exp_type'][$i];
                        $chrg_remarks = ""; $chk_arr="";
                    }
                    else{
                        $delAll = true;
                    } break;
                case 3:
                    $chrg_type = $post['exp_type'][$i];
                    $arr = array_filter($post['cooking_name']);
                    if(!empty($arr)){
                        for($j=0;$j<sizeof($post['cooking_name']);$j++){
                            if(!empty($post['cooking_name'][$j])){
                                $chrg_remarks[] = $post['cooking_name'][$j]." - ".$post['cooking_charge'][$j];
                            }
                        }
                        $chrg_remarks = implode(",", $chrg_remarks);
                        $tot_chrg = $post['cooking_totchrg'];
                        unset($post['cooking_name']);
                        unset($post['cooking_charge']);
                        unset($post['cooking_totchrg']);
                        $post['cook'] = array('fin_year'=>$finyear,'exp_date'=>$post['exp_date'],'exp_month'=>date('M',strtotime($post['exp_date'])),'chrg_type'=>$chrg_type,'chrg_remarks'=>$chrg_remarks,'tot_expense'=>$tot_chrg);
                        $chk_arr = array($post['exp_date'],$chrg_type,$finyear);
                        if($this->checkExists($chk_arr)){
                            $result = $this->dbRowUpdate('nhm_expense', $post['cook'],"`exp_date`='".$post['exp_date']."' AND `chrg_type`='".$chrg_type."'");
                        }else{
                            $result = $this->dbRowInsert('nhm_expense', $post['cook']);
                        }
                        $chrgDel = ($chrgDel == null)?$post['exp_type'][$i]:$chrgDel.",".$post['exp_type'][$i];
                        $chrg_remarks = ""; $chk_arr="";
                    }
                    else{
                        $delAll = true;
                    } break;
                case 4:
                    $chrg_type = $post['exp_type'][$i];
                    $arr = array_filter($post['gas_name']);
                    if(!empty($arr)){
                        for($j=0;$j<sizeof($post['gas_name']);$j++){
                            if(!empty($post['gas_name'][$j])){
                                $chrg_remarks[] = $post['gas_name'][$j]." - ".$post['gas_charge'][$j];
                            }
                        }
                        $chrg_remarks = implode(",", $chrg_remarks);
                        $tot_chrg = $post['gas_totchrg'];
                        unset($post['gas_name']);
                        unset($post['gas_charge']);
                        unset($post['gas_totchrg']);
                        $post['gas'] = array('fin_year'=>$finyear,'exp_date'=>$post['exp_date'],'exp_month'=>date('M',strtotime($post['exp_date'])),'chrg_type'=>$chrg_type,'chrg_remarks'=>$chrg_remarks,'tot_expense'=>$tot_chrg);
                        $chk_arr = array($post['exp_date'],$chrg_type,$finyear);
                        if($this->checkExists($chk_arr)){
                            $result = $this->dbRowUpdate('nhm_expense', $post['gas'],"`exp_date`='".$post['exp_date']."' AND `chrg_type`='".$chrg_type."'");
                        }else{
                            $result = $this->dbRowInsert('nhm_expense', $post['gas']);
                        }
                        $chrgDel = ($chrgDel == null)?$post['exp_type'][$i]:$chrgDel.",".$post['exp_type'][$i];
                        $chrg_remarks = ""; $chk_arr="";
                    }
                    else{
                        $delAll = true;
                    } break;
                case 5:
                    $chrg_type = $post['exp_type'][$i];
                    $arr = array_filter($post['ansth_name']);
                    if(!empty($arr)){
                        for($j=0;$j<sizeof($post['ansth_name']);$j++){
                            if(!empty($post['ansth_name'][$j])){
                                $chrg_remarks[] = $post['ansth_name'][$j]." - ".$post['ansth_charge'][$j];
                            }
                        }
                        $chrg_remarks = implode(",", $chrg_remarks);
                        $tot_chrg = $post['ansth_totchrg'];
                        unset($post['ansth_name']);
                        unset($post['ansth_charge']);
                        unset($post['ansth_totchrg']);
                        $post['ansth'] = array('fin_year'=>$finyear,'exp_date'=>$post['exp_date'],'exp_month'=>date('M',strtotime($post['exp_date'])),'chrg_type'=>$chrg_type,'chrg_remarks'=>$chrg_remarks,'tot_expense'=>$tot_chrg);
                        $chk_arr = array($post['exp_date'],$chrg_type,$finyear);
                        if($this->checkExists($chk_arr)){
                            $result = $this->dbRowUpdate('nhm_expense', $post['ansth'],"`exp_date`='".$post['exp_date']."' AND `chrg_type`='".$chrg_type."'");
                        }else{
                            $result = $this->dbRowInsert('nhm_expense', $post['ansth']);
                        }
                        $chrgDel = ($chrgDel == null)?$post['exp_type'][$i]:$chrgDel.",".$post['exp_type'][$i];
                        $chrg_remarks = ""; $chk_arr="";
                    }
                    else{
                        $delAll = true;
                    } break;
                case 6:
                    $chrg_type = $post['exp_type'][$i];
                    $arr = array_filter($post['emp_name']);
                    if(!empty($arr)){
                        for($j=0;$j<sizeof($post['emp_name']);$j++){
                            if(!empty($post['emp_name'][$j])){
                                $chrg_remarks[] = $post['emp_name'][$j]." - ".$post['emp_charge'][$j];
                                if($delEmp == null){
                                    $delEmp = '"SKNH - '.$post['emp_name'][$j].'"';
                                }else{
                                    $delEmp = $delEmp.',"SKNH - '.$post['emp_name'][$j].'"';
                                }
                                $delFlag = true;
                            }
                        }
                        $chrg_remarks = implode(",", $chrg_remarks);
                        $tot_chrg = $post['emp_totchrg'];
                        
                        unset($post['emp_name']);
                        unset($post['emp_charge']);
                        unset($post['emp_totchrg']);
                        $post['emp'] = array('fin_year'=>$finyear,'exp_date'=>$post['exp_date'],'exp_month'=>date('M',strtotime($post['exp_date'])),'chrg_type'=>$chrg_type,'chrg_remarks'=>$chrg_remarks,'tot_expense'=>$tot_chrg);
                        $chk_arr = array($post['exp_date'],$chrg_type,$finyear);
                        if($this->checkExists($chk_arr)){
                            $result = $this->dbRowUpdate('nhm_expense', $post['emp'],"`exp_date`='".$post['exp_date']."' AND `chrg_type`='".$chrg_type."'");
                        }else{
                            $result = $this->dbRowInsert('nhm_expense', $post['emp']);
                        }
                        $chrgDel = ($chrgDel == null)?$post['exp_type'][$i]:$chrgDel.",".$post['exp_type'][$i];
                        $chrg_remarks = ""; $chk_arr="";
                    }
                    else{
                        $delAll = true;
                    } break;
                case 7:
                    $chrg_type = $post['exp_type'][$i];
                    $arr = array_filter($post['elc_name']);
                    if(!empty($arr)){
                        for($j=0;$j<sizeof($post['elc_name']);$j++){
                            if(!empty($post['elc_name'][$j])){
                                $chrg_remarks[] = $post['elc_name'][$j]." - ".$post['elc_charge'][$j];
                            }
                        }
                        $chrg_remarks = implode(",", $chrg_remarks);
                        $tot_chrg = $post['elc_totchrg'];
                        unset($post['elc_name']);
                        unset($post['elc_charge']);
                        unset($post['elc_totchrg']);
                        $post['elc'] = array('fin_year'=>$finyear,'exp_date'=>$post['exp_date'],'exp_month'=>date('M',strtotime($post['exp_date'])),'chrg_type'=>$chrg_type,'chrg_remarks'=>$chrg_remarks,'tot_expense'=>$tot_chrg);
                        $chk_arr = array($post['exp_date'],$chrg_type,$finyear);
                        if($this->checkExists($chk_arr)){
                            $result = $this->dbRowUpdate('nhm_expense', $post['elc'],"`exp_date`='".$post['exp_date']."' AND `chrg_type`='".$chrg_type."'");
                        }else{
                            $result = $this->dbRowInsert('nhm_expense', $post['elc']);
                        }
                        $chrgDel = ($chrgDel == null)?$post['exp_type'][$i]:$chrgDel.",".$post['exp_type'][$i];
                        $chrg_remarks = ""; $chk_arr="";
                    }
                    else{
                        $delAll = true;
                    } break;
                case 8:
                    $chrg_type = $post['exp_type'][$i];
                    $arr = array_filter($post['pat_name']);
                    if(!empty($arr)){
                        for($j=0;$j<sizeof($post['pat_name']);$j++){
                            if(!empty($post['pat_name'][$j])){
                                $chrg_remarks[] = $post['pat_name'][$j]." - ".$post['pat_charge'][$j];
                            }
                        }
                        $chrg_remarks = implode(",", $chrg_remarks);
                        $tot_chrg = $post['pat_totchrg'];
                        unset($post['pat_name']);
                        unset($post['pat_charge']);
                        unset($post['pat_totchrg']);
                        $post['pat'] = array('fin_year'=>$finyear,'exp_date'=>$post['exp_date'],'exp_month'=>date('M',strtotime($post['exp_date'])),'chrg_type'=>$chrg_type,'chrg_remarks'=>$chrg_remarks,'tot_expense'=>$tot_chrg);
                        $chk_arr = array($post['exp_date'],$chrg_type,$finyear);
                        if($this->checkExists($chk_arr)){
                            $result = $this->dbRowUpdate('nhm_expense', $post['pat'],"`exp_date`='".$post['exp_date']."' AND `chrg_type`='".$chrg_type."'");
                        }else{
                            $result = $this->dbRowInsert('nhm_expense', $post['pat']);
                        }
                        $chrgDel = ($chrgDel == null)?$post['exp_type'][$i]:$chrgDel.",".$post['exp_type'][$i];
                        $chrg_remarks = ""; $chk_arr="";
                    }
                    else{
                        $delAll = true;
                    } break;
                case 9:
                    $chrg_type = $post['exp_type'][$i];
                    $arr = array_filter($post['bldg_name']);
                    if(!empty($arr)){
                        for($j=0;$j<sizeof($post['bldg_name']);$j++){
                            if(!empty($post['bldg_name'][$j])){
                                $chrg_remarks[] = $post['bldg_name'][$j]." - ".$post['bldg_charge'][$j];
                            }
                        }
                        $chrg_remarks = implode(",", $chrg_remarks);
                        $tot_chrg = $post['bldg_totchrg'];
                        unset($post['bldg_name']);
                        unset($post['bldg_charge']);
                        unset($post['bldg_totchrg']);
                        $post['bldg'] = array('fin_year'=>$finyear,'exp_date'=>$post['exp_date'],'exp_month'=>date('M',strtotime($post['exp_date'])),'chrg_type'=>$chrg_type,'chrg_remarks'=>$chrg_remarks,'tot_expense'=>$tot_chrg);
                        $chk_arr = array($post['exp_date'],$chrg_type,$finyear);
                        if($this->checkExists($chk_arr)){
                            $result = $this->dbRowUpdate('nhm_expense', $post['bldg'],"`exp_date`='".$post['exp_date']."' AND `chrg_type`='".$chrg_type."'");
                        }else{
                            $result = $this->dbRowInsert('nhm_expense', $post['bldg']);
                        }
                        $chrgDel = ($chrgDel == null)?$post['exp_type'][$i]:$chrgDel.",".$post['exp_type'][$i];
                        $chrg_remarks = ""; $chk_arr="";
                    }
                    else{
                        $delAll = true;
                    } break;
                case 10:
                    $chrg_type = $post['exp_type'][$i];
                    $arr = array_filter($post['ot_name']);
                    if(!empty($arr)){
                        for($j=0;$j<sizeof($post['ot_name']);$j++){
                            if(!empty($post['ot_name'][$j])){
                                $chrg_remarks[] = $post['ot_name'][$j]." - ".$post['ot_charge'][$j];
                            }
                        }
                        $chrg_remarks = implode(",", $chrg_remarks);
                        $tot_chrg = $post['ot_totchrg'];
                        unset($post['ot_name']);
                        unset($post['ot_charge']);
                        unset($post['ot_totchrg']);
                        $post['ot'] = array('fin_year'=>$finyear,'exp_date'=>$post['exp_date'],'exp_month'=>date('M',strtotime($post['exp_date'])),'chrg_type'=>$chrg_type,'chrg_remarks'=>$chrg_remarks,'tot_expense'=>$tot_chrg);
                        $chk_arr = array($post['exp_date'],$chrg_type,$finyear);
                        if($this->checkExists($chk_arr)){
                            $result = $this->dbRowUpdate('nhm_expense', $post['ot'],"`exp_date`='".$post['exp_date']."' AND `chrg_type`='".$chrg_type."'");
                        }else{
                            $result = $this->dbRowInsert('nhm_expense', $post['ot']);
                        }
                        $chrgDel = ($chrgDel == null)?$post['exp_type'][$i]:$chrgDel.",".$post['exp_type'][$i];
                        $chrg_remarks = ""; $chk_arr="";
                    }
                    else{
                        $delAll = true;
                    } break;
                case 11:
                    $chrg_type = $post['exp_type'][$i];
                    $arr = array_filter($post['ot_oth_name']);
                    if(!empty($arr)){
                        for($j=0;$j<sizeof($post['ot_oth_name']);$j++){
                            if(!empty($post['ot_oth_name'][$j])){
                                $chrg_remarks[] = $post['ot_oth_name'][$j]." - ".$post['ot_oth_charge'][$j];
                            }
                        }
                        $chrg_remarks = implode(",", $chrg_remarks);
                        $tot_chrg = $post['ot_oth_totchrg'];
                        unset($post['ot_oth_name']);
                        unset($post['ot_oth_charge']);
                        unset($post['ot_oth_totchrg']);
                        $post['ot_oth'] = array('fin_year'=>$finyear,'exp_date'=>$post['exp_date'],'exp_month'=>date('M',strtotime($post['exp_date'])),'chrg_type'=>$chrg_type,'chrg_remarks'=>$chrg_remarks,'tot_expense'=>$tot_chrg);
                        $chk_arr = array($post['exp_date'],$chrg_type,$finyear);
                        if($this->checkExists($chk_arr)){
                            $result = $this->dbRowUpdate('nhm_expense', $post['ot_oth'],"`exp_date`='".$post['exp_date']."' AND `chrg_type`='".$chrg_type."'");
                        }else{
                            $result = $this->dbRowInsert('nhm_expense', $post['ot_oth']);
                        }
                        $chrgDel = ($chrgDel == null)?$post['exp_type'][$i]:$chrgDel.",".$post['exp_type'][$i];
                        $chrg_remarks = ""; $chk_arr="";
                    }
                    else{
                        $delAll = true;
                    } break;
                case 12:
                    $chrg_type = $post['exp_type'][$i];
                    $arr = array_filter($post['med_name']);
                    if(!empty($arr)){
                        for($j=0;$j<sizeof($post['med_name']);$j++){
                            if(!empty($post['med_name'][$j])){
                                $chrg_remarks[] = $post['med_name'][$j]." - ".$post['med_charge'][$j];
                            }
                        }
                        $chrg_remarks = implode(",", $chrg_remarks);
                        $tot_chrg = $post['med_totchrg'];
                        unset($post['med_name']);
                        unset($post['med_charge']);
                        unset($post['med_totchrg']);
                        $post['med'] = array('fin_year'=>$finyear,'exp_date'=>$post['exp_date'],'exp_month'=>date('M',strtotime($post['exp_date'])),'chrg_type'=>$chrg_type,'chrg_remarks'=>$chrg_remarks,'tot_expense'=>$tot_chrg);
                        $chk_arr = array($post['exp_date'],$chrg_type,$finyear);
                        if($this->checkExists($chk_arr)){
                            $result = $this->dbRowUpdate('nhm_expense', $post['med'],"`exp_date`='".$post['exp_date']."' AND `chrg_type`='".$chrg_type."'");
                        }else{
                            $result = $this->dbRowInsert('nhm_expense', $post['med']);
                        }
                        $chrgDel = ($chrgDel == null)?$post['exp_type'][$i]:$chrgDel.",".$post['exp_type'][$i];
                        $chrg_remarks = ""; $chk_arr="";
                    }
                    else{
                        $delAll = true;
                    } break;
                case 13:
                    $chrg_type = $post['exp_type'][$i];
                    $arr = array_filter($post['oth_name']);
                    if(!empty($arr)){
                        for($j=0;$j<sizeof($post['oth_name']);$j++){
                            if(!empty($post['oth_name'][$j])){
                                $chrg_remarks[] = $post['oth_name'][$j]." - ".$post['oth_charge'][$j];
                            }
                        }
                        $chrg_remarks = implode(",", $chrg_remarks);
                        $tot_chrg = $post['oth_totchrg'];
                        unset($post['oth_name']);
                        unset($post['oth_charge']);
                        unset($post['oth_totchrg']);
                        $post['oth'] = array('fin_year'=>$finyear,'exp_date'=>$post['exp_date'],'exp_month'=>date('M',strtotime($post['exp_date'])),'chrg_type'=>$chrg_type,'chrg_remarks'=>$chrg_remarks,'tot_expense'=>$tot_chrg);
                        
                        $chk_arr = array($post['exp_date'],$chrg_type,$finyear);
                        if($this->checkExists($chk_arr)){
                            $result = $this->dbRowUpdate('nhm_expense', $post['oth'],"`exp_date`='".$post['exp_date']."' AND `chrg_type`='".$chrg_type."'");
                        }else{
                            $result = $this->dbRowInsert('nhm_expense', $post['oth']);
                        }
                        $chrgDel = ($chrgDel == null)?$post['exp_type'][$i]:$chrgDel.",".$post['exp_type'][$i];
                        $chrg_remarks = ""; $chk_arr="";
                    }
                    else{
                        $delAll = true;
                    } break;
            }
        }
        
        if($result){
             if($chrgDel){
                $rs = $this->dbRowDelete('nhm_expense','`chrg_type` NOT IN ('.$chrgDel.') AND exp_date = "'.$post['exp_date'].'"');
                $cherg_arr = explode(',', $chrgDel);
                if(!in_array(1, $cherg_arr)){
                    $rs = $this->dbRowDelete('nshm_adv','payment_date = "'.$post['exp_date'].'"');
                }
             }
        }else if($delAll){
            $result = $this->dbRowDelete('nhm_expense','exp_date = "'.$post['exp_date'].'"');
        }
        
        if($result){
            $req = "select count(*) AS count from emp_salary WHERE sal_date = '".$post['exp_date']."'";
            $res = $this->conn->query($req);
            $count = "";
            while ($row = $res->fetch_assoc()) {
                $count = $row['count'];
            }
            if($count > 0){
                if($delFlag){
                    $result = $this->dbRowDelete('emp_salary','`emp_id` NOT IN ('.$delEmp.') AND sal_date = "'.$post['exp_date'].'"');
                }else{
                    $rs = $this->dbRowDelete('emp_salary','sal_date = "'.$post['exp_date'].'"');
                }
            }
        }
        return $result;
    }
    
    function getExp($param){
        $chrg_type = array(1=>'doc_name',2=>'mrk_name',
                           3=>'cooking_name',4=>'gas_name',
                           5=>'ansth_name',6=>'emp_name',
                           7=>'elc_name',8=>'pat_name',
                           9=>'bldg_name',10=>'ot_name',
                           11=>'ot_oth_name',12=>'med_name',
                           13=>'oth_name');
        
        $chrg_exp = array(1=>'doc_charge',2=>'mrk_charge',
                           3=>'cooking_charge',4=>'gas_charge',
                           5=>'ansth_charge',6=>'emp_charge',
                           7=>'elc_charge',8=>'pat_charge',
                           9=>'bldg_charge',10=>'ot_charge',
                           11=>'ot_oth_charge',12=>'med_charge',
                           13=>'oth_charge');
        
        $chrg_tot = array(1=>'doc_totchrg',2=>'mrk_totchrg',
                           3=>'cooking_totchrg',4=>'gas_totchrg',
                           5=>'ansth_totchrg',6=>'emp_totchrg',
                           7=>'elc_totchrg',8=>'pat_totchrg',
                           9=>'bldg_totchrg',10=>'ot_totchrg',
                           11=>'ot_oth_totchrg',12=>'med_totchrg',
                           13=>'oth_totchrg');
        
        $req = "select `chrg_type`,`chrg_remarks`,`tot_expense` from `nhm_expense` where `exp_date`='".$param."'";
        $result = $this->conn->query($req);
        $arr_exp = "";
        while ($row = $result->fetch_assoc()) {
            //echo $row['chrg_type']." | ".$row['chrg_remarks']." | ".$row['tot_expense']."<br/>";
            $arr_exp['exp_type'][] = $row['chrg_type'];
            $chrgType = explode(",", $row['chrg_remarks']);
            for($i=0;$i<sizeof($chrgType);$i++){
                $arr = explode("-", $chrgType[$i]);
                $arr_exp[$chrg_type[$row['chrg_type']]][] = $arr[0];
                $arr_exp[$chrg_exp[$row['chrg_type']]][] = $arr[1];
            }
            $arr_exp[$chrg_tot[$row['chrg_type']]] = $row['tot_expense'];
        }
        //print_r($arr_exp);
        echo json_encode($arr_exp);
    }
            
    function checkExists($param) {
        $req = "select count(*) AS `count` from `nhm_expense` where `fin_year`='".$param[2]."' AND `exp_date`='".$param[0]."' AND `chrg_type`='".$param[1]."'";
        $result = $this->conn->query($req);
        $count = "";
        while ($row = $result->fetch_assoc()) {
            $count = $row['count'];
        }
        return $count;
    }
	
    function updateIncome(){

        $req = "SELECT DISTINCT `exp_date` FROM `nhm_expense` ORDER BY `exp_date`;";
        
        $query = $this->conn->query($req);
        $rowcount=mysqli_num_rows($query);
        
        if($rowcount == 0){
            $pdrq = "SELECT `payment_date` FROM `nshm_ptnraccount` ORDER BY `payment_date`";
            $pdquery = $this->conn->query($pdrq);
            $pdcount = mysqli_num_rows($pdquery);
            if($pdcount >= 1){
                while ($r = mysqli_fetch_assoc($pdquery)) {
                    $spResponse = $this->conn->query("Call sp_accountUpdate(0,0,'".$r['payment_date']."');");
                }
            }
        }

        if($rowcount>0){
            if($rowcount == 1){
                //echo "One Row";
                while ($row = mysqli_fetch_assoc($query)) {
                    $spResponse = $this->conn->query("Call sp_accountUpdate(0,0,'".$row['exp_date']."');");
                    $pdrq = "SELECT `payment_date` FROM `nshm_ptnraccount` WHERE `payment_date` NOT IN ('".$row['exp_date']."')";
                    $pdquery = $this->conn->query($pdrq);
                    $pdcount = mysqli_num_rows($pdquery);
                    if($pdcount >= 1){
                        while ($r = mysqli_fetch_assoc($pdquery)) {
                            $spResponse = $this->conn->query("Call sp_accountUpdate(0,0,'".$r['payment_date']."');");
                        }
                    }
                }
            }else{
                while ($row = mysqli_fetch_assoc($query)) {
                    $spResponse = $this->conn->query("Call sp_accountUpdate(0,0,'".$row['exp_date']."');");
                }
            }
        }
        return $spResponse;
    }
}
