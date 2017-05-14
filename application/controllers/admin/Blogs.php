<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 12/09/2016
 * Time: 9:12 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs extends CI_Controller
{
    public function index($page=0)
    {
        $this->load->model('Article_model','blog');
        $total_results = $this->blog->get_count(Article_model::TYPE_BLOG);

        $this->load->library('pagination');

        $pgconfig['base_url'] = $this->config->item("base_url")."myadmin/blogs/index/";
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

        $rows = $this->blog->get_list(Article_model::TYPE_BLOG, 20,$page);

        $breadcrumb = array("Home"=>base_url("myadmin"),
            "Blogs"=>"");
        $data = array("content"=>"blogs",
            "page_title"=>$this->config->item("site_brand")." | Blog Articles",
            "breadcrumb"=>$breadcrumb,"page_heading"=>"Blog Articles",
            "total_results"=>$total_results,
            "rows"=>$rows,
            "page"=>$page);

        $this->load->view('admin/templates/head',$data);
        $this->load->view('admin/templates/breadcrumb',$data);
        $this->load->view('admin/blog/blogs',$data);
        $this->load->view('admin/templates/footer',$data);
    }

    public function add()
    {
        $this->session->set_flashdata('blogs_success',null);
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
                $this->article->type = Article_model::TYPE_BLOG;
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

                log_message("info","Created new blog article [".$this->article->get_id()."][".$title."]");

                $this->session->set_flashdata('blog_success',"Blog Article ".$title." successfully added");
                redirect("myadmin/blogs/index");
            }
            else{
                $dberrmsg = "Title already exists. Please try again";
            }
        }

        $action = "myadmin/blogs/add";
        $breadcrumb = array("Home"=>base_url("myadmin"),
            "Blogs"=>base_url("myadmin/blogs/index"),
            "Add New Blog Article"=>"");
        $data = array("content"=>"blogs",
            "page_title"=>$this->config->item("site_brand")." | Add New Blog Article",
            "breadcrumb"=>$breadcrumb,
            "page_heading"=>"Add New Blog Article",
            "html"=>$html,
            "formaction"=>$action,
            "dberrmsg"=>$dberrmsg,
            "default_author"=>$default_author);

        $this->load->view('admin/templates/head',$data);
        $this->load->view('admin/templates/breadcrumb',$data);
        $this->load->view('admin/blog/blogadd',$data);
        $this->load->view('admin/templates/footer',$data);
    }

    public function edit($id)
    {
        $this->load->model('Article_model','article');

        if($this->article->init_by_id($id)!==FALSE)
        {
            $this->session->set_flashdata('blogs_success',null);
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
                    $this->article->type = Article_model::TYPE_BLOG;
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

                    log_message("info","Updated blog article [".$this->article->get_id()."][".$title."]");

                    $this->_gen_xml_list();

                    $this->session->set_flashdata('blog_success',"Blog Article ".$title." successfully added");
                    redirect("myadmin/blogs/index");
                }
                else{
                    $dberrmsg = "Title already exists. Please try again";
                }
            }

            $action = "myadmin/blogs/edit/".$id;
            $breadcrumb = array("Home"=>base_url("myadmin"),
                "Blogs"=>base_url("myadmin/blogs/index"),
                "Edit Blog Article"=>"");
            $data = array("content"=>"blogs",
                "page_title"=>$this->config->item("site_brand")." | Edit Blog Article #".$id,
                "breadcrumb"=>$breadcrumb,
                "page_heading"=>"Edit Blog Article #".$id,
                "html"=>$html,
                "formaction"=>$action,
                "dberrmsg"=>$dberrmsg,
                "dbarticle"=>$this->article);

            $this->load->view('admin/templates/head',$data);
            $this->load->view('admin/templates/breadcrumb',$data);
            $this->load->view('admin/blog/blogedit',$data);
            $this->load->view('admin/templates/footer',$data);
        }
        else
        {
            // show error in list
            $this->session->set_flashdata('blog_warning',"Blog article not found. Please try again");
            redirect("myadmin/blogs/index");
        }
    }

    public function delete($id)
    {
        $this->load->model('Article_model','blog');
        $success = false;

        if($this->blog->init_by_id($id)!==false)
        {
            $this->blog->delete();
            $success = true;
            $this->session->set_flashdata('blog_success',"Blog article successfully deleted.");

            $this->_gen_xml_list();
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array("success"=>$success)));
    }

    protected function _gen_xml_list()
    {
        $dest_file = APPPATH."cache/bloglist.xml";
        $this->load->helper(array('xml','file'));
        $this->load->model('Article_model','article');
        $rows = $this->article->get_list(Article_model::TYPE_BLOG, 0, 1, true);

        $dom = xml_dom();
        $blogs = xml_add_child($dom,"blogs");

        foreach($rows as $r)
        {
            $blog = xml_add_child($blogs,"blog");
            $url = base_url("blogs/details/".$r["url_slug"]);
            $date = date("jS F Y h:ia",strtotime($r["date_published"]));

            xml_add_child($blog,"id",$r["id"]);
            xml_add_child($blog,"title",$r['article_title'],TRUE);
            xml_add_child($blog,"url",$url,TRUE);
            xml_add_child($blog,"short_descr",$r["short_descr"],TRUE);
            xml_add_child($blog,"author",$r["published_by"],TRUE);
            xml_add_child($blog,"date",$date);
        }

        $xml = xml_print($dom,TRUE);
        if(write_file($dest_file,$xml,"w+") == FALSE)
        {
            log_message("error","unable to save blog file ".$dest_file);
        }
        else
        {
            log_message("info","blog list xml ".$dest_file." updated");
        }
    }
}