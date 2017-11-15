<?php 
	$allow = array(1,2);
	if(!in_array($_SESSION['type'], $allow)){
		echo "<script>alert('You are not allowed to access this page.');</script>";
		echo "<script>window.location = '/index.php?pg=home'</script>";
	}
?>
<link href="css/jquery-ui.css" rel="stylesheet"/>
<style>
    .numeric{
        text-align: right;
    }
</style>
<div class="row" >
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" >Patient</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="row">
                        <?php
                        if (isset($_SESSION['success'])) {
                            if ($_SESSION['success']) {
                                ?>
                                <div class="alert bg-success" role="alert" >
                                    <span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo $_SESSION['msg']; ?>
                                    <a href="javascript:void(0)" class="close pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                                </div>
                            <?php } else { ?>
                                <div class="alert bg-danger" role="alert" >
                                    <span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo $_SESSION['msg']; ?> 
                                    <a href="javascript:void(0)" class="close pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <form class="form-horizontal" id="doct_form" action="action.php?action=pt_acc" method="post" onsubmit="return chkEmpty();">
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <label class="control-label">Account Date : </label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="acc_date" name="acc_date"/>
                            </div>
                            <div class="col-md-2 text-right">
                                <label class="control-label">Patient ID : </label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="reg_no" name="reg_no" required/>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="acc_id" name="acc_id" value=""/>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label class="control-label">OT Type : </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group col-xs-3">
                                    <select class="form-control" name="ot_type" id="ot_type">
                                        <option value="">Select Type</option>
                                        <option value="1">Major</option>
                                        <option value="2">Minor</option>
                                    </select>
                                </div>
                                <div class="form-group col-xs-4">
                                    <input type="text" class="form-control numeric chrg" id="ot_chrg" name="ot_chrg" onblur="addVal()"style="margin-left: 5px;"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label class="control-label">OT Other Type : </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group col-xs-3">
                                    <textarea class="form-control" rows="1" style="resize: none" id="ot_oth_type" name="ot_oth_type"></textarea>
                                </div>
                                <div class="form-group col-xs-4">
                                    <input type="text" class="form-control numeric chrg" id="ot_oth_chrg" name="ot_oth_chrg" onblur="addVal()"style="margin-left: 5px;"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label class="control-label">OT Medicine : </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group col-xs-3">
                                    <textarea class="form-control" rows="1" style="resize: none" id="ot_medicine" name="ot_medicine"></textarea>
                                </div>
                                <div class="form-group col-xs-4">
                                    <input type="text" class="form-control numeric chrg" id="ot_medicine_chrg" name="ot_medicine_chrg" onblur="addVal()"style="margin-left: 5px;"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label class="control-label">Word Medicine : </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group col-xs-3">
                                    <textarea class="form-control" rows="1" style="resize: none" id="word_medicine" name="word_medicine"></textarea>
                                </div>
                                <div class="form-group col-xs-4">
                                    <input type="text" class="form-control numeric chrg" id="word_medicine_chrg" name="word_medicine_chrg" onblur="addVal()"style="margin-left: 5px;"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label class="control-label">Child Medicine : </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group col-xs-3">
                                    <textarea class="form-control" rows="1" style="resize: none" id="child_medicine" name="child_medicine"></textarea>
                                </div>
                                <div class="form-group col-xs-4">
                                    <input type="text" class="form-control numeric chrg" id="child_medicine_chrg" name="child_medicine_chrg" onblur="addVal()"style="margin-left: 5px;"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label class="control-label">Other's Medicine : </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group col-xs-3">
                                    <textarea class="form-control" rows="1" style="resize: none" id="oth_medicine" name="oth_medicine"></textarea>
                                </div>
                                <div class="form-group col-xs-4">
                                    <input type="text" class="form-control numeric chrg" id="oth_medicine_chrg" name="oth_medicine_chrg" onblur="addVal()"style="margin-left: 5px;"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label class="control-label">Baby Other Charge : </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group col-xs-3">
                                    <textarea class="form-control" rows="1" style="resize: none" id="baby_other" name="baby_other"></textarea>
                                </div>
                                <div class="form-group col-xs-4">
                                    <input type="text" class="form-control numeric chrg" id="baby_other_chrg" name="baby_other_chrg" onblur="addVal()"style="margin-left: 5px;"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label class="control-label">Attending Doctor : </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group col-xs-3">
                                    <textarea class="form-control" rows="1" style="resize: none" id="atd_doc" name="atd_doc"></textarea>
                                </div>
                                <div class="form-group col-xs-4">
                                    <input type="text" class="form-control numeric chrg" id="atd_doc_chrg" name="atd_doc_chrg" onblur="addVal()"style="margin-left: 5px;"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label class="control-label">Attending Nurse : </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group col-xs-3">
                                    <textarea class="form-control" rows="1" style="resize: none" id="atd_nurse" name="atd_nurse"></textarea>
                                </div>
                                <div class="form-group col-xs-4">
                                    <input type="text" class="form-control numeric chrg" id="atd_nurse_chrg" name="atd_nurse_chrg" onblur="addVal()"style="margin-left: 5px;"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label class="control-label">Anesthesiologist : </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group col-xs-3">
                                    <textarea class="form-control" rows="1" style="resize: none" id="ansth" name="ansth"></textarea>
                                </div>
                                <div class="form-group col-xs-4">
                                    <input type="text" class="form-control numeric chrg" id="ansth_chrg" name="ansth_chrg" onblur="addVal()"style="margin-left: 5px;"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label class="control-label">Labour Room Charge : </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group col-xs-3">
                                    <textarea class="form-control" rows="1" style="resize: none" id="lb_room" name="lb_room"></textarea>
                                </div>
                                <div class="form-group col-xs-4">
                                    <input type="text" class="form-control numeric chrg" id="lb_room_chrg" name="lb_room_chrg" onblur="addVal()"style="margin-left: 5px;"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label class="control-label">Nursing Home Charge : </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group col-xs-3">
                                    <textarea class="form-control" rows="1" style="resize: none" id="nh_charge" name="nh_charge"></textarea>
                                </div>
                                <div class="form-group col-xs-4">
                                    <input type="text" class="form-control numeric chrg" id="nh_chrg" name="nh_chrg" onblur="addVal()"style="margin-left: 5px;"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <div class="form-group">
                                    <label class="control-label">Baby Doc Charge : </label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group col-xs-3">
                                    <textarea class="form-control" rows="1" style="resize: none" id="baby_doc" name="baby_doc"></textarea>
                                </div>
                                <div class="form-group col-xs-4">
                                    <input type="text" class="form-control numeric chrg" id="baby_doc_chrg" name="baby_doc_chrg" onblur="addVal()"style="margin-left: 5px;"/>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-xs-5">
                                <strong><span id="amount_inword"></span></strong>
                            </div>
                            <div class="col-xs-3 text-right">
                                <label class="control-label">Total Charge : </label>
                            </div>
                            <div class="col-xs-4 text-right">
                                <input type="text" name="total_chrg" id="total_chrg" value="" class="form-control numeric" readonly/>
                            </div>
                        </div>
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-md-6 text-right">
                                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                            </div>
                            <div class="col-md-6">
                                <button type="reset" id="reset" class="btn btn-default">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col-->
    </div></div>

<script src="js/jquery-ui.js"></script>
<script>
                                        $('#acc_date').datepicker({
                                            changeMonth: true,
                                            changeYear: true,
                                            dateFormat: 'dd-mm-yy',
                                        }).datepicker("setDate", new Date());

                                        $(document).ready(function () {
                                            $(".bg-success,.bg-danger").delay(5000).fadeOut();
                                            $.ajax({url: "action.php?action=del_session", success: function (result) {
                                                }});
                                        });
                                        $(function (event) {
                                            $("#reg_no").autocomplete(
                                                    {
                                                        source: 'action.php?action=reg_no',
                                                    });
                                        });
</script>
<script>

    //When DOM loaded we attach click event to button
    $(document).ready(function () {

        //attach keypress to input
        $('.numeric').keydown(function (event) {
            // Allow special chars + arrows 
            if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9
                    || event.keyCode == 27 || event.keyCode == 13
                    || (event.keyCode == 65 && event.ctrlKey === true)
                    || (event.keyCode >= 35 && event.keyCode <= 39)) {
                return;
            } else {
                // If it's not a number stop the keypress
                if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                    event.preventDefault();
                }
            }
        });

    });

</script>
<script>
    function addVal() {
        var tot = 0;
        $(".chrg").each(function () {
            tot = tot + Number($(this).val());
        });
        $('#total_chrg').val(tot);
        $.ajax({url: "action.php?action=amnt_toword",type: "POST",data: {amount: tot}, success: function (result) {
                $('#amount_inword').html("Amounts In Word : "+result+" Only");
        }});
    }
    function chkEmpty(){
        if($('#total_chrg').val() > 0){
            return true;
        }else{
            alert("Please Enter Any One Type of Charge.");
        }
        return false;
    }
    $('#reg_no').on('change',function (e){
        $.getJSON("action.php?action=get_acc", {id: $('#reg_no').val(),date: $('#acc_date').val()}, function (data) {
            $.each(data,function (key,value){
                if(key === 'ot_type'){
                    console.log(key+" => "+value);
                    $('#'+key).val(value).attr('selected',true);
                }else{
                    $('#'+key).val(value);
                }
            });
            addVal();
        });
    });
</script>
