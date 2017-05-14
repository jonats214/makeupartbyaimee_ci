<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 7/08/2016
 * Time: 9:34 PM
 */


class Siteconfig_model extends CI_Model
{
    const TABLE_CONFIG = "siteconfig";

    private $key = "";
    private $value = "";

    function __construct(){
        parent::__construct();
    }

    public function get_value($key)
    {
        $sql = "SELECT confval FROM ".self::TABLE_CONFIG." WHERE confkey= ? ";
        $query = $this->db->query($sql,array($key));
        $row = $query->row();
        if(isset($row))
        {
            return $row->confval;
        }

        return false;
    }

    public function set_value($key,$value,$desciption="")
    {
        $hits = 0;
        $sql = "SELECT COUNT(*) AS hits FROM ".self::TABLE_CONFIG." WHERE confkey= ? ";
        $query = $this->db->query($sql,array($key));
        $row = $query->row();
        if(isset($row))
        {
            $hits = $row->hits;
        }

        if($hits>0)
        {
            $this->db->set('confval',$value);
            $this->db->where('confkey',$key);
            $this->db->update(self::TABLE_CONFIG);
        }
        else
        {
            $this->db->set('confval',$value);
            $this->db->set('confkey',$key);
            $this->db->set('descr',$desciption);
            $this->db->insert(self::TABLE_CONFIG);
        }
    }
}