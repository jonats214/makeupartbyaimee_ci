<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 31/07/2016
 * Time: 7:48 PM
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
    <meta name="keywords" content="Makeup, Aimee Bulaong, artist" />
    <meta name="robots" content="index, follow" />
    <link rel="canonical" href="<?php echo base_url(); ?>" />

    <meta property="og:title" content="Makeup by Aimee | Home">
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
    <link href="<?php echo base_url("css/sitecss.1.0.0.css"); ?>" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container" id="divmainlogo">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <a href="/"><img src="<?php echo base_url("images/logo.png"); ?>" alt="Makeup Art By Aimee" class="img-responsive"/></a>
            </div>
        </div>
    </div>
    <div class="divfluidline"></div>
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img src="<?php echo base_url("images/logo_small.png"); ?>" alt="Makeup Art By Aimee"/></a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav nav-justified text-uppercase">
                    <li class="active"><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li><a href="<?php echo base_url("about"); ?>">About</a></li>
                    <li><a href="<?php echo base_url("works"); ?>">Works</a></li>
                    <li><a href="<?php echo base_url("videos"); ?>">Videos</a></li>
                    <li><a href="<?php echo base_url("blog"); ?>">Blog</a></li>
                    <li><a href="<?php echo base_url("contact"); ?>">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="divfluidline"></div>
    <div class="divspacer"></div>