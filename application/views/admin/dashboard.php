<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 22/08/2016
 * Time: 11:18 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<h1>Dashboard</h1>
<div class="row">
    <div class="col-md-12">
        <div class="well well-lg">Welcome back <strong><?php echo $admin->user_name; ?></strong>! Your last log in was <?php echo $last_login; ?>.</div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <i class="fa fa-film" aria-hidden="true"></i> Videos
            </div>
            <div class="text-center panel-body">
                <span class="dashboardcount"><?php echo $video_count; ?></span><br />
                <button role="btn" class="btn btn-primary btn-sm btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Video Article</button>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <i class="fa fa-paint-brush" aria-hidden="true"></i> Works
            </div>
            <div class="text-center panel-body">
                <span class="dashboardcount"><?php echo $work_count; ?></span><br />
                <button role="btn" class="btn btn-primary btn-sm btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Works Article</button>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Blogs
            </div>
            <div class="text-center panel-body">
                <span class="dashboardcount"><?php echo $blog_count; ?></span><br />
                <button role="btn" class="btn btn-primary btn-sm btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Blog Article</button>
            </div>
        </div>
    </div>
</div>
