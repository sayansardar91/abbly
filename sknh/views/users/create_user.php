<div class="row">
    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">Welcome to <?php echo APP_Name; ?></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">Any Super user is not active.</div>
                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-md-12">
                        <form role="form" action="action.php?action=add_user" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <label class="control-label">User Name</label>
                                    <input type="hidden" name="user_type" value="1"/>
                                    <input type="hidden" name="create_type" value="1"/>
                                    <input type="hidden" name="emp_id" value="SP0001"/>
                                    <input type="hidden" name="status" value="1"/>
                                    <input class="form-control" placeholder="User Name" name="emp_name" type="text" autofocus required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">User ID</label>
                                    <input class="form-control" placeholder="User ID" name="user_name" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Password</label>
                                    <input class="form-control" placeholder="Password" name="user_passwd" type="password" value="" required>
                                </div>
                                <input type="submit" class="btn btn-primary" value="Create User" name="create_user">
                            </fieldset>
                        </form>
                    </div></div>
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
