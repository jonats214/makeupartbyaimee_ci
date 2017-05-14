<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 10/08/2016
 * Time: 9:58 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <div class="row">
        <div class="col-md-12"><hr />
            <p class="text-center"><?php echo date("l, j F Y h:i a"); ?></p>
        </div>
    </div>
</div>
</div>
</div>
<script>
    $(document).ready(function(){
        setPageTitle('<?php echo $page_title; ?>');

        $("#menu_<?php echo $content; ?>").addClass("active");
        var parent = $("#menu_<?php echo $content; ?>").closest('[data-toggle]');
        if(parent.length>0){
            parent.addClass("active");
            parent.find("ul").collapse();
        }
    });
</script>
</body>
</html>