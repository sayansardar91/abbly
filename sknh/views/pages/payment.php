<?php 
	$allow = array(1,2,3);
	if(!in_array($_SESSION['type'], $allow)){
		echo "<script>alert('You are not allowed to access this page.');</script>";
		echo "<script>window.location = '/index.php?pg=home'</script>";
	}
?>
<link href="css/jquery-ui.css" rel="stylesheet"/>
<link href="css/pure-min.css" rel="stylesheet"/>
<style>
    .numeric{
        text-align: right;
    }
    
</style>
<div class="row" >
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" >Add Patient Payment</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="row">
                        <?php
                        if (isset($_SESSION['success'])) {
                            if ($_SESSION['success']) {
                                if (isset($_SESSION['bill_no'])) {
                                    echo "<script type=\"text/javascript\">
        window.open('reports/rcpt.php?bill_no=" . $_SESSION['bill_no'] . "', '_blank')
                                </script>";
                                }
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
                    <form action="action.php?action=pt_payment" method="post" id="emp_form">
                        <div class="row">
                            <div class="col-md-3"><div class="form-group">
                                    <label>Bill No.</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="bill_no" name="bill_no" required/>
                                    </div>
                                </div></div>
                            <div class="col-md-3"><div class="form-group">
                                    <label>Patient ID/Reg. No.</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="reg_no" name="reg_no" required/>
                                    </div>
                                </div></div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Patient Name</label>
                                    <input class="form-control" type="text" name="patient_name" id="patient_name"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group col-xs-12">
                                    <label>Payment Date</label>
                                    <input class="form-control" type="text" name="payment_date" id="payment_date"/>
                                </div>
                            </div>
                        </div>
<!--                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group col-xs-4">
                                    <label>Bed Charge</label>
                                    <input type="text" class="form-control numeric chrg" id="bed_days" name="bed_days" placeholder="Attending Days" />
                                </div>
                                <div class="form-group col-xs-4">
                                    <label>&nbsp;</label>
                                    <input type="text" class="form-control numeric chrg" id="bed_chrg" name="bed_chrg" placeholder="Bed Charges"/>
                                </div>
                                <div class="form-group col-xs-4">
                                    <label>&nbsp;</label>
                                    <input type="text" class="form-control numeric chrg" id="bed_total_charge" name="bed_total_charge" placeholder="Total Charges" readonly/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col-xs-4">
                                    <label>Private Attendint</label>
                                    <input type="text" class="form-control numeric chrg" id="pvtatd_days" name="pvtatd_days" placeholder="Attending Days"/>
                                </div>
                                <div class="form-group col-xs-4">
                                    <label>&nbsp;</label>
                                    <input type="text" class="form-control numeric chrg" id="pvtatd_charge" name="pvtatd_charge" placeholder="Attendent Charge"/>
                                </div>
                                <div class="form-group col-xs-4">
                                    <label>&nbsp;</label>
                                    <input type="text" class="form-control numeric chrg" id="pvtatd_total_charge" name="pvtatd_total_charge" placeholder="Total Charge" readonly/>
                                </div>
                            </div>
                        </div>-->
                        <div class="row"><hr /></div>
                        <div class="row text-center">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="form-group col-xs-6">
                                        <label class="control-label">Total Unpaid Amount : </label>
                                    </div>
                                    <div class="form-group col-xs-6">
                                        <label class="control-label"><span id="total_amount_span"></span></label>
                                        <input type="hidden" id="total_amount" name="total_amount" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-6">
                                        <label class="control-label">Total Paid Amount : </label>
                                    </div>
                                    <div class="form-group col-xs-6">
                                        <label class="control-label"><span id="amount_paid_span"></span></label>
                                        <input type="hidden" id="amount_paid" name="amount_paid" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-6">
                                        <label class="control-label">Total Due Amount : </label>
                                    </div>
                                    <div class="form-group col-xs-6">
                                        <label class="control-label"><span id="amount_due_span"></span></label>
                                        <input type="hidden" id="amount_due" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-6">
                                        <label class="control-label">Payable Amount : </label>
                                    </div>
                                    <div class="form-group col-xs-6">
                                        <input type="text" class="form-control numeric chrg" required id="payble_amount" name="payble_amount" placeholder="Payble Amount"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                &nbsp;
                            </div>
                            <div class="col-md-4">
                                <table class="pure-table pure-table-bordered" id="payment-table">
                                    <thead>
                                        <tr>
                                            <th>Payment Date</th>
                                            <th>Paid Amount</th>
                                            
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr id="no-data" >
                                            <td colspan="2">No data Found</td>
                                        </tr>
                                    </tbody>
                                </table>
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

    $('#payment_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
    }).datepicker("setDate", new Date());
</script>
<script>
    $('#reset').on('click', function () {
        $(this).closest('form').find('input[type=text], textarea').val('');
    });
    $(function (event) {
        $("#reg_no").autocomplete(
                {
                    source: 'action.php?action=reg_no',
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
        getBillNo();
        
    });
    $('#reg_no').on('change',function(){
        $.getJSON("action.php?action=pt_name", {id: $('#reg_no').val()}, function (data) {
                $.each(data, function (index,value) {
                    $('#'+index).val(value);
                });
            });
        /*$.getJSON("action.php?action=add_charge", {id: $('#reg_no').val()}, function (data) {
                $.each(data, function (index,value) {
                    $.each(value,function(i,v){
                        $('#'+i).val(v);
                    });
                });
            });*/
        $.getJSON("action.php?action=pt_total", {id: $('#reg_no').val()}, function (data) {
                $.each(data, function (index,vl) {
                    $('#'+index).val(vl);
                    $('#'+index+"_span").html("Rs. "+vl+"/-");
                });
            });
        var html;
        $.getJSON("action.php?action=pmt_list", {id: $('#reg_no').val()}, function (data) {
            if(data.length != 0){
                $.each(data, function (index,value) {
                   
                    html += '<tr><td>'+value['payment_date']+'</td><td>Rs '+value['payble_amount']+' /-</td></tr>';
                });
                $('#no-data').remove();
                $('#payment-table').append(html);
            }
                
            });
    });
    $('#bed_days').on('blur',function (){
        var tot,last,diff,paid;
        if($('#bed_days').val() == 0){
            tot = Number($('#total_amount').val())-Number($('#bed_total_charge').val());
            $('#total_amount').val(tot);
            $('#total_amount_span').html("Rs. "+tot+"/-");
           $('#bed_total_charge').val("");
           paid = Number($('#amount_paid').val());
            tot = Number($('#total_amount').val());
            tot = tot - paid;
            $('#amount_due').val(tot);
            $('#amount_due_span').html("Rs. "+tot+"/-");
        }else{
            last = Number($('#bed_total_charge').val());
            $('#bed_total_charge').val(Number($(this).val())*Number($('#bed_chrg').val()));
            console.log($('#bed_total_charge').val());
            diff = last - Number($('#bed_total_charge').val());
            tot = Number($('#total_amount').val()) - diff;
            $('#total_amount').val(tot);
            $('#total_amount_span').html("Rs. "+tot+"/-");
            paid = Number($('#amount_paid').val());
            tot = Number($('#total_amount').val());
            tot = tot - paid;
            $('#amount_due').val(tot);
            $('#amount_due_span').html("Rs. "+tot+"/-");
        }
    });
    $('#pvtatd_charge').on('blur',function (){
        var tot,last,diff,paid;
        if($('#pvtatd_charge').val() == 0){
            tot = Number($('#total_amount').val())-Number($('#pvtatd_total_charge').val());
            $('#total_amount').val(tot);
            $('#total_amount_span').html("Rs. "+tot+"/-");
           $('#pvtatd_total_charge').val("");
           paid = Number($('#amount_paid').val());
            tot = Number($('#total_amount').val());
            tot = tot - paid;
            $('#amount_due').val(tot);
            $('#amount_due_span').html("Rs. "+tot+"/-");
        }else{
            last = Number($('#pvtatd_total_charge').val());
            $('#pvtatd_total_charge').val(Number($(this).val())*Number($('#pvtatd_days').val())*2);
            diff = last - Number($('#pvtatd_total_charge').val());
            tot = Number($('#total_amount').val()) - diff;
            $('#total_amount').val(tot);
            $('#total_amount_span').html("Rs. "+tot+"/-");
            paid = Number($('#amount_paid').val());
            tot = Number($('#total_amount').val());
            tot = tot - paid;
            $('#amount_due').val(tot);
            $('#amount_due_span').html("Rs. "+tot+"/-");
        }
    });
    function getBillNo() {
        $.ajax({url: "action.php?action=bill_no", success: function (result) {
                $("#bill_no").val($.trim(result)).attr('readonly', true);
            }});
    }
</script>