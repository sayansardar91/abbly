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
            <div class="panel-heading" >Admit New Employee</div>
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
                    <form action="action.php?action=adm_emp" method="post" id="emp_form">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="control-label pull-left" style="margin-top: 10px;">Employee Type</label>
                                <div class="col-sm-4">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" checked="true" name="emp_type" id="emp_typeE" value="E" onchange="activeDipDiv(this)">Employee
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="emp_type" id="emp_typeS" value="S" onchange="activeDipDiv(this)">Sister
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><div class="form-group">
                                    <label>Employee ID</label>

                                    <input type="text" class="form-control" id="emp_id" name="emp_id" required="true"/>
                                </div></div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input class="form-control" type="text" name="emp_firstname" id="emp_firstname" required="true"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input class="form-control" type="text" name="emp_middlename" id="emp_middlename"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input class="form-control" type="text" name="emp_lastname" id="emp_lastname" required="true"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Sex</label>
                                    <div class="row">
                                        <div class="col-md-4"><div class="radio">
                                                <label>
                                                    <input type="radio" name="emp_sex" id="emp_sexM" value="M" >Male
                                                </label>
                                            </div></div>
                                        <div class="col-md-4"><div class="radio">
                                                <label>
                                                    <input type="radio" name="emp_sex" id="emp_sexF" value="F" >Female
                                                </label>
                                            </div></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 dip_div" >
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="form-control" name="emp_dept" id="emp_dept" >

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label>DOB</label>
                                <input class="form-control" type="text" name="emp_dob" id="emp_dob" />
                            </div>
                            <div class="col-md-3">
                                <label>Father Name</label>
                                <input class="form-control" type="text" name="emp_fathername" id="emp_fathername"/>
                            </div>
                            <div class="col-md-2">
                                <label>Home Phone No</label>
                                <input class="form-control numeric"  maxlength="10" type="text" name="emp_homephn" id="emp_homephn"/>
                            </div>
                            <div class="col-md-2">
                                <label>Work Phone No</label>
                                <input class="form-control numeric"  maxlength="10" type="text" name="emp_workphn" id="emp_workphn"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 dip_div">&nbsp;</div>
                            <div class="col-md-2">
                                <span id="dob_words"></span>
                            </div>
                        </div>
                        <div class="row"><hr /></div>

                        <div class="row">
                            <div class="col-md-3">
                                <label>Date Of Joining</label>
                                <input class="form-control" type="text" name="emp_doj" id="emp_doj" required="true"/>
                            </div>
                            <div class="col-md-3">
                                <label>Date Of Retirement</label>
                                <input class="form-control" type="text" name="emp_dor" id="emp_dor"/>
                            </div>
                            <div class="col-md-3">
                                <label>Basic Pay</label>
                                <input class="form-control numeric" type="text" name="basic_pay" id="basic_pay" />
                            </div>
                            <div class="col-md-3">
                                <label>E-mail</label>
                                <input class="form-control" type="text" name="emp_email" id="emp_email"/>
                            </div>
                        </div>

                        <div class="row"><hr /></div>
                        <div class="row"><h4 style="margin-left: 15px"><u>Permanent Address<u/></h4></div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Address / Village</label>
                                <input class="form-control" type="text" name="perm_address" id="perm_address"/>
                            </div>
                            <div class="col-md-4">
                                <label>PO</label>
                                <input class="form-control po" type="text" id="perm_po" name="perm_po" />
                            </div>
                            <div class="col-md-4">
                                <label>P.S</label>
                                <input type="text" class="form-control ps" id="perm_ps" name="perm_ps" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label>District</label>
                                <input class="form-control dist" type="text" id="perm_dist" name="perm_dist" />
                            </div>
                            <div class="col-md-4">
                                <label>State</label>
                                <input class="form-control" type="text" id="perm_state" name="perm_state" />
                            </div>
                        </div>
                        <div class="row"><hr></div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="checkbox" id="chk_address" />&nbsp; Click Here If Present Address & Permanent Address Both Are Same.
                            </div>
                        </div>
                        <div class="row"><h4 style="margin-left: 15px"><u>Present Address<u/></h4></div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Address / Village</label>
                                <input class="form-control" type="text" name="present_address" id="present_address"/>
                            </div>
                            <div class="col-md-4">
                                <label>PO</label>
                                <input class="form-control po" type="text" id="present_po" name="present_po"/>
                                <div id="po_result"></div>
                            </div>
                            <div class="col-md-4">
                                <label>P.S</label>
                                <input type="text" class="form-control ps" id="present_ps" name="present_ps"/>
                                <div id="ps_result"></div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <label>District</label>
                                <input class="form-control dist" type="text" id="present_dist" name="present_dist"/>
                                <div id="dist_result"></div>
                            </div>
                            <div class="col-md-4">
                                <label>State</label>
                                <input class="form-control" type="text" id="present_state" name="present_state"/>
                            </div>
                        </div>
                        <div class="row"><hr /></div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Qualification</label>
                                <textarea id="emp_qualification"  name="emp_qualification" class="form-control" style="resize: none"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label>Remarks</label>
                                <textarea id="emp_remarks" name="emp_remarks" class="form-control" style="resize: none"></textarea>
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
                                                $('#reset').on('click', function () {
                                                    $(this).closest('form').find('input[type=text], textarea').val('');
                                                });
                                                $(function (event) {

                                                    $("#emp_id").autocomplete(
                                                            {
                                                                source: 'action.php?action=emp_auto&id=emp_id',
                                                            });

                                                    $("#perm_ps").autocomplete(
                                                            {
                                                                source: 'action.php?action=emp_auto&id=perm_ps',
                                                            });
//                                                    $("#perm_pin").autocomplete(
//                                                            {
//                                                                source: 'action.php?action=emp_auto&id=perm_pin',
//                                                            });
                                                    $("#perm_po").autocomplete(
                                                            {
                                                                source: 'action.php?action=emp_auto&id=perm_po',
                                                            });
                                                    $("#perm_dist").autocomplete(
                                                            {
                                                                source: 'action.php?action=emp_auto&id=perm_dist',
                                                            });
                                                    $("#perm_state").autocomplete(
                                                            {
                                                                source: 'action.php?action=emp_auto&id=perm_state',
                                                            });

                                                    $("#present_ps").autocomplete(
                                                            {
                                                                source: 'action.php?action=emp_auto&id=present_ps',
                                                            });
//                                                    $("#present_pin").autocomplete(
//                                                            {
//                                                                source: 'action.php?action=emp_auto&id=present_pin',
//                                                            });
                                                    $("#present_po").autocomplete(
                                                            {
                                                                source: 'action.php?action=emp_auto&id=present_po',
                                                            });
                                                    $("#present_dist").autocomplete(
                                                            {
                                                                source: 'action.php?action=emp_auto&id=present_dist',
                                                            });
                                                    $("#present_state").autocomplete(
                                                            {
                                                                source: 'action.php?action=emp_auto&id=present_state',
                                                            });
                                                });
