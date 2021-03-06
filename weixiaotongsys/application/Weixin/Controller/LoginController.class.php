<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
session_start();
header( 'Content-Type:text/html;charset=utf-8 ');
class LoginController extends WeixinbaseController
{
    function index()
    {
        $openid = $_SESSION["user"]["weixin"];
        //从用户表查找是否存在这个用户
        $res = M("wxtuser")->where(array("weixin"=>$openid))->select();
        if($res){
            //如果存在就直接读取用户
            $_SESSION["type"] = 1;
        }else {
            //如果不存在就用默认的
            //用户的userid
            $_SESSION["type"] = 0;
            $res=array(array('id'=>3459));
        }
        $studentinfo = array();
        $teacherinfo = array();
        foreach($res as $value){
            $userid=$value['id'];
            //$userid=3459;
            //查询家长关系表中是否有这个数据 查到家长学生学校等详细信息
            $stu_real_res = M("relation_stu_user as relation")
                ->join("wxt_wxtuser as user on relation.studentid = user.id")
                ->join("wxt_class_relationship as class on relation.studentid = class.userid")
                ->join("wxt_school_class as sclass on sclass.id = class.classid")
                ->join("wxt_school as school on school.schoolid = sclass.schoolid")
                ->field("studentid,appellation,school_name,classname,user.name,relation.userid,user.photo")
                ->where("relation.userid = '$userid'")
                ->select();
            if(!empty($stu_real_res)){
                $studentinfo[] = $stu_real_res;
            }

            $user_stu_rela = M("teacher_info as t")
                ->join("wxt_wxtuser as w on t.teacherid = w.id")
                ->join("wxt_school as ws on ws.schoolid = t.schoolid")
                ->field("w.photo,w.name,ws.school_name,t.teacherid")
                ->where("t.teacherid = '$userid'")->select();
            if(!empty($user_stu_rela)){
                $teacherinfo[] = $user_stu_rela;
            }


        }

        $stuNum = count($studentinfo);
        $teaNum = count($teacherinfo);

        //如果家长老师的身份和大于2的话就直接映射去列表页面  如果就一个就直接映射到页面
        if ($stuNum + $teaNum >=2){
            $this->assign("teacherinfo",$teacherinfo);
            //注册老师
            $this->assign("studentinfo",$studentinfo);
            $this->display();
        }else{
            if ($stuNum ==1 && $teaNum==0){
                $_SESSION['studentid'] = $studentinfo[0][0]['studentid'];
                $_SESSION['userid'] = $studentinfo[0][0]['userid'];
                $this->assign('userid',$_SESSION['userid']);
                $this->assign("studentinfo",$studentinfo);
                $this->display();
            }
            if ( $teaNum ==1 && $stuNum==0){
                $_SESSION['userid'] = $teacherinfo[0][0]['id'];
                $this->assign('userid',$_SESSION['userid']);
                $this->assign("teacherinfo",$teacherinfo);
                $this->display();

            }
            //如果都等于0 说明 还没有绑定过账号 跳到绑定页面
            if($stuNum==0 && $teaNum==0){
                $tindex = A('Index');
                $tindex->build();
            }
        }


    }
        function format_ret($status, $data = '')
        {
            if ($status) {
                //成功
                return array('status' => 'success', 'data' => $data);
            } else {
                //验证失败
                return array('status' => 'error', 'data' => $data);
            }
        }

        function  ajax_session(){
            if(I('userid')){

                $_SESSION['userid'] = I('userid');
            }

            if(I('studentid')){
                $_SESSION['studentid'] = I('studentid');
            }

            if($_SESSION['userid'] || $_SESSION['studentid']){
                echo json_encode(array('data'=>1,'message'=>'数据操作成功'));
            }else{
                echo json_encode(array('data'=>0,'message'=>'数据操作失敗'));
            }
        }


}
