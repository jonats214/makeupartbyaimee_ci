<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 30/10/2016
 * Time: 10:03 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?><footer class="footer">
    <div class="container">
        <p class="text-muted text-center">Version <?php echo $site_version; ?>&nbsp;Designed and Developed by Jonathan Bulaong.&nbsp;
            <i class="fa fa-copyright"></i>2013-<?php echo date("Y"); ?>. All rights reserved.</p>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url("js/bootstrap.min.js"); ?>"></script>
<script src="<?php echo base_url("js/adminscript.1.0.0.js"); ?>"></script>
</body>
</html>