<?php 
	$allow = array(1,2);
	if(!in_array($_SESSION['type'], $allow)){
		echo "<script>alert('You are not allowed to access this page.');</script>";
		echo "<script>window.location = '/index.php?pg=home'</script>";
	}
?>
<div class="row" >
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" >Add New Employee Type</div>
            <div class="panel-body">
                <div class="row">
                    <form class="form-horizontal" role="form" action="action.php?action=add_dept" method="post">
                        <input type="hidden" id="dept_group" name="dept_group" value="1" />
                        <div class="form-group">
                            <label for="inputType" class="col-sm-2 control-label">Type Title</label>
                            <div class="col-sm-4">
                                <input type="text" required class="form-control" id="dept_name" name="dept_name" placeholder="Input Department Name">
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary" name="submit">Add Type</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row"><hr></div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Employee Types</div>
                            <div class="panel-body">
                                <table id="table" data-toggle="table" data-url="action.php?action=get_empdpt"  
                                       data-pagination="true" data-sort-name="name" data-sort-order="desc">
                                    <thead>
                                        <tr>
                                            <th data-field="sno" data-halign="center" data-align="center">S/No.</th>
                                            <th data-field="dept_name" data-halign="center" data-align="center" >Department Name</th>
                                            <th data-field="status" data-halign="center" data-align="center" data-formatter="statusFormatter">Status</th>
                                        </tr>
                                    </thead>
                                </table>
                                <script>
                                    function statusFormatter(value, row) {
                                        var status = value === "1" ? 'Active ' : 'Inactive';
                                        var data = row.id;
                                        var btn = value === "1" ? 'btn-success' : 'btn-danger';

                                        return '<i data="' + data + '" class="status_checks btn ' + btn + '" style="width:75px" id="bct">' + status + '</i>' +
                                    '&nbsp;&nbsp;&nbsp;&nbsp;<i data="' + data + '" class="status_delete btn btn-danger" style="width:75px" id="bct">Delete</i>';
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.col-->
</div>
<script src="js/bootstrap-table.js"></script>
<script type="text/javascript">
    $(document).on('click', '.status_checks', function () {
        var status = ($(this).hasClass("btn-success")) ? '0' : '1';
        var msg = (status == '0') ? 'Deactivate' : 'Activate';
        if (confirm("Are you sure to " + msg)) {
            var current_element = $(this);
            url = "action.php?action=actv";
            $.ajax({
                type: "POST",
                url: url,
                data: {id: $(current_element).attr('data'), status: status},
                success: function (data)
                {
                    //location.reload();
                    window.location.href = 'index.php?pg=emp_department';
                }
            });
        }
    });
    $(document).on('click', '.status_delete', function () {
        var current_element = $(this);
        var data_val = $(current_element).attr('data');
        if (confirm("Are you sure to delete this record ?")) {
            $.ajax({method: "POST", url: "action.php?action=del_dept", data: {id: data_val}, success: function (result) {
                    window.location.href = 'index.php?pg=emp_department';
                }});
        }
    });
</script>