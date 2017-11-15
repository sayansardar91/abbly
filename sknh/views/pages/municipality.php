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
            <div class="panel-heading" >Municipality Report</div>
            <div class="panel-body">
                <form class="form-horizontal" id="doct_form" action="reports/municipality_report.php" method="post" target="_blank">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-sm-5">
                                <div class="form-group text-center">
                                    <label class="control-label">Baby ID From : </label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="baby_idfrom" name="baby_idfrom"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-sm-5">
                                <div class="form-group text-center">
                                    <label class="control-label">Baby ID To : </label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="baby_idto" name="baby_idto"/>
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
<script>
    $(function (event) {
        $("#baby_idfrom").autocomplete({
            source: 'action.php?action=baby_id'
        });
        $("#baby_idto").autocomplete({
            source: 'action.php?action=baby_id'
        });
    });
    
    
</script>