<?php 
	$allow = array(1,2);
	if(!in_array($_SESSION['type'], $allow)){
		echo "<script>alert('You are not allowed to access this page.');</script>";
		echo "<script>window.location = '/index.php?pg=home'</script>";
	}
?>
<link href="css/jquery-ui.css" rel="stylesheet"/>
<div class="row" >
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" >Daily Expenses</div>
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
                    <form class="form-horizontal" id="doct_form" action="action.php?action=daily_exp" method="post">
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <label for="doc_reg" class="col-xs-4 control-label">Expense Date : </label>
                                    <div class="col-xs-3">
                                        <input type="text" class="form-control charge" id="exp_date" name="exp_date"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Expense Type</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Expense Details</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Expense Cost</label>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label">1. Dr. Expense</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="exp_type[]" value="1" >
                                        <table class="doc_list" style="width: 100%">
                                            <tr id="docHead">
                                                <td>Dr. Name</td>
                                                <td>Expense</td>
                                            </tr>

                                            <tr id="docEntry">
                                                <td>
                                                    <!--<input type="text" name="doc_name[]" style="margin-bottom: 5px;" class="form-control"/>-->
                                                    <select style="margin-bottom: 5px;" class="atd_doctor form-control" name="doc_name[]">
                                                        <option value="">Select Doctor</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="doc_chrg[]" class="charge form-control" style="margin-bottom: 5px; margin-left: 5px;"/>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                        <div class="row text-left">
                                            <a href="#" title="" class="add-doc">Add More</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">&nbsp;</div>
                                <div class="form-group">
                                    <input type="text" name="doc_totchrg" id="doc_totchrg" class="charge form-control" readonly="readonly"/>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" name="exp_type[]" value="2" >
                                    <div class="col-md-12">
                                        <label class="control-label">2. Marketing Expense</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="mrk_list" style="width: 100%">
                                            <tr id="mrkHead">
                                                <td>Items</td>
                                                <td>Expense</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="mrk_name[]" style="margin-bottom: 5px;" class="form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="mrk_charge[]" class="charge form-control" style="margin-bottom: 5px; margin-left: 5px;"/>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                        <div class="row text-left">
                                            <a href="#" title="" class="add-mrk">Add More</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">&nbsp;</div>
                                <div class="form-group">
                                    <input type="text" name="mrk_totchrg" id="mrk_totchrg" class="charge form-control" readonly="readonly"/>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" name="exp_type[]" value="3" >
                                    <div class="col-md-12">
                                        <label class="control-label">3. Cooking Expense</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="cooking_list" style="width: 100%">
                                            <tr id="cookingHead">
                                                <td>Expense Type</td>
                                                <td>Expense</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="cooking_name[]" style="margin-bottom: 5px;" class="form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="cooking_charge[]" class="charge form-control" style="margin-bottom: 5px; margin-left: 5px;"/>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                        <div class="row text-left">
                                            <a href="#" title="" class="add-cook">Add More</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">&nbsp;</div>
                                <div class="form-group">
                                    <input type="text" name="cooking_totchrg" id="cooking_totchrg" class="charge form-control" readonly="readonly"/>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" name="exp_type[]" value="4" >
                                    <div class="col-md-12">
                                        <label class="control-label">4. Gas</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="gas_list" style="width: 100%">
                                            <tr id="gasHead">
                                                <td>Expense Type</td>
                                                <td>Expense</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="gas_name[]" style="margin-bottom: 5px;" class="form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="gas_charge[]" class="charge form-control" style="margin-bottom: 5px; margin-left: 5px;"/>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                        <div class="row text-left">
                                            <a href="#" title="" class="add-gas">Add More</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">&nbsp;</div>
                                <div class="form-group">
                                    <input type="text" name="gas_totchrg" id="gas_totchrg" class="charge form-control" readonly="readonly"/>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" name="exp_type[]" value="5" >
                                    <div class="col-md-12">
                                        <label class="control-label">5. Anaesthetist Expense </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="ansth_list" style="width: 100%">
                                            <tr id="ansthHead">
                                                <td>Anaesthetist Name</td>
                                                <td>Expense</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="ansth_name[]" style="margin-bottom: 5px;" class="form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="ansth_charge[]" class="charge form-control" style="margin-bottom: 5px; margin-left: 5px;"/>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                        <div class="row text-left">
                                            <a href="#" title="" class="add-ansth">Add More</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">&nbsp;</div>
                                <div class="form-group">
                                    <input type="text" name="ansth_totchrg" id="ansth_totchrg" class="charge form-control" readonly="readonly"/>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" name="exp_type[]" value="6" >
                                    <div class="col-md-12">
                                        <label class="control-label">6. Employee Expense </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="emp_list" style="width: 100%">
                                            <tr id="empHead">
                                                <td>Employee ID</td>
                                                <td>Expense</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="emp_name[]" style="margin-bottom: 5px;" class="form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="emp_charge[]" class="charge form-control" style="margin-bottom: 5px; margin-left: 5px;"/>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                        <div class="row text-left">
                                            <a href="#" title="" class="add-emp">Add More</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">&nbsp;</div>
                                <div class="form-group">
                                    <input type="text" name="emp_totchrg" id="emp_totchrg" class="charge form-control" readonly="readonly"/>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" name="exp_type[]" value="7" >
                                    <div class="col-md-12">
                                        <label class="control-label">7. Electric Expense </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="elc_list" style="width: 100%">
                                            <tr id="elcHead">
                                                <td>Electric</td>
                                                <td>Expense</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="elc_name[]" style="margin-bottom: 5px;" class="form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="elc_charge[]" class="charge form-control" style="margin-bottom: 5px; margin-left: 5px;"/>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                        <div class="row text-left">
                                            <a href="#" title="" class="add-elc">Add More</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">&nbsp;</div>
                                <div class="form-group">
                                    <input type="text" name="elc_totchrg" id="elc_totchrg" class="charge form-control" readonly="readonly"/>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" name="exp_type[]" value="8" >
                                    <div class="col-md-12">
                                        <label class="control-label">8. Patient Expense </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="pat_list" style="width: 100%">
                                            <tr id="patHead">
                                                <td>Patient</td>
                                                <td>Expense</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="pat_name[]" style="margin-bottom: 5px;" class="form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="pat_charge[]" class="charge form-control" style="margin-bottom: 5px; margin-left: 5px;"/>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                        <div class="row text-left">
                                            <a href="#" title="" class="add-pat">Add More</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">&nbsp;</div>
                                <div class="form-group">
                                    <input type="text" name="pat_totchrg" id="pat_totchrg" class="charge form-control" readonly="readonly"/>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" name="exp_type[]" value="9" >
                                    <div class="col-md-12">
                                        <label class="control-label">9. Building Maintenance </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="bldg_list" style="width: 100%">
                                            <tr id="bldgHead">
                                                <td>Maintenence</td>
                                                <td>Expense</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="bldg_name[]" style="margin-bottom: 5px;" class="form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="bldg_charge[]" class="charge form-control" style="margin-bottom: 5px; margin-left: 5px;"/>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                        <div class="row text-left">
                                            <a href="#" title="" class="add-bldg">Add More</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">&nbsp;</div>
                                <div class="form-group">
                                    <input type="text" name="bldg_totchrg" id="bldg_totchrg" class="charge form-control" readonly="readonly"/>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" name="exp_type[]" value="10" >
                                    <div class="col-md-12">
                                        <label class="control-label">10. OT Maintenance </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="ot_list" style="width: 100%">
                                            <tr id="otHead">
                                                <td>Maintenence</td>
                                                <td>Expense</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="ot_name[]" style="margin-bottom: 5px;" class="form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="ot_charge[]" class="charge form-control" style="margin-bottom: 5px; margin-left: 5px;"/>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                        <div class="row text-left">
                                            <a href="#" title="" class="add-ot">Add More</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">&nbsp;</div>
                                <div class="form-group">
                                    <input type="text" name="ot_totchrg" id="ot_totchrg" class="charge form-control" readonly="readonly"/>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" name="exp_type[]" value="11" >
                                    <div class="col-md-12">
                                        <label class="control-label">11. OT Other Expenses </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="ot_oth_list" style="width: 100%">
                                            <tr id="ot_othHead">
                                                <td>OT Others</td>
                                                <td>Expense</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="ot_oth_name[]" style="margin-bottom: 5px;" class="form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="ot_oth_charge[]" class="charge form-control" style="margin-bottom: 5px; margin-left: 5px;"/>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                        <div class="row text-left">
                                            <a href="#" title="" class="add-ot-oth">Add More</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">&nbsp;</div>
                                <div class="form-group">
                                    <input type="text" name="ot_oth_totchrg" id="ot_oth_totchrg" class="charge form-control" readonly="readonly"/>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" name="exp_type[]" value="12" >
                                    <div class="col-md-12">
                                        <label class="control-label">12. Medicine Expenses </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="med_list" style="width: 100%">
                                            <tr id="medHead">
                                                <td>Medicine</td>
                                                <td>Expense</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="med_name[]" style="margin-bottom: 5px;" class="form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="med_charge[]" class="charge form-control" style="margin-bottom: 5px; margin-left: 5px;"/>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                        <div class="row text-left">
                                            <a href="#" title="" class="add-med">Add More</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">&nbsp;</div>
                                <div class="form-group">
                                    <input type="text" name="med_totchrg" id="med_totchrg" class="charge form-control" readonly="readonly"/>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" name="exp_type[]" value="13" >
                                    <div class="col-md-12">
                                        <label class="control-label">13. Other Expenses </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="oth_list" style="width: 100%">
                                            <tr id="othHead">
                                                <td>Other's</td>
                                                <td>Expense</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="oth_name[]" style="margin-bottom: 5px;" class="form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" name="oth_charge[]" class="charge form-control" style="margin-bottom: 5px; margin-left: 5px;"/>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                        <div class="row text-left">
                                            <a href="#" title="" class="add-oth">Add More</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">&nbsp;</div>
                                <div class="form-group">
                                    <input type="text" name="oth_totchrg" id="oth_totchrg" class="charge form-control" readonly="readonly"/>
                                </div>
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
    $('#exp_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
    }).datepicker("setDate", new Date());

    $(document).ready(function () {
        $(".bg-success,.bg-danger").delay(5000).fadeOut();
        $.ajax({url: "action.php?action=del_session", success: function (result) {
            }});
    });
