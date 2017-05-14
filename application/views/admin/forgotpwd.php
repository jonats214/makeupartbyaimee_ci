<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 11/08/2016
 * Time: 9:36 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="container">
    <?php echo form_open('myadmin/forgotpwd', array("class"=>"form-signin")); ?>
        <p><img src="<?php echo base_url("images/logo.png"); ?>" alt="<?php echo $site_brand; ?>" class="img img-responsive"/></p><br />
    <h4>Forgot Password</h4>
        <?php
        $error_msg = $this->session->flashdata( 'forgotpwd_error' );
        $success_msg = $this->session->flashdata( 'forgotpwd_success' );

        if($error_msg!=""): ?>
        <p class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <?php echo $error_msg; ?>
        </p>
        <?php endif; ?>
        <div class="form-group">
            <label for="useremail" class="sr-only">Email address</label>
            <input type="email" class="form-control" id="useremail" name="useremail" placeholder="Email Address" value="<?php echo set_value('useremail'); ?>" maxlength="100" required autofocus>
            <p class="help-block">Only registered email addresses will be processed.</p>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="btnsubmit" id="btnsubmit"><i class="fa fa-envelope-o" aria-hidden="true"></i> Retrieve Password</button>
    <?php echo form_close(); ?>
    <br />
    <p class="text-center"><a href="<?php echo base_url(); ?>myadmin/login"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to sign in</a></p>
</div>