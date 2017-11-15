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
            <div class="panel-heading" >
              <p>New Account Type</p>
            </div>
            <div class="panel-body">
                <div class="row">
                    <form class="form-horizontal" role="form" action="action.php?action=add_acttype" method="post">
                    	<input type="hidden" name="id" id="id" value=""/>
                        <div class="form-group">
                           <label for="inputType" class="col-sm-2 control-label">Account Type</label>
                           <div class="col-sm-3">
                               <input type="text" class="form-control" id="accounts_name" name="accounts_name" placeholder="Accounts Type">
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row"><hr></div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Accountss List</div>
                            <div class="panel-body">
                                <table id="table" data-toggle="table" data-url="action.php?action=get_accttype"  
                                       data-pagination="true" data-sort-name="name" data-sort-order="desc">
                                    <thead>
                                        <tr>
                                            <th data-field="id" data-halign="center" data-align="center">S/No</th>
                                            <th data-field="accounts_name" data-halign="center" data-align="center" >Accounts Name</th>
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
                                    '&nbsp;&nbsp;&nbsp;&nbsp;<i data="' + data + '" class="edit_type btn btn-warning" style="width:75px" id="bct">Edit</i>&nbsp;&nbsp;&nbsp;&nbsp;<i data="' + data + '" class="status_delete btn btn-danger" style="width:75px" id="bct">Delete</i>';
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
<script src="js/jquery-ui.js"></script>
<script src="js/bootstrap-table.js"></script>
<script type="text/javascript">
    $(document).on('click', '.status_checks', function () {
        var status = ($(this).hasClass("btn-success")) ? '0' : '1';
        var msg = (status == '0') ? 'Deactivate' : 'Activate';
        if (confirm("Are you sure to " + msg)) {
            var current_element = $(this);
            url = "action.php?action=prov_actv";
            $.ajax({
                type: "POST",
                url: url,
                data: {id: $(current_element).attr('data'), status: status},
                success: function (data)
                {
                    //location.reload();
                    window.location.href = 'index.php?pg=provisional';
                }
            });
        }
    });
    $(document).on('click', '.status_delete', function () {
        var current_element = $(this);
        var data_val = $(current_element).attr('data');
        if (confirm("Are you sure to delete this record ?")) {
            $.ajax({method: "POST", url: "action.php?action=del_dig", data: {id: data_val}, success: function (result) {
                    window.location.href = 'index.php?pg=provisional';
                }});
        }
    });
    
    $(document).on('click', '.edit_type', function () {
        var current_element = $(this);
        var data_val = $(current_element).attr('data');
        $.post("action.php?action=get_actname",{ id : data_val }, function (data) {
		   data = $.parseJSON(data);
           $.each(data,function(ind,val){
			   $.each(val, function(i,v){
				   $('#' + i).val(v);
			   });
			});
        });
    });
	 
	$(function (event) {
        $("#diog_name").autocomplete({
            source: 'action.php?action=diog_name'
        });
    });
	$('#diog_name').on('blur', function () {
        $.getJSON("action.php?action=get_diog&diog_name=" + $('#diog_name').val(), function (data) {
            $.each(data, function (i, value) {
                    $('#' + i).val(value);
            });
        });
    });
</script>