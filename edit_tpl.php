<?php
/**
 * Created by PhpStorm.
 * User: xiaosu
 * Date: 2019/1/15
 * Time: 14:58
 */
?>
<link href="<?php echo STATIC_ROOT ?>css/bootstrap3.min.css" rel="stylesheet">
<style type="text/css">
    .Tips_ {position: fixed;width: 200px;height: 100px;line-height: 100px;border-radius: 3px;background-color: rgba(0, 0, 0, 0.6);left: 50%;top: 50%;margin-left: -100px;margin-top: -50px;display: none;text-align: center;color: #fff;font-size: 16px;z-index: 999999;}
    .botton-edit span{color: white;}
    .div-input-left{margin-left: -15px;}
    .cooperation_keword,.access_keyword{margin-left: -30px;}
    .datepicker{z-index: 9999 !important;}
    textarea{border: 2px solid #eae8e8;}
    .lab_file{font-size: 12px;padding: 5px 15px;background: #fff;color: #000;border: 1px solid;border-radius: 17px;border-color: #000;margin-top: 16px;}
    .i-span{color: #ccc}
    i{margin-left: 16px;}
    .dialog{position: fixed; left:50%;top:30%;width: 200px;height: 80px;background: rgba(0,0,0,0.8);z-index: 100;border-radius: 8px;display: flex;align-items: center;justify-content: center;}
    .dialog .dialog-msg{color: #f7f7f7;line-height: 2;font-size: 16px;text-align: center;}
    .img-file{margin-left: 10px;width:auto;height:auto;max-width: 100%;max-height: 100%;}
    .i-span > .form-group{margin-left: 2px;margin-bottom: 10px;}
    .i-span > .form-group>input{width: 350px;}
    .glyphicon-remove-circle{font-size: 25px;margin-left: 40px;color: red;}
</style>
<?php if ($save_rs) {
    if ($save_rs['ret']) {
        ?>
        <div class="green div-tip">
            <?php echo $save_rs['msg'] ?> <a class="btn_submit" href="<?php echo base_url('adminactivity/general_activity_list') ?>">返回列表</a>
        </div>
    <?php } else {
        ?>
        <div class="red div-tip"><?php echo $save_rs['msg'] ?></div>
    <?php }
} ?>
<div class="div-all" id="activity_list">
    <div class="Tips_"></div>
    <form class="form-horizontal form-submit" id="form-data" enctype="multipart/form-data" method="post">
        <input type="hidden" name="id" v-model="id">
        <div class="panel panel-default">
            <div class="panel-heading">活动信息</div>
            <div class="panel-body">
                <div class="col-sm-9">
                    <div class="form-group">
                        <label for="" class="col-sm-1 control-label">活动名称:</label>
                        <div class="col-sm-7">
                            <input type="text" v-model="activity.name" name="name" class="form-control" autocomplete="off" placeholder="请输入" value="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="form-group">
                        <label for="" class="col-sm-1 control-label">有效期：</label>
                        <div class="">
                            <div class="col-sm-3">
                                <input type="text" v-model="activity.start_time" autocomplete="off" name="start_time" id="start_time" class="form-control selectSearchTime" value="" placeholder="2019-01-01">
                            </div>
                            <div class="col-sm-1"><label for="" class="control-label">至</label></div>
                            <div class="col-sm-3">
                                <input type="text" v-model="activity.end_time" autocomplete="off" name="end_time" class="form-control selectSearchTime" value="" placeholder="2019-01-01">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="form-group">
                        <label for="" class="col-sm-1 control-label">备注：</label>
                        <div class="col-sm-7">
                            <textarea v-model="activity.remarks" name="remarks" class="form-control" id="" cols="80" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="form-group">
                        <label for="" class="col-sm-1 control-label">活动状态：</label>
                        <div class="col-sm-7">
                            <label for="status1" class="radio-inline">
                                <input id="status1" type="radio" v-model="activity.status" name="status" value="1">未开始
                            </label>
                            <label for="status2" class="radio-inline">
                                <input id="status2" type="radio" v-model="activity.status" name="status" value="2">已上架
                            </label>
                            <label for="status3" class="radio-inline">
                                <input id="status3" type="radio" v-model="activity.status" name="status" value="3">已下架
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">banner配置</div>
            <div class="panel-body">
                <div class="col-sm-9">
                    <div class="form-group">
                        <label for="" class="col-sm-1 control-label">跳转链接：</label>
                        <div class="col-sm-7">
                            <input type="text" v-model="imageInfo.banner_url" name="banner_url" class="form-control" autocomplete="off" placeholder="http://xxx" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-1"></div>
                        <input style="display: none;" type="file" name="banner_pic_url" id="img_big_banner" @change="changeImage('banner')">
                        <img class="file_img_banner img-file" :src="(imageInfo.banner_pic_url == null?this.baseurl+'resource/images/activity_default.png':this.websitPath+imageInfo.banner_pic_url)">
                        <i>
                            <span class="i-span">尺寸限制：宽度375px,高度不限制</span></br>
                            <span class="i-span">格式png,jpeg,jpg。大小不能超过2M</span></br>
                            <label for="img_big_banner" id="lab_file_banner" class="lab_file">上传图片</label>
                        </i>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">活动简介配置</div>
            <div class="panel-body">
                <div class="col-sm-9">
                    <div class="form-group">
                        <label for="" class="col-sm-1 control-label">跳转链接：</label>
                        <div class="col-sm-7">
                            <input type="text" v-model="imageInfo.brief_url" name="brief_url" class="form-control" autocomplete="off" placeholder="http://xxx" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-1"></div>
                        <input style="display: none;" type="file" name="brief_pic_url" id="img_big_brief" @change="changeImage('brief')">
                        <img class="file_img_brief img-file" :src="(imageInfo.brief_pic_url == null?this.baseurl+'resource/images/activity_default.png':this.websitPath+imageInfo.brief_pic_url)">
                        <i>
                            <span class="i-span">尺寸限制：宽度375px,高度不限制</span></br>
                            <span class="i-span">格式png,jpeg,jpg。大小不能超过2M</span></br>
                            <label for="img_big_brief" class="lab_file">上传图片</label>
                        </i>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">优惠券配置</div>
            <div class="panel-body">
                <div class="col-sm-9">
                    <div class="form-group">
                        <label for="" class="col-sm-1 control-label">优惠券样式：</label>
                        <div class="col-sm-7">
                            <label class="radio-inline">
                                <input type="radio" v-model="activity.coupon_type"  name="coupon_type"  value="1">样式1
                                <img width="100px" src="<?php echo $this->config->item('base_url') ?>/resource/images/activity_package1.png">
                            </label>
                            <label class="radio-inline">
                                <input type="radio" v-model="activity.coupon_type" name="coupon_type"  value="2">样式2
                                <img width="100px" src="<?php echo $this->config->item('base_url') ?>/resource/images/activity_package2.png">
                            </label>
                            <label class="radio-inline">
                                <input type="radio" v-model="activity.coupon_type" name="coupon_type" value="3">样式3
                                <img width="100px" src="<?php echo $this->config->item('base_url') ?>/resource/images/activity_package3.png">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9 couponDiv">
                    <div v-for="(coupon,index) in couponList" :class="'form-group couponDiv'+coupon.id">
                        <input type="hidden" name="coupon_id[]" :value="coupon.id">
                        <input style="display: none;" type="file" name="coupon_pic_url[]" :id="'img_big_coupon'+coupon.id" @change="changeImage('coupon'+coupon.id)">
                        <img :class="'img-file file_img_coupon'+coupon.id" :src="(coupon.pic_url == null?baseurl+'resource/images/activity_default.png':websitPath+coupon.pic_url)">
                        <i>
                            <div class="form-inline i-span">
                                <div class="form-group">
                                    <label class="control-label">跳转链接：</label>
                                    <input type="text" v-model="coupon.url" name="coupon_url[]" class="form-control" autocomplete="off" placeholder="http://xxx" value="">
                                    <span class="glyphicon glyphicon-remove-circle" @click="delCouponDiv(index,coupon.id)"></span>
                                </div>
                            </div>
                            <label :for="'img_big_coupon'+coupon.id" class="lab_file">上传图片</label>
                        </i>
                    </div>
                </div>
                <button class="btn btn-primary col-sm-6" type="button" @click="addCouponDiv()">+添加</button>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">推荐套餐配置</div>
            <div class="panel-body">
                <div class="col-sm-9">
                    <div class="form-group">
                        <label for="" class="col-sm-1 control-label">套餐样式：</label>
                        <div class="col-sm-7">
                            <label class="radio-inline">
                                <input type="radio" v-model="activity.package_type" name="package_type" value="1">样式1
                                <img width="100px" src="<?php echo $this->config->item('base_url') ?>/resource/images/activity_package1.png">
                            </label>
                            <label class="radio-inline">
                                <input type="radio" v-model="activity.package_type" name="package_type" value="2">样式2
                                <img width="100px" src="<?php echo $this->config->item('base_url') ?>/resource/images/activity_package2.png">
                            </label>
                            <label class="radio-inline">
                                <input type="radio" v-model="activity.package_type" name="package_type" value="3">样式3
                                <img width="100px" src="<?php echo $this->config->item('base_url') ?>/resource/images/activity_package3.png">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div v-for="(package,index) in packageList" class="form-group">
                        <input type="hidden" name="package_id[]" :value="package.id">
                        <input style="display: none;" type="file" name="package_pic_url[]" :id="'img_big_package'+package.id" @change="changeImage('package'+package.id)">
                        <img :class="'img-file file_img_package'+package.id" :src="(package.pic_url == null?baseurl+'resource/images/activity_default.png':websitPath+package.pic_url)">
                        <i>
                            <div class="form-inline i-span">
                                <div class="form-group">
                                    <label class="control-label">跳转链接：</label>
                                    <input type="text" v-model="package.url" name="package_url[]" class="form-control" autocomplete="off" placeholder="http://xxx" value="">
                                    <span class="glyphicon glyphicon-remove-circle" @click="delPackageDiv(index,package.id)"></span>
                                </div>
                            </div>
                            <label :for="'img_big_package'+package.id" class="lab_file">上传图片</label>
                        </i>
                    </div>
                </div>
                <button class="btn btn-primary col-sm-6" type="button" @click="addPackageDiv()">+添加</button>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">活动说明</div>
            <div class="panel-body">
                <div class="col-sm-9">
                    <div class="form-group">
                        <label for="" class="col-sm-1 control-label">跳转链接：</label>
                        <div class="col-sm-7">
                            <input type="text" v-model="imageInfo.instructions_url" name="instructions_url" class="form-control" autocomplete="off" placeholder="http://xxx">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-1"></div>
                        <input style="display: none;" type="file" name="instructions_pic_url" id="img_big_instructions" @change="changeImage('instructions')">
                        <img class="file_img_instructions img-file" :src="(imageInfo.instructions_pic_url == null?baseurl+'resource/images/activity_default.png':websitPath+imageInfo.instructions_pic_url)">
                        <i>
                            <span class="i-span">尺寸限制：宽度375px,高度不限制</span></br>
                            <span class="i-span">格式png,jpeg,jpg。大小不能超过2M</span></br>
                            <label for="img_big_instructions" class="lab_file">上传图片</label>
                        </i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-sm-9">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="button" class="btn btn-primary col-sm-offset-3 button-submit" @click="submit()">提交</button>
            </div>
        </div>
    </form>
    <div class="dialog" v-show="dialogShow" style="z-index: 9999;">
        <div class="dialog-msg">{{msg}}</div>
    </div>
</div>
<script src="<?php echo base_url()?>resource/js/jquery.form.js"></script>
<script src="<?php echo STATIC_ROOT; ?>layui/layui.all.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.13.1/lodash.min.js"></script>
<script>
    var vue = new Vue({
        el: '#activity_list',
        data: {
            baseurl: "<?php echo $this->config->item('base_url')?>",
            websitPath: "<?php echo $this->config->item('websit_path')?>",
            dialogShow:false,
            loading: true,
            errored: false,
            msg:'',
            dataList:[],
            couponNum:4,
            couponList:[
                {id:1},
                {id:2},
                {id:3}
            ],
            packageNum:2,
            packageList:[
                {id:1},
            ],
            activity:{},
            couponArr:[],
            packageArr:[],
            imageInfo:[],
            isCheck:false,
            id:'<?php echo empty($_GET['id'])?'':$_GET['id']?>',
        },
        created:function(){
            if(this.id != '') this.getActivity();
        },
        mounted: function () {

        },
        methods: {
            showDialog: function(msg) {
                var _this = this;
                _this.dialogShow = true;
                _this.msg = msg;
                console.log(msg);
                setTimeout(function(){
                    _this.dialogShow = false;
                },2000)
            },
            changeImage: function (name) {
                var _this = this;
                var file = document.getElementById('img_big_'+name).files[0];
                console.dir(file);
                if( !file['type'].match(/.png|.jpg|.jpeg/)) {
                    _this.showDialog('上传错误,文件格式必须为：png/jpg/jpeg');
                    return;
                }
                if(file['size'] > 1024*1024*2) {
                    _this.showDialog('图片大小不能超过2M');
                    return;
                }
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        var txt = event.target.result;
                        $('.file_img_'+name).attr('src',txt);
                    };
                }
                reader.readAsDataURL(file);
            },
            addCouponDiv:function () {
                this.couponList.push({id:this.couponNum++})
            },
            addPackageDiv:function () {
                this.packageList.push({id:this.packageNum++})
            },
            delCouponDiv:function(index,id){
                console.log(index+'-----'+id);
                if(this.id && confirm('你确认删除吗？')==true){
                    axios.post(this.baseurl+'adminActivity/delImgById',"id="+id, {
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    })
                    .then(function (response) {
                        console.log(response);
                        this.showDialog('删除成功');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                    this.couponList.splice(index,1)
                }
                if(this.id == '') this.couponList.splice(index,1)
            },
            delPackageDiv:function(index,id){
                if(this.id && confirm('你确认删除吗？')==true){
                    axios.post(this.baseurl+'adminActivity/delImgById',"id="+id, {
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    })
                        .then(function (response) {
                            console.log(response);
                            this.showDialog('删除成功');
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    this.packageList.splice(index,1)
                }
                if(this.id == '') this.packageList.splice(index,1)
            },
            checkForm:function(){
                if(this.activity.name == null) {
                    this.showDialog('活动名称不能为空');$("input[name='name']").focus();return;
                }
                if(this.activity.start_time == null) {
                    this.showDialog('请选择活动开始时间');$("input[name='start_time']").focus();return;
                }
                if(this.activity.end_time == null) {
                    this.showDialog('请选择活动结束时间');$("input[name='end_time']").focus();return;
                }
                if(this.activity.status == null) {
                    this.showDialog('请选择活动状态');$("input[name='status']").focus();return;
                }
                if(this.activity.coupon_type == null || this.activity.coupon_type == 0) {
                    this.showDialog('请选择优惠券样式');$("input[name='coupon_type']").focus();return;
                }
                if(this.activity.package_type == null || this.activity.coupon_type == 0) {
                    this.showDialog('请选选择套餐样式');$("input[name='package_type']").focus();return;
                }
                this.isChecked = true;
            },
            submit:function () {
                this.checkForm();
                if(this.isChecked) $('#form-data').submit();
            },
            getActivity:function () {
                var _self = this;
                console.log(_self.id);
                axios.get(this.baseurl+'adminActivity/general_activity_edit?isAjax=1&id='+_self.id)
                    .then(function (res) {
                        _self.activity = res.data.activity_info;
                        _self.imageInfo.banner_pic_url = res.data.banner_pic_url;
                        _self.imageInfo.banner_url = res.data.banner_url;
                        _self.imageInfo.brief_pic_url = res.data.brief_pic_url;
                        _self.imageInfo.brief_url = res.data.brief_url;
                        _self.imageInfo.instructions_pic_url = res.data.instructions_pic_url;
                        _self.imageInfo.instructions_url = res.data.instructions_url;
                        _self.packageList = res.data.package_list;
                        _self.couponList = res.data.coupon_list;
                    })
                    .catch(function (error) {
                        console.log(error);
                        this.errored = true
                    })
                    .finally(() => this.loading = false)
            }
        }
    });
</script>



