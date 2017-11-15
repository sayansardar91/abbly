<?php
if (isset($_POST['login'])) {
    $user = new UserClass();
    $suc = $user->doLogin($_POST);
    if ($suc['success']) {
        header("Location: index.php?pg=home");
    } else {
        echo "<script>alert('" . $suc['msg'] . "');</script>";
    }
}
?>

<div class="row">
    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">Welcome to <?php echo APP_Name; ?></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">Please Login With the UserID and Password. Issued By The Authority.</div>
                </div>
                <div class="row">&nbsp;</div>
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
                    <div class="col-md-12">
                        <form role="form" action="" method="post" autocomplete="off">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Employee ID" name="user_name" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <input type="submit" class="btn btn-primary" value="Login" name="login">
                            </fieldset>
                        </form>
                    </div>
                    </div>
                    <div class="row">&nbsp;</div>
                     <div class="row">
                    	<div class="col-md-12">
                    	Terms & Conditions: © 2015-<?=date('Y')?> ABLY Technology and Training Center. All rights reserved.
                        </div>
                    </div>
            </div>
        </div>
    </div><!-- /.col-->
</div><!-- /.row -->
<script>
    $(document).ready(function () {
        $(".bg-success,.bg-danger").delay(5000).fadeOut();
        $.ajax({url: "action.php?action=del_session", success: function (result) {
        }});
    });
</script>
