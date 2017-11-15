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
        <!--<table id="table" data-toggle="table" data-url="action.php?action=get_bd"  
               data-pagination="true" data-sort-name="name" data-sort-order="desc">-->
                <table id="table" data-toggle="table" data-url="action.php?action=bill_list"  
                       data-pagination="true" data-search="true" data-show-refresh="true">
                    <thead>
                        <tr>
                            <th data-field="bill_no" data-halign="center" data-align="center">Bill No</th>
                            <th data-field="reg_no" data-halign="center" data-align="center">Registration No</th>
                            <th data-field="total_amount" data-halign="center" data-align="center">Total Amount</th>
                            <th data-field="payble_amount" data-halign="center" data-align="center">Amount Paid</th>
                            <th data-field="payment_date" data-halign="center" data-align="center">Payment Date</th>
                            <th data-field="payment_month" data-halign="center" data-align="center">Payment Month</th>
                            <th data-field="fin_year" data-halign="center" data-align="center">Financial Year</th>
                            <th data-halign="center" data-align="center" data-formatter="statusFormatter">Action</th>
                        </tr>
                    </thead>
                    <script>
                        function statusFormatter(value, row) {
                            var status = 'Print';
                            var data = row.bill_no;
                            var btn = 'btn-success';

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
        $(".bg-success,.bg-danger").delay(5000).fadeOut();
        $.ajax({url: "action.php?action=del_session", success: function (result) {
            }});
    });
    $(document).on('click', '.status_checks', function () {
        var current_element = $(this);
        var data = $(current_element).attr('data');
        window.open('reports/receipt.php?reg_no=' + data, '_blank')
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
</script>





