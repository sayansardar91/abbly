<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $page_title; ?> | <?php echo APP_Name; ?></title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet">
        <link rel="icon" type="image/ico" href="<?php echo FAV_ICON ?>">

        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
        <script src="js/jquery-1.11.1.min.js"></script>
    </head>

    <body>
        <!--<div class="vertical-center">-->
            <?php
            // put your code here
            include($page_content);
            ?>
        <!--</div>-->
        
        <script src="js/bootstrap.min.js"></script>
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
    </body>

</html>
