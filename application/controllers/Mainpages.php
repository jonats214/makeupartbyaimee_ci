<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 1/08/2016
 * Time: 9:36 PM
 */
class Mainpages extends CI_Controller
{
    public function index(){
        $this->load->model('Staticblock_model','block');
        $this->block->init_by_id(1);

        $this->load->model('Staticblock_model','block2');
        $this->block2->init_by_id(3);

        $data = array("welcome"=>$this->block->content,
            "brief_about"=>$this->block2->content);

        $this->load->view('templates/head',$data);
        $this->load->view('pages/index',$data);
        $this->load->view('templates/footer',$data);
    }

    public function about(){
        $this->load->model('Staticblock_model','block');
        $this->block->init_by_id(2);

        $data = array("content"=>$this->block->content);

        $this->load->view('templates/head',$data);
        $this->load->view('pages/about',$data);
        $this->load->view('templates/footer',$data);
    }

    public function contact(){
        $this->load->model("siteconfig_model","sc");
        $email = $this->sc->get_value("site_email");

        $data = array("email"=>$email);

        $this->load->view('templates/head',$data);
        $this->load->view('pages/contact',$data);
        $this->load->view('templates/footer',$data);
    }
}