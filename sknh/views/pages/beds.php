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
            <div class="panel-heading" >Add New Bed Category</div>
            <div class="panel-body">
                <div class="row">
                    <form class="form-horizontal" role="form" action="action.php?action=add_bcat" method="post">
                        <div class="form-group">
                            <label for="inputType" class="col-sm-2 control-label">Bed Type &amp; Details</label>
                            <input type="hidden" id="id" name="id" value=""/>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="bed_type" name="bed_type" placeholder="Input Bed Type">
                            </div>
                            <!--<div class="col-sm-2">
                                <input type="text" class="form-control" id="bed_no" name="bed_no" placeholder="Total Bed Number">
                            </div>-->
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="bed_name" name="bed_name" placeholder="Input Bed Name">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="bed_chrg" name="bed_chrg" placeholder="Input Bed Charge">
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-primary" name="submit">Add Bed Category</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row"><hr></div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Bed Types</div>
                            <div class="panel-body">
                                <div class="CSSTableGenerator" >
                                    <table id="table" data-toggle="table" data-url="action.php?action=get_tp"  
                                           data-pagination="false" data-sort-order="desc">
                                        <thead>
                                            <tr>
                                                <th data-field="sno" data-halign="center" data-align="center">S/No</th>
                                                <th data-field="bed_type" data-halign="center" data-align="center" >Bed Type</th>
                                                <th data-field="bed_no" data-halign="center" data-align="center">Total Bed Numbers</th>
                                                <th data-field="bed_chrg" data-halign="center" data-align="center">Bed Charge</th>
                                                <th data-field="status" data-halign="center" data-align="center" data-formatter="statusFormatterT">Status</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <script>
                                        function statusFormatterT(value, row) {
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

                <div class="row"><hr></div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Bed Details</div>
                            <div class="panel-body">
                                <div class="CSSTableGenerator" >
                                    <table id="table" data-toggle="table" data-url="action.php?action=get_bd"  
                                           data-pagination="false" data-sort-name="name" data-sort-order="desc">
                                        <thead>
                                            <tr>
                                                <th data-field="sno" data-halign="center" data-align="center">S/No</th>
                                                <th data-field="bed_type" data-halign="center" data-align="center">Bed Type</th>
                                                <th data-field="bed_name" data-halign="center" data-align="center">Bed Numbers</th>
                                                <th data-field="status" data-halign="center" data-align="center" data-formatter="statusFormatter">Status</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <script>
                                        function statusFormatter(value, row) {
                                            var status = value === "1" ? 'Active ' : 'Inactive';
                                            var data = row.id;
                                            var btn = value === "1" ? 'btn-success' : 'btn-danger';

                                            return '<i data="' + data + '" class="status_checksbd btn ' + btn + '" style="width:75px" id="bct">' + status + '</i>'+
                                                    '&nbsp;&nbsp;&nbsp;&nbsp;<i data="' + data + '" class="status_deletebd btn btn-danger" style="width:75px" id="bct">Delete</i>';
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.col-->
</div>
<script src="js/jquery-ui.js"></script>
<script src="js/bootstrap-table.js"></script>
<script type="text/javascript">
    $(document).on('click', '.status_checks', function () {
        var status = ($(this).hasClass("btn-success")) ? '0' : '1';
        var msg = (status == '0') ? 'Deactivate' : 'Activate';
        if (confirm("Are you sure to " + msg)) {
            var current_element = $(this);
            url = "action.php?action=bct";
            /*switch ($(current_element).attr('id')) {
                case "bct":
                    url = "action.php?action=bct";
                    break;
                case "bd":
                    url = "action.php?action=bd";
                    break;
            }*/
			console.log(url);
            $.ajax({
                type: "POST",
                url: url,
                data: {id: $(current_element).attr('data'), status: status},
                success: function (data)
                {
                    //location.reload();
                    if (data != " ") {
                        alert(data);
                    } else {
                       window.location.href = 'index.php?pg=beds';
                    }

                }
            });
        }
    });
	$(document).on('click', '.status_checksbd', function () {
        var status = ($(this).hasClass("btn-success")) ? '0' : '1';
        var msg = (status == '0') ? 'Deactivate' : 'Activate';
        if (confirm("Are you sure to " + msg)) {
            var current_element = $(this);
            url = "action.php?action=bd";
			console.log(url);
            $.ajax({
                type: "POST",
                url: url,
                data: {id: $(current_element).attr('data'), status: status},
                success: function (data)
                {
                    //location.reload();
                    if (data != " ") {
                        alert(data);
                    } else {
                       window.location.href = 'index.php?pg=beds';
                    }

                }
            });
        }
    });
    $(document).on('click', '.status_delete', function () {
        var current_element = $(this);
        var data_val = $(current_element).attr('data');
        if (confirm("Are you sure to delete this record ?")) {
            $.ajax({method: "POST", url: "action.php?action=del_dedcg", data: {id: data_val}, success: function (result) {
                    window.location.href = 'index.php?pg=beds';
                }});
        }
    });
	$(document).on('click', '.status_deletebd', function () {
        var current_element = $(this);
        var data_val = $(current_element).attr('data');
        if (confirm("Are you sure to delete this record ?")) {
            $.ajax({method: "POST", url: "action.php?action=del_ded", data: {id: data_val}, success: function (result) {
                    window.location.href = 'index.php?pg=beds';
                }});
        }
    });
    $(function (event) {

        $("#bed_type").autocomplete(
                {
                    source: 'action.php?action=bed_auto&id=bed_type',
                });
    });
    $('#bed_type').on('blur', function () {
        $.getJSON("action.php?action=get_beds&bed_type=" + $('#bed_type').val(), function (data) {
            $.each(data, function (i, value) {
                $('#' + i).val(value);
            });
        });
    });
</script>