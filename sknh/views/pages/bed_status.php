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
            <div class="panel-heading" >Bed Status</div>
            <div class="panel-body">
                <div class="col-md-4">
                	<table id="table" data-toggle="table" data-url="action.php?action=get_admdt" >
                        <thead>
                            <tr>
                                <th data-field="sno" data-halign="center" data-align="center">S/No.</th>
                                <th data-field="adm_date" data-halign="center" data-align="center" >Admission Date</th>
                                <th data-field="adm_no" data-halign="center" data-align="center">Admission No.</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-md-4">
                	<table id="table" data-toggle="table" data-url="action.php?action=get_dchrgdt" >
                        <thead>
                            <tr>
                                <th data-field="sno" data-halign="center" data-align="center">S/No.</th>
                                <th data-field="dschrg_date" data-halign="center" data-align="center" >Discharge Date</th>
                                <th data-field="dschrg_no" data-halign="center" data-align="center">Discharge No.</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-md-4">
                	<table id="table" data-toggle="table" data-url="action.php?action=get_beddt" >
                        <thead>
                            <tr>
                                <th data-field="tot_bed" data-halign="center" data-align="center">Total Bed</th>
                                <th data-field="tot_avl" data-halign="center" data-align="center" >Total Available</th>
                                <th data-field="tot_bkd" data-halign="center" data-align="center">Total Booked</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.col-->
</div>
<script src="js/bootstrap-table.js"></script>
