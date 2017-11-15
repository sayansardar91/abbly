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
                <table id="table" data-toggle="table" data-url="action.php?action=doc_atnd"  
                       data-pagination="true" data-sort-name="name" data-sort-order="desc" data-search="true" data-show-refresh="true">
                    <thead>
                        <tr>
                            <th data-field="dept_name" data-halign="center" data-align="center">Department</th>
                            <th data-field="doc_name" data-halign="center" data-align="center">Dr. Name</th>
                            <th data-field="date" data-halign="center" data-align="center">Attending Date</th>
                            <th data-field="in_time" data-halign="center" data-align="center">In Time</th>
                            <th data-field="out_time" data-halign="center" data-align="center">Out Time</th>
                            <th data-field="status" data-halign="center" data-align="center" data-formatter="statusFormatter">Attendance</th>
                        </tr>
                    </thead>
                    <script>
                        function statusFormatter(value, row) {
                            var status = value === "1" ? 'In ' : 'Out';
                            var data = row.id;
                            var btn = value === "1" ? 'btn-success' : 'btn-danger';

                            return '<i data="' + data + '" class="status_checks btn ' + btn + '" style="width:75px" id="bct">' + status + '</i>';
                        }
                    </script>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.status_checks', function () {
        var status = ($(this).hasClass("btn-success")) ? '0' : '1';
        var msg = (status == '0') ? 'Out' : 'In';
        if (confirm("Are you confirm that the doctor is " + msg+" ?")) {
            var current_element = $(this);
            url = "action.php?action=doc_ats";
            $.ajax({
                type: "POST",
                url: url,
                data: {id: $(current_element).attr('data'), status: status},
                success: function (data)
                {
                    //location.reload();
                    window.location.href = 'index.php?pg=docattend';
                }
            });
        }
    });
</script>