</script>
<script>

    //When DOM loaded we attach click event to button
    $(document).ready(function () {

        
        //getEmpExp();
        //attach keypress to input
        $('.charge').keydown(function (event) {
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
    function getEmpExp(){
        $.getJSON("action.php?action=emp_exp&exp_date=" + $('#exp_date').val(), function (data) {
            var tot = 0;
            if (data.length != 0) {
                for (var i = 0, len = data.length; i < len; i++) {
                    newRow +=
                            '<tr class="empOld">' +
                            '<td><input type="text" value="' + $.trim(data[i].emp_id.substr(7)) + '" name="emp_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                            '<td><input type="text" value="' + $.trim(data[i].net_amount) + '" name="emp_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                            '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>' +
                            '</tr>';
                    tot = tot + Number(data[i].net_amount);
                }
                $(newRow).insertAfter("#empHead");
                $('#emp_totchrg').val(tot);
                newRow = "";
            }
        });
    }
</script>
<script type="text/javascript">
    function addDoc(){
        $.getJSON("action.php?action=get_doctall", function (data) {
            $('.atd_doctor').empty();
            $('.atd_doctor').append(
                    $('<option></option>').val("").html("Select Doctor Name"));
            $.each(data, function (index) {
                $('.atd_doctor').append(
                    $('<option></option>').val(data[index].id).html("Dr. "+data[index].doc_name));
            });
        });
    }
    function addDocVal(id){
        $.getJSON("action.php?action=get_doctall", function (data) {
            $('.atd_doctor'+id).empty();
            $('.atd_doctor'+id).append(
                    $('<option></option>').val("").html("Select Doctor Name"));
            $.each(data, function (index) {
                $('.atd_doctor'+id).append(
                        $('<option></option>').val(data[index].id).html("Dr. "+data[index].doc_name));
            });
        });
    }
    function addDocSelect(id,value){
        $.getJSON("action.php?action=get_doctall", function (data) {
            $('.atd_doctor'+id).empty();
            $('.atd_doctor'+id).append(
                    $('<option></option>').val("").html("Select Doctor Name"));
            $.each(data, function (index) {
                $('.atd_doctor'+id).append(
                        $('<option></option>').val(data[index].id).html("Dr. "+data[index].doc_name));
            });
            $('.atd_doctor'+id).val(value);
        });
    }
    addDoc();
    
</script>
<script>
var counter = 1;
$(function () {

        var $table = $('table.doc_list');

        $('a.add-doc').click(function (event) {
            event.preventDefault();
            
            var newRow =
                    '<tr>' +
                    '<td><select style="margin-bottom: 5px;" class="atd_doctor'+counter+' form-control" name="doc_name[]"><option value="">Select Doctor</option></select></td>' +
                    '<td><input type="text" name="doc_chrg[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                    '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>'
            '</tr>';
            $table.append(newRow);
            addDocVal(counter);
            counter++;
        });

        $table.on('click', '.remove', function () {
            $(this).closest('tr').find("input.charge").each(function () {
                $('#doc_totchrg').val(Number($('#doc_totchrg').val()) - Number(this.value));
            });
            $(this).closest('tr').remove();
        });
        var tot = 0;
        $table.on('change', '.charge', function () {
            $table.find('input.charge').each(function (index) {
                //console.log(this.value);
                tot = tot + Number(this.value);
            });
            $('#doc_totchrg').val(tot);
            tot = 0;
        });

    });</script>

<script>$(function () {

        var $table = $('table.mrk_list'),
                counter = 1;

        $('a.add-mrk').click(function (event) {
            event.preventDefault();
            counter++;
            var newRow =
                    '<tr>' +
                    '<td><input type="text" name="mrk_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                    '<td><input type="text" name="mrk_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                    '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>'
            '</tr>';
            $table.append(newRow);
        });

        $table.on('click', '.remove', function () {
            $(this).closest('tr').find("input.charge").each(function () {
                $('#mrk_totchrg').val(Number($('#mrk_totchrg').val()) - Number(this.value));
            });
            $(this).closest('tr').remove();
        });
        var tot = 0;
        $table.on('change', '.charge', function () {
            $table.find('input.charge').each(function (index) {
                //console.log(this.value);
                tot = tot + Number(this.value);
            });
            $('#mrk_totchrg').val(tot);
            tot = 0;
        });

    });</script>

<script>$(function () {

        var $table = $('table.cooking_list'),
                counter = 1;

        $('a.add-cook').click(function (event) {
            event.preventDefault();
            counter++;
            var newRow =
                    '<tr>' +
                    '<td><input type="text" name="cooking_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                    '<td><input type="text" name="cooking_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                    '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>'
            '</tr>';
            $table.append(newRow);
        });

        $table.on('click', '.remove', function () {
            $(this).closest('tr').find("input.charge").each(function () {
                $('#cooking_totchrg').val(Number($('#cooking_totchrg').val()) - Number(this.value));
            });
            $(this).closest('tr').remove();
        });
        var tot = 0;
        $table.on('change', '.charge', function () {
            $table.find('input.charge').each(function (index) {
                //console.log(this.value);
                tot = tot + Number(this.value);
            });
            $('#cooking_totchrg').val(tot);
            tot = 0;
        });

    });</script>

<script>$(function () {

        var $table = $('table.gas_list'),
                counter = 1;

        $('a.add-gas').click(function (event) {
            event.preventDefault();
            counter++;
            var newRow =
                    '<tr>' +
                    '<td><input type="text" name="gas_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                    '<td><input type="text" name="gas_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                    '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>'
            '</tr>';
            $table.append(newRow);
        });

        $table.on('click', '.remove', function () {
            $(this).closest('tr').find("input.charge").each(function () {
                $('#gas_totchrg').val(Number($('#gas_totchrg').val()) - Number(this.value));
            });
            $(this).closest('tr').remove();
        });
        var tot = 0;
        $table.on('change', '.charge', function () {
            $table.find('input.charge').each(function (index) {
                //console.log(this.value);
                tot = tot + Number(this.value);
            });
            $('#gas_totchrg').val(tot);
            tot = 0;
        });

    });</script>

<script>$(function () {

        var $table = $('table.ansth_list'),
                counter = 1;

        $('a.add-ansth').click(function (event) {
            event.preventDefault();
            counter++;
            var newRow =
                    '<tr>' +
                    '<td><input type="text" name="ansth_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                    '<td><input type="text" name="ansth_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                    '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>'
            '</tr>';
            $table.append(newRow);
        });

        $table.on('click', '.remove', function () {
            $(this).closest('tr').find("input.charge").each(function () {
                $('#ansth_totchrg').val(Number($('#ansth_totchrg').val()) - Number(this.value));
            });
            $(this).closest('tr').remove();
        });
        var tot = 0;
        $table.on('change', '.charge', function () {
            $table.find('input.charge').each(function (index) {
                //console.log(this.value);
                tot = tot + Number(this.value);
            });
            $('#ansth_totchrg').val(tot);
            tot = 0;
        });

    });</script>

<script>$(function () {

        var $table = $('table.emp_list'),
                counter = 1;

        $('a.add-emp').click(function (event) {
            event.preventDefault();
            counter++;
            var newRow =
                    '<tr>' +
                    '<td><input type="text" name="emp_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                    '<td><input type="text" name="emp_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                    '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>'
            '</tr>';
            $table.append(newRow);
        });

        $table.on('click', '.remove', function () {
            $(this).closest('tr').find("input.charge").each(function () {
                $('#emp_totchrg').val(Number($('#emp_totchrg').val()) - Number(this.value));
            });
            $(this).closest('tr').remove();
        });
        var tot = 0;
        $table.on('change', '.charge', function () {
            $table.find('input.charge').each(function (index) {
                //console.log(this.value);
                tot = tot + Number(this.value);
            });
            $('#emp_totchrg').val(tot);
            tot = 0;
        });

    });</script>

<script>$(function () {

        var $table = $('table.elc_list'),
                counter = 1;

        $('a.add-elc').click(function (event) {
            event.preventDefault();
            counter++;
            var newRow =
                    '<tr>' +
                    '<td><input type="text" name="elc_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                    '<td><input type="text" name="elc_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                    '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>'
            '</tr>';
            $table.append(newRow);
        });

        $table.on('click', '.remove', function () {
            $(this).closest('tr').find("input.charge").each(function () {
                $('#elc_totchrg').val(Number($('#elc_totchrg').val()) - Number(this.value));
            });
            $(this).closest('tr').remove();
        });
        var tot = 0;
        $table.on('change', '.charge', function () {
            $table.find('input.charge').each(function (index) {
                //console.log(this.value);
                tot = tot + Number(this.value);
            });
            $('#elc_totchrg').val(tot);
            tot = 0;
        });

    });</script>

<script>$(function () {

        var $table = $('table.pat_list'),
                counter = 1;

        $('a.add-pat').click(function (event) {
            event.preventDefault();
            counter++;
            var newRow =
                    '<tr>' +
                    '<td><input type="text" name="pat_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                    '<td><input type="text" name="pat_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                    '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>'
            '</tr>';
            $table.append(newRow);
        });

        $table.on('click', '.remove', function () {
            $(this).closest('tr').find("input.charge").each(function () {
                $('#pat_totchrg').val(Number($('#pat_totchrg').val()) - Number(this.value));
            });
            $(this).closest('tr').remove();
        });
        var tot = 0;
        $table.on('change', '.charge', function () {
            $table.find('input.charge').each(function (index) {
                //console.log(this.value);
                tot = tot + Number(this.value);
            });
            $('#pat_totchrg').val(tot);
            tot = 0;
        });

    });</script>

<script>$(function () {

        var $table = $('table.bldg_list'),
                counter = 1;

        $('a.add-bldg').click(function (event) {
            event.preventDefault();
            counter++;
            var newRow =
                    '<tr>' +
                    '<td><input type="text" name="bldg_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                    '<td><input type="text" name="bldg_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                    '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>'
            '</tr>';
            $table.append(newRow);
        });

        $table.on('click', '.remove', function () {
            $(this).closest('tr').find("input.charge").each(function () {
                $('#bldg_totchrg').val(Number($('#bldg_totchrg').val()) - Number(this.value));
            });
            $(this).closest('tr').remove();
        });
        var tot = 0;
        $table.on('change', '.charge', function () {
            $table.find('input.charge').each(function (index) {
                //console.log(this.value);
                tot = tot + Number(this.value);
            });
            $('#bldg_totchrg').val(tot);
            tot = 0;
        });

    });</script>

<script>$(function () {

        var $table = $('table.ot_list'),
                counter = 1;

        $('a.add-ot').click(function (event) {
            event.preventDefault();
            counter++;
            var newRow =
                    '<tr>' +
                    '<td><input type="text" name="ot_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                    '<td><input type="text" name="ot_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                    '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>'
            '</tr>';
            $table.append(newRow);
        });

        $table.on('click', '.remove', function () {
            $(this).closest('tr').find("input.charge").each(function () {
                $('#ot_totchrg').val(Number($('#ot_totchrg').val()) - Number(this.value));
            });
            $(this).closest('tr').remove();
        });
        var tot = 0;
        $table.on('change', '.charge', function () {
            $table.find('input.charge').each(function (index) {
                //console.log(this.value);
                tot = tot + Number(this.value);
            });
            $('#ot_totchrg').val(tot);
            tot = 0;
        });

    });</script>

<script>$(function () {

        var $table = $('table.ot_oth_list'),
                counter = 1;

        $('a.add-ot-oth').click(function (event) {
            event.preventDefault();
            counter++;
            var newRow =
                    '<tr>' +
                    '<td><input type="text" name="ot_oth_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                    '<td><input type="text" name="ot_oth_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                    '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>'
            '</tr>';
            $table.append(newRow);
        });

        $table.on('click', '.remove', function () {
            $(this).closest('tr').find("input.charge").each(function () {
                $('#ot_oth_totchrg').val(Number($('#ot_oth_totchrg').val()) - Number(this.value));
            });
            $(this).closest('tr').remove();
        });
        var tot = 0;
        $table.on('change', '.charge', function () {
            $table.find('input.charge').each(function (index) {
                //console.log(this.value);
                tot = tot + Number(this.value);
            });
            $('#ot_oth_totchrg').val(tot);
            tot = 0;
        });

    });</script>

<script>$(function () {

        var $table = $('table.med_list'),
                counter = 1;

        $('a.add-med').click(function (event) {
            event.preventDefault();
            counter++;
            var newRow =
                    '<tr>' +
                    '<td><input type="text" name="med_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                    '<td><input type="text" name="med_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                    '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>'
            '</tr>';
            $table.append(newRow);
        });

        $table.on('click', '.remove', function () {
            $(this).closest('tr').find("input.charge").each(function () {
                $('#med_totchrg').val(Number($('#med_totchrg').val()) - Number(this.value));
            });
            $(this).closest('tr').remove();
        });
        var tot = 0;
        $table.on('change', '.charge', function () {
            $table.find('input.charge').each(function (index) {
                //console.log(this.value);
                tot = tot + Number(this.value);
            });
            $('#med_totchrg').val(tot);
            tot = 0;
        });

    });</script>

<script>$(function () {

        var $table = $('table.oth_list'),
                counter = 1;

        $('a.add-oth').click(function (event) {
            event.preventDefault();
            counter++;
            var newRow =
                    '<tr>' +
                    '<td><input type="text" name="oth_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                    '<td><input type="text" name="oth_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                    '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>'
            '</tr>';
            $table.append(newRow);
        });

        $table.on('click', '.remove', function () {
            $(this).closest('tr').find("input.charge").each(function () {
                $('#oth_totchrg').val(Number($('#oth_totchrg').val()) - Number(this.value));
            });
            $(this).closest('tr').remove();
        });
        var tot = 0;
        $table.on('change', '.charge', function () {
            $table.find('input.charge').each(function (index) {
                //console.log(this.value);
                tot = tot + Number(this.value);
            });
            $('#oth_totchrg').val(tot);
            tot = 0;
        });

    });</script>

<script>
    var newRow = "";
    $('#exp_date').change(function () {
        $("[class*='Old']").each(function (i, el) {
            $(this).remove();
        });
        $("input[id*='_totchrg']").each(function (i, el) {
            $(this).val(""); 
        });
        $.getJSON("action.php?action=get_exp&date=" + $('#exp_date').val(), function (data) {
            
            if (data.length == 0) {
                //$('#exp_date').removeAttr('readonly');
                $('.docOld').each(function () {
                    $(this).remove();
                });
                $('.mrkOld').each(function () {
                    $(this).remove();
                });
                $('.cookingOld').each(function () {
                    $(this).remove();
                });
                $('.gasOld').each(function () {
                    $(this).remove();
                });
                $('.ansthOld').each(function () {
                    $(this).remove();
                });
                $('.empOld').each(function () {
                    $(this).remove();
                });
                $('.elcOld').each(function () {
                    $(this).remove();
                });
                $('.patOld').each(function () {
                    $(this).remove();
                });
                $('.bldgOld').each(function () {
                    $(this).remove();
                });
                $('.otOld').each(function () {
                    $(this).remove();
                });
                $('.ot_oth_Old').each(function () {
                    $(this).remove();
                });
                $('.medOld').each(function () {
                    $(this).remove();
                });
                $('.othOld').each(function () {
                    $(this).remove();
                });

                $('#doc_totchrg').val("");
                $('#mrk_totchrg').val("");
                $('#cooking_totchrg').val("");
                $('#gas_totchrg').val("");
                $('#ansth_totchrg').val("");
                $('#emp_totchrg').val("");
                $('#elc_totchrg').val("");
                $('#pat_totchrg').val("");
                $('#bldg_totchrg').val("");
                $('#ot_totchrg').val("");
                $('#ot_oth_totchrg').val("");
                $('#med_totchrg').val("");
                $('#oth_totchrg').val("");
                //getEmpExp();
            } else {
                //$('#exp_date').attr('readonly', true);
                //getEmpExp();
                $.each(data['exp_type'], function (key, value) {
                    switch (value) {
                        case '1':
                            for (var i = 0, len = data['doc_name'].length; i < len; i++) {
                                newRow +=
                                        '<tr class="docOld">' +
                                        '<td><select style="margin-bottom: 5px;" class="atd_doctor' + counter +' form-control" name="doc_name[]"><option value="">Select Doctor</option></select></td>' +
                                        '<td><input type="text" value="' + $.trim(data['doc_charge'][i]) + '" name="doc_chrg[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                                        '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>' +
                                        '</tr>';
                                addDocSelect(counter,$.trim(data['doc_name'][i]));
                                counter++;
                            }
                            $(newRow).insertAfter("#docHead");
                            $('#doc_totchrg').val(data['doc_totchrg']);
                            newRow = "";
                            break;
                        case '2':
                            for (var i = 0, len = data['mrk_name'].length; i < len; i++) {
                                newRow +=
                                        '<tr class="mrkOld">' +
                                        '<td><input type="text" value="' + $.trim(data['mrk_name'][i]) + '" name="mrk_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                                        '<td><input type="text" value="' + $.trim(data['mrk_charge'][i]) + '" name="mrk_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                                        '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>' +
                                        '</tr>';
                            }
                            $(newRow).insertAfter("#mrkHead");
                            $('#mrk_totchrg').val(data['mrk_totchrg']);
                            newRow = "";
                            break;
                        case '3':
                            for (var i = 0, len = data['cooking_name'].length; i < len; i++) {
                                newRow +=
                                        '<tr class="cookingOld">' +
                                        '<td><input type="text" value="' + $.trim(data['cooking_name'][i]) + '" name="cooking_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                                        '<td><input type="text" value="' + $.trim(data['cooking_charge'][i]) + '" name="cooking_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                                        '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>' +
                                        '</tr>';
                            }
                            $(newRow).insertAfter("#cookingHead");
                            $('#cooking_totchrg').val(data['cooking_totchrg']);
                            newRow = "";
                            break;
                        case '4':
                            for (var i = 0, len = data['gas_name'].length; i < len; i++) {
                                newRow +=
                                        '<tr class="gasOld">' +
                                        '<td><input type="text" value="' + $.trim(data['gas_name'][i]) + '" name="gas_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                                        '<td><input type="text" value="' + $.trim(data['gas_charge'][i]) + '" name="gas_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                                        '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>' +
                                        '</tr>';
                            }
                            $(newRow).insertAfter("#gasHead");
                            $('#gas_totchrg').val(data['gas_totchrg']);
                            newRow = "";
                            break;
                        case '5':
                            for (var i = 0, len = data['ansth_name'].length; i < len; i++) {
                                newRow +=
                                        '<tr class="ansthOld">' +
                                        '<td><input type="text" value="' + $.trim(data['ansth_name'][i]) + '" name="ansth_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                                        '<td><input type="text" value="' + $.trim(data['ansth_charge'][i]) + '" name="ansth_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                                        '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>' +
                                        '</tr>';
                            }
                            $(newRow).insertAfter("#ansthHead");
                            $('#ansth_totchrg').val(data['ansth_totchrg']);
                            newRow = "";
                            break;
                        case '6':
                            
                            for (var i = 0, len = data['emp_name'].length; i < len; i++) {
                                newRow +=
                                        '<tr class="empOld">' +
                                        '<td><input type="text" value="' + $.trim(data['emp_name'][i]) + '" name="emp_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                                        '<td><input type="text" value="' + $.trim(data['emp_charge'][i]) + '" name="emp_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                                        '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>' +
                                        '</tr>';
                            }
                            $(newRow).insertAfter("#empHead");
                            $('#emp_totchrg').val(data['emp_totchrg']);
                            newRow = "";
                            break;
                        case '7':
                            for (var i = 0, len = data['elc_name'].length; i < len; i++) {
                                newRow +=
                                        '<tr class="elcOld">' +
                                        '<td><input type="text" value="' + $.trim(data['elc_name'][i]) + '" name="elc_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                                        '<td><input type="text" value="' + $.trim(data['elc_charge'][i]) + '" name="elc_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                                        '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>' +
                                        '</tr>';
                            }
                            $(newRow).insertAfter("#elcHead");
                            $('#elc_totchrg').val(data['elc_totchrg']);
                            newRow = "";
                            break;
                        case '8':
                            for (var i = 0, len = data['pat_name'].length; i < len; i++) {
                                newRow +=
                                        '<tr class="patOld">' +
                                        '<td><input type="text" value="' + $.trim(data['pat_name'][i]) + '" name="pat_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                                        '<td><input type="text" value="' + $.trim(data['pat_charge'][i]) + '" name="pat_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                                        '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>' +
                                        '</tr>';
                            }
                            $(newRow).insertAfter("#patHead");
                            $('#pat_totchrg').val(data['pat_totchrg']);
                            newRow = "";
                            break;
                        case '9':
                            for (var i = 0, len = data['bldg_name'].length; i < len; i++) {
                                newRow +=
                                        '<tr class="bldgOld">' +
                                        '<td><input type="text" value="' + $.trim(data['bldg_name'][i]) + '" name="bldg_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                                        '<td><input type="text" value="' + $.trim(data['bldg_charge'][i]) + '" name="bldg_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                                        '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>' +
                                        '</tr>';
                            }
                            $(newRow).insertAfter("#bldgHead");
                            $('#bldg_totchrg').val(data['bldg_totchrg']);
                            newRow = "";
                            break;
                        case '10':
                            for (var i = 0, len = data['ot_name'].length; i < len; i++) {
                                newRow +=
                                        '<tr class="otOld">' +
                                        '<td><input type="text" value="' + $.trim(data['ot_name'][i]) + '" name="ot_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                                        '<td><input type="text" value="' + $.trim(data['ot_charge'][i]) + '" name="ot_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                                        '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>' +
                                        '</tr>';
                            }
                            $(newRow).insertAfter("#otHead");
                            $('#ot_totchrg').val(data['ot_totchrg']);
                            newRow = "";
                            break;
                        case '11':
                            for (var i = 0, len = data['ot_oth_name'].length; i < len; i++) {
                                newRow +=
                                        '<tr class="ot_oth_Old">' +
                                        '<td><input type="text" value="' + $.trim(data['ot_oth_name'][i]) + '" name="ot_oth_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                                        '<td><input type="text" value="' + $.trim(data['ot_oth_charge'][i]) + '" name="ot_oth_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                                        '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>' +
                                        '</tr>';
                            }
                            $(newRow).insertAfter("#ot_othHead");
                            $('#ot_oth_totchrg').val(data['ot_oth_totchrg']);
                            newRow = "";
                            break;
                        case '12':
                            for (var i = 0, len = data['med_name'].length; i < len; i++) {
                                newRow +=
                                        '<tr class="medOld">' +
                                        '<td><input type="text" value="' + $.trim(data['med_name'][i]) + '" name="med_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                                        '<td><input type="text" value="' + $.trim(data['med_charge'][i]) + '" name="med_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                                        '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>' +
                                        '</tr>';
                            }
                            $(newRow).insertAfter("#medHead");
                            $('#med_totchrg').val(data['med_totchrg']);
                            newRow = "";
                            break;
                        case '13':
                            for (var i = 0, len = data['oth_name'].length; i < len; i++) {
                                newRow +=
                                        '<tr class="othOld">' +
                                        '<td><input type="text" value="' + $.trim(data['oth_name'][i]) + '" name="oth_name[]" style="margin-bottom: 5px" class="form-control"/></td>' +
                                        '<td><input type="text" value="' + $.trim(data['oth_charge'][i]) + '" name="oth_charge[]" class="charge form-control" style="margin-bottom: 5px;margin-left: 5px;"/></td>' +
                                        '<td><a class="remove" style="margin-bottom: 5px; margin-left: 5px;">Remove</a></td>' +
                                        '</tr>';
                            }
                            $(newRow).insertAfter("#othHead");
                            $('#oth_totchrg').val(data['oth_totchrg']);
                            newRow = "";
                            break;
                    }
                });
            }
        });
    });
</script>

