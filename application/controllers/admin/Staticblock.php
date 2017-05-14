<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 12/09/2016
 * Time: 9:12 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Staticblock extends CI_Controller
{
    public function index($page=0)
    {
        $this->load->model('Staticblock_model','block');
        $total_results = $this->block->get_count();

        $this->load->library('pagination');

        $pgconfig['base_url'] = base_url("myadmin/staticblock/index");
        $pgconfig['total_rows'] = $total_results;
        $pgconfig['per_page'] = 20;
        $pgconfig['num_links'] = 3;
        $pgconfig['full_tag_open'] = '<ul class="pagination">';
        $pgconfig['full_tag_close'] = '</ul>';
        $pgconfig['num_tag_open'] = '<li>';
        $pgconfig['num_tag_close'] = '</li>';
        $pgconfig['cur_tag_open'] = '<li class="active"><a href="#">';
        $pgconfig['cur_tag_close'] = ' <span class="sr-only">(current)</span></a></li>';
        $pgconfig['prev_tag_open'] = '<li>';
        $pgconfig['prev_tag_close'] = '</li>';
        $pgconfig['next_tag_open'] = '<li>';
        $pgconfig['next_tag_close'] = '</li>';
        $pgconfig['last_tag_open'] = '<li>';
        $pgconfig['last_tag_close'] = '</li>';
        $pgconfig['first_tag_open'] = '<li>';
        $pgconfig['first_tag_close'] = '</li>';

        $this->pagination->initialize($pgconfig);

        $rows = $this->block->get_list(20,$page);

        $breadcrumb = array("Home"=>base_url("myadmin"),
            "Static Blocks"=>"");
        $data = array("base_url"=>$this->config->item("base_url"),"content"=>"staticblock",
            "page_title"=>$this->config->item("site_brand")." | Static Blocks",
            "breadcrumb"=>$breadcrumb,"page_heading"=>"Static Blocks",
            "total_results"=>$total_results,"rows"=>$rows,"page"=>$page);

        $this->load->view('admin/templates/head',$data);
        $this->load->view('admin/templates/breadcrumb',$data);
        $this->load->view('admin/staticblock/staticblocks',$data);
        $this->load->view('admin/templates/footer',$data);
    }

    public function add()
    {
        $this->session->set_flashdata('staticblock_success',null);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('cmsblocktitle', 'Static Block Title', 'trim|required|min_length[5]');

        $html = "";
        $dberrmsg = "";
        if(isset($_POST['cmsblockcontent'])){
            // we want it as is
            $html = $_POST['cmsblockcontent'];
        }

        if($this->form_validation->run() == TRUE)
        {
            // successful validation, let's try the db
            $this->load->model('Staticblock_model','block');
            $title = $this->input->get_post("cmsblocktitle");
            $title = ucwords($title);
            if($this->block->check_title($title))
            {
                $this->block->title = $title;
                $this->block->descr = $this->input->get_post("cmsblockdescr");
                $this->block->content = $this->input->get_post("cmsblockcontent");
                $this->block->is_active = $this->input->get_post("cmsblockactive");
                $this->block->save();

                log_message("info","Created new static block [".$this->block->get_id()."][".$title."]");

                $this->session->set_flashdata('staticblock_success',"Static block ".$title." successfully added");
                redirect("myadmin/staticblock/index");
            }
            else{
                $dberrmsg = "Title already exists. Please try again";
            }
        }

        $action = "myadmin/staticblock/add";
        $breadcrumb = array("Home"=>base_url("myadmin"),
            "CMS"=>base_url("myadmin/staticblock/index"),
            "Add New Static Block"=>"");
        $data = array(
            "content"=>"cmsblocks","page_title"=>$this->config->item("site_brand")." | Add New Static Block",
            "breadcrumb"=>$breadcrumb,
            "page_heading"=>"Add New Static Block",
            "html"=>$html,
            "formaction"=>$action,
            "dberrmsg"=>$dberrmsg);

        $this->load->view('admin/templates/head',$data);
        $this->load->view('admin/templates/breadcrumb',$data);
        $this->load->view('admin/staticblock/staticblockformadd',$data);
        $this->load->view('admin/templates/footer',$data);
    }

    public function edit($id)
    {
        $this->load->model('Staticblock_model','block');

        if($this->block->init_by_id($id)!==false)
        {
            $this->session->set_flashdata('staticblock_success',null);
            $this->load->library('form_validation');

            $this->form_validation->set_rules('cmsblocktitle', 'Static Block Title', 'trim|required|min_length[5]');

            $html = $this->block->content;
            $dberrmsg = "";
            if(isset($_POST['cmsblockcontent']))
            {
                // we want it as is
                $html = $_POST['cmsblockcontent'];
            }

            if($this->form_validation->run() == TRUE)
            {
                // successful validation, let's try the db
                $title = $this->input->get_post("cmsblocktitle");
                $title = ucwords($title);
                if($this->block->check_title($title))
                {
                    $this->block->title = $title;
                    $this->block->descr = $this->input->get_post("cmsblockdescr");
                    $this->block->content = $this->input->get_post("cmsblockcontent");
                    $this->block->is_active = $this->input->get_post("cmsblockactive");
                    $this->block->save();

                    log_message("info","Updated static block [".$this->block->get_id()."][".$title."]");

                    $this->session->set_flashdata('staticblock_success',"Static block ".$title." successfully updated");
                    redirect("myadmin/staticblock/index");
                }
                else{
                    $dberrmsg = "Title already exists. Please try again";
                }
            }

            $action = "myadmin/staticblock/edit/".$id;
            $breadcrumb = array("Home"=>base_url("myadmin"),
                "CMS"=>base_url("myadmin/staticblock/index"),
                "Edit Static Block"=>"");
            $data = array(
                "content"=>"cmsblocks","page_title"=>$this->config->item("site_brand")." | Edit Static Block",
                "breadcrumb"=>$breadcrumb,
                "page_heading"=>"Edit Static Block",
                "html"=>$html,
                "formaction"=>$action,
                "dberrmsg"=>$dberrmsg,
                "dbblock"=>$this->block);

            $this->load->view('admin/templates/head',$data);
            $this->load->view('admin/templates/breadcrumb',$data);
            $this->load->view('admin/staticblock/staticblockformedit',$data);
            $this->load->view('admin/templates/footer',$data);
        }
        else{
            // show error in list
            $this->session->set_flashdata('staticblock_warning',"Static block not found. Please try again");
            redirect("myadmin/staticblock/index");
        }
    }

    public function delete($id)
    {
        $this->load->model('Staticblock_model','block');
        $success = false;

        if($this->block->init_by_id($id)!==false)
        {
            $this->block->delete();

            log_message("info","Deleted static block [".$this->block->get_id()."][".$title."]");

            $success = true;
            $this->session->set_flashdata('staticblock_success',"Static block successfully deleted.");
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array("success"=>$success)));
    }
}