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
            <div class="panel-heading" >Add Employee Payment</div>
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
                    <form action="action.php?action=emp_sal" method="post" id="emp_form">
                        <div class="row">
                            <div class="col-md-3"><div class="form-group">
                                    <label>Employee ID</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="emp_id" name="emp_id" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" id="srch_reg">Search</button>
                                        </span>
                                    </div>
                                </div></div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Employee Name</label>
                                    <input class="form-control" type="text" name="emp_firstname" id="emp_firstname"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Department</label>
                                    <input class="form-control" type="text" name="emp_dept" id="emp_dept" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Apointment Date</label>
                                    <input class="form-control" type="text" name="emp_doj" id="emp_doj" readonly="readonly"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>For Month Of</label>
                                    <input class="form-control" type="text" name="sal_month" id="sal_month"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Salary Date</label>
                                    <input class="form-control" type="text" name="sal_date" id="sal_date"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Basic Pay</label>
                                    <input class="form-control" type="text" name="basic_pay" id="basic_pay"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Bonus</label>
                                    <input class="form-control numeric" type="text" name="bonus" id="bonus"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Salary Reduction</label>
                                    <input class="form-control numeric" type="text" name="salary_reduc" id="salary_reduc"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Net Amount Payable</label>
                                    <input class="form-control" type="text" name="net_amount" id="net_amount"/>
                                </div>
                            </div>
                        </div>
                        <div class="row"><hr /></div>

                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        <button type="reset" id="reset" class="btn btn-default">Reset</button>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.col-->
</div>
<script src="js/jquery-ui.js"></script>
<script>
    $('#sal_month').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'M/yy',
    }).datepicker("setDate", new Date());
    $('#sal_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
    }).datepicker("setDate", new Date());
</script>
<script>
    $('#reset').on('click', function () {
        $(this).closest('form').find('input[type=text], textarea').val('');
    });
    $(function (event) {

        $("#emp_id").autocomplete(
                {
                    source: 'action.php?action=emp_auto&id=emp_id',
                });
        $("#emp_firstname").autocomplete(
                {
                    source: 'action.php?action=emp_auto&id=emp_firstname',
                });
    });
</script>
<script>
    $(document).ready(function () {
        $(".numeric").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // Allow: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
        $(".bg-success,.bg-danger").delay(10000).fadeOut();
        $.ajax({url: "action.php?action=del_session", success: function (result) {
            }});
    });

    $('#srch_reg').click(function () {
        $.getJSON("action.php?action=get_empsal&emp_id=" + $('#emp_id').val(), function (data) {
            $.each(data, function (i, value) {
                $('#' + i).val(value).attr('readonly', true);
                
            });
            
            $("#net_amount").val($('#basic_pay').val()).attr('readonly', true);
            $("#emp_id").attr('readonly', true);
        });
    });
    $('#emp_firstname').on('blur', function () {
        if($('#emp_firstname').val() != ""){
            $.ajax({url: "action.php?action=get_empid&emp_name=" + $('#emp_firstname').val(), success: function (result) {
                $('#emp_id').val($.trim(result));
            }});
        }
        
    });
    $('#bonus').on('blur', function () {
        $('#net_amount').val((Number($('#basic_pay').val()) + Number($(this).val())) - Number($('#salary_reduc').val()));
    });
    $('#salary_reduc').on('blur',function (){
        $('#net_amount').val((Number($('#basic_pay').val()) + Number($('#bonus').val())) - Number($(this).val()));
    });
</script>

