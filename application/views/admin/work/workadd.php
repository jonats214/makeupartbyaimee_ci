<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 10/10/2016
 * Time: 10:11 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="panel panel-default">
<div class="panel-body">
<div id="alerterror" class="alert alert-danger alert-dismissible" role="alert" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
    Content cannot be blank!
</div>
<?php echo form_open($formaction,array("id"=>"formarticle"));

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
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#articledetails">Details</a></li>
    <li><a data-toggle="tab" href="#articlecontent">Content</a></li>
    <li><a data-toggle="tab" href="#articlegallery">Gallery</a></li>
</ul><p></p>
<div class="row">
    <div class="col col-md-12">
        <div class="tab-content">
            <div id="articledetails" class="tab-pane fade in active">
                <div class="form-group">
                    <label for="articletitle">Title</label>
                    <input type="text" class="form-control" id="articletitle" name="articletitle" placeholder="Title" maxlength="100" required value="<?php echo set_value('articletitle'); ?>">
                </div>
                <div class="form-group">
                    <label for="articleshortdescr">Short Description</label>
                    <textarea class="form-control" id="articleshortdescr" name="articleshortdescr" maxlength="255" rows="2"><?php echo set_value('articleshortdescr'); ?></textarea><span class="help-block">Will appear in lists and SEO purposes</span>
                </div>
                <div class="form-group">
                    <label for="articlekeywords">Keywords</label>
                    <input type="text" class="form-control" id="articlekeywords" name="articlekeywords" placeholder="Keywords" maxlength="100" required value="<?php echo set_value('articlekeywords'); ?>">
                </div>
                <div class="form-group">
                    <label for="articleauthor">Author</label>
                    <input type="text" class="form-control" id="articleauthor" name="articleauthor" required value="<?php echo set_value('articleauthor',$default_author); ?>">
                </div>
                <div class="form-group">
                    <label for="articlepublish">Is Published</label>
                    <select class="form-control" id="articlepublish" name="articlepublish">
                        <option value="0"  <?php echo  set_select('articlepublish', '0', TRUE); ?> >No</option>
                        <option value="1"  <?php echo  set_select('articlepublish', '1'); ?> >Yes</option>
                    </select>
                </div>
                <div class="form-group<?php if($this->input->get("articlepublish")==0){echo " hidden";} ?>" id="divpublishdate">
                    <label for="publishdate">Publish Date</label>
                    <input type="text" class="form-control" id="publishdate" name="publishdate" value="<?php echo set_value('publishdate'); ?>">
                </div>
                <div class="form-group">
                    <label for="allow_comments">Allow Comments</label>
                    <select class="form-control" id="allow_comments" name="allow_comments">
                        <option value="1"  <?php echo  set_select('allow_comments', '1', TRUE); ?> >Yes</option>
                        <option value="0"  <?php echo  set_select('allow_comments', '0'); ?> >No</option>
                    </select>
                </div>
            </div>
            <div id="articlecontent" class="tab-pane fade">
                <div class="form-group">
                    <label for="articlecontent">Content</label>
                    <input type="hidden" name="htmlcontent" id="htmlcontent" value=""/>
                    <div class="summernote"><?php echo $html; ?></div>
                </div>
            </div>
            <div id="articlegallery" class="tab-pane fade">
                <div class="form-group">
                    Gallery
                </div>
            </div>
        </div><p></p>
        <div>
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-default" id="btncancel">Cancel</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>


<script src="<?php echo base_url("js/summernote.min.js"); ?>"></script>
<script>
    $(document).ready(function(){
        $('.summernote').summernote({height:300,focus:true});
        $('#formarticle').submit(function(event){
            var html = $('.summernote').summernote('code');
            if(html.length==0){
                $('#alerterror').show();
                event.preventDefault();
            }
            else{
                $('#alerterror').hide();
                $("#htmlcontent").val(html);
            }
        });
        $("#btncancel").click(function(){
            window.location.href="<?php echo base_url("myadmin/works/index"); ?>";
        });
        $("#articlepublish").change(function(){
            var v = $(this).val();
            if(v==1){
                $("div#divpublishdate").removeClass('hidden').slideDown("fast");
            }
            else{
                $("div#divpublishdate").slideUp("fast");
            }
        });
    });
</script>