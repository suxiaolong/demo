<?php
/**
 * Created by PhpStorm.
 * User: xiaosu
 * Date: 2019/1/14
 * Time: 11:35
 */
?>
<style type="text/css">
    .Tips_ {position: fixed;width: 200px;height: 100px;line-height: 100px;border-radius: 3px;background-color: rgba(0, 0, 0, 0.6);left: 50%;top: 50%;margin-left: -100px;margin-top: -50px;display: none;text-align: center;color: #fff;font-size: 16px;z-index: 999999;}
    .botton-edit span{color: white;}
    .dialog{position: fixed; left:50%;top:30%;width: 200px;height: 80px;background: rgba(0,0,0,0.8);z-index: 100;border-radius: 8px;display: flex;align-items: center;justify-content: center;}
    .dialog .dialog-msg{color: #f7f7f7;line-height: 2;font-size: 16px;text-align: center;}
    .nav-page{display: flex;justify-content: flex-end;}
</style>
<div id="activity-list">
    <div class="Tips_"></div>
    <h1 class="admin-title">常规活动配置</h1>
    <div class="cont">
        <form class="form">
            <input type="hidden" class="packageList" name="" value="">
            <div class="choice">
                <a target="_blank" class="btn_submit" href="<?php echo base_url('adminactivity/general_activity_edit') ?>">添加活动</a>
                <div class="clear"></div>
            </div>
        </form>
        <div class="table">
            <h3 class="tle">常规活动列表</h3>
            <div class="table-content clear">
                <table class="mytable">
                    <tr class="thead">
                        <td width="100">序号</td>
                        <td>活动名称</td>
                        <td>有效期</td>
                        <td width="100">状态</td>
                        <td>操作</td>
                    </tr>
                    <tbody>
                        <tr v-for="(v,k) in temlist">
                            <td>{{v.id}}</td>
                            <td>{{v.name}}</td>
                            <td>{{v.start_time}}</td>
                            <td>{{v.status | getStatus }}</td>
                            <td>
                                <a class="btn btn-info btn-xs" target="_blank" :href="baseurl+'adminactivity/general_activity_edit?id='+v.id" >编辑</a>
                             </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <ul class="nav-page">
            <li><button @click="descPage">上一页</button></li>
            <li>
                <span>当前页</span>
                <select name="" id="" v-model.lazy="page">
                    <option :value="item" v-for="item in totalPage">{{item}}</option>
                </select>
            </li>
            <li>共{{totalPage}}页</li>
            <li><button @click="ascPage">下一页</button></li>
        </ul>
    </div>
    <div class="dialog" v-show="dialogShow" style="z-index: 9999;">
        <div class="dialog-msg">{{msg}}</div>
    </div>
    <div v-if="loading">Loading...</div>
    <div v-if="errored">请求失败</div>
</div>
<script>
    var statusName = ['未开始','已上架','已下架'];
    var vue = new Vue({
        el:'#activity-list',
        data:{
            dialogShow:false,
            msg:'',
            loading: true,
            errored: false,
            baseurl: "<?php echo $this->config->item('base_url')?>",
            temlist:[],
            page: 1,
            pageSize: 15,
            totalcount:0,
        },
        created(){
        },
        mounted: function () {
            this.getList();
        },
        computed: {
            totalPage: function () {
                return Math.ceil(this.totalcount/this.pageSize);
            }
        },
        watch: {
            page: function () {
                this.getList();
            }
        },
        filters: {
            getStatus(index) {
                return statusName[index]
            }
        },
        methods:{
            showDialog: function(msg) {
                var _this = this;
                _this.dialogShow = true;
                _this.msg = msg;
                setTimeout(function(){
                    _this.dialogShow = false;
                },2000)
            },
            getList:function () {
                var _self = this;
                var start = (_self.page - 1)*_self.pageSize;
                axios.get(this.baseurl+'adminActivity/general_activity_list',{
                     params:{
                       isAjax:1,
                       start:start,
                       pagesize:_self.pageSize,
                      }
                   }).then(function (res) {
                        _self.totalcount = res.data.total;
                        _self.temlist = res.data.list.map(function(tao){
                            return tao
                        })
                     })
                    .catch(function (error) {
                        console.log(error);
                        this.errored = true
                    })
                    .finally(() => this.loading = false)
            },
            descPage: function () {
                if (this.page > 1) {
                    this.page -= 1;
                }
            },
            ascPage: function () {
                if (this.page < this.totalPage) {
                    this.page += 1;
                }
            },
        }
    })
</script>