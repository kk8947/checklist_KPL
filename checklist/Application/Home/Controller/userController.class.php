<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
	//食神达人列表
	public function index()
	{
		$User = M("t_user");
		$data = $User->select();
		if ($data) {
        	$this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
        else{
        	$this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }

	}
	//我的菜谱列表
	public function mycook($userid)
	{
		$MyCook = M();
		$data = $MyCook->table("t_cookbook")
		->field("cookbook_id,cookbook_name,cookbook_image")
		->where("t_cookbook.user_id = $userid")->select();
		if(!empty($data)){ //判断一级是否为空
        foreach($data as $key=>$value){   //循环读取
            $pid =  $value['cookbook_id'];//字段赋值
            $data[$key]["material"] = M("t_material")->where("cookbook_id =$pid")->select();
            $data[$key]["collectionnumber"] = M("t_collectionnumber")->where("cookbook_id =$pid")->select();
            $data[$key]["browsenumber"] = M("t_browsenumber")->where("cookbook_id =$pid")->select();
          }
        }
		if ($data) {
        	$this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
        else{
        	$this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }

	}


	//获取某一个用户信息
	public function userdetail($userid){
		$Users = M("t_user");
		$data = $Users->where("user_id=$userid")->select()[0];

		$Fans = M("t_fans");
		$Fansdata = $Fans->where("user_id=$userid")->select();
		$data["fanscount"] = count($Fansdata);

		$Attention = M("t_fans");
		$Attentiondata = $Attention->where("user_fans=$userid")->select();
		$data["attcount"] = count($Attentiondata);

		if ($data) {
        	$this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
        else{
        	$this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }
	}
	//登录
    public function login(){

//http://localhost:8886/ishop/index.php/home/user/login
    		//	username=ccc&password=000000
    	//Content-Type: application/json
        $username = $_POST["username"];
		$password = $_POST["password"];

		$Users = M("t_user");

		// 定义多条件
		$condition["user_name"] = $username;
		$condition["user_password"] = $password;

		$data = $Users -> where($condition) -> select();
		$sql=$Users->getLastSql();

		if ($data) {
			$this -> ajaxReturn(array("code" => "200" ,"data" => $data ),"JSON");
		}
		else
		{
			$this -> ajaxReturn(array("code" => "500","sql"=>$sql ,"data" => "null" ),"JSON");
		}
    }

public function panduan($email){
	$Main = M("t_user");
	$data = $Main->where("user_mail=$email")->select();
	if ($data) {
        	$this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
        else{
        	$this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }

}
    //邮箱注册
    public function registermail(){

    	$email = $_POST["email"];
		$password = $_POST["password"];
		$nickname = $_POST["nickname"];
        
        //重复性判断
		if ($this->isExistMail($email)) {
			$this -> ajaxReturn(array("status" => "500" ,"message" => "邮箱重复"),"JSON");
			return;
		}

		$Users = M("t_user");

		// 添加的数据
		$data["user_mail"] = $email;
		$data["user_name"] = $email;
		$data["user_password"] = $password;
		$data["user_nickname"] = $nickname;
		$userid = $Users -> add($data);

		if ($userid) {
			$this -> ajaxReturn(array("code" => "200" ,"userid" => $userid),"JSON");
		}
		else
		{
			$this -> ajaxReturn(array("code" => "500" ,"message" => "注册失败" ),"JSON");
		}

    }

    public function isExistMail($email)
	{
		$Users = M("t_user");
		$data = $Users -> where(" user_mail = '$email'") -> select();
		if ($data) {
			return true;
		}
		else
		{
			return false;
		}

	}

    //手机号注册
    public function register(){

    	$tel = $_POST["tel"];
		$password = $_POST["password"];
        
        //重复性判断
		if ($this->isExistTel($tel)) {
			$this -> ajaxReturn(array("status" => "500" ,"message" => "手机号重复"),"JSON");
			return;
		}

		$Users = M("t_user");

		// 添加的数据
		$data["user_telephone"] = $tel;
		$data["user_password"] = $password;
		$userid = $Users -> add($data);

		if ($userid) {
			$this -> ajaxReturn(array("code" => "200" ,"userid" => $userid),"JSON");
		}
		else
		{
			$this -> ajaxReturn(array("code" => "500" ,"message" => "注册失败" ),"JSON");
		}

    }

    //手机号重复验证
	public function isExistTel($tel)
	{
		$Users = M("t_user");
		$data = $Users -> where(" user_telephone = '$tel'") -> select();
		if ($data) {
			return true;
		}
		else
		{
			return false;
		}

	}

//改昵称
	public function nickname(){
		$userid = $_POST["userid"];
		$nickname = $_POST["nickname"];

		$Ncikname = M("t_user");
		$data["user_nickname"] = $nickname;
		$Ncikname
		->where("user_id=$userid")
		->save($data);

		if ($userid) {
			$this -> ajaxReturn(array("code" => "200" ,"userid" => $userid),"JSON");
		}
		else
		{
			$this -> ajaxReturn(array("code" => "500" ,"message" => "更新失败" ),"JSON");
		}

	}

public function uploadHeaderImage()
    {
        	
      $config = array(
          'maxSize' => 1024 * 1024,
          'rootPath' => './image/',   //根目录
          //'savePath' => 'images/', //图片文件夹目录
          'autoSub' => true,
          'saveName' => array('uniqid','is'),//默认的命名规则设置是采用uniqid函数生成一个唯一的字符串序列,is为图片名前缀
          'exts' => array('jpg', 'gif', 'png', 'jpeg'),
          'autoSub' => false,
          'subName' => array('date','Ymd')
          );
      $upload = new \Think\Upload($config);// 实例化上传类

      $info = $upload -> upload();//上传

      foreach ($info as  $key => $value) {
      	//获取保存图片的名称
         $data["user_headerimage"] = $value['savename'];

       }
       if ($data) {
        	$this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
        else{
        	$this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }
         
     }


public function gaiheaderimage(){
		$userid = $_POST["userid"];
		$headerimage = $_POST["headerimage"];

		$Ncikname = M("t_user");
		$data["user_herderimage"] = $headerimage;
		$Ncikname
		->where("user_id=$userid")
		->save($data);

		if ($userid) {
			$this -> ajaxReturn(array("code" => "200" ,"userid" => $userid),"JSON");
		}
		else
		{
			$this -> ajaxReturn(array("code" => "500" ,"message" => "更新失败" ),"JSON");
		}
}

//改个性签名
public function stur(){
		$userid = $_POST["userid"];
		$stur = $_POST["stur"];

		$Ncikname = M("t_user");
		$data["user_stur"] = $stur;
		$Ncikname
		->where("user_id=$userid")
		->save($data);

		if ($userid) {
			$this -> ajaxReturn(array("code" => "200" ,"userid" => $userid),"JSON");
		}
		else
		{
			$this -> ajaxReturn(array("code" => "500" ,"message" => "更新失败" ),"JSON");
		}

	}


//改性别
public function sex(){
		$userid = $_POST["userid"];
		$sex = $_POST["sex"];

		$Sex = M("t_user");
		$data["user_sex"] = $sex;
		$Sex
		->where("user_id=$userid")
		->save($data);

		if ($userid) {
			$this -> ajaxReturn(array("code" => "200" ,"userid" => $userid),"JSON");
		}
		else
		{
			$this -> ajaxReturn(array("code" => "500" ,"message" => "更新失败" ),"JSON");
		}

	}	


//改城市
public function city(){
		$userid = $_POST["userid"];
		$city = $_POST["city"];

		$City = M("t_user");
		$data["user_city"] = $city;
		$City
		->where("user_id=$userid")
		->save($data);

		if ($userid) {
			$this -> ajaxReturn(array("code" => "200" ,"userid" => $userid),"JSON");
		}
		else
		{
			$this -> ajaxReturn(array("code" => "500" ,"message" => "更新失败" ),"JSON");
		}

	}	

//获取粉丝列表
public function fans($userid){
	$Fans = M();
	$data = $Fans
	->field("t_user.user_nickname,t_user.user_herderimage,t_user.user_id")
	->table("t_user,t_fans")
	->where("t_fans.user_fans=t_user.user_id AND t_fans.user_id=$userid")
	->select();
	if($data)
            $this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        else
            $this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");

}
//获取关注列表
public function attentions($userid){
	$Attention = M();
	$data = $Attention
	->field("t_user.user_nickname,t_user.user_herderimage,t_user.user_id")
	->table("t_user,t_fans")
	->where("t_fans.user_fans=$userid AND t_fans.user_id=t_user.user_id")
	->select();
	if($data)
            $this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        else
            $this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
}

public function daren(){
	$Users = M("t_user");
	$data = $Users->limit(5)->select();

	if($data)
            $this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        else
            $this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
}

public function tauserinfo($userid)
{
	$Users = M("t_user");
	$data["userinfo"] = $Users
	->field("user_stur,user_herderimage,user_nickname,user_id")
	->where("user_id=$userid")
	->select();

	$Fans = M("t_fans");
	$Fansdata = $Fans
	->where("user_id=$userid")
	->select();
	$data["fanscount"] = count($Fansdata);

	$Attention = M("t_fans");
	$Attentiondata = $Attention
	->where("user_fans=$userid")
	->select();
	$data["attcount"] = count($Attentiondata);

	$Shai = M();
	$data["shaiinfo"] = $Shai
	->field("t_user.user_id,t_user.user_nickname,t_user.user_herderimage,t_shai.*")
	->table("t_shai,t_user")
	->where("t_shai.user_id = t_user.user_id AND t_shai.user_id = $userid")
	->order("t_shai.shai_time desc")
	->select();

	$Release = M("t_cookbook");
	$Releasedata = $Release
	->order("cookbook_creattime desc")
	->field("cookbook_name,cookbook_introduction,cookbook_image,cookbook_creattime,cookbook_id")
	->where("user_id = $userid")
	->select();
	$data["booknum"] = count($Releasedata);
	$data["bookinfo"] = $Releasedata;


	$Detectionshouye = M();

	$data["detectioninfo"] = $Detectionshouye
	->field("t_user.user_id,t_user.user_nickname,t_user.user_herderimage,t_detection.*")
	->table("t_user,t_detection")
	->where("t_user.user_id=t_detection.user_id AND t_detection.user_id = $userid")
	->order("detection_time desc")
	->select();


	if ($data) {
        	$this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
        else{
        	$this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }

}


//关注
public function deletefans($userid,$attentionid){
	$User = M("t_fans");
	$userdata = $User 
	->where("user_fans = $userid AND user_id=$attentionid")
	->select();
	if ($userdata) {
		$User 
		->where("user_fans = $userid AND user_id=$attentionid")
		->delete();
	}
	else
	{
		$data["user_fans"] = $userid;
		$data["user_id"] = $attentionid;
		$userid = $User -> add($data);
	}
	if ($userid) {
			$this -> ajaxReturn(array("code" => "200" ,"userid" => $userid),"JSON");
		}
		else
		{
			$this -> ajaxReturn(array("code" => "500" ,"message" => "更新失败" ),"JSON");
		}
}

public function mydetection($userid)
{
	$Detectionshouye = M();

	$data["info"]= $Detectionshouye
	->field("t_user.user_id,t_user.user_nickname,t_user.user_herderimage,t_detection.*")
	->table("t_user,t_detection")
	->where("t_user.user_id=t_detection.user_id AND t_detection.user_id = $userid")
	->order("detection_time desc")
	->select();

	foreach ($data["info"] as $key => $value) {
			$iddd = $value['detection_id'];
			$Cell = M("t_detectioncell");
        	$cellnum = $Cell->where("detection_id=$iddd")->select();
        	$cellnums[] = count($cellnum);
		}
	$data["cellnum"] = $cellnums;


	if ($data) {
        	$this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
        else{
        	$this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }
}

public function zuop($userid)
{
	$Shai = M();

	$data = $Shai
	->table("t_user,t_shai")
	->field("t_user.user_id,t_user.user_nickname,t_user.user_herderimage,t_shai.*")
	->where("t_shai.user_id = $userid AND t_user.user_id = t_shai.user_id")
	->order("shai_time desc")
	->select();

	if ($data) {
        	$this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
        else{
        	$this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }

}

public function delecoolect($userid,$cookbookid)
{
	$Collect = M("t_collection");
	$Collect 
		->where("user_id = $userid AND cookbook_id=$cookbookid")
		->delete();
}


}