<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 20/09/2016
 * Time: 8:49 PM
 */


class Staticblock_model extends CI_Model
{
    const TABLE_STATICBLOCK = "static_blocks";

    protected $_id = "";
    public $title = "";
    public $descr = "";
    public $content = "";
    public $is_active = false;
    public $date_created = "";
    public $date_updated = "";

    public function __construct()
    {
        parent::__construct();
    }

    public function get_id()
    {
        return $this->_id;
    }

    public function init_by_id($id)
    {
        $sql = "SELECT * FROM ".self::TABLE_STATICBLOCK." WHERE block_id= ?";
        $query = $this->db->query($sql,array(intval($id)));
        $row = $query->row();
        if(isset($row))
        {
            $this->_load_by_row($row);
            return $this;
        }

        return false;
    }

    public function save()
    {
        $this->db->set("block_title",$this->title);
        $this->db->set("block_descr",$this->descr);
        $this->db->set("is_active",$this->is_active?1:0);
        $this->db->set("block_content",$this->content);
        $this->db->set("date_updated",date("Y-m-d H:i:s"));

        if($this->get_id()==0)
        {
            $this->db->set("date_created",date("Y-m-d H:i:s"));
            return $this->db->insert(self::TABLE_STATICBLOCK);
        }
        else
        {
            $this->db->where("block_id",$this->get_id());
            return $this->db->update(self::TABLE_STATICBLOCK);
        }
    }

    protected function _load_by_row($row)
    {
        $this->_id = $row->block_id;
        $this->title = $row->block_title;
        $this->descr = $row->block_descr;
        $this->content = $row->block_content;
        $this->is_active = $row->is_active==1;
        $this->date_created = $row->date_created;
        $this->date_updated = $row->date_updated;
    }

    public function check_title($title)
    {
        $count = 0;

        $sql = "SELECT COUNT(*) AS hits FROM ".self::TABLE_STATICBLOCK." WHERE block_id<> ? AND block_title= ?";
        $query = $this->db->query($sql,array($this->_id,$title));
        $row = $query->row();
        if(isset($row))
        {
            $count = intval($row->hits);
        }

        return $count==0;
    }

    public function get_list($items_per_page, $page_index)
    {
        $this->db->order_by('block_title', 'ASC');
        $this->db->limit($items_per_page, $page_index);
        $query = $this->db->get(self::TABLE_STATICBLOCK);

        return $query->result_array();
    }

    public function get_count()
    {
        return $this->db->count_all_results(self::TABLE_STATICBLOCK);
    }

    public function delete()
    {
        $this->db->delete(self::TABLE_STATICBLOCK, array('block_id' => $this->get_id()));
    }
}