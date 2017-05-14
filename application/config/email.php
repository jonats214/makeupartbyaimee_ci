<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 30/10/2016
 * Time: 10:35 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');
/*
$config['mailtype'] = 'html';
$config["smtp_host"]='dedrelay.secureserver.net';
$config["protocol"]='smtp';
$config["smtp_port"]='25';
$config["smtp_keepalive"]=FALSE;
$config["smtp_crypto"]='tls';
$config["smtp_user"]='';
$config["smtp_pass"]='';


'protocol' => 'smtp',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_port' => 465,
    'smtp_user' => 'xxx',
    'smtp_pass' => 'xxx',
    'mailtype'  => 'html',
    'charset'   => 'iso-8859-1'

*/

// TODO: have this as a settings

$config['mailtype'] = 'html';
$config["smtp_host"]='ssl://smtp.gmail.com';
$config["protocol"]='smtp';
$config["smtp_port"]='465';
$config["smtp_keepalive"]=FALSE;
//$config["smtp_crypto"]='tls';
$config["smtp_user"]='makeupartbyaimee';
$config["smtp_pass"]='011808230331';
$config["charset"]='iso-8859-1';
