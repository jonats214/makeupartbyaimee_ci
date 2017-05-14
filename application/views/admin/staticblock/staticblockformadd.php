<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 18/09/2016
 * Time: 8:52 PM
 */
/** @var Staticblock_model $dbblock */

defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="panel panel-default">
    <div class="panel-body">
        <div id="alerterror" class="alert alert-danger alert-dismissible" role="alert" style="display:none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            Content cannot be blank!
        </div>
        <?php echo form_open($formaction,array("id"=>"cmsblock"));

        $errormsg = validation_errors();
        if ( strlen($errormsg)>0 ) : ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <?php echo $errormsg; ?>
        </div>
        <?php elseif ( strlen($dberrmsg)>0 ) : ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <?php echo $errormsg; ?>
        </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="cmsblocktitle">Block Title</label>
            <input type="text" class="form-control" id="cmsblocktitle" name="cmsblocktitle" placeholder="Title" maxlength="100" required value="<?php echo set_value('cmsblocktitle'); ?>">
        </div>
        <div class="form-group">
            <label for="cmsblockdescr">Short Description</label>
            <input type="text" class="form-control" id="cmsblockdescr" name="cmsblockdescr" placeholder="ex. purpose of this block" maxlength="255" value="<?php echo set_value('cmsblockdescr'); ?>">
        </div>
        <div class="form-group">
            <label for="cmsblockactive">Is Active</label>
            <select class="form-control" id="cmsblockactive" name="cmsblockactive">
                <option value="1"  <?php echo  set_select('cmsblockactive', '1', TRUE); ?> >Yes</option>
                <option value="0"  <?php echo  set_select('cmsblockactive', '0'); ?> >No</option>
            </select>
        </div>
            <div class="form-group">
                <label for="cmsblockcontent">Content</label>
                <input type="hidden" name="cmsblockcontent" id="cmsblockcontent" value=""/>
                <div class="summernote"><?php echo $html; ?></div>
            <div>
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-default" id="btncancel">Cancel</button>
        <?php echo form_close(); ?>
    </div>
</div>
<script src="<?php echo base_url("js/summernote.min.js"); ?>"></script>
<script>
$(document).ready(function(){
    $('.summernote').summernote({height:300,focus:true});
    $('#cmsblock').submit(function(event){
        var html = $('.summernote').summernote('code');
        if(html.length==0){
            $('#alerterror').show();
            event.preventDefault();
        }
        else{
            $('#alerterror').hide();
            $("#cmsblockcontent").val(html);
        }
    });
    $("#btncancel").click(function(){
        window.location.href="<?php echo base_url("myadmin/staticblock/index"); ?>";
    });
});
</script>