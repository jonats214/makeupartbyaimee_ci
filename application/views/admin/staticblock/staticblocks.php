<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 20/09/2016
 * Time: 9:21 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $succmsg = $this->session->flashdata( 'staticblock_success' );
$warningmsg = $this->session->flashdata( 'staticblock_warning' );
if(strlen($succmsg)>0): ?>
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
    <?php echo $succmsg; ?>
</div>
<?php endif;
if(strlen($warningmsg)>0): ?>
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
    <?php echo $warningmsg; ?>
</div>
<?php endif; ?>
<div class="panel panel-default">
    <div class="panel-body">
        <strong>Found <?php echo $total_results; ?> results</strong>
        <div class="pull-right">
            <button type="button" class="btn btn-primary" id="btnaddblock" name="btnaddblock">Create New Static Block</button>
        </div>
        <div class="clearfix"></div>
    </div>
    <table class="table table-striped table-hover">
        <tr>
            <th style="width:80px">#</th>
            <th>Title</th>
            <th>Description</th>
            <th style="width:100px;">Status</th>
            <th style="width:120px;">Date Created</th>
            <th style="width:120px;">Date Updated</th>
            <th style="width:100px;">Action</th>
        </tr>
        <?php if($total_results==0): ?>
        <tr>
            <td colspan="7" align="center"><p><i>No results found</i></p></td>
        </tr>
        <?php else:
        $count=1;
         foreach($rows as $row):
             $status = $row["is_active"]?"Active":"Inactive";
             $dateCreated= date("j M Y", strtotime($row["date_created"]));
             $dateUpdated= date("j M Y", strtotime($row["date_updated"]))
             ?>
        <tr>
            <td><?php echo $page+$count;?></td>
            <td><?php echo $row['block_title']; ?></td>
            <td><?php echo $row['block_descr']; ?></td>
            <td><?php echo $status; ?></td>
            <td><?php echo $dateCreated; ?></td>
            <td><?php echo $dateUpdated; ?></td>
            <td><button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Static Block" onclick="jQuery(function($){window.location.href='<?php echo $base_url; ?>myadmin/staticblock/edit/<?php echo $row["block_id"]; ?>';})">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </button></td>
        </tr>
        <?php   $count++;
         endforeach;
         endif; ?>
    </table>
</div><!-- PAGINATION -->
<div class="text-center">
    <?php echo $this->pagination->create_links(); ?>
</div>
<script>
$(document).ready(function(){
    $('#btnaddblock').click(function(){
        window.location.href="<?php echo $base_url; ?>myadmin/staticblock/add";
    });
});
</script>
