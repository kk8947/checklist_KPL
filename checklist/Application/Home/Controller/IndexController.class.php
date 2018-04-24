<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    // public function index(){
    //     $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    // }

    public function test(){
    	$this->ajaxReturn("123");
    }

    //根据日期获取确认情况$day,$project,$code_s,$code_e
    public function request_info($day,$project,$code_s,$code_e){//日期，所属项目，开始编号，结束编号,不传编号默认筛选0~100
    	$Info = M("Travels_check_table");

        if ($code_e = -1) {
            $code_e = 100;
        }

        if ($code_s = -1) {
            $code_s = 0;
        }

    	$data = $Info
        ->where("$project = project_id and $day = day_time and code >= $code_s and code <= $code_e")
    	//->field("Inspection_item_table.inspect")
        ->order("code")
    	->select();

        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');// 响应头设置 

    	if ($data) {
        	$this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
        else{
        	$this->ajaxReturn(array("code"=>"500","data"=>"null!"),"JSON");
        }
    }

    //提交确认信息
    public function submit_confirm(){
        $Table = M("Travels_check_table");

        $id_arr = $_POST["id_arr"];//外键id数组
        $code_arr = $_POST["code_arr"];//编号id数组
        $data["user_name"] = $_POST["user"];//检查人
        $data["user_desc"] = $_POST["desc"];//备注
        $data["edit_man"] = $_POST["edit"];//编辑人员
        //$data["inspect_id"] = $inspect_id;
        $data["inspect_time"] = time();
        $data["day_time"] = date("Ymd");
        $data["project_id"] = $_POST["project_id"];//所属项目id
        $j = 0;
        for ($i = 0; $i < count($id_arr); $i ++) { 
            $data["inspect_id"] = $id_arr[$i];
            $data["code"] = intval($code_arr[$i]);
            $j = $Table -> add($data);
        }

        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');// 响应头设置 

        if ($j) {
            $this->ajaxReturn(array("code"=>"200","data"=>"success!"),"JSON");
        }
        else{
            $this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }
    }

    //负责人提交信息
    public function rep_submit_confirm(){
        $Table = M("Confirm_table");

        $data["user_name"] = $_POST["user"];
        $data["confirm_desc"] = $_POST["desc"];
        $data["project_id"] = $_POST["project_id"];
        $data["confirm_time"] = time();
        $data["confirm_day"] = date("Ymd");

        $add = $Table -> add($data);

        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');// 响应头设置 

        if ($add) {
            $this->ajaxReturn(array("code"=>"200","data"=>"success!"),"JSON");
        }
        else{
            $this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }
    }

    //查询负责人签到信息
    public function request_rep_info(){
        $Table = M("Confirm_table");

        $project_id = $_POST["project_id"];
        $confirm_day = $_POST["confirm_day"];
        $data = $Table
        ->where("project_id = $project_id and confirm_day = $confirm_day")
        ->select();

        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');// 响应头设置 
        
        if ($data) {
            $this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
        else{
            $this->ajaxReturn(array("code"=>"500","data"=>"null!"),"JSON");
        }
    }

    
}