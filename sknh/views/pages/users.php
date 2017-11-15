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
                <table id="table" data-toggle="table" data-url="action.php?action=user_list"  
                       data-pagination="true" data-sort-name="name" data-sort-order="desc" data-search="true" data-show-refresh="true">
                    <thead>
                        <tr>
                            <th data-field="sno" data-halign="center" data-align="center">S/No.</th>
                            <th data-field="emp_id" data-halign="center" data-align="center">Employee ID</th>
                            <th data-field="user_name" data-halign="center" data-align="center">User Name</th>
                            <th data-field="user_type" data-halign="center" data-align="center">User Type</th>
                            <th data-field="user_passwdstr" data-halign="center" data-align="center">User Password</th>
                            <th data-field="created_on" data-halign="center" data-align="center">Created On</th>
                            <th data-field="status" data-halign="center" data-align="center" data-formatter="statusFormatter">Status</th>
                        </tr>
                    </thead>
                    <script>
                        function statusFormatter(value, row) {
                            var status = value === "1" ? 'Active ' : 'Inactive';
                            var data = row.id;
                            console.log(row.emp_id);
                            var btn = value === "1" ? 'btn-success' : 'btn-danger';
                            var rt;
                            if(row.emp_id === "SP0001"){
                                rt = "N/A";
                            }else{
                                rt = '<i data="' + data + '" class="status_checks btn ' + btn + '" style="width:75px" id="bct">' + status + '</i>';
                            }
                            return rt;
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
        });
    $(document).on('click', '.status_checks', function () {
        var status = ($(this).hasClass("btn-success")) ? '0' : '1';
        var msg = (status == '0') ? 'Deactivate' : 'Activate';
        if (confirm("Are you sure to " + msg)) {
            var current_element = $(this);
            url = "action.php?action=user_actv";
            $.ajax({
                type: "POST",
                url: url,
                data: {id: $(current_element).attr('data'), status: status},
                success: function (data)
                {
                    //location.reload();
                    window.location.href = 'index.php?pg=users';
                }
            });
        }
    });
</script>





