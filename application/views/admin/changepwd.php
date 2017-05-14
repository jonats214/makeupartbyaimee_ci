<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 24/08/2016
 * Time: 8:29 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="panel panel-default">
    <div class="panel-body">
        <?php echo form_open('myadmin/changepwd', array("class"=>"form-horizontal")); ?>
        <?php $succmsg = $this->session->flashdata( 'pwd_success' );
        $errormsg = validation_errors();
        if ( strlen($errormsg)>0 ) :
            ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <?php echo $errormsg; ?>
            </div>
        <?php elseif( strlen($succmsg)>0 ): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <?php echo $succmsg; ?>
            </div>

        <?php endif; ?>
            <div class="form-group">
                <label for="innewpwd" class="col-sm-2 control-label">New Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="innewpwd" name="innewpwd" placeholder="New Password" value="<?php if( strlen($succmsg)==0 ){ echo set_value('innewpwd'); } ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="inconfpwd" class="col-sm-2 control-label">Confirm Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inconfpwd" name="inconfpwd" placeholder="Re-type New Password" value="<?php if( strlen($succmsg)==0 ){ echo set_value('inconfpwd'); } ?>" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