</script>
<script>
    $('#emp_dob').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'mm/dd/yy',
        yearRange: '1970:' + (new Date().getFullYear() - 18),
        minDate: '-50Y',
    });
    $('#emp_doj,#emp_dor').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy',
    });
</script>
<script>
    function getEmpID() {
        $.ajax({url: "action.php?action=empid", success: function (result) {
                $("#emp_id").val($.trim(result));
            }});
    }
    $(document).ready(function () {
        getEmpID();
        $(".bg-success,.bg-danger").delay(10000).fadeOut();
        $.ajax({url: "action.php?action=del_session", success: function (result) {
            }});
    });
    $(document).ready(function () {
        $.getJSON("action.php?action=dpt_list&group=1", function (data) {
            $('#emp_dept').append(
                    $('<option></option>').val("").html("Select Department"));
            $.each(data, function (index) {
                $('#emp_dept').append(
                        $('<option></option>').val(data[index].id).html(data[index].dept_name));
            });
        });
    });
    $('#emp_id').on('blur', function () {
        $.getJSON("action.php?action=get_emp&emp_id=" + $('#emp_id').val(), function (data) {
            $.each(data, function (i, value) {
                if (i === 'emp_type') {
                    $('#' + i + value).val(value).attr('checked', 'checked');
                } else if (i === 'emp_sex') {
                    $('#' + i + value).val(value).attr('checked', 'checked');
                } else if (i === 'emp_dept') {
                    $('#' + i).val(value).attr('selected',true);
                    if (value == 0) {
                        $('.dip_div').hide();
                    }
                } else {
                    $('#' + i).val(value);
                }
            });
            $("#emp_form").attr('action', 'action.php?action=emp_update');
        });
    });
    $("#emp_id").click(function () {
        $("#emp_id").val("");
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
    });</script>
