<?php 
	$allow = array(1,2,3);
	if(!in_array($_SESSION['type'], $allow)){
		echo "<script>alert('You are not allowed to access this page.');</script>";
		echo "<script>window.location = '/index.php?pg=home'</script>";
	}
?>
<div class="row" >
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-body">
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
                <div class="row">
                    <div class="pull-right" style="padding-right: 10px">
                        <!--<input type="text" id="doc_name" class="form-control">
                        <button type="button" class="btn btn-default btn-sm" id="reFresh">
                          <span class="glyphicon glyphicon-filter"></span> Filter By Doctor
                        </button>-->
                        <div class="input-group">
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="refreshTable"><span class="glyphicon glyphicon-refresh"></span></button>
                          </span>
                          <input id="doc_name" placeholder="Doctor Name" class="form-control" type="textbox">
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="reFresh"><span class="glyphicon glyphicon-search"></span> Search</button>
                          </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    &nbsp;
                </div>
                <table id="table" data-toggle="table" data-url="action.php?action=patient_list" data-search="true" data-pagination="true">       
                    <!--<table id="table" data-toggle="table" data-url="action.php?action=patient_list" data-pagination="true">-->
                    <thead>
                        <tr>
                            <th data-field="reg_no" data-halign="center" data-align="center">Reg. No.</th>
                            <th data-field="name" data-halign="center" data-align="center">Name</th>
                            <th data-field="sex" data-halign="center" data-align="center">Sex</th>
                            <th data-field="age" data-halign="center" data-align="center">Age</th>
                            <th data-field="contact_no_1" data-halign="center" data-align="center">Contact No</th>
                            <th data-field="bed_no" data-halign="center" data-align="center">Bed No</th>
                            <th data-field="doc_name" data-halign="center" data-align="center">Doctor</th>
                            <th data-field="admit_time" data-halign="center" data-align="center">Admit On</th>
                            <th data-field="doc_ref" data-halign="center" data-align="center">Admit<br/>Type</th>
                            <th data-field="tot_chrg" data-halign="center" data-align="center">Total<br/>Charge</th>
                            <th data-field="status" data-halign="center" data-align="center" data-formatter="statusFormatter">Action</th>
                        </tr>
                    </thead>
                    <script>
                        function statusFormatter(value, row) {
                            var status = 'Print';
                            var data = row.id;
                            var btn = 'btn-success';
                            return '<i data="' + data + '" class="status_checks btn ' + btn + '" style="width:60px" id="bct">' + status + '</i>' +
                                    '&nbsp;&nbsp;<i data="' + data + '" class="status_delete btn btn-danger" style="width:60px" id="bct">Delete</i>';
                        }
                    </script>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".bg-success,.bg-danger").delay(5000).fadeOut();
        $.ajax({url: "action.php?action=del_session", success: function (result) {
            }});
    });
    $(document).on('click', '.status_checks', function () {
        var current_element = $(this);
        var data = $(current_element).attr('data');
        window.open('reports/admission_form.php?reg_no=' + data, '_blank')
    });
    $(document).on('click', '.status_delete', function () {
        var current_element = $(this);
        var data_val = $(current_element).attr('data');
        if (confirm("Are you sure to delete this record ?")) {
            $.ajax({method: "POST", url: "action.php?action=del_adm", data: {id: data_val}, success: function (result) {
                window.location.href = 'index.php?pg=admission_form';
            }});
        }
    });
    $('#reFresh').click(function(){
            //alert($('#table').data('url'));
            //alert($('#doc_name').val());
            var uri = "";
            if($('#doc_name').val() == ""){
                uri = 'action.php?action=patient_list';
            }else{
                uri = 'action.php?action=patient_list&dName=' + $('#doc_name').val();
            }
            $("#table").bootstrapTable('refresh', {
                url: uri
            });
    });
    $('#refreshTable').click(function(){
        $("#table").bootstrapTable('refresh', {
                url: 'action.php?action=patient_list'
            });
        $('#doc_name').val("");
    });
</script>





