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
            <div class="panel-heading" >Add Doctor Details</div>
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
                    <form class="form-horizontal" id="doct_form" action="action.php?action=add_doc" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="hidden" id="id" name="id" value=""/>
                                <label class="control-label pull-left">Doctor Type</label>
                                <div class="col-sm-4">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" checked="true" name="doc_type" id="doc_typeD" value="D" onchange="activeDipDiv(this)">Doctor
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="doc_type" id="doc_typeA" value="A" onchange="activeDipDiv(this)">Anesthetist
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">&nbsp;</div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="doc_reg" class="col-xs-4 control-label">Doctor's ID/Reg. No.</label>
                                    <div class="col-xs-5">
                                        <input type="text" class="form-control" id="doc_reg" name="doc_reg" placeholder="Doctor's ID/Reg. No" required/>
                                    </div>
                                    <!--                                    <div class="col-xs-3">
                                                                            <button type="button" class="btn btn-default" id="reg_btn" title="Generate Reg. No."><i class="fa fa-refresh"></i></button>
                                                                        </div>-->
                                </div>
                            </div>
                            <div class="col-xs-6 dip_div">
                                <div class="form-group">
                                    <label for="dept_id" class="col-xs-5 control-label">Department</label>
                                    <div class="col-xs-6">
                                        <select class="form-control" name="dept_id" id="dept_id">

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="doc_name" class="col-xs-4 control-label">Doctor's Name</label>
                                    <div class="col-xs-7">
                                        <input type="text" class="form-control" id="doc_name" name="doc_name" placeholder="Doctor's Name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="doj" class="col-xs-5 control-label">Date Of Joining</label>
                                    <div class="col-xs-6">
                                        <input type="text" class="form-control" id="doj" name="doj" placeholder="Date Of Joining" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group" >
                                    <label class="col-xs-4 control-label">Contact Number</label>
                                    <div class="col-xs-5" id="originalTemplate">
                                        <input type="text" class="form-control contacts" name="contact_no[]"/>
                                    </div>
                                    <div class="col-xs-3">
                                        <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                <!-- The option field template containing an option field and a Remove button -->
                                <div class="form-group hide" id="optionTemplate">
                                    <div class="col-xs-offset-4 col-xs-5">
                                        <input class="form-control" type="text" name="contact_no[]" onkeypress="return isNumber(event)" maxlength="10"/>
                                    </div>
                                    <div class="col-xs-3">
                                        <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="dor" class="col-xs-5 control-label">Date Of Retirment</label>
                                    <div class="col-xs-6">
                                        <input type="text" class="form-control" id="dor" name="dor" placeholder="Date Of Retirment" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="col-xs-4 control-label">Doctor Address</label>
                                    <div class="col-xs-7">
                                        <textarea class="form-control" rows="3" style="resize: none" id="doc_address" name="doc_address"></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="dor" class="col-xs-5 control-label">Doctor Qualification</label>
                                    <div class="col-xs-6">
                                        <textarea class="form-control" rows="3" style="resize: none" id="doct_quli" name="doct_quli"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="col-xs-4 control-label">Remarks</label>
                                    <div class="col-xs-7">
                                        <textarea class="form-control" rows="3" style="resize: none" id="remarks" name="remarks"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-md-6 text-right">
                                <button type="submit" class="btn btn-primary" name="submit">Submit Button</button>
                            </div>
                            <div class="col-md-6">
                                <button type="reset" id="reset" class="btn btn-default">Reset Button</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col-->
    </div></div>
<style>
    * {
        .border-radius: 0 !important;
    }

    #field {
        margin-bottom:20px;
    }
</style>
<script src="js/jquery-ui.js"></script>
<script>
                                            $('#reset').on('click', function () {
                                                $(this).closest('form').find('input[type=text], textarea').val('');
                                            });
                                            $(document).ready(function () {
                                                //$('.bg-success,.bg-danger').hide();
                                                $.getJSON("action.php?action=dpt_list", function (data) {
                                                    $('#dept_id').append(
                                                            $('<option></option>').val("").html("Select Department"));
                                                    $.each(data, function (index) {
                                                        $('#dept_id').append(
                                                                $('<option></option>').val(data[index].id).html(data[index].dept_name));
                                                    });
                                                });
                                                $(".bg-success,.bg-danger").delay(5000).fadeOut();
                                                $.ajax({url: "action.php?action=del_session", success: function (result) {
                                                    }});
                                            });
                                            $('.close').on("click", function () {
                                                $(this).closest("div").fadeOut();
                                            });
                                            $('#doj').datepicker({});
                                            $('#dor').datepicker({});
