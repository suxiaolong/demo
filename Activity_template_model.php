<?php
/**
 * Created by PhpStorm.
 * User: xiaosu
 * Date: 2019/1/16
 * Time: 14:26
 */

class Activity_template_model extends MY_Model
{
    private $table_name;

    function __construct()
    {
        $this->table_name = 'activity_template';
        parent::__construct($this->table_name);
    }

    public function getList(){
        $this->db->select('SQL_CALC_FOUND_ROWS *',false);
        $this->db->limit($_POST['pagesize'],$_POST['start']);
        $q = $this->db->get($this->table_name);
        $rs = $this->db->query('SELECT FOUND_ROWS() total');
        $count = $rs->row_array();
        return ['list'=>$q->result_array(),'total'=>$count['total']];
    }

    public function getInfo(){
        $this->db->select('p.url,p.type,p.pic_url,p.id as p_id,ac.name,ac.remarks,ac.status,ac.start_time,ac.end_time,ac.coupon_type,ac.package_type');
        $this->db->join('page_config p','p.template_id = ac.id','left');
        $this->db->where('ac.id',$_POST['id']);
        $q = $this->db->get($this->table_name.' ac');
        return $q->result_array();
    }
}