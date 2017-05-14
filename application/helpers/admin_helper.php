<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 23/08/2016
 * Time: 9:57 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


if ( ! function_exists('check_admin_session'))
{
    function check_admin_session(CI_Controller $ci)
    {
        $ci->load->helper('cookie');

        if($ci->session->has_userdata(SESSION_ADMIN_ID) === FALSE)
        {
            // check the cookie if it exists
            $id = admin_get_cookie_value($ci);
            if(intval($id)>0)
            {
                $ci->load->model("Admin_model","admin");

                if($id !== FALSE && $ci->admin->init_by_id($id) !== FALSE)
                {
                    $ci->session->set_userdata(SESSION_ADMIN_ID,$id);
                    return true;    // login using cookie successful
                }
            }

            return false;
        }
        else
        {
            return true; // active admin
        }
    }
}

if ( ! function_exists('get_admin_obj'))
{
    /**
     * @return Admin_model
     */
    function get_admin_obj(CI_Controller $ci)
    {
        $id = $ci->session->userdata(SESSION_ADMIN_ID);
        $ci->load->model("Admin_model","admin");
        $ci->admin->init_by_id($id);
        // error_log("admin id ".$ci->admin->get_id());
        return $ci->admin;
    }
}

if ( ! function_exists('admin_get_cookie_value'))
{
    function admin_get_cookie_value(CI_Controller $ci)
    {
        $ci->load->library('encryption');
        $cookie = get_cookie(COOKIE_ADMIN_ID);

        if($cookie !== FALSE)
        {
            $decodedStr = $ci->encryption->decrypt($cookie);
            // we just get the last set of digits

            $numDigits = substr($decodedStr,-1);
            $id = substr($decodedStr,-1*($numDigits+1),$numDigits);

            // error_log("decode cookie [".$id."][".$cookie."][".$decodedStr."][".$numDigits."]");

            return $id;
        }

        return false;
    }
}

if ( ! function_exists('admin_set_cookie_value'))
{
    function admin_set_cookie_value(CI_Controller $ci, $id)
    {
        $ci->load->library('encryption');
        $ci->load->helper("cookie");

        $cookie = time().$id.strlen($id);
        $cookie = $ci->encryption->encrypt($cookie);

        set_cookie(COOKIE_ADMIN_ID,$cookie,60*60*24*30);
    }
}