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
            <div class="panel-heading" >IT Report</div>
            <div class="panel-body">
                <form class="form-horizontal" id="doct_form" action="reports/it_report.php" method="post" target="_blank">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-sm-5">
                                <div class="form-group text-center">
                                    <label class="control-label">IT-Report From : </label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" name="exp_from" id="exp_from" class="form-control" placeholder="Enter Date From" required="required"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-sm-3">
                                <div class="form-group text-center">
                                    <label class="control-label">IT-Report To : </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" name="exp_to" id="exp_to" class="form-control" placeholder="Enter Date To" required="required"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row dept_divd">&nbsp;</div>
                   
                    <div class="row">&nbsp;</div>
                    <div class="row">
                        <div class="col-md-6 text-right">
                            <button type="submit" class="btn btn-primary" name="submit">Generate</button>
                        </div>
                        <div class="col-md-6">
                            <button type="reset" id="reset" class="btn btn-default">Reset</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div><!-- /.col-->
</div>
<script src="js/bootstrap-table.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.maskedinput.min.js"></script>
<script type="text/javascript">
    $("#exp_from,#exp_to").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    });
    jQuery(function ($) {
        $("#exp_from").mask("9999-99-99");
        $("#exp_to").mask("9999-99-99");
    });
    
//    $(function () {
//        var html = "";
//        var i = 0;
//        $.getJSON("action.php?action=dpt_list", function (data) {
//
//            $.each(data, function (index) {
//
//                html = '<div class="row r' + i + '">\n\
//                        <div class="col-md-8">\n\
//                            <div class="col-sm-3">\n\
//                                <div class="checkbox">\n\
//                                    <label class="control-label">\n\
//                                        <input type="checkbox" value="' + data[index].id + '" name="dept_id[]" id="dept_id" class="dept_checkbox"> ' + data[index].dept_name + '\n\
//                                    </label>\n\
//                                </div>\n\
//                            </div>\n\
//                        <div class="col-sm-3">\n\
//                            <div class="form-group">\n\
//                                <input type="text" name="iss_no[]" id="iss_no" placeholder="No. Of Issues" style="margin-top: 12px;" disabled="disabled"/>\n\
//                            </div>\n\
//                        </div>\n\
//                        <div class="col-sm-3">\n\
//                            <div class="form-group">\n\
//                                <input type="text" name="mj_ot[]" id="mj_ot" placeholder="Mejor OT Charge" style="margin-top: 12px;" disabled="disabled"/>\n\
//                            </div>\n\
//                        </div>\n\
//                        <div class="col-sm-3">\n\
//                            <div class="form-group">\n\
//                                <input type="text" name="min_ot[]" id="min_ot" placeholder="Minor OT Charge" style="margin-top: 12px;" disabled="disabled"/>\n\
//                            </div>\n\
//                        </div>\n\
//                    </div></div>';
//                if (i === 0) {
//                    $('.dept_divd').after(html);
//                } else {
//                    $('.r' + (i - 1)).after(html);
//                }
//                i++;
//            });
//        });
//        $('.row').on('click','input[type=checkbox]',function () {
//            $(this).closest('.row').find('input[type=text]').prop('disabled', !$(this).is(':checked'));
//        });
//    });
</script>