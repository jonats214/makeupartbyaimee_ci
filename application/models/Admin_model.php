<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 10/08/2016
 * Time: 9:49 PM
 */

class Admin_model extends CI_Model
{
    const TABLE_ADMIN = "admin";
    protected $_id = 0;

    public $user_name = "";
    public $user_pwd = "";
    public $user_email = "";
    public $is_active = false;
    public $date_last_login = "";
    public $error_msg = "";

    public function get_id()
    {
        return $this->_id;
    }

    /**
     * Search admin profile by email
     *
     * @param $email
     * @return $this|bool
     */
    public function init_by_email($email)
    {
        $sql = "SELECT * FROM ".self::TABLE_ADMIN." WHERE user_email= ? AND is_active='1'";
        $query = $this->db->query($sql,array($email));
        $row = $query->row();
        if(isset($row))
        {
            $this->_load_by_row($row);
            return $this;
        }

        return false;
    }

    public function init_by_id($id)
    {
        $sql = "SELECT * FROM ".self::TABLE_ADMIN." WHERE id= ? AND is_active='1'";
        $query = $this->db->query($sql,array(intval($id)));
        $row = $query->row();
        if(isset($row))
        {
            $this->_load_by_row($row);
            return $this;
        }

        return false;
    }

    public function authenticate()
    {
        $encryption = $this->config->item("encryption_key");
        $algo = $this->config->item("hash_algo");
        $name = $this->input->get_post("username");
        $pwd = $this->input->get_post("userpwd");
        $hashpwd = hash_hmac($algo,$pwd,$encryption);

        $sql = "SELECT * FROM ".self::TABLE_ADMIN." WHERE user_name= ? AND user_pwd= ? AND is_active='1'";
        $query = $this->db->query($sql,array($name,$hashpwd));
        //$sql = "SELECT * FROM ".self::TABLE_ADMIN." WHERE user_name= ? AND is_active='1'";
        //$query = $this->db->query($sql,array($name));
        $row = $query->row();
        if(isset($row))
        {
            $this->_load_by_row($row);
            $this->save_login();
            return $this;
        }

        return false;
    }

    protected function _load_by_row($row)
    {
        $this->_id = $row->id;
        $this->is_active = $row->is_active==1;
        $this->user_name = $row->user_name;
        $this->user_email = $row->user_email;
        $this->date_last_login = $row->date_last_login;
    }

    public function update_password($newpassword)
    {
        $encryption = $this->config->item("encryption_key");
        $algo = $this->config->item("hash_algo");
        $hashpwd = hash_hmac($algo,$newpassword,$encryption);

        $this->db->set("user_pwd",$hashpwd);
        $this->db->where("id",$this->_id);
        $s = $this->db->update(self::TABLE_ADMIN);

        if($s !== FALSE)
        {
            log_message("info","Successfully update password [".$this->_id."]");
            return TRUE;
        }
        else
        {
            log_message("error","Unable to update password [".$this->_id."]");
        }

        return FALSE;
    }

    public function save_login()
    {
        $sql = "UPDATE ".self::TABLE_ADMIN."
            SET date_last_login=date_login, date_login='".date("Y-m-d H:i:s")."'
            WHERE id='".$this->_id."'";
        $this->db->query($sql);
    }
}