<?php
/**
 * Created by PhpStorm.
 * User: xiaosu
 * Date: 2019/1/16
 * Time: 14:25
 */

class Activity_template extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getList(){
        echo json_encode_unicode($this->model->getList($_POST),256);
    }

    public function getInfo(){
        $data = [];
        $activity = $this->model->getInfo($_POST);
        foreach ($activity as $v){
            switch ($v['type']){
                case 6:
                    $data['banner_url'] = $v['url'];
                    $data['banner_pic_url'] = $v['pic_url'];
                    break;
                case 7:
                    $data['brief_url'] = $v['url'];
                    $data['brief_pic_url'] = $v['pic_url'];
                    break;
                case 8:
                    $data['instructions_url'] = $v['url'];
                    $data['instructions_pic_url'] = $v['pic_url'];
                    break;
                case 9:
                    $data['coupon_list'][] = ['id'=>$v['p_id'],'url'=>$v['url'],'pic_url'=>$v['pic_url']];
                    break;
                case 10:
                    $data['package_list'][] = ['id'=>$v['p_id'],'url'=>$v['url'],'pic_url'=>$v['pic_url']];
                    break;
            }
        }
        if(!empty($activity[0])) $data['activity_info'] = $activity[0];
        echo json_encode_unicode($data,256);
    }
}