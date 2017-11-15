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
            <div class="panel-heading" >Discharge Report</div>
            <div class="panel-body">
                <div class="row">
                        <div class="form-group">
                            <div class="col-md-3 text-right">
                            <label class="control-label">Date Range : </label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="from" name="from" placeholder="From">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="to" name="to" placeholder="To">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary" name="submit">Generate</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div><!-- /.col-->
</div>
<script src="js/bootstrap-table.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript">
    $('#from,#to').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    });
    $(document).on('click', '.btn', function () {
        if($('#to').val() == ""){
            window.open('reports/discharge_report.php?from='+$('#from').val(), '_blank')
        }else{
            window.open('reports/discharge_report.php?from='+$('#from').val()+'&to='+$('#to').val(), '_blank')
        }
        
    });
</script>