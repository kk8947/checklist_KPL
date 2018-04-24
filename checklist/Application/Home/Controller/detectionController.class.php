<?php
namespace Home\Controller;
use Think\Controller;
class DetectionController extends Controller {


	//获取帖子一楼内容
	public function shouye(){
		$Detectionshouye = M();

		$data["info"] = $Detectionshouye
		->field("t_user.user_id,t_user.user_nickname,t_user.user_herderimage,t_detection.*")
		->table("t_user,t_detection")
		->where("t_user.user_id=t_detection.user_id")
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

public function test($detectionid){
		$Cell = M("t_detectioncell");
        $cellnum = $Cell->where("detection_id=$detectionid")->select();
		//$cellnums[]= count($cellnum);
		$data = count($cellnum);
		if ($data) {
        	$this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
        else{
        	$this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }

}



	//获取帖子内容
	public function main($detectionid){
		$Main = M();
		$data = $Main
		->field("t_user.user_id,t_user.user_nickname,t_user.user_herderimage,t_detectioncell.*")
		->table("t_user,t_detectioncell")
		->where("t_user.user_id=t_detectioncell.user_id AND t_detectioncell.detection_id=$detectionid")
		->order("detectioncell_time asc")
		->select();
		if ($data) {
        	$this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
        else{
        	$this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }

	}

	//发布帖子
	public function addtie(){


		$Detection = M("t_detection");
		// 添加的数据
		$data["detection_name"] = $_POST["name"];
		$data["user_id"] = $_POST["userid"];
		$data["detection_body"] = $_POST["body"];
		$data["detection_time"] = $_POST["time"];
		$id = $Detection -> add($data);

		if ($id) {
			$this -> ajaxReturn(array("code" => "200" ,"commentid" => $id),"JSON");
		}
		else
		{
			$this -> ajaxReturn(array("code" => "500" ,"commentid" => "null" ),"JSON");
		}
	}

	//回复帖子
	public function addhuifu(){

		$Detectioncell = M("t_detectioncell");
		// 添加的数据
		$data["detection_id"] = $_POST["id"];
		$data["user_id"] = $_POST["userid"];
		$data["detectioncell_body"] = $_POST["body"];
		$data["detectioncell_time"] = $_POST["time"];
		$id = $Detectioncell -> add($data);

		if ($id) {
			$this -> ajaxReturn(array("code" => "200" ,"commentid" => $id),"JSON");
		}
		else
		{
			$this -> ajaxReturn(array("code" => "500" ,"commentid" => "null" ),"JSON");
		}
	}

	//上传图片
	public function uploadimage(){
		$config = array(
          'maxSize' => 10240 * 10240,
          'rootPath' => './Application/Home/Image/',   //根目录
          'savePath' => 'Detectionimage/', //图片文件夹目录
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
         $imagename[] = $value['savename'];
       }

       $Detection = M("t_detection");
		// 添加的数据
		$data["detection_name"] = $_POST["name"];
		$data["user_id"] = $_POST["userid"];
		$data["detection_body"] = $_POST["body"];
		$data["detection_time"] = $_POST["time"];
		$data["detection_image"] = implode($imagename);
		$id = $Detection -> add($data);
       if ($imagename) {
        	$this->ajaxReturn(array("code"=>"200","data"=>$imagename),"JSON");
        }
        else{
        	$this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }

	}


	//获取用户名头像
	public function userinfo($userid){
		$Main = M("t_user");
		$data = $Main->where("user_id=$userid")->select();
		if ($data) {
        	$this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
        else{
        	$this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }


	}

	//晒一晒
public function shaishouye()
{
	$Shai = M();
	$data = $Shai
	->field("t_user.user_id,t_user.user_nickname,t_user.user_herderimage,t_shai.*")
	->table("t_shai,t_user")
	->where("t_shai.user_id = t_user.user_id")
	->order("t_shai.shai_time desc")
	->select();

	if ($data) {
        	$this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
        else{
        	$this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }

}

public function addshai(){
	$config = array(
          'maxSize' => 10240 * 10240,
          'rootPath' => './Application/Home/Image/',   //根目录
          'savePath' => 'Shaiimage/', //图片文件夹目录
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
         $imagename = $value['savename'];
       }
      $Shai = M("t_shai");
		// 添加的数据
		$data["shai_name"] = $_POST["shainame"];
		$data["user_id"] = $_POST["userid"];
		$data["shai_stur"] = $_POST["stur"];
		$data["shai_time"] = $_POST["time"];
		$data["shai_image"] = $imagename;
		$id = $Shai -> add($data);
	if ($imagename) {
        	$this->ajaxReturn(array("code"=>"200","data"=>$imagename),"JSON");
        }
        else{
        	$this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }

}

public function shaicomment($shaiid)
{
	$Shaicell = M();

	$data = $Shaicell
	->field("t_shaicell.*,t_user.user_id,t_user.user_nickname,t_user.user_herderimage")
	->table("t_shaicell,t_user")
	->where("t_shaicell.shai_id = $shaiid AND t_shaicell.user_id = t_user.user_id")
	->order("t_shaicell.shaicell_time desc")
	->select();

	if ($data) {
        	$this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
    else{
        	$this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }



}

public function addshaicomment(){
	$Shaicell = M("t_shaicell");

	$data["user_id"] = $_POST["userid"];
	$data["shaicell_time"] = $_POST["time"];
	$data["shaicell_body"] = $_POST["body"];
	$data["shai_id"] = $_POST["shaiid"];
	$id = $Shaicell -> add($data);

	if ($id) {
        	$this->ajaxReturn(array("code"=>"200","data"=>$id),"JSON");
        }
        else{
        	$this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }
}



}	