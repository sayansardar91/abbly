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
            <div class="panel-heading" >Admission Report</div>
            <div class="panel-body">
                <form class="form-horizontal" id="doct_form" action="reports/admission_report.php" method="post" target="_blank">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-sm-5">
                                <div class="form-group text-center">
                                    <label class="control-label">Report By Date : </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" name="date_daily" id="date_daily" class="form-control" placeholder="Enter a Date"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-sm-3">
                                <div class="form-group text-center">
                                    <label class="control-label">Date Range : </label>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <input type="text" name="date_from" id="date_from" class="form-control" placeholder="From"/>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group text-center">
                                        <label class="control-label">to</label>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <input type="text" name="date_to" id="date_to" class="form-control" placeholder="To"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<!--                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-sm-5">
                                <div class="form-group text-center">
                                    <label class="control-label">Report By Month : </label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" name="exp_month" id="exp_month" class="form-control" placeholder="Enter a Month"/>
                                    (Exp. JAN,FEB,....etc)
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-sm-6">
                                <div class="form-group text-center">
                                    <label class="control-label">Report By Financial Year : </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" name="exp_year" id="exp_year" class="form-control" placeholder="Enter a Year"/>
                                    (Exp. 2015-16)
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <div class="row">&nbsp;</div>
                    <div class="row">
                        <div class="col-md-6 text-right">
                            <button type="submit" class="btn btn-primary" name="submit">Generate</button>
                        </div>
                        <div class="col-md-6">
                            <button type="reset" id="reset" class="btn btn-default">Reset</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div><!-- /.col-->
</div>
<script src="js/bootstrap-table.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.maskedinput.min.js"></script>
<script type="text/javascript">
    $("#date_daily,#date_from,#date_to").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    });
    jQuery(function ($) {
        //$("#product").mask("99/99/9999", {placeholder: " "});
        $("#date_daily,#date_from,#date_to").mask("9999-99-99");
        $("#exp_month").mask("aaa");
        $("#exp_year").mask("9999-99");
    });
</script>