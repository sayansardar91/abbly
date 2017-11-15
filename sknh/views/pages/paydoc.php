<?php 
	$allow = array(1,2);
	if(!in_array($_SESSION['type'], $allow)){
		echo "<script>alert('You are not allowed to access this page.');</script>";
		echo "<script>window.location = '/index.php?pg=home'</script>";
	}
?>
<link href="css/jquery-ui.css" rel="stylesheet"/>
<div class="row">
    <div class="col-md-12 col-sm-6 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <form class="form-horizontal row-border" method="post" action="action.php?action=payment&tp=dr">
            <div class="form-group">
            	<div class="row">
                	<label class="col-md-2 control-label">Dr. Name :</label>
                    <div class="col-md-3">
                    <select class="form-control" name="atd_doctor" id="atd_doctor" required="true">
                        <option value="">Select Doctor</option>
                    </select>
                  </div>
                  <label class="col-md-2 control-label">Patient ID :</label>
                    <div class="col-md-3">
                    
                    <select class="form-control" name="patient_id" id="patient_id" required="true">
                        <option value="">Select Patient Id</option>
                    </select>
                  </div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                	<label class="col-md-2 control-label">Doctor's Amount :</label>
                    <div class="col-md-3">
                    <input class="form-control numeric" name="amount_paid" id="amount_paid" placeholder="Amount" type="text" required="true">
                  </div>
                  <label class="col-md-2 control-label">Payment Date :</label>
                    <div class="col-md-3">
                    <input class="form-control" placeholder="Payment Date" name="payment_date" id="payment_date" type="text" required="true">
                  </div>
                  
                  <div class="col-md-12" align="center">
                  	<div class="row">&nbsp;</div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    <button type="reset" id="reset" class="btn btn-default">Reset</button>
                  </div>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="js/bootstrap-table.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript">
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
    });
	$('#atd_doctor').change(function () {
        if ($('#atd_doctor').val()) {
            $.getJSON("action.php?action=by_doc", {id: $('#atd_doctor').val()}, function (data) {
                $('#patient_id').empty();
                $('#patient_id').append(
                        $('<option></option>').val("").html("Select Patient ID"));
                $.each(data, function (index) {
                    //console.log(data["bd_details"][index].id+"=>"+data["bd_details"][index].bed_name);
                    $('#patient_id').append(
                            $('<option></option>').val(data[index].id).html(data[index].patient_name)
                            );
                });
            });
        } else {
            $('#patient_id').empty();
            $('#patient_id').append($('<option></option>').val("").html("Select Patient ID"));
        }
    });
	$(function (event) {
		$.getJSON("action.php?action=get_doctall", function (data) {
			$('#atd_doctor').empty();
            $('#atd_doctor').append(
                    $('<option></option>').val("").html("Select Doctor Name"));
            $.each(data, function (index) {
                $('#atd_doctor').append(
                        $('<option></option>').val(data[index].id).html("Dr. "+data[index].doc_name)
                        );
            });
        });
	});
	
	</script>
    <script>
    $('#payment_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        /*minDate: -1,
         maxDate: new Date()*/
    }).datepicker("setDate", new Date());
</script>