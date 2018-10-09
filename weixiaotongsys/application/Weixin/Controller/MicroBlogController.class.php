<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class MicroBlogController extends WeixinbaseController {
    function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $userid = I("userid");
        //获取微信的openid
        $openid  = I("openid");
        //获取学生的id
        $studentid = I("studentid");
        $schoolid = I("schoolid");//学校ID
        $appid = I("appid");//获取公众号的appid
        $appsecret = I("appsecret");//获取公众号的appsecret
        //判断是否有空
        if(empty($userid) || empty($openid) || empty($studentid)||empty($appid) ||empty($schoolid) ||empty($appsecret)){
            unset($userid);
            unset($openid);
            unset($studentid);
            unset($appid);
            unset($appsecret);
            unset($schoolid);
        }else{
            $_SESSION["APPID"] = $appid;
            $_SESSION["APPSECRET"] = $appsecret;
            $_SESSION["user"]["weixin"] = $openid;
            //$res = M("wxtuser")->where(array("id"=>$userid,"weixin"=>$openid))->find();
            $res = M("xctuserwechat")->where(array("userid"=>$userid,"weixin"=>$openid))->find();
            if ($res){
                $_SESSION["userid"] = $userid;
                $_SESSION["studentid"] = $studentid;
                //顺带查出来学校id 学校名字 学生班级
                $sch_info = M("school")->where(array('schoolid' => $schoolid))->find();
                if ($sch_info){
                    $_SESSION["school_name"] = $sch_info["school_name"];
                    $_SESSION["schoolid"] = $sch_info["schoolid"];
                }
            }
//            }
        }

    }
	//	localhost/weixiaotong2016/index.php/Weixin/MicroBlog/index
	//动态
	public function index(){
        //$signPackage = $this->getSignPackage();
        //dump($signPackage);
        //$this->assign('signPackage',$signPackage);
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
	    $userid = $_SESSION["userid"];

        //获取学生姓名
        $studentid = $_SESSION['studentid'];
        //注册班级和学校到前端
        if(empty($_SESSION['classid'])){
            $info = M("class_relationship")->where(array("userid"=>$studentid))->find();
            $_SESSION['classid'] = $info['classid'];
            $_SESSION['schoolid'] = $info['schoolid'];
        }
        $this->assign("schoolid",$_SESSION['schoolid']);
        $this->assign("classid",$_SESSION['classid']);
//        $stu_info = M("wxtuser")->where(array("id"=>$studentid))->find();
//        $this->assign("name",$stu_info['name']);
        //获取用户姓名
        $user_info = M("relation_stu_user")->where(array("userid"=>$userid,"studentid"=>$studentid))->field("name")->find();

        //$user_info = M("wxtuser")->where(array("id"=>$userid))->find();
        $this->assign("username",$user_info['name']);
	    $this->assign("userid",$userid);
		$this->display();
	}
	public function Fabu(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);

        $signPackage = $this->getSignPackage();
        $this->assign('signPackage',$signPackage);

        $user_info = M("relation_stu_user")->where(array("userid"=>$_SESSION['userid'],"studentid"=>$_SESSION['studentid']))->field("name")->find();
        $this->assign('send_name',$user_info["name"]);
        $this->assign('classid',$_SESSION['classid']);
        $this->assign('schoolid',$_SESSION['schoolid']);
        $this->assign('studentid',$_SESSION['studentid']);
        $this->assign('userid',$_SESSION['userid']);
		$this->display("fabudongtai");
	}
	
	
}


