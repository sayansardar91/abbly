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
            <div class="panel-heading" >Admit New Patient</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="row">
                        <?php
                        if (isset($_SESSION['success'])) {
                            if ($_SESSION['success']) {
                                /* if(isset($_SESSION['reg_no'])){
                                  echo "<script type=\"text/javascript\">
                                  window.open('reports/admission_form.php?reg_no=".$_SESSION['reg_no']."', '_blank')
                                  </script>";} */
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
                    <form action="action.php?action=dchrg" method="post" id="discharge_form" onsubmit="return validateForm()">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-sm-1">&nbsp;</div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Patient ID</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="patient_id" name="patient_id"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Discharge ID</label>
                                        <input class="form-control" type="text" id="discharge_id" name="discharge_id" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Discharge Date</label>
                                        <input type="tel" class="form-control" name="discharge_date" id="discharge_date" required="required"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="col-sm-1">&nbsp;</div>
                            <div class="col-sm-11">
                                <label class="control-label" id="pt_admtdt">&nbsp;</label>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-sm-1">&nbsp;</div>
                                <div class="col-sm-11">
                                    <div class="checkbox">
                                        <label class="control-label">
                                            <input type="checkbox" value="1" name="chk_it" id="chk_it" > Do you want to add this patient to IT report? Then check this box.....
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="display: none" id="opt_it">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-1">&nbsp;</div>
                                    <div class="col-sm-5">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" value="300" name="ot_mj" id="ot_mj" > OT Major Charge Rs. 300 /-
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" value="200" name="gen_bed" id="gen_bed" > Bed Charge Gen - Rs. 200 /-
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-1">&nbsp;</div>
                                    <div class="col-sm-5">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" value="250" name="ot_mn" id="ot_mn" > OT Minor Charge Rs. 250 /-
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" value="300" name="cb_bed" id="cb_bed" > Bed Charge Cabin - Rs. 300 /-
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-1">&nbsp;</div>
                                    <div class="col-sm-5">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" value="300" name="carm" id="carm" > C-ARM Charge Rs. 300 /-
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-1">&nbsp;</div>
                                    <div class="col-sm-5">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" value="500" name="orth_chrg" id="orth_chrg" > Orthopedic Charge Rs. 500 /-
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-sm-2">&nbsp;</div>
                                <div class="col-sm-2">&nbsp;</div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn form-control btn-primary" name="submit">Discharge Patient</button>
                                    </div></div>
                                <div class="col-sm-2">&nbsp;</div>
                                <div class="col-sm-2">&nbsp;</div>

                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Discharge Report</div>
                                <div class="panel-body">
                                    <table id="table" data-toggle="table" data-url="action.php?action=dchrg_pt"  
                                           data-pagination="true" data-sort-name="name" data-sort-order="desc" data-search="true" data-show-refresh="true">
                                        <thead>
                                            <tr>
                                                <th data-field="id" data-halign="center" data-align="center">S/No.</th>
                                                <th data-field="discharge_id" data-halign="center" data-align="center">Discharge ID</th>
                                                <th data-field="patient_id" data-halign="center" data-align="center" >Registration No</th>
                                                <th data-field="patient_name_add" data-halign="center" data-align="center">Patient <br/> Name &amp; Address</th>
                                                <th data-field="discharge_date" data-halign="center" data-align="center" >Discharge Date</th>
                                                <th data-field="gurd_name" data-halign="center" data-align="center" >Guardian Name</th>
                                                <th data-field="admit_time" data-halign="center" data-align="center">Admission <br/> Date &amp; Time</th>
                                                <th data-field="diog_name" data-halign="center" data-align="center" >Case</th>
                                                <th data-field="doc_name" data-halign="center" data-align="center" >Attending Doctor</th>
                                                <th data-halign="center" data-align="center" data-formatter="statusFormatter">Action</th>
                                        <script>
                                            function statusFormatter(value, row) {
                                                var status = 'Print';
                                                var data = row.discharge_id;
                                                var btn = 'btn-success';

                                                return '<i data="' + data + '" class="status_checks btn ' + btn + '" style="width:75px" id="bct">' + status + '</i>' +
                                                        '&nbsp;&nbsp;&nbsp;&nbsp;<i data="' + data + '" class="status_delete btn btn-danger" style="width:75px" id="bct">Delete</i>';
                                            }
                                        </script>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.col-->
        <script>
            function validateForm() {
                /*var str = $("#patient_id").val();
                 var n = str.length;
                 if (n<12) {
                 alert("Please Enter Valid Patient ID.");
                 return false;
                 }*/
            }
        </script>
        <script src="js/bootstrap-table.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script type="text/javascript">
            $(function (event) {
                $("#patient_id").autocomplete({
                    source: 'action.php?action=reg_no_dchrg',
                });
            });
            $(document).on('blur', '#patient_id', function (e) {
                $.ajax({url: "action.php?action=did", success: function (result) {
                        if ($("#discharge_id").val() === "") {
                            $("#discharge_id").val($.trim(result));
                        }
                    }});
                var regno = $(e.target).val();
                $.getJSON("action.php?action=getPtd", {id: regno}, function (dt) {
                    $("#pt_admtdt").empty();
                    $("#pt_admtdt").append(dt['pt_admtdt']);
                });
            });
            /*$(document).on('click', '#discharge_id', function () {
             $.ajax({url: "action.php?action=did", success: function (result) {
             if ($("#discharge_id").val() === "") {
             $("#discharge_id").val($.trim(result));
             }
             }});
             });*/
            $('#discharge_date').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                //minDate: 0,
                //maxDate: 15
            }).datepicker("setDate", new Date());
            $(document).ready(function () {
                $(".bg-success,.bg-danger").delay(5000).fadeOut();
                $.ajax({url: "action.php?action=del_session", success: function (result) {
                    }});
            });
        </script>
        <script type="text/javascript">
            $(document).on('click', '.status_checks', function () {
                var current_element = $(this);
                var data = $(current_element).attr('data');
                window.open('reports/discharge_form.php?reg_no=' + data, '_blank')
            });
            $(document).on('click', '.status_delete', function () {
                var current_element = $(this);
                var data_val = $(current_element).attr('data');
                if (confirm("Are you sure to delete this record ?")) {
                    $.ajax({method: "POST", url: "action.php?action=del_dch", data: {id: data_val}, success: function (result) {
                            window.location.href = 'index.php?pg=discharge';
                        }});
                }
            });
            $('#chk_it').on('click', function () {
                $('#opt_it').toggle(this.checked);
                if (this.checked) {
                    $('#opt_it').find('input').prop('disabled', false);
                } else {
                    $('#opt_it').find('input').prop('disabled', true);
                }

            });
            $(document).ready(function () {
                $('#opt_it').find('input').prop('disabled', true);
            });
            $("form").submit(function (e) {

                var isDisabled = $('#opt_it input[type=checkbox]').is(':disabled');
                if (!isDisabled) {
                    if (!$('#opt_it input[type=checkbox]:checked').length) {
                        alert("Please check at least one charge to add to IT Report.");

                        //stop the form from submitting
                        return false;
                    }
                }


                return true;
            });
            $('#ot_mj,#ot_mn').on('change',function(){
                var isChecked = $('#ot_mj,#ot_mn').is(':checked');
                if(isChecked){
                    $('#carm,#orth_chrg').prop('disabled',true);
                }else{
                    $('#carm,#orth_chrg').prop('disabled',false);
                }
            });
            $('#carm,#orth_chrg').on('change',function(){
                var isChecked = $('#carm,#orth_chrg').is(':checked');
                if(isChecked){
                    $('#ot_mj,#ot_mn').prop('disabled',true);
                }else{
                    $('#ot_mj,#ot_mn').prop('disabled',false);
                }
            });
            $('#gen_bed').on('change',function(){
                var isChecked = $('#gen_bed').is(':checked');
                if(isChecked){
                    $('#cb_bed').prop('disabled',true);
                }else{
                    $('#cb_bed').prop('disabled',false);
                }
            });
            $('#cb_bed').on('change',function(){
                var isChecked = $('#cb_bed').is(':checked');
                if(isChecked){
                    $('#gen_bed').prop('disabled',true);
                }else{
                    $('#gen_bed').prop('disabled',false);
                }
            });
            
        </script>