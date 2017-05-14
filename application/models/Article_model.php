<?php
/**
 * Created by PhpStorm.
 * User: Jonats
 * Date: 5/10/2016
 * Time: 9:37 PM
 */

class Article_model extends CI_Model
{
    const TABLE_ARTICLES = "articles";

    const TYPE_VIDEO = "video";
    const TYPE_WORK = "work";
    const TYPE_BLOG = "blog";

    protected $_id = "";
    public $title = "";
    public $short_descr = "";
    public $content = "";
    public $type = "";
    public $url_slug = "";
    public $date_created = "";
    public $date_updated = "";
    public $date_published = "";
    public $is_published = false;
    public $keywords = "";
    public $published_by = "";
    public $allow_comments = false;
    public $image_url = "";
    public $video_embed = "";
    public $page_views = 0;


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
        $sql = "SELECT * FROM ".self::TABLE_ARTICLES." WHERE id= ?";
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
        $this->url_slug = url_title(strtolower($this->title));

        $this->db->set("article_title",$this->title);
        $this->db->set("short_descr",$this->short_descr);
        $this->db->set("is_published",$this->is_published?1:0);
        $this->db->set("article_content",$this->content);
        $this->db->set("url_slug",$this->url_slug);
        $this->db->set("image_url",$this->image_url);
        $this->db->set("video_embed",$this->video_embed);
        $this->db->set("article_keywords",$this->keywords);
        $this->db->set("allow_comments",$this->allow_comments?1:0);
        $this->db->set("published_by",$this->published_by);
        $this->db->set("date_updated",date("Y-m-d H:i:s"));
        $this->db->set("article_type",$this->type);
        $this->db->set("page_views",$this->page_views);

        if($this->is_published==true && strlen($this->date_published)>0)
        {
            $this->db->set("date_published",$this->date_published);
        }

        if($this->get_id()==0)
        {
            $this->db->set("date_created",date("Y-m-d H:i:s"));
            return $this->db->insert(self::TABLE_ARTICLES);
        }
        else
        {
            $this->db->where("id",$this->get_id());
            return $this->db->update(self::TABLE_ARTICLES);
        }
    }

    protected function _load_by_row($row)
    {
        $this->_id = $row->id;
        $this->title = $row->article_title;
        $this->short_descr = $row->short_descr;
        $this->url_slug = $row->url_slug;
        $this->content = $row->article_content;
        $this->is_published = $row->is_published==1;
        $this->date_created = $row->date_created;
        $this->date_updated = $row->date_updated;
        $this->date_published = $row->date_published;
        $this->keywords = $row->article_keywords;
        $this->allow_comments = $row->allow_comments==1;
        $this->published_by = $row->published_by;
        $this->image_url = $row->image_url;
        $this->video_embed = $row->video_embed;
        $this->type = $row->article_type;
        $this->page_views = $row->page_views;
    }

    public function check_title($title)
    {
        $count = 0;

        $sql = "SELECT COUNT(*) AS hits FROM ".self::TABLE_ARTICLES." WHERE id<> ? AND article_title= ? AND article_type = ?";
        $query = $this->db->query($sql,array($this->_id,$title,$this->type));
        $row = $query->row();
        if(isset($row))
        {
            $count = intval($row->hits);
        }

        return $count==0;
    }

    public function get_list( $type, $items_per_page, $page_index, $published_only=false)
    {
        $this->db->where("article_type",$type);
        $this->db->order_by('date_created', 'DESC');

        if($published_only==true)
        {
            $this->db->where('is_published',1);
            $this->db->order_by('date_published', 'DESC');
        }

        if($page_index>0)
        {
            $this->db->limit($items_per_page, $page_index);
        }

        $query = $this->db->get(self::TABLE_ARTICLES);

        return $query->result_array();
    }

    public function get_count($type)
    {
        $this->db->where('article_type',$type);
        return $this->db->count_all_results(self::TABLE_ARTICLES);
    }

    public function delete()
    {
        $this->db->delete(self::TABLE_ARTICLES, array('id' => $this->get_id()));
    }

    public function inc_page_views()
    {
        $this->db->simple_query("UPDATE ".self::TABLE_ARTICLES." SET page_views=page_views+1 WHERE id='".$this->get_id()."'");
    }
}