<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 21/11/2016
 * Time: 10:31 PM
 */


defined('BASEPATH') OR exit('No direct script access allowed');

class Works extends CI_Controller
{
    public function index($page=0)
    {
        $this->load->model('Article_model','work');
        $total_results = $this->work->get_count(Article_model::TYPE_WORK);

        $this->load->library('pagination');

        $pgconfig['base_url'] = $this->config->item("base_url")."myadmin/works/index/";
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

        $rows = $this->work->get_list(Article_model::TYPE_WORK, 20,$page);

        $breadcrumb = array("Home"=>base_url("myadmin"),
            "Works"=>"");
        $data = array("content"=>"works",
            "page_title"=>$this->config->item("site_brand")." | Work Articles",
            "breadcrumb"=>$breadcrumb,"page_heading"=>"Work Articles",
            "total_results"=>$total_results,
            "rows"=>$rows,
            "page"=>$page);

        $this->load->view('admin/templates/head',$data);
        $this->load->view('admin/templates/breadcrumb',$data);
        $this->load->view('admin/work/works',$data);
        $this->load->view('admin/templates/footer',$data);
    }

    public function add()
    {
        $this->session->set_flashdata('works_success',null);
        $this->load->library('form_validation');

        $this->load->model('Siteconfig_model','siteconfig');

        $default_author = $this->siteconfig->get_value('default_author');

        $this->form_validation->set_rules('articletitle', 'Title', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('articleshortdescr', 'Short Description', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('articleauthor', 'Author', 'trim|required|min_length[3]');

        $html = "";
        $dberrmsg = "";
        if($this->input->get_post("htmlcontent")){
            // we want it as is
            $html = $this->input->get_post['htmlcontent'];
        }

        if($this->form_validation->run() == TRUE)
        {
            // successful validation, let's try the db
            $this->load->model('Article_model','article');
            $title = $this->input->get_post("articletitle");
            $title = ucwords($title);
            if($this->article->check_title($title))
            {
                $this->article->title = $title;
                $this->article->type = Article_model::TYPE_WORK;
                $this->article->short_descr = $this->input->get_post("articleshortdescr");
                $this->article->keywords = $this->input->get_post("articlekeywords");
                $this->article->content = $this->input->get_post("htmlcontent");
                $this->article->allow_comments = $this->input->get_post("allow_comments")==1;
                $this->article->date_created = date("Y-m-d H:i:s");
                $this->article->date_updated = date("Y-m-d H:i:s");
                $this->article->is_published = $this->input->get_post("articlepublish")==1;
                $this->article->published_by = $this->input->get_post("articleauthor");

                if($this->article->is_published==TRUE){
                    $this->date_published= $this->input->get_post("publishdate");
                }

                // TODO: $this->image_url = $row->image_url;
                $this->article->save();

                $this->_gen_xml_list();

                log_message("info","Created new work article [".$this->article->get_id()."][".$title."]");

                $this->session->set_flashdata('works_success',"Work Article ".$title." successfully added");
                redirect("myadmin/works/index");
            }
            else{
                $dberrmsg = "Title already exists. Please try again";
            }
        }

        $action = "myadmin/works/add";
        $breadcrumb = array("Home"=>base_url("myadmin"),
            "Works"=>base_url("myadmin/works/index"),
            "Add New Work Article"=>"");
        $data = array("content"=>"works",
            "page_title"=>$this->config->item("site_brand")." | Add New Work Article",
            "breadcrumb"=>$breadcrumb,
            "page_heading"=>"Add New Work Article",
            "html"=>$html,
            "formaction"=>$action,
            "dberrmsg"=>$dberrmsg,
            "default_author"=>$default_author);

        $this->load->view('admin/templates/head',$data);
        $this->load->view('admin/templates/breadcrumb',$data);
        $this->load->view('admin/work/workadd',$data);
        $this->load->view('admin/templates/footer',$data);
    }

    public function edit($id)
    {
        $this->load->model('Article_model','article');

        if($this->article->init_by_id($id)!==FALSE)
        {
            $this->session->set_flashdata('works_success',null);
            $this->load->library('form_validation');
            $this->load->model('Siteconfig_model','siteconfig');

            $this->form_validation->set_rules('articletitle', 'Title', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('articleshortdescr', 'Short Description', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('articleauthor', 'Author', 'trim|required|min_length[3]');

            $html = $this->article->content;
            $dberrmsg = "";
            if($this->input->get_post("htmlcontent"))
            {
                // we want it as is
                $html = $this->input->get_post['htmlcontent'];
            }

            if($this->form_validation->run() == TRUE)
            {
                // successful validation, let's try the db

                $title = $this->input->get_post("articletitle");
                $title = ucwords($title);
                if($this->article->check_title($title)){
                    $this->article->title = $title;
                    $this->article->type = Article_model::TYPE_WORK;
                    $this->article->short_descr = $this->input->get_post("articleshortdescr");
                    $this->article->keywords = $this->input->get_post("articlekeywords");
                    $this->article->content = $this->input->get_post("htmlcontent");
                    $this->article->allow_comments = $this->input->get_post("allow_comments")==1;
                    $this->article->date_updated = date("Y-m-d H:i:s");
                    $this->article->is_published = $this->input->get_post("articlepublish")==1;
                    $this->article->published_by = $this->input->get_post("articleauthor");

                    if($this->article->is_published==TRUE){
                        $this->date_published= $this->input->get_post("publishdate");
                    }

                    // TODO: $this->image_url = $row->image_url;
                    $this->article->save();

                    log_message("info","Updated work article [".$this->article->get_id()."][".$title."]");

                    $this->_gen_xml_list();

                    $this->session->set_flashdata('works_success',"Work Article ".$title." successfully added");
                    redirect("myadmin/works/index");
                }
                else{
                    $dberrmsg = "Title already exists. Please try again";
                }
            }

            $action = "myadmin/works/edit/".$id;
            $breadcrumb = array("Home"=>base_url("myadmin"),
                "Works"=>base_url("myadmin/works/index"),
                "Edit Work Article"=>"");
            $data = array("content"=>"works",
                "page_title"=>$this->config->item("site_brand")." | Edit Work Article #".$id,
                "breadcrumb"=>$breadcrumb,
                "page_heading"=>"Edit Work Article #".$id,
                "html"=>$html,
                "formaction"=>$action,
                "dberrmsg"=>$dberrmsg,
                "dbarticle"=>$this->article);

            $this->load->view('admin/templates/head',$data);
            $this->load->view('admin/templates/breadcrumb',$data);
            $this->load->view('admin/work/workedit',$data);
            $this->load->view('admin/templates/footer',$data);
        }
        else
        {
            // show error in list
            $this->session->set_flashdata('works_warning',"Work article not found. Please try again");
            redirect("myadmin/works/index");
        }
    }

    public function delete($id)
    {
        $this->load->model('Article_model','work');
        $success = false;

        if($this->work->init_by_id($id)!==false)
        {
            $this->work->delete();
            $success = true;
            $this->session->set_flashdata('works_success',"Work article successfully deleted.");

            $this->_gen_xml_list();
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array("success"=>$success)));
    }

    protected function _gen_xml_list()
    {
        $dest_file = APPPATH."cache/worklist.xml";
        $this->load->helper(array('xml','file'));
        $this->load->model('Article_model','article');
        $rows = $this->article->get_list(Article_model::TYPE_WORK, 0, 1, true);

        $dom = xml_dom();
        $works = xml_add_child($dom,"works");

        foreach($rows as $r)
        {
            $work = xml_add_child($works,"work");
            $url = base_url("works/details/".$r["url_slug"]);
            $date = date("jS F Y h:ia",strtotime($r["date_published"]));

            xml_add_child($work,"id",$r["id"]);
            xml_add_child($work,"title",$r['article_title'],TRUE);
            xml_add_child($work,"url",$url,TRUE);
            xml_add_child($work,"short_descr",$r["short_descr"],TRUE);
            xml_add_child($work,"author",$r["published_by"],TRUE);
            xml_add_child($work,"date",$date);
        }

        $xml = xml_print($dom,TRUE);
        if(write_file($dest_file,$xml,"w+") == FALSE)
        {
            log_message("error","unable to save work file ".$dest_file);
        }
        else
        {
            log_message("info","work list xml ".$dest_file." updated");
        }
    }
}