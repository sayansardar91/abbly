<?php
if (isset($_GET['act'])) {
    $user = new UserClass();
    $user->doLogout();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $page_title; ?></title>
        <title><?php echo $page_title; ?> | <?php echo APP_Name; ?></title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/datepicker3.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet">
        <link href="css/font-awesome.css" rel="stylesheet">
        <link href="css/bootstrap-table.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" type="image/ico" href="<?php echo FAV_ICON ?>">

        <script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-datepicker.js"></script>
        <script src="js/jquery.form-validator.min.js"></script>
        <script src="js/bootstrap-table.js"></script>
        <script src="extensions/export/bootstrap-table-export.js"></script> 



        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->



    </head>

    <body onload="startTime()">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">

                    <a class="navbar-brand" href="#"><span><?php echo APP_Name; ?></span>
                    </a>
                    <ul class="user-menu">
                        <li class="pull-left"><span id="txt" style="color: #ffffff;margin-right: 15px;font-weight: bold"></span></li>
                        <li class="dropdown pull-right">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo $user_name; ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="?act=logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div><!-- /.container-fluid -->
        </nav>



        <?php
        // put your code here
        include($side_bar);
        ?>

        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
                    <li class="parent"><?php echo $log_segment; ?> Dashboard</li>
                    <li class="active"><?php echo $page_title; ?></li>
                </ol>

            </div><!--/.row-->

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $page_title; ?></h1>
                </div>
            </div><!--/.row-->



            <?php
            // put your code here
            include($page_content);
            ?>							
            <!--/.row-->
            <div class="row">
                    	<div class="col-md-12">
                    		<div class="panel panel-default">
            					<div class="panel-footer text-right" >Terms & Conditions: © 2015-<?=date('Y') ?> ABLY Technology and Training Center. All rights reserved.</div></div></div>
                        </div>
                    </div>
        </div>	<!--/.main-->


        <script>

            !function ($) {
                $(document).on("click", "ul.nav li.parent > a > span.icon", function () {
                    $(this).find('em:first').toggleClass("glyphicon-minus");
                });
                $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
            }(window.jQuery);

            $(window).on('resize', function () {
                if ($(window).width() > 768)
                    $('#sidebar-collapse').collapse('show')
            })
            $(window).on('resize', function () {
                if ($(window).width() <= 767)
                    $('#sidebar-collapse').collapse('hide')
            })
        </script>	
        <script>
            function hidestatus() {
                window.status = ''
                return true
            }

            if (document.layers)
                document.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT)

            document.onmouseover = hidestatus
            document.onmouseout = hidestatus
        </script>
        <script>
            function startTime() {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                var d = today.toDateString();
                var ap = "AM";
                if (h > 11) {
                    ap = "PM";
                }
                if (h > 12) {
                    h = h - 12;
                }
                if (h == 0) {
                    h = 12;
                }
                m = checkTime(m);
                s = checkTime(s);
                document.getElementById('txt').innerHTML = d + " " + h + ":" + m + ":" + s + " " + ap;
                var t = setTimeout(function () {
                    startTime()
                }, 500);
            }

            function checkTime(i) {
                if (i < 10) {
                    i = "0" + i
                }
                ;  // add zero in front of numbers < 10
                return i;
            }
            $('#reset').on('click',function(){
                window.location.reload();
            });
        </script>
    <script>
		$(function(){
		  $('li.parent').hide()
		});
        var idleTime = 0;
        function isInactive(){
         idleTime++;
         if(idleTime > 29){
              var msg= "You are in idle mode for 30 minutes. So, system has logged you out automactically.";
              var temp= (window.confirm(msg)) ? 'index.php?act=logout' : null;
              if (temp) window.location.href= temp;
         }
        }
        
        $(document).ready(function () {
        //Increment the idle time counter every minute.
        setInterval("isInactive()", 60000);
        
        $(this).mousemove(function (e) {
            idleTime = 0;
        });
        $(this).keypress(function (e) {
            idleTime = 0;
        });
    });
	</script>
 </body>

</html>
