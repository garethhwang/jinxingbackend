<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/12
 * Time: 21:38
 */
class ModelWechatHelp extends Model
{
    public function getFaq(){
        $query=$this->db->query("SELECT * FROM wechat_faq");
        return $query->rows;
    }

    public function addFaq($title,$content){
        $this->db->query("INSERT INTO  wechat_faq(title,content) VALUES ('" . $title . "','" . $content . "')");
    }

    public function deleteFaq($faqId){
        $this->db->query("DELETE FROM wechat_faq WHERE id = '" . $faqId . "'");
    }

    public function updateFaq($faqId,$title,$content){
        $this->db->query("UPDATE  wechat_faq SET  title = '" . $title."', content = '" . $content."' WHERE id = '" . $faqId . "'");
    }
}