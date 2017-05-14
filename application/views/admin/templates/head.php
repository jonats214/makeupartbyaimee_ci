<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 10/08/2016
 * Time: 9:58 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MakeupArtByAimee | Home</title>
    <meta name="description" content="Welcome to jbulaong.com" />
    <meta name="keywords" content="Makeup art by Aimee" />
    <meta name="robots" content="index, follow" />
    <link rel="canonical" href="<?php echo base_url(); ?>" />

    <meta property="og:title" content="MakeupArtByAimee | Home">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="images/default.jpg">
    <meta property="og:image:width" content="620" />
    <meta property="og:image:height" content="349" />
    <meta name="og:description" content="Welcome to Makeup Art By Aimee!" />
    <meta property="og:site_name" content="MakeUpArtByAimee.com">
    <meta property="fb:app_id" content="471477309629720">

    <meta name="format-detection" content="telephone=no"/>

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url("apple-touch-icon.png"); ?>">
    <link rel="icon" type="image/png" href="<?php echo base_url("favicon-32x32.png"); ?>" sizes="32x32">
    <link rel="icon" type="image/png" href="<?php echo base_url("favicon-16x16.png"); ?>" sizes="16x16">
    <link rel="manifest" href="<?php echo base_url("manifest.json"); ?>">
    <link rel="mask-icon" href="<?php echo base_url("safari-pinned-tab.svg"); ?>" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">

    <link href="<?php echo base_url("css/bootstrap.min.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("css/font-awesome.min.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("css/summernote.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("css/admin.1.0.0.css"); ?>" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url("js/bootstrap.min.js"); ?>"></script>
    <script src="<?php echo base_url("js/adminscript.1.0.0.js"); ?>"></script>

</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2" style="padding:0">
            <div class="nav nav-side-menu col-sm-3 col-md-2" style="padding-right:0">
                <div class="brand"><img src="<?php echo base_url("images/logo_small.png"); ?>" alt="Makeupartbyaimee" class="img img-responsive"/></div>
                <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
                <div class="menu-list">
                    <ul id="menu-content" class="menu-content collapse out">
                        <li id="menu_dashboard">
                            <a href="<?php echo base_url("myadmin"); ?>">
                                <i class="fa fa-dashboard fa-lg"></i> Dashboard
                            </a>
                        </li>

                        <li data-toggle="collapse" data-target="#menucms" class="collapsed">
                            <a href="#" ><i class="fa fa-cubes fa-lg"></i> CMS </a> <span class="arrow"></span>
                            <ul class="sub-menu collapse" id="menucms">
                                <li id="menu_staticblock"><a href="<?php echo base_url("myadmin/staticblock/index"); ?>">Static Blocks</a></li>
                                <li id="menu_gallery"><a href="<?php echo base_url("myadmin/gallery/index"); ?>">Image Gallery</a></li>
                            </ul>
                        </li>
                        <li data-toggle="collapse" data-target="#menuarticles" class="collapsed">
                            <a href="#" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Articles </a> <span class="arrow"></span>
                            <ul class="sub-menu collapse" id="menuarticles">
                                <li id="menu_videos"><a href="<?php echo base_url("myadmin/videos/index"); ?>">Videos</a></li>
                                <li id="menu_works"><a href="<?php echo base_url("myadmin/works/index"); ?>">Works</a></li>
                                <li id="menu_blogs"><a href="<?php echo base_url("myadmin/blogs/index"); ?>">Blogs</a></li>
                            </ul>
                        </li>
                        <li data-toggle="collapse" data-target="#menusettings" class="collapsed">
                            <a href="#" ><i class="fa fa-cogs fa-lg"></i> Settings </a> <span class="arrow"></span>
                            <ul class="sub-menu collapse" id="menusettings">
                                <li id="menu_system"><a href="<?php base_url("myadmin/system"); ?>">System</a></li>
                                <li id="menu_logs"><a href="<?php echo base_url("myadmin/logs"); ?>">Logs</a></li>
                                <li id="menu_backup"><a href="<?php echo base_url("myadmin/backup"); ?>">Backup</a></li>
                            </ul>
                        </li>
                        <li id="menu_changepwd">
                            <a href="<?php echo base_url("myadmin/changepwd"); ?>">
                                <i class="fa fa-lock fa-lg" aria-hidden="true"></i> Change Password
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("myadmin/logout"); ?>">
                                <i class="fa fa-sign-out fa-lg" aria-hidden="true"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
