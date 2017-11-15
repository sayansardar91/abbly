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
            <div class="panel-heading" >Add New User</div>
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
                    <form class="form-horizontal" id="doct_form" action="action.php?action=add_user" method="post">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label">Employee ID : </label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="emp_id" name="emp_id" required/>
                                </div>
                            </div>
                            <div class="col-md-2 text-right">
                                <label class="control-label">Employee Name : </label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="emp_name" name="emp_name"/>
                                
                            </div>
                        </div>
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="doc_reg" class="col-xs-4 control-label">User Type : </label>
                                    <div class="col-xs-6">
                                        <select class="form-control" name="user_type" id="user_type">
                                            <option value="1">Super User</option>
                                            <option value="2">Manager/Clerk</option>
                                            <option value="3">Reception</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="doc_reg" class="col-xs-4 control-label">User name : </label>
                                    <div class="col-xs-6">
                                        <input type="text" class="form-control" id="user_name" name="user_name"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="doc_reg" class="col-xs-4 control-label">Password : </label>
                                    <div class="col-xs-5">
                                        <input type="text" class="form-control" id="user_passwd" name="user_passwd" placeholder="Password" readonly="readonly" />
                                    </div>
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

        $("#emp_id").autocomplete(
            {
                source: 'action.php?action=emp_auto&id=emp_id',
            });
    });
    $("#emp_id").on('blur', function () {
        if ($("#emp_id").val() != "") {
            var str = $("#emp_id").val();
            $.getJSON("action.php?action=get_empname&emp_id=" + $('#emp_id').val(), function (data) {
                $.each(data, function (i, value) {
                    $('#' + i).val(value).attr('readonly', true);
                });
                $('#user_name').val($.trim(str.substr(str.indexOf("-") + 1)).toLowerCase());
                $('#user_passwd').val(getDigit());
            });
        }
    });
</script>
<script>

    //When DOM loaded we attach click event to button
    $(document).ready(function () {

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
    function getDigit(){
        var a = Math.floor(100000 + Math.random() * 900000)
        a = a.toString().substring(0, 4);
        return a;
    }
</script>