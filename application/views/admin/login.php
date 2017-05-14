<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 1/08/2016
 * Time: 9:57 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <?php echo form_open('myadmin/login', array("class"=>"form-signin")); ?>
        <p><img src="<?php echo base_url("images/logo.png"); ?>" alt="<?php echo $site_brand; ?>" class="img img-responsive"/></p><br />
        <h4><?php echo $site_brand; ?> Admin Login</h4>

        <?php $errormsg = $this->session->flashdata( 'login_error' );
        $fpmsg = $this->session->flashdata( 'forgotpwd_msg' );
        if( $errormsg === FALSE )
        {
            $errormsg = validation_errors();
        }

        if ( $errormsg ) :
            ?>
        <p class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <?php echo htmlspecialchars($errormsg); ?>
        </p>
        <?php elseif(strlen($fpmsg)>0): ?>
        <p class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <?php echo htmlspecialchars($fpmsg); ?>
        </p>
        <?php endif; ?>

        <label for="username" class="sr-only">Username</label>
        <input type="text" id="username" name="username" class="form-control" placeholder="Username" maxlength="50" required autofocus value="<?php echo set_value('username'); ?>">
        <label for="userpwd" class="sr-only">Password</label>
        <input type="password" id="userpwd" name="userpwd" class="form-control" placeholder="Password" maxlength="50" required value="<?php echo set_value('userpwd'); ?>" >

        <div class="checkbox pull-left">
            <label>
                <input type="checkbox" id="userremember" name="userremember" value="1" <?php echo set_checkbox('userremember', '1'); ?> > Remember me
            </label>
        </div>
        <div class="pull-right" style="line-height:40px;">
            <a href="<?php echo base_url(); ?>myadmin/forgotpwd">Forgot your password?</a>
        </div>
        <div class="clearfix"></div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="btnsubmit" id="btnsubmit"><i class="fa fa-sign-in" aria-hidden="true"></i> Sign in</button>
    <?php echo form_close(); ?>
    <br />
</div>