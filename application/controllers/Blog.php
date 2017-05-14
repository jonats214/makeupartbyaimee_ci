<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 14/11/2016
 * Time: 10:39 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller
{
    public function index()
    {
        $data = array();

        $this->load->view('templates/head',$data);
        $this->load->view('pages/bloglist',$data);
        $this->load->view('templates/footer',$data);
    }
}