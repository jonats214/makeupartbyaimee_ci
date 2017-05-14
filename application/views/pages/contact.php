<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 1/08/2016
 * Time: 10:20 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h1>Aimee Bulaong</h1>
            <div class="divspacer"></div>
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">
                            <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                        </p>
                    </div>
                </div>
            </form>
            <small class="text-muted">Please indicate your name and then state your purpose. Also state your contact details for me to get back to you. Thank you.</small>
            <p></p>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2>Contact Me</h2>
                    <div class="divspacer"></div>
                    <form>
                        <div class="form-group">
                            <label for="contact_name">Name</label>
                            <input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="Your name">
                        </div>
                        <div class="form-group">
                            <label for="conact_email">Email</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email" placeholder="Your email">
                        </div>
                        <div class="form-group">
                            <label for="contact_phone">Contact Number</label>
                            <input type="text" class="form-control" id="contact_phone" name="contact_phone" placeholder="Your best contact number">
                        </div>
                        <div class="form-grooup">
                            <label for="contact_msg">Message</label>
                            <textarea class="form-control" name="contact_msg" id="contact_msg" rows="4"></textarea>
                        </div><br />
                        <button type="submit" class="btn btn-primary" id="btnsubmit" name="btnsubmit"><i class="fa fa-envelope-o" aria-hidden="true"></i> SEND MESSAGE</button>
                    </form>
                </div>
            </div>





        </div>
    </div>
</div>
<div class="divspacer"></div>