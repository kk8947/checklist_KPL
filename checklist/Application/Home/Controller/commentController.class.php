<?php
namespace Home\Controller;
use Think\Controller;
class commentController extends Controller {
    public function addcomment(){
        $cookbookid = $_POST["cookbookid"];
        $userid = $_POST["userid"];
        $commentbody = $_POST["commentbody"];
        $commenttime = $_POST["commenttime"];

        $Comments = M("t_comment");
        $data["user_id"] = $userid;
        $data["cookbook_id"] = $cookbookid;
        $data["comment_time"] = $commenttime;
        $data["comment_body"] = $commentbody;
        $commentid = $Comments ->add($data);

        if ($commentid) {
			$this -> ajaxReturn(array("code" => "200" ,"userid" => $commentid),"JSON");
		}
		else
		{
			$this -> ajaxReturn(array("code" => "500" ,"message" => "注册失败" ),"JSON");
		}
    }
}