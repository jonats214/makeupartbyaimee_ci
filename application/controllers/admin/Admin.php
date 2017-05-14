<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 10/08/2016
 * Time: 9:25 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function index()
    {
        $this->load->helper("admin");
        if(check_admin_session($this) == FALSE)
        {
            redirect("myadmin/login");
        }
        else
        {
            // show dashboard
            $last_login = date("jS F Y h:ia",strtotime(get_admin_obj($this)->date_last_login));

            $this->load->model('Article_model','blog');

            $total_blogs = $this->blog->get_count(Article_model::TYPE_BLOG);
            $total_videos = 0; //TODO:$this->blog->get_count(Article_model::TYPE_VIDEO);
            $total_works = 0; //TODO:$this->blog->get_count(Article_model::TYPE_WORK);

            $data = array("video_count"=>$total_videos,
                "work_count"=>$total_works,
                "blog_count"=>$total_blogs,
                "admin"=>get_admin_obj($this),
                "last_login"=>$last_login);
            $footer_data = array("content"=>"dashboard",
                "page_title"=>$this->config->item("site_brand")." | Dashboard");

            $this->load->view('admin/templates/head',$data);
            $this->load->view('admin/dashboard',$data);
            $this->load->view('admin/templates/footer',$footer_data);
        }
    }

    public function login()
    {
        $brand = $this->config->item("site_brand");
        $data = array("site_version"=>$this->config->item("site_version"),
            "site_brand"=>$brand,
            "page_title"=>$brand." Admin Login");

        $this->session->set_flashdata('login_error',null);
        $this->load->helper(array('form', 'url','admin'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('userpwd', 'Password', 'trim|required');
        $this->form_validation->set_rules('userremember', 'Remember Me', 'trim');

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('admin/templates/login_head',$data);
            $this->load->view("admin/login",$data);
            $this->load->view('admin/templates/login_footer',$data);
        }
        else
        {
            $errormsg = validation_errors();

            if(strlen($errormsg)==0){
                $this->load->model("Admin_model","admin");

                if($this->admin->authenticate() !== FALSE)
                {
                    log_message('debug',"Login successful for ".$this->admin->user_name);

                    $this->session->set_userdata(SESSION_ADMIN_ID,$this->admin->get_id());

                    if($this->input->get_post("userremember"))
                    {
                        admin_set_cookie_value($this,$this->admin->get_id());
                    }

                    if($this->session->has_userdata(SESSION_PREV_PAGE) !== FALSE)
                    {
                        // redirect to a previous page
                        redirect($this->session->userdata(SESSION_PREV_PAGE));
                    }
                    else
                    {
                        redirect("myadmin/index");
                    }
                }
                else
                {
                    log_message('debug',"Login not successful for ".$this->admin->user_name);

                    $this->session->set_flashdata('login_error','Invalid username and/or password');
                    $this->load->view('admin/templates/login_head',$data);
                    $this->load->view("admin/login",$data);
                    $this->load->view('admin/templates/login_footer',$data);
                }
            }
            else
            {
                $this->session->set_flashdata('login_error',$errormsg);
                $this->load->view('admin/templates/login_head',$data);
                $this->load->view("admin/login",$data);
                $this->load->view('admin/templates/login_footer',$data);
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();

        $this->load->helper("cookie");
        delete_cookie(COOKIE_ADMIN_ID);

        redirect('myadmin/login');
    }

    public function forgotpwd()
    {
        $this->load->helper(array('form', 'url','admin','string'));

        if(check_admin_session($this) == TRUE)
        {
            redirect("myadmin/dashboard");
        }
        else
        {
            $this->load->model("Admin_model","admin");
            $brand = $this->config->item("site_brand");
            $data = array("site_version"=>$this->config->item("site_version"),
                "error_msg"=>"",
                "page_title"=>$brand." Admin - Forgot Password",
                "site_brand"=>$brand);

            $this->session->set_flashdata('forgotpwd_error',null);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('useremail', 'User Email', 'trim|required|valid_email');

            if($this->form_validation->run() == TRUE)
            {
                // check if this email is registered
                $email = $this->input->get_post("useremail");
                if($this->admin->init_by_email($email)!==false)
                {
                    // create random string
                    $newpwd = random_string('alnum',8);

                    $html = "<html><head></head><body><div><p>Hi ".htmlspecialchars($this->admin->user_name).",</p><p>This is a notification that your password was reset to <strong>".$newpwd."</strong> as of ".date("jS F Y h:i a").".</p><p>Regards,<br />".$brand." Admin</p></div></body>";

                    // try to email
                    $this->load->library('email');

                    $this->email->from($this->config->item("email_sender"), $this->config->item("email_sender_name"));
                    $this->email->to($email);

                    $this->email->subject($brand.' - Reset Password');
                    $this->email->message($html);
                    $this->email->set_newline("\r\n");

                    if($this->email->send()==TRUE)
                    {
                        // if we can email, then we can save
                        $this->admin->update_password($newpwd);

                        log_message('info',"Reset password sent to ".$email);

                        $msg = "Reset password successful! An email was sent to ".$email." containing the new password.";

                        $this->session->set_flashdata('forgotpwd_msg',$msg);

                        redirect("myadmin/login");
                    }
                    else
                    {
                        echo $this->email->print_debugger();

                        $this->session->set_flashdata('forgotpwd_error',"Unable to send ".$email.". Please try again.");
                        $this->load->view('admin/templates/login_head',$data);
                        $this->load->view("admin/forgotpwd",$data);
                        $this->load->view('admin/templates/login_footer',$data);
                    }
                }
                else
                {
                    $this->session->set_flashdata('forgotpwd_error',"Email ".$email." is not registered.");
                    $this->load->view('admin/templates/login_head',$data);
                    $this->load->view("admin/forgotpwd",$data);
                    $this->load->view('admin/templates/login_footer',$data);
                }
            }
            else
            {
                $this->load->view('admin/templates/login_head',$data);
                $this->load->view("admin/forgotpwd",$data);
                $this->load->view('admin/templates/login_footer',$data);
            }
        }
    }

    public function forgotpwdsuccess()
    {

        $brand = $this->config->item("site_brand");
        $data = array("site_version"=>$this->config->item("site_version"),
            "error_msg"=>"",
            "page_title"=>$brand." Admin - Forgot Password",
            "site_brand"=>$brand);

        $data["email"] = "jonathan.bulaong@gmail.com";

        $this->load->view('admin/templates/login_head',$data);
        $this->load->view("admin/forgotpwdsuccess",$data);
        $this->load->view('admin/templates/login_footer',$data);
    }

    public function changepwd()
    {
        $this->load->helper(array('form', 'url','admin'));
        if(check_admin_session($this) == FALSE)
        {
            redirect("myadmin/login");
        }
        else
        {
            $this->session->set_flashdata('pwd_error',null);
            $this->session->set_flashdata('pwd_success',null);
            $this->load->library('form_validation');

            $this->form_validation->set_rules('innewpwd', 'New Password', 'trim|required|min_length[5]');
            $this->form_validation->set_rules('inconfpwd', 'Re-type Password', 'trim|required|matches[innewpwd]');

            $breadcrumb = array("Home"=>base_url("myadmin"),
                "Change Password"=>"");
            $data = array("content"=>"changepwd",
                "page_title"=>$this->config->item("site_brand")." | Change Password",
                "breadcrumb"=>$breadcrumb,
                "page_heading"=>"Change Password");

            if ($this->form_validation->run() == TRUE)
            {
                $newpwd = $this->input->get_post("innewpwd");
                if(get_admin_obj($this)->update_password($newpwd)==true)
                {
                    log_message('info',"Password updated for ".get_admin_obj($this)->user_name);
                    $this->session->set_flashdata('pwd_success',"<i class=\"fa fa-check-circle\" aria-hidden=\"true\"></i> Successfully updated password");
                }
                else
                {
                    $this->session->set_flashdata('pwd_error',get_admin_obj($this)->error_msg);
                }
            }

            $this->load->view('admin/templates/head',$data);
            $this->load->view('admin/templates/breadcrumb',$data);
            $this->load->view('admin/changepwd',$data);
            $this->load->view('admin/templates/footer',$data);
        }
    }
}