</script>
<script>
    $('#reg_btn').on('click', function () {
        getReg();
    });
    function getReg() {
        $.ajax({url: "action.php?action=doc_reg", success: function (result) {
                $("#doc_reg").val($.trim(result));
            }});
    }
</script>
<script>
    $(document).ready(function () {
        // The maximum number of options
        var MAX_OPTIONS = 5;

        $('#doct_form')
                // Add button click handler
                .on('click', '.addButton', function () {
                    var $template = $('#optionTemplate'),
                            $clone = $template
                            .clone()
                            .removeClass('hide')
                            .removeAttr('id')
                            .insertBefore($template),
                            $option = $clone.find('[name="contact_no[]"]');

                    // Add new field
                    //$('#doct_form').formValidation('addField', $option);
                })

                // Remove button click handler
                .on('click', '.removeButton', function () {
                    var $row = $(this).parents('.form-group'),
                            $option = $row.find('[name="contact_no[]"]');

                    // Remove element containing the option
                    $row.remove();

                    // Remove field
                    //$('#doct_form').formValidation('removeField', $option);
                })

                // Called after adding new field
                .on('added.field.fv', function (e, data) {
                    // data.field   --> The field name
                    // data.element --> The new field element
                    // data.options --> The new field options

                    if (data.field === 'contact_no[]') {
                        if ($('#doct_form').find(':visible[name="contact_no[]"]').length >= MAX_OPTIONS) {
                            $('#doct_form').find('.addButton').attr('disabled', 'disabled');
                        }
                    }
                })

                // Called after removing the field
                .on('removed.field.fv', function (e, data) {
                    if (data.field === 'contact_no[]') {
                        if ($('#doct_form').find(':visible[name="contact_no[]"]').length < MAX_OPTIONS) {
                            $('#doct_form').find('.addButton').removeAttr('disabled');
                        }
                    }
                });
    });
</script>
<script>
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    $(document).ready(function () {
        $(".contacts").keydown(function (e) {
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
    });
    $(document).ready(function () {
        $(".contacts").attr("maxlength", 10);
    });
    $(function (event) {

        $("#doc_reg").autocomplete(
                {
                    source: 'action.php?action=doc_auto&id=doc_reg',
                });
    });
    function activeDipDiv(id) {
        if ($(id).val() === 'A') {
            $('.dip_div').hide();
        }
        if ($(id).val() === 'D') {
            $('.dip_div').show();
        }
    }
    $("#doc_reg").on('blur', function () {
        var contact;
        $.getJSON("action.php?action=get_doc&doc_reg=" + $('#doc_reg').val(), function (data) {
            $.each(data, function (i, value) {
                if (i === 'doc_type') {
                    $('#' + i + value).val(value).attr('checked', 'checked');
                    if (value === 'D') {
                        $('.dip_div').show();
                    }
                    if (value === 'A') {
                        $('.dip_div').hide();
                    }
                } else if (i === 'contact_no') {
                    contact = value.split(',<br>');
                     var ind = 1;
                    $.each(contact, function (i, vl) {
                       
                        if (vl !== "") {
                            if (ind == 1) {
                               console.log($('#originalTemplate').find('[name="contact_no[]"]').val(vl));
                                ind++;
                            } else {
                                var $template = $('#optionTemplate'),
                                        $clone = $template
                                        .clone()
                                        .removeClass('hide')
                                        .removeAttr('id')
                                        .insertBefore($template),
                                        $option = $clone.find('[name="contact_no[]"]');
                                $clone.find('[name="contact_no[]"]').val(vl);
                                 ind++;
                            }
                        }
                    });
                } else {
                    $('#' + i).val(value);
                }
                /*var $template = $('#optionTemplate'),
                 $clone = $template
                 .clone()
                 .removeClass('hide')
                 .removeAttr('id')
                 .insertBefore($template),
                 $option = $clone.find('[name="contact_no[]"]');
                 $clone.find('[name="contact_no[]"]').val('');*/
            });
        });
    });
</script>
