<?php
namespace Home\Controller;
use Think\Controller;
class cookbookController extends Controller {
    //根据ID获取菜谱详情


    public function index($cookbook_id){
        $Cookbook = M();
        $data["body"] = $Cookbook
        ->table("t_user,t_cookbook")
        ->where("t_user.user_id=t_cookbook.user_id AND t_cookbook.cookbook_id=$cookbook_id")
        ->select();

        $Material = M("t_material");
        $data["material"] = $Material->where("cookbook_id=$cookbook_id")->select(); 

        $Step = M("t_process");
        $data["steps"] = $Step->field("process_step,process_image,process_content")->where("cookbook_id=$cookbook_id")->select();

        $Comment = M();
        $data["comments"] = $Comment
        ->field("t_user.user_nickname,t_user.user_herderimage,t_comment.comment_time,t_comment.comment_body")
        ->table("t_user,t_comment")
        ->where("t_comment.cookbook_id=$cookbook_id AND t_user.user_id=t_comment.user_id")
        ->order("comment_time desc")
        ->select();

        $Zeng = M("t_browsenumber");
        $Zeng->where("cookbook_id = $cookbook_id")->setInc("browsenumber_number");

        if($data)
            $this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        else
            $this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
    }

    //获取评论
    public function comment($cookbookid){
    	$Comment = M();
        $data = $Comment
        ->field("t_user.user_nickname,t_user.user_herderimage,t_comment.comment_time,t_comment.comment_body")
        ->table("t_user,t_comment")
        ->where("t_comment.cookbook_id=$cookbookid AND t_user.user_id=t_comment.user_id")
        ->order("comment_time desc")
        ->select();


        if($data)
            $this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        else
            $this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
    }
//  上传菜谱视频
        public function uploadvideo()
        {
          $config = array(
          'maxSize' => 0,
          'rootPath' => './Application/Home/',   //根目录
          'savePath' => 'Video/', //图片文件夹目录
          'autoSub' => true,
          'saveName' => array('uniqid','is'),//默认的命名规则设置是采用uniqid函数生成一个唯一的字符串序列,is为图片名前缀
          'exts' => array('mp4', 'mov', ),
          'autoSub' => false
          );  
      $upload = new \Think\Upload($config);// 实例化上传类

      $info = $upload -> upload();//上传
      foreach ($info as  $key => $value) {
        //获取保存图片的名称
         $imagename = $value['savename'];
       }
      if ($imagename) {
          $this->ajaxReturn(array("code"=>"200","data"=>$imagename),"JSON");
        }
        else{
          $this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }
         
        }

public function type($type){
      $Type = M();
      if($type == 13)
  {
    $data = $Type
    ->table("t_browsenumber,t_cookbook")->field("t_cookbook.*")
    ->where("t_browsenumber.cookbook_id=t_cookbook.cookbook_id")
    ->order("t_browsenumber.browsenumber_number desc")
    ->select();
        if(!empty($data)){ //判断一级是否为空
        foreach($data as $key=>$value){   //循环读取
            $pid =  $value['cookbook_id'];//字段赋值
            $data[$key]["material"] = M("t_material")->where("cookbook_id =$pid")->select();
            $data[$key]["collectionnumber"] = M("t_collectionnumber")->where("cookbook_id =$pid")->select();
            $data[$key]["browsenumber"] = M("t_browsenumber")->where("cookbook_id =$pid")->select();
          }
        }
      }
      else if ($type == 14) {
        $data = $Type
        ->table("t_collectionnumber,t_cookbook")->field("t_cookbook.*")
        ->where("t_collectionnumber.cookbook_id")
        ->order("t_collectionnumber.collectionnumber_number desc")
        ->select();
        if(!empty($data)){ //判断一级是否为空
        foreach($data as $key=>$value){   //循环读取
            $pid =  $value['cookbook_id'];//字段赋值
            $data[$key]["material"] = M("t_material")->where("cookbook_id =$pid")->select();
            $data[$key]["collectionnumber"] = M("t_collectionnumber")->where("cookbook_id =$pid")->select();
            $data[$key]["browsenumber"] = M("t_browsenumber")->where("cookbook_id =$pid")->select();
          }
        }
      }
      else
      {
      $data = $Type
        ->table("t_type,t_cookbook")
        ->where("t_type.type_name=$type AND t_cookbook.cookbook_id=t_type.cookbook_id")
        ->select();
        if(!empty($data)){ //判断一级是否为空
        foreach($data as $key=>$value){   //循环读取
            $pid =  $value['cookbook_id'];//字段赋值
            $data[$key]["material"] = M("t_material")->where("cookbook_id =$pid")->select();
            $data[$key]["collectionnumber"] = M("t_collectionnumber")->where("cookbook_id =$pid")->select();
            $data[$key]["browsenumber"] = M("t_browsenumber")->where("cookbook_id =$pid")->select();
          }
        }
      }
      if($data){
        $this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
      }
      else{
        $this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
      }
    }
    


