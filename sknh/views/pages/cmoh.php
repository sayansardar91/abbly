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
            <div class="panel-heading" >C.M.O.H Report</div>
            <div class="panel-body">
                <form class="form-horizontal" id="doct_form" action="reports/cmoh.php" method="post" target="_blank">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-sm-5">
                                <div class="form-group text-center">
                                    <label class="control-label">Report Month : </label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <input type="text" name="cmoh_month" id="cmoh_month" class="form-control" placeholder="Enter a Month"/>
                                    (Exp. JAN,FEB,....etc)
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-sm-5">
                                <div class="form-group text-center">
                                    <label class="control-label">Year : </label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <input type="text" name="cmoh_year" id="cmoh_year" class="form-control" placeholder="Enter a Year"/>
                                    (Exp. 2010,2011,...)
                                </div>
                            </div>
                        </div>
                    </div>
                    
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
//        //$("#product").mask("99/99/9999", {placeholder: " "});
//        $("#date_daily,#date_from,#date_to").mask("9999-99-99");
        $("#cmoh_month").mask("aaa");
        $("#cmoh_year").mask("9999");
    });
</script>