<script >

    function getAge(dateString) {
        var now = new Date();
        var today = new Date(now.getYear(), now.getMonth(), now.getDate());
        var yearNow = now.getYear();
        var monthNow = now.getMonth();
        var dateNow = now.getDate();
        var dob = new Date(dateString.substring(6, 10),
                dateString.substring(0, 2) - 1,
                dateString.substring(3, 5)
                );
        var yearDob = dob.getYear();
        var monthDob = dob.getMonth();
        var dateDob = dob.getDate();
        var age = {};
        var ageString = "";
        var yearString = "";
        var monthString = "";
        var dayString = "";
        yearAge = yearNow - yearDob;
        if (monthNow >= monthDob)
            var monthAge = monthNow - monthDob;
        else {
            yearAge--;
            var monthAge = 12 + monthNow - monthDob;
        }

        if (dateNow >= dateDob)
            var dateAge = dateNow - dateDob;
        else {
            monthAge--;
            var dateAge = 31 + dateNow - dateDob;
            if (monthAge < 0) {
                monthAge = 11;
                yearAge--;
            }
        }

        age = {
            years: yearAge,
            months: monthAge,
            days: dateAge
        };
        if (age.years > 1)
            yearString = " years";
        else
            yearString = " year";
        if (age.months > 1)
            monthString = " months";
        else
            monthString = " month";
        if (age.days > 1)
            dayString = " days";
        else
            dayString = " day";
        if ((age.years > 0) && (age.months > 0) && (age.days > 0))
            ageString = age.years + yearString + ", " + age.months + monthString + ", and " + age.days + dayString + " old.";
        else if ((age.years == 0) && (age.months == 0) && (age.days > 0))
            ageString = "Only " + age.days + dayString + " old!";
        else if ((age.years > 0) && (age.months == 0) && (age.days == 0))
            ageString = age.years + yearString + " old.Happy Birthday!!";
        else if ((age.years > 0) && (age.months > 0) && (age.days == 0))
            ageString = age.years + yearString + " and " + age.months + monthString + " old.";
        else if ((age.years == 0) && (age.months > 0) && (age.days > 0))
            ageString = age.months + monthString + " and " + age.days + dayString + " old.";
        else if ((age.years > 0) && (age.months == 0) && (age.days > 0))
            ageString = age.years + yearString + " and " + age.days + dayString + " old.";
        else if ((age.years == 0) && (age.months > 0) && (age.days == 0))
            ageString = age.months + monthString + " old.";
        else
            ageString = "Oops! Could not calculate age!";
        return ageString;
    }
    $('#emp_dob').change(function () {
        $('#dob_words').html('Age: ' + getAge($('#emp_dob').val()));
    });
    $('#chk_address').change(function () {
        if (this.checked) {
            $('#present_address').val($('#perm_address').val()).attr('readonly', true);
//            $('#present_pin').val($('#perm_pin').val()).attr('readonly', true);
            $('#present_po').val($('#perm_po').val()).attr('readonly', true);
            $('#present_ps').val($('#perm_ps').val()).attr('readonly', true);
            $('#present_dist').val($('#perm_dist').val()).attr('readonly', true);
            $('#present_state').val($('#perm_state').val()).attr('readonly', true);
        } else {
            $('#present_perm_address').val("").removeAttr('readonly');
//            $('#present_pin').val("").removeAttr('readonly');
            $('#present_po').val("").removeAttr('readonly');
            $('#present_ps').val("").removeAttr('readonly');
            $('#present_dist').val("").removeAttr('readonly');
            $('#present_state').val("").removeAttr('readonly');
        }

    });
    function activeDipDiv(id) {
        if ($(id).val() === 'S') {
            $('.dip_div').hide();
        }
        if ($(id).val() === 'E') {
            $('.dip_div').show();
        }
    }
</script>