    public function mycollection($userid)
    {
        $Cookbook = M();

        $data = $Cookbook
        ->table("t_collection,t_cookbook")
        ->field("t_cookbook.cookbook_id,t_cookbook.cookbook_name,t_cookbook.cookbook_image")
        ->where("t_collection.user_id=$userid and t_cookbook.cookbook_id = t_collection.cookbook_id")->select();
        if(!empty($data)){ //判断一级是否为空
        foreach($data as $key=>$value){   //循环读取
            $pid =  $value['cookbook_id'];//字段赋值
            $data[$key]["material"] = M("t_material")->where("cookbook_id =$pid")->select();
            $data[$key]["collectionnumber"] = M("t_collectionnumber")->where("cookbook_id =$pid")->select();
            $data[$key]["browsenumber"] = M("t_browsenumber")->where("cookbook_id =$pid")->select();
          }
        }
        if($data)
            $this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        else
            $this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
    }


public function addcollect()
{
	$cookbookid = $_POST["cookbookid"];
	$userid = $_POST["userid"];

	if ($this->isExistMail($cookbookid,$userid)) {
			$this -> ajaxReturn(array("status" => "500" ,"message" => "123321"),"JSON");
			return;
		}

	$Collects = M("t_collection");
	$data["cookbook_id"] = $cookbookid;
	$data["user_id"] = $userid;
	$collectionid = $Collects->add($data);

	$Zeng = M("t_collectionnumber");
	$Zeng ->where("cookbook_id = $cookbook_id")->setInc("collectionnumber_number");

	if ($collectionid) {
			$this -> ajaxReturn(array("code" => "200" ,"collectionid" => $collectionid),"JSON");
		}
		else
		{
			$this -> ajaxReturn(array("code" => "500" ,"message" => "321123" ),"JSON");
		}
}

public function isExistMail($cookbookid,$userid)
	{
		$Users = M("t_collection");
		$data = $Users -> where(" cookbook_id = '$cookbookid' AND user_id = '$userid'") -> select();
		if ($data) {
			return true;
		}
		else
		{
			return false;
		}

	}


public function searchcook($key)
    {
      $Search = M();
      $data = $Search
      ->table("t_cookbook")
      ->field("cookbook_id,cookbook_name,cookbook_image")
      ->where("cookbook_name like '%$key%'")
      ->select();
    if(!empty($data)){ //判断一级是否为空
        foreach($data as $key=>$value){   //循环读取
            $pid =  $value['cookbook_id'];//字段赋值
            $data[$key]["material"] = M("t_material")->where("cookbook_id =$pid")->select();
            $data[$key]["collectionnumber"] = M("t_collectionnumber")->where("cookbook_id =$pid")->select();
            $data[$key]["browsenumber"] = M("t_browsenumber")->where("cookbook_id =$pid")->select();
          }
        }
      if($data){
          $this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
        else
        {
          $this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");     
        }

    }
    public function searchuser($key)
    {
      $Search = M();
      $data = $Search
      ->table("t_user")
      ->field("user_id,user_nickname,user_herderimage")
      ->where("user_nickname like '%$key%'")
      ->select();
      if($data){
        $this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
        else
        {
        $this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");     
        }

    }

    public function cookByAll()
{
  $Cook = M("t_cookbook");
  $data = $Cook->field("cookbook_id,cookbook_name,cookbook_image,cookbook_longitude,cookbook_dimension")->select();
  if(!empty($data)){ //判断一级是否为空
        foreach($data as $key=>$value){   //循环读取
            $pid =  $value['cookbook_id'];//字段赋值
            $data[$key]["material"] = M("t_material")->where("cookbook_id =$pid")->select();
            $data[$key]["collectionnumber"] = M("t_collectionnumber")->where("cookbook_id =$pid")->select();
            $data[$key]["browsenumber"] = M("t_browsenumber")->where("cookbook_id =$pid")->select();
          }
        }
      if($data){
          $this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
        }
        else
        {
          $this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");     
        }  
}

public function addbook()
{
  $config = array(
          'maxSize' => 10240 * 10240,
          'rootPath' => './Application/Home/Image/',   //根目录
          'savePath' => 'Cookbookimage/', //图片文件夹目录
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

       $Shai = M("t_cookbook");
    // 添加的数据
    $data["cookbook_name"] = $_POST["name"];
    $data["cookbook_introduction"] = $_POST["stur"];
    $data["cookbook_creattime"] = $_POST["time"];
    $data["user_id"] = $_POST["userid"];
    $data["cookbook_longitude"] = $_POST["longitude"];
    $data["cookbook_dimension"] = $_POST["dimension"];
    $data["cookbook_image"] = $imagename;
    $id = $Shai -> add($data);



    if ($id) {
          $this->ajaxReturn(array("code"=>"200","data"=>$id),"JSON");
        }
        else{
          $this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }

}

public function addshicai()
{
  $Material = M("t_material");

  $data["material_name"] = $_POST["name"];
  $data["material_quantity"] = $_POST["num"];
  $data["cookbook_id"] = $_POST["id"];
  $id = $Material -> add($data);

  $Brow = M("t_browsenumber");
  $info["cookbook_id"] = $_POST["id"];
  $Brow -> add($info);

  $Collect = M("t_collectionnumber");
  $infoo["cookbook_id"] = $_POST["id"];
  $Collect ->add($infoo);

  if ($id) {
          $this->ajaxReturn(array("code"=>"200","data"=>$id),"JSON");
        }
        else{
          $this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }
}

public function addstep()
{

  $config = array(
          'maxSize' => 10240 * 10240,
          'rootPath' => './Application/Home/Image/',   //根目录
          'savePath' => 'Stepimage/', //图片文件夹目录
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


  $Process = M("t_process");

  $data["process_step"] = $_POST["step"];
  $data["process_image"] = $imagename;
  $data["process_content"] = $_POST["content"];
  $data["cookbook_id"] = $_POST["id"];
  $id = $Process -> add($data);

  if ($id) {
          $this->ajaxReturn(array("code"=>"200","data"=>$id),"JSON");
        }
        else{
          $this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
        }


}

public function pertect($cookbookid){
  $Pertect = M("t_cookbook");
    $data["cookbook_usetime"] = $_POST["usetime"];
    $data["cookbook_population"] = $_POST["population"];
    $data["cookbook_video"] = $_POST["video"];
    $data["cookbook_eattime"] = $_POST["eattime"];

    $Pertect
    ->where("cookbook_id = $cookbookid")
    ->save($data);

    // if ($id) {
    //   $this -> ajaxReturn(array("code" => "200" ,"id" => $id),"JSON");
    // }
    // else
    // {
    //   $this -> ajaxReturn(array("code" => "500" ,"message" => "更新失败" ),"JSON");
    // }


}

public function cookByTime($time){
    $Cookbook = M("t_cookbook");
    $data = $Cookbook->where("cookbook_eattime='$time'")->select();
    if(!empty($data)){ //判断一级是否为空
        foreach($data as $key=>$value){   //循环读取
            $pid = $value['cookbook_id'];//字段赋值
            $data[$key]["material"] = M("t_material")->where("cookbook_id =$pid")->select();
            $data[$key]["collectionnumber"] = M("t_collectionnumber")->where("cookbook_id =$pid")->select();
            $data[$key]["browsenumber"] = M("t_browsenumber")->where("cookbook_id =$pid")->select();
          }
        }
    if($data)
      $this->ajaxReturn(array("code"=>"200","data"=>$data),"JSON");
    else
      $this->ajaxReturn(array("code"=>"500","data"=>null),"JSON");
  }

}