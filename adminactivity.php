<?php
/**
 * Created by PhpStorm.
 * User: xiaosu
 * Date: 2019/1/14
 * Time: 11:36
 */
require_once FCPATH . 'core/AdminController.php';
class adminactivity extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        require_once BASEPATH . 'libraries/user/Myenum.php';
        require_once BASEPATH . 'libraries/Cos/Mycos.php';
        require_once BASEPATH . 'libraries/user/Image.php';
        require_once BASEPATH . 'libraries/user/Cachekey.php';
    }

    public function general_activity_list(){
        $data =[];
        if(!empty($_GET['isAjax'])) {
            $list = CI_MyApi::excute('activity_template/getList',['pagesize'=>$_GET['pagesize'],'start'=>$_GET['start']],'post');
            echo json_encode_unicode($list);die;
        }
        $this->render('list_tpl',$data);
    }

    public function uploadImg($data){
        if ($_FILES[$data['name']]['tmp_name']) {
            if(is_array($_FILES[$data['name']]['tmp_name'])) {
                foreach ($_FILES[$data['name']]['tmp_name'] as $k=>$v) {
                    if(empty($_FILES[$data['name']]['tmp_name'])) continue;
                    $file = [
                        'name'=>$_FILES[$data['name']]['name'][$k],
                        'type'=>$_FILES[$data['name']]['type'][$k],
                        'tmp_name'=>$_FILES[$data['name']]['tmp_name'][$k],
                        'size'=>$_FILES[$data['name']]['size'][$k],
                        'error'=>$_FILES[$data['name']]['error'][$k],
                    ];
                    $upload = $this->_upload_img_file($file, '大图', md5('org_big_' . microtime()), 460 * 340, '200K', 'resource/upload/orgs/');
                    if ($upload[0]) {
                        $map = [
                            'template_id' => $data['id'],
                            'pic_url' => $upload[1],
                            'type' => $data['type'],
                            'url' => $data['url'][$k],
                            'title' => $data['title']
                        ];
                        if(!empty($data['cids'][$k])) $map['id'] = $data['cids'][$k];
                        if(!empty($data['pids'][$k])) $map['id'] = $data['pids'][$k];
                        CI_MyApi::excute('page_config/save_entry', $map, 'post');
                    }
                }
            }else {
                $upload = $this->_upload_img_file($_FILES[$data['name']], '大图', md5('org_big_' . microtime()), 460 * 340, '200K', 'resource/upload/orgs/');
                if ($upload[0]) {
                    $map = [
                        'template_id' => $data['id'],
                        'pic_url' => $upload[1],
                        'type' => $data['type'],
                        'url' => $data['url'],
                        'title' => $data['title']
                    ];
                    CI_MyApi::excute('page_config/save_entry', $map, 'post');
                } else {
                    //return array('ret' => false, 'msg' => $upload[1]);
                }
            }
        }
    }

    public function general_activity_edit(){
        $data = [];
        $saveRes = [];
        if(!empty($_GET['id']) && !empty($_GET['isAjax'])){
            $activity = CI_MyApi::excute('activity_template/getInfo',['id'=>$_GET['id']],'post');
            echo json_encode_unicode($activity);die;
        }
        if(IS_POST){
            if(empty($_POST['name']) || empty($_POST['remarks']) || empty($_POST['start_time'])){
                $saveRes['ret'] = 0;
                $saveRes['msg'] = '每项都要必填必选';
            }else {
                $map = [
                    'name'=>$_POST['name'],
                    'remarks'=>$_POST['remarks'],
                    'status'=>$_POST['status'],
                    'start_time'=>$_POST['start_time'],
                    'end_time'=>$_POST['end_time'],
                    'coupon_type'=>$_POST['coupon_type'],
                    'package_type'=>$_POST['package_type'],
                    'admin_id'=>$this->admin['id']
                ];
                if(!empty($_POST['id'])) $map['id'] = $_POST['id'];
                $res = CI_MyApi::excute('activity_template/save_entry', $map, 'post');
                if ($res) {
                    $map = [
                        'id'=>$res,
                        'title'=>$_POST['name'],
                    ];
                    if (!empty($_FILES["banner_pic_url"]['tmp_name'])) $this->uploadImg(array_merge($map,['type'=>6,'url'=>$_POST['banner_url'],'name'=>'banner_pic_url']));
                    if (!empty($_FILES["brief_pic_url"]['tmp_name'])) $this->uploadImg(array_merge($map,['type'=>7,'url'=>$_POST['brief_url'],'name'=>'brief_pic_url']));
                    if (!empty($_FILES["instructions_pic_url"]['tmp_name'])) $this->uploadImg(array_merge($map,['type'=>8,'url'=>$_POST['instructions_url'],'name'=>'instructions_pic_url']));
                    if (!empty($_FILES["coupon_pic_url"]['tmp_name'])) $this->uploadImg(array_merge($map,['type'=>9,'url'=>$_POST['coupon_url'],'name'=>'coupon_pic_url','cids'=>$_POST['coupon_id']]));
                    if (!empty($_FILES["package_pic_url"]['tmp_name'])) $this->uploadImg(array_merge($map,['type'=>10,'url'=>$_POST['package_url'],'name'=>'package_pic_url','pids'=>$_POST['package_id']]));

                    $saveRes['ret'] = 1;
                    $saveRes['msg'] = empty($_POST['id'])?'保存成功':'修改成功';
                } else {
                    $saveRes['ret'] = 0;
                    $saveRes['msg'] = empty($_POST['id'])?'保存失败':'修改失败';
                }
            }
        }
        $data['save_rs'] = $saveRes;
        $this->render('edit_tpl',$data);
    }

    public function delImgById(){
        return CI_MyApi::excute('page_config/delById',['id'=>$_POST['id']],'post');
    }
}