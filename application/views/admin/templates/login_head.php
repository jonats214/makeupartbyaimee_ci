<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 30/10/2016
 * Time: 10:02 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $page_title; ?></title>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow" />
    <meta name="format-detection" content="telephone=no"/>

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url("apple-touch-icon.png"); ?>">
    <link rel="icon" type="image/png" href="<?php echo base_url("favicon-32x32.png"); ?>" sizes="32x32">
    <link rel="icon" type="image/png" href="<?php echo base_url("favicon-16x16.png"); ?>" sizes="16x16">
    <link rel="manifest" href="<?php echo base_url("manifest.json"); ?>">
    <link rel="mask-icon" href="<?php echo base_url("safari-pinned-tab.svg"); ?>" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">

    <link href="<?php echo base_url("css/bootstrap.min.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("css/font-awesome.min.css"); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url("css/login.1.0.0.cs"); ?>s"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<?php flush(); ?>
<body>