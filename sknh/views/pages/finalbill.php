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
            <div class="panel-heading" >Generate Final Bill</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="row">
                        <?php
                        if (isset($_SESSION['success'])) {
                            if ($_SESSION['success']) {
                                if(isset($_SESSION['bill_no'])){
                                  echo "<script type=\"text/javascript\">
                                  window.open('reports/receipt.php?bill_no=".$_SESSION['bill_no']."', '_blank')
                                  </script>";}
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
                    <form  method="post" id="finalbill_form" action="action.php?action=addbill">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-sm-1">&nbsp;</div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Patient ID</label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="reg_no" name="reg_no" />
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" title="Generate" type="button" id="reGen"><span class="glyphicon glyphicon-forward"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Bill No.</label>
                                        <input class="form-control" type="text" id="bill_no" name="bill_no" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Bill Date</label>
                                        <input type="tel" class="form-control" name="bill_date" id="bill_date" required="required"/>
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
                                        <button type="submit" class="btn form-control btn-primary" name="submit">Generate Bill</button>
                                    </div></div>
                                <div class="col-sm-2">&nbsp;</div>
                                <div class="col-sm-2">&nbsp;</div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Final Bill</div>
                                <div class="panel-body">
                                    <table id="table" data-toggle="table" data-url="action.php?action=fbill_list"  
                                           data-pagination="true" data-sort-name="name" data-sort-order="desc" data-search="true" data-show-refresh="true">
                                        <thead>
                                            <tr>
                                                <th data-field="id" data-halign="center" data-align="center">S/No.</th>
                                                <th data-field="bill_no" data-halign="center" data-align="center">Bill No.</th>
                                                <th data-field="patient_id" data-halign="center" data-align="center" >Registration No</th>
                                                <th data-field="patient_name_add" >Patient <br/> Name &amp; Address</th>
                                                <th data-field="admit_time" data-halign="center" data-align="center">Admission <br/> Date &amp; Time</th>
                                                <th data-field="bill_date" data-halign="center" data-align="center" >Bill Date</th>
                                                <th data-halign="center" data-align="center" data-formatter="statusFormatter">Action</th>
                                        <script>
                                            function statusFormatter(value, row) {
                                                var status = 'Print Bill';
                                                var data = row.bill_no;
                                                var btn = 'btn-success';

                                                /*return '<i data="' + data + '" class="status_checks btn ' + btn + '" style="width:75px" id="bct">' + status + '</i>' +
                                                        '&nbsp;&nbsp;&nbsp;&nbsp;<i data="' + data + '" class="status_delete btn btn-danger" style="width:75px" id="bct">Delete</i>';*/
                                                return '<i data="' + data + '" class="status_checks btn ' + btn + '" style="width:75px" id="bct">' + status + '</i>';
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
        
        <script src="js/bootstrap-table.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script type="text/javascript">
            $(function (event) {
                $("#reg_no").autocomplete({
                    source: 'action.php?action=reg_no_fbill',
                });
            });
            $(document).on('click', '#reGen', function () {
                $.ajax({url: "action.php?action=final_bill", success: function (result) {
                        if ($("#bill_no").val() === "") {
                            $("#bill_no").val($.trim(result));
                        }
                    }});
            });
            $( "#finalbill_form" ).submit(function( event ) {
                var reg = $("#reg_no").val();
                var bill = $("#bill_no").val();
                if(jQuery.trim(reg).length <= 0)
                {
                   alert( "Patient ID can't be blank." );
                   $("#reg_no").focus();
                   event.preventDefault();
                }else if(jQuery.trim(bill).length <= 0){
                    alert( "Bill No. can't be blank. Please Generate the Bill No." );
                   $("#reGen").focus();
                   event.preventDefault();
                }
              
            });
            /*$(document).on('click', '#bill_no', function () {
             $.ajax({url: "action.php?action=did", success: function (result) {
             if ($("#bill_no").val() === "") {
             $("#bill_no").val($.trim(result));
             }
             }});
             });*/
            $('#bill_date').datepicker({
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
                window.open('reports/receipt.php?bill_no=' + data, '_blank');
            });
//            $(document).on('click', '.status_delete', function () {
//                var current_element = $(this);
//                var data_val = $(current_element).attr('data');
//                if (confirm("Are you sure to delete this record ?")) {
//                    $.ajax({method: "POST", url: "action.php?action=del_dch", data: {id: data_val}, success: function (result) {
//                            window.location.href = 'index.php?pg=discharge';
//                        }});
//                }
//            });
        </script>