<div class="row">
                <div class="col-xs-12 col-md-6 col-lg-3">
                    <div class="panel panel-blue panel-widget ">
                        <div class="row no-padding">
                            <div class="col-sm-3 col-lg-5 widget-left">
                                <em class="glyphicon glyphicon-plus glyphicon-l"></em>
                            </div>
                            <div class="col-sm-9 col-lg-7 widget-right">
                                <div class="large"><a href="?pg=admission" style="color:#5f6468">Patients</a></div>
                                <div class="text-muted"><a href="?pg=admission" style="color:#9fadbb">Admit Patients</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-3">
                    <div class="panel panel-red panel-widget">
                        <div class="row no-padding">
                            <div class="col-sm-3 col-lg-5 widget-left">
                                <em class="fa fa-inr fa-align-center fa-4x"></em>
                            </div>
                            <div class="col-sm-9 col-lg-7 widget-right">
                                <div class="large"><a href="?pg=payment" style="color:#5f6468">Payment</a></div>
                                <div class="text-muted">Make Payments</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-3">
                    <div class="panel panel-teal panel-widget">
                        <div class="row no-padding">
                            <div class="col-sm-3 col-lg-5 widget-left">
                                <em class="fa fa-bed fa-align-center fa-4x"></em>
                            </div>
                            <div class="col-sm-9 col-lg-7 widget-right">
                                <div class="large"><a href="?pg=bed_status" style="color:#5f6468">Availibility</a></div>
                                <div class="text-muted">Bed Status</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-3">
                    <div class="panel panel-orange panel-widget">
                        <div class="row no-padding">
                            <div class="col-sm-3 col-lg-5 widget-left">
                                <em class="fa fa-user-md fa-align-center fa-4x"></em>
                            </div>
                            <div class="col-sm-9 col-lg-7 widget-right">
                                <div class="large"><a href="?pg=docattend" style="color:#5f6468">Doctors</a></div>
                                <div class="text-muted">Doctor Status</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/.row-->
<div class="row">
    <div class="col-md-8">

        <div class="panel panel-default chat">
            <div class="panel-heading" id="accordion"><span class="glyphicon glyphicon-tasks"></span> Current Events</div>
            <div class="panel-body" id="notification">
            </div>

            <div class="panel-footer">
                
            </div>
        </div>

    </div><!--/.col-->

    <div class="col-md-4">

        <div class="panel panel-red">
            <div class="panel-heading dark-overlay"><span class="glyphicon glyphicon-calendar"></span>Calendar</div>
            <div class="panel-body">
                <div id="calendar"></div>
            </div>
        </div>

    </div><!--/.col-->
</div>
<script>
	 $('#calendar').datepicker({});
</script>
<script>
    $(document).ready(function () {
        var html;
        $.getJSON("action.php?action=get_wordpad", function (data) {
            $.each(data, function (index) {
                if (data[index].id === '1') {
                    $('#notification').html(data[index].file_content);
                }
            });
        });
    });
</script>