<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchnoticeController extends WeixinbaseController {
    function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $type = I("type");
        if($type){
            $id = I("id");
            $stu_id = I("stu_id");
            $school_id = I("school_id");
            $this->check_menu($id,$stu_id,$school_id);
            return;
        }
//        $this->check_session();//查看session 是否过期
        $userid = I("userid");//获得用户ID
        $openid  = I("openid");//获取微信的openid
        $schoolid  = I("schoolid");//获得学校ID
        $appid = I("appid");//获取公众号的appid
        $appsecret = I("appsecret");//获取公众号的appsecret
//        判断有没有空
        if (empty($userid) || empty($openid)||empty($appid) ||empty($schoolid) ||empty($appsecret) ){
            unset($userid);
            unset($openid);
            unset($appid);
            unset($appsecret);
            unset($schoolid);
        }else {
            $_SESSION["APPID"] = $appid;
            $_SESSION["APPSECRET"] = $appsecret;
            $_SESSION["user"]["weixin"] = $openid;
                //开始写session
                $_SESSION["userid"] = $userid;
                //查询学校id 学校名字
                $sch_info = M("school")->where(array('schoolid' => $schoolid))->find();
                if ($sch_info) {
                    $_SESSION["schoold_name"] = $sch_info["school_name"];
                    $_SESSION["schoolid"] = $sch_info["schoolid"];
                }

        }
    }
    //教师端通知公告  老师获取的通知公告
    //localhost/weixiaotong2016/index.php/weixin/Tchnotice/index
    public function index() {
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);//学校名称
        $this->assign("userid", $_SESSION['userid']);//老师ID
        $this->assign('schoolid', $_SESSION['schoolid']); //学校ID
        $this->display("tongzhigonggao");
    }
    //获取的公告详情
    public function details(){
        $receiverid = I("receiverid");
        $noticeid = I("noticeid");
        $schoolid =$_SESSION["schoolid"];
        //调用APPS详情接口
        $array=$this->get_receive_notice_details($receiverid,$noticeid,$schoolid);
       // $array=R("Apps/School/get_receive_notice_details",array("receiverid"=>$receiverid,"noticeid"=>$noticeid));
        $result = json_decode($array,true);
//        echo "<pre>";
//        print_r($result);
//        die();
        $stu_sch_name = $_SESSION["school_name"];//学校名称
        $this->assign("schoolname",$stu_sch_name);
        $types = $result["data"][0]["notice_info"][0]["type"];//类型
        $title = $result["data"][0]["notice_info"][0]["title"];//通知标题
        $content = $result["data"][0]["notice_info"][0]["content"];//通知内容
        $name = $result["data"][0]["notice_info"][0]["name"];//通知人名称
        $photo = $result["data"][0]["notice_info"][0]["photo"];//通知人头像
        $Tmie = date('Y-m-d H:i:s',$result["data"][0]["notice_info"][0]["create_time"]);//通知时间
        $user = $receiverid; //接收人ID
        $create_time = $result["data"][0]["create_time"]; //有没有读取

        $readarray = $result["data"][0]["receiv_list"];
        $h=0;
        foreach($readarray  as $k=>$v){
            if($v["create_time"]>0){
                $h++;
            }
        }
        $zongshu = count($readarray); //总数
        $yushu = $h; //已读
        $weidu=$zongshu-$h;//未读

        $subContent = $result["data"][0]['pic'];//图片
        if(count($subContent)==0){
            $sub=1;
        }else{
            $subContent=$subContent;
            $sub=0;
        }

        $this->assign("sub",$sub);
        $this->assign("create_time",$create_time);
        $this->assign("user",$user);
        $this->assign("photo",$photo);
        $this->assign("name",$name);

        $this->assign("title",$title);
        $this->assign("content",$content);
        $this->assign("subContent",$subContent);
        $this->assign("Tmie",$Tmie);
        $this->assign("noticeid",$noticeid);
        $this->assign("zongshu",$zongshu);
        $this->assign("yushu",$yushu);
        $this->assign("weidu",$weidu);
        $this->assign("types",$types);
        $this->display("jiaotongzhixiangqing");
    }


    //家长端 获取公告 详情
    public function get_receive_notice_details($receiverid,$noticeid,$schoolid){
        //获取参数
        if($receiverid){
            $notice_where["r.receiverid"] = $receiverid;
        }else{
            $ret = $this->format_ret(0,'lost params');
            echo json_encode($ret);
            exit;
        }
        if($noticeid){
            $notice_where["r.noticeid"] = $noticeid;
        }
        if($schoolid){
            $notice_where["r.schoolid"] = $schoolid;
            $info_where["teacher.schoolid"] = $schoolid;
            $info_where["n.send_type"] = 1;
            $info_where["n.schoolid"] = $schoolid;
        }


            $notice_model=M('notice');
            $receive_model=M('notice_receiverid');
            $pic_model = M('notice_photo');
            $user_model=M('wxtuser');
            //在接收人表中通过传入的receiverid获取到对应的信息
            $receive_info=$receive_model
                ->alias("r")
//                ->where("r.receiverid=$receiverid and r.noticeid=$noticeid")
                ->where($notice_where)
                ->select();
            //foreach循环获取剩余所需信息
            foreach ($receive_info as &$notice) {
                $id=$notice['noticeid'];
                $info_where["n.id"] = $id;
                //在公告信息表中通过查询到的对应主键id获取到对应的公告信息,两表联查在user表中查询发布人的姓名等信息
                $notice_info=$notice_model
                    ->alias("n")
                    ->join("wxt_wxtuser w ON n.userid=w.id")
                    ->join("wxt_teacher_info teacher ON n.userid=teacher.teacherid")
//                    ->where("n.id=$id")
                    ->where($info_where)
                    ->field("teacher.name,w.photo,n.id,n.userid,n.title,n.type,n.content,n.create_time")
                    ->select();
                $notice['notice_info']=$notice_info;
                //在接收人表中通过查询到的对应主键id获取到所有收到这条信息的人
                $receiv_list=$receive_model
                    ->alias("e")
                    ->join("wxt_wxtuser u ON e.receiverid=u.id")
                    ->field("u.name,u.photo,u.phone,e.*")
                    ->where("e.noticeid=$noticeid")
                    ->select();
                $notice['receiv_list']=$receiv_list;
                //获取图片
                $pic=$pic_model->field("photo,width,height")->where("noticeid=$noticeid")->select();
                $notice['pic']=$pic;
                for ($j=0; $j < count($pic); $j++) {
                    $notice['pic'][$j]["picturewidth"]=$pic[$j]["width"];
                    $notice['pic'][$j]["pictureheight"]=$pic[$j]["height"];
                }
                unset($notice);
            }
            $ret = $this->format_ret(1,$receive_info);

            return json_encode($ret);
    }

    //发布通知列表页面
    public function Tong() {
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $userid = $_SESSION['userid'];
        $this->assign('schoolid',$_SESSION["schoolid"]);
        $this->assign('classid',$_SESSION["classid"]);
        $this->assign("userid", $userid);
        $this->display("fabutongzhigonggao");
    }
    //发布的公告详情
    public function detailsI() {
        $userid = I("userid");
        $noticeid = I("noticeid");
        $schoolid = $_SESSION["schoolid"];
        //调用APPS详情接口
        $array=$this->getnoticelist_details($userid,$noticeid,$schoolid);
        //$array=R("Apps/School/getnoticelist_details",array("userid"=>$userid,"noticeid"=>$noticeid));
        $result = json_decode($array,true);
//        echo "<pre>";
//        print_r($result);
//        die();
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $types = $result["data"][0]["type"];//类型
        $title = $result["data"][0]["title"];//标题
        $content = $result["data"][0]["content"];//内容
        $name = $result["data"][0]["username"];//发布人名字
        $create_time = date('Y-m-d H:i:s',$result["data"][0]["create_time"]);//发布时间
        $avatar = $result["data"][0]["avatar"];//发布人头像

        //已读 未读
        $readarray = $result["data"][0]["receive_list"];
        $h=0;
        foreach($readarray  as $k=>$v){
            if($v["create_time"]>0){
                $h++;
            }
        }
        $shuliang = count($readarray); //总数
        $yidu = $h; //已读
        $Weidu=$shuliang-$h;//未读

        $subContent = $result["data"][0]['pic'];//图片
        if(count($subContent)==0){
            $sub=1;
        }else{
            $subContent=$subContent;
            $sub=0;
        }

        $this->assign("noticeid",$noticeid);
        $this->assign("subContent", $subContent);
        $this->assign("avatar", $avatar);
        $this->assign("shuliang", $shuliang);
        $this->assign("Weidu", $Weidu);
        $this->assign("yidu", $yidu);
        $this->assign("sub", $sub);
        $this->assign("title", $title);
        $this->assign("content", $content);
        $this->assign("name", $name);
        $this->assign("create_time", $create_time);
        $this->assign("types", $types);
        $this->display("Izhigonggao");
    }

    //获取自己发布的公告列表详情
    public function getnoticelist_details($userid,$noticeid,$schoolid){
        //获取参数
//        $noticeid =  Intval(I('noticeid'));
//        $userid = Intval(I('userid'));
//
//        $schoolid = I('schoolid');
        if($userid){
            $notice_where["userid"]  = $userid;

        }else
        {
            $ret = $this->format_ret(0,'lost params');
            echo json_encode($ret);
            exit;
        }

        if($schoolid){
            $notice_where["schoolid"]  = $schoolid;
            $user_where["schoolid"] = $schoolid;
        }
        if($noticeid){
            $notice_where["id"]  = $noticeid;
        }

            $notice_model = M('notice');
            //通过传参的userid获取到对应的公告信息
            $lists = $notice_model
                ->field('id,userid,title,content,type,create_time')
//                ->where("userid=$userid and id=$noticeid")
                ->where($notice_where)
                ->order('id desc')
                ->select();
            $user_model = M('wxtuser');
            $receive_model=M('notice_receiverid');
            $pic_model = M('notice_photo');
            foreach ($lists as &$notice ) {
                $noticeids = $notice["id"];
                $userids = $notice["userid"];
                $user_where["teacherid"]=$userids;
                //通过查询到的userid在user表中查询出对应的姓名头像
                $userinfo = $user_model
                    ->field("name,photo")
                    ->where("id=$userids")
                    ->find();
//                $teacher = M("teacher_info")->where("teacherid=$userid")->field("name")->find();
                $teacher = M("teacher_info")->where($user_where)->field("name")->find();
                if($userinfo){
                    $notice['username']=$teacher["name"];
                    $notice["avatar"]= $userinfo["photo"];
                }
                else{
                    $notice['username']="";
                    $notice["avatar"]= "default.png";
                }
                //通过查询到的主键id在接收人表中查询出接收人的信息,并通过两表联查获取到接收人的姓名等信息
                $receive_list=$receive_model
                    ->alias("r")
//                    ->join("wxt_wxtuser w ON r.receiverid=w.id")
                    ->where("r.noticeid=$noticeids")
//                    ->field("w.name,w.photo,w.phone,r.id,r.noticeid,r.receiverid,r.receivertype,r.create_time")
                    ->field("r.id,r.noticeid,r.receiverid,r.receivertype,r.create_time")
                    ->select();
                $notice['receive_list']=$receive_list;
                //获取图片
                $pohtolist = $pic_model
                    ->field("id,photo as pictureurl,width,height,create_time")
                    ->where("noticeid=$noticeids")
                    ->order("id asc")
                    ->select();
                if($pohtolist){
                    $notice['pic']= $pohtolist;
                    for ($j=0; $j < count($pohtolist); $j++) {
                        $notice['pic'][$j]["picturewidth"]=$pohtolist[$j]["width"];
                        $notice['pic'][$j]["pictureheight"]=$pohtolist[$j]["height"];
                    }
                }else
                {
                    $notice['pic']= "";
                }

                unset($notice);
            }

            $ret = $this->format_ret(1,$lists);

        return json_encode($ret);
    }

    //学生群发
    public function addtianjia(){
        $stu_sch_name = $_SESSION["school_name"];//学校名称
        $this->assign("schoolname",$stu_sch_name);
        $signPackage = $this->getSignPackage();
        $this->assign('signPackage',$signPackage);
        $teacherid = $_SESSION['userid']; //老师ID
        $schoolid = $_SESSION['schoolid']; //学校ID
        $this->assign('schoolid', $schoolid);
        $this->assign("teacherid", $_SESSION['userid']);

        $action = "weixin/Tchnotice/addtianjia";
        $result = $this->check_role(strtolower($action),$teacherid,$schoolid);
        $this->assign('check',$result);

        $this->display("Answer_Parent");


    }
    //老师群发
    public function Answer() {
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);

        $signPackage = $this->getSignPackage();
        $this->assign('signPackage',$signPackage);
        $teacherid = $_SESSION['userid'];
        $schoolid = $_SESSION['schoolid'];
        $this->assign("teacherid",$teacherid);

        $this->assign('schoolid', $schoolid);

        $action = "weixin/Tchnotice/Answer";
        $result = $this->check_role(strtolower($action),$teacherid,$schoolid);//查看是否有权限
        $this->assign('check',$result);

        $this->display("Answer_publish");
    }
    //接收情况
    public function read(){
          $stu_sch_name = $_SESSION["school_name"];
          $this->assign("schoolname",$stu_sch_name);
          $schoolid = $_SESSION["schoolid"];
          $noticeid = I("noticeid");
          $model = M();
          $type = I("types");//类型
          if($type==1){ //表示老师
              $sql = "SELECT t.name,w.phone,w.photo,r.noticeid,r.receiverid,r.receivertype,r.create_time FROM wxt_notice_receiverid r  JOIN wxt_wxtuser w on r.receiverid=w.id JOIN wxt_teacher_info t on t.teacherid=w.id WHERE ( r.noticeid='$noticeid' and r.create_time>0 and t.schoolid='$schoolid')";
              $arr = "SELECT t.name,w.phone,w.photo,r.noticeid,r.receiverid,r.receivertype,r.create_time FROM wxt_notice_receiverid r  JOIN wxt_wxtuser w on r.receiverid=w.id JOIN wxt_teacher_info t on t.teacherid=w.id WHERE ( r.noticeid='$noticeid' and r.create_time=0 and t.schoolid='$schoolid')";
              $receive_list = $model->query($sql);
              $rlist = $model->query($arr);
              //print_r($rlist);
              //print_r($rlist);
              $this->assign("receive_list",$receive_list);//已读人数
              $this->assign("rlist",$rlist);//未读人数
          }
        if($type==2){ //表示家长
            $sql = "SELECT s.stu_name as name,w.phone,w.photo,r.noticeid,r.receiverid,r.receivertype,r.create_time,w.id FROM wxt_notice_receiverid r  JOIN wxt_wxtuser w on r.receiverid=w.id JOIN wxt_student_info s on s.userid=w.id WHERE ( r.noticeid='$noticeid' and r.create_time>0)";
            $arr = "SELECT s.stu_name as name,w.phone,w.photo,r.noticeid,r.receiverid,r.receivertype,r.create_time,w.id FROM wxt_notice_receiverid r  JOIN wxt_wxtuser w on r.receiverid=w.id JOIN wxt_student_info s on s.userid=w.id WHERE ( r.noticeid='$noticeid' and r.create_time=0)";
            $receive_list = $model->query($sql);
            $rlist = $model->query($arr);
            foreach($receive_list as &$value)
            {
                $studentid = $value["id"];//学生ID
                $result = M("relation_stu_user as a")->join("wxt_wxtuser as b on a.userid=b.id")->field("b.phone")->where("a.studentid=$studentid")->find();
                $value["phone"] = $result["phone"];
            }

            foreach($rlist as &$value)
            {
                $studentid = $value["id"];//学生ID
                $result = M("relation_stu_user as a")->join("wxt_wxtuser as b on a.userid=b.id")->field("b.phone")->where("a.studentid=$studentid")->find();
                $value["phone"] = $result["phone"];
            }
            $this->assign("receive_list",$receive_list);//已读人数
            $this->assign("rlist",$rlist);//未读人数
        }

          $this->display("read");
      }

    /* $action 方法
     * $userid 用户ID
     */
    //查看是否有权限
    public function  check_role($action,$userid,$schoolid){
//        school_duty //
        //teacher_duty
        //wxt_school_authaccess_app
        $newarray=array();
        $result = M("duty_teacher")->where(array("teacher_id"=>$userid,"schoolid"=>$schoolid))->find();
        //dump($result);
        if(count($result)){
            $duty_id = $result["duty_id"];
//            $query = M("school_authaccess_app")->where("role_id = $duty_id and schoolid=$schoolid")->select();
            $query = M("school_authaccess_app")->where(array("role_id"=>$duty_id,"schoolid"=>$schoolid))->select();
            foreach ($query as $value){
                $newarray[] = $value["rule_name"];
            }
            if(in_array($action,$newarray)){
                return 1;
            }else{
                return 2;
            }
        }
    }
}

?>