<?php 
	$allow = array(1,2);
	if(!in_array($_SESSION['type'], $allow)){
		echo "<script>alert('You are not allowed to access this page.');</script>";
		echo "<script>window.location = '/index.php?pg=home'</script>";
	}
?>
<div class="row" >
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-body">
            <!--<table id="table" data-toggle="table" data-url="action.php?action=get_bd"  
                   data-pagination="true" data-sort-name="name" data-sort-order="desc">-->
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
                    <div class="col-md-4">
                        <label class="control-label"><h2>All Sisters</h2></label>
                    </div>
                </div>
                <table id="table" data-toggle="table" data-url="action.php?action=sister_list"  
                       data-pagination="true" data-sort-name="name" data-sort-order="desc" data-search="true" data-show-refresh="true">
                    <thead>
                        <tr>
                            <th data-field="emp_id" data-halign="center" data-align="center">Emp. ID</th>
                            <th data-field="emp_name" data-halign="center" data-align="center">Sister Name</th>
                            <th data-field="emp_homephn" data-halign="center" data-align="center">Personal Contact</th>
                            <th data-field="emp_workphn" data-halign="center" data-align="center">Work Contact</th>
                            <th data-field="emp_qualification" data-halign="center" data-align="center">Qualification</th>
                            <th data-field="emp_doj" data-halign="center" data-align="center">Date Of Joining</th>
                            <th data-field="status" data-halign="center" data-align="center" data-formatter="statusFormatterSister">Status</th>
                        </tr>
                    </thead>
                    <script>
                        function statusFormatterSister(value, row) {
                            var status = value === "1" ? 'Active ' : 'Inactive';
                            var data = row.id;
                            var btn = value === "1" ? 'btn-success' : 'btn-danger';

                            return '<i data="' + data + '" class="status_delete btn btn-danger" style="width:75px" id="bct">Delete</i>';
                        }
                    </script>
                </table>
                
                <div class="row"><hr></div>
                
                <div class="row">
                    <div class="col-md-4">
                        <label class="control-label"><h2>All Employees</h2></label>
                    </div>
                </div>
                <table id="table" data-toggle="table" data-url="action.php?action=emp_list"  
                       data-pagination="true" data-sort-name="name" data-sort-order="desc" data-search="true" data-show-refresh="true">
                    <thead>
                        <tr>
                            <th data-field="emp_id" data-halign="center" data-align="center">Emp. ID</th>
                            <th data-field="emp_name" data-halign="center" data-align="center">Employee Name</th>
                            <th data-field="emp_homephn" data-halign="center" data-align="center">Personal Contact</th>
                            <th data-field="emp_workphn" data-halign="center" data-align="center">Work Contact</th>
                            <th data-field="emp_qualification" data-halign="center" data-align="center">Qualification</th>
                            <th data-field="emp_doj" data-halign="center" data-align="center">Date Of Joining</th>
                            <th data-field="status" data-halign="center" data-align="center" data-formatter="statusFormatterSister">Status</th>
                        </tr>
                    </thead>
                    <script>
                        function statusFormatter(value, row) {
                            var status = value === "1" ? 'Active ' : 'Inactive';
                            var data = row.id;
                            var btn = value === "1" ? 'btn-success' : 'btn-danger';

                            return '<i data="' + data + '" class="status_checks btn ' + btn + '" style="width:75px" id="bct">' + status + '</i>' +
                                    '&nbsp;&nbsp;&nbsp;&nbsp;<i data="' + data + '" class="status_delete btn btn-danger" style="width:75px" id="bct">Delete</i>';
                        }
                    </script>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        //$('.bg-success,.bg-danger').hide();
        $.getJSON("action.php?action=get_dpt", function (data) {
            $('#dept_id').append(
                    $('<option></option>').val("").html("Select Department"));
            $.each(data, function (index) {
                $('#dept_id').append(
                        $('<option></option>').val(data[index].id).html(data[index].dept_name));
            });
        });
        $(".bg-success,.bg-danger").delay(5000).fadeOut();
        $.ajax({url: "action.php?action=del_session", success: function (result) {
            }});
    });
    $(document).on('click', '.status_checks', function () {
        var status = ($(this).hasClass("btn-success")) ? '0' : '1';
        var msg = (status == '0') ? 'Deactivate' : 'Activate';
        if (confirm("Are you sure to " + msg)) {
            var current_element = $(this);
            url = "action.php?action=doc_actv";
            $.ajax({
                type: "POST",
                url: url,
                data: {id: $(current_element).attr('data'), status: status},
                success: function (data)
                {
                    //location.reload();
                    window.location.href = 'index.php?pg=employeelist';
                }
            });
        }
    });
    $(document).on('click', '.status_delete', function () {
        var current_element = $(this);
        var data_val = $(current_element).attr('data');
        if (confirm("Are you sure to delete this record ?")) {
            $.ajax({method: "POST", url: "action.php?action=del_emp", data: {id: data_val}, success: function (result) {
                    window.location.href = 'index.php?pg=employeelist';
                }});
        }
    });
</script>





