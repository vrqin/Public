<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
session_start();
header( 'Content-Type:text/html;charset=utf-8 ');  
class MenuController extends WeixinbaseController
{
//第一步：用户同意授权，获取code
function accept(){
    //session_unset();
   // dump($_SESSION);
    //die();
//    $action  = $this->action;//跳转的地址
//    $schoolid = $this->schoolid;//学校ID
//    $type = $this->type;//类型
    if(I("appid") and I("action") and I("type")){
        $id = I("appid");//公众号ID
        $_SESSION["manage_id"] = $id;
        $action = I("action");//跳转的地址
        $type= I("type");//类型
        $result = M("wxmanage")->where("id = $id")->find();
        $appid = $result["wx_appid"];
        $appsecret = $result["wx_appsecret"];
        $_SESSION["APPID"] = $appid; //获取公众号的APPID
        $_SESSION["APPSECRET"] = $appsecret; //获取公众号的 APPSECRET

        if($result){
            //这个链接是获取code的链接 链接会带上code参数
            $http = "http://".$_SERVER['HTTP_HOST'].__ROOT__;
            $REDIRECT_URI = "$http/index.php/weixin/Menu/getCode?action=".$action."&type=".$type;
            $REDIRECT_URI = urlencode($REDIRECT_URI);
            $scope = "snsapi_userinfo";
            $state = md5(mktime());
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$_SESSION["APPID"]."&redirect_uri=".$REDIRECT_URI."&response_type=code&scope=".$scope."&state=".$state."#wechat_redirect";
            header("location:$url");
        }
    }
}
//用户同意之后就获取code  通过获取code可以获取一切东西了  机智如我
function getCode(){

    $code = $_GET["code"];
    //用code获取access_yoken
    $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$_SESSION["APPID"]."&secret=".$_SESSION["APPSECRET"]."&code=".$code."&grant_type=authorization_code";
    //这里可以获取全部的东西  access_token openid scope
    $res = $this->https_request($url);
    $res  = json_decode($res,true);

    $openid = $res["openid"];
    $access_token = $res["access_token"];
    //这里是获取用户信息
    $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
//    echo $url;
    $res = $this->https_request($url);

    $res = json_decode($res,true);


    //把用户的信息写入session 以备查用
    //openid
    $weixin = $res["openid"];
    //sex
    $sex = $res["sex"];
    //头像
    $headimg = $res["headimgurl"];
    //昵称
    $nickname = $res["nickname"];
    $_SESSION["user"]['weixin'] = $weixin;
    $_SESSION["user"]['sex'] = $sex;
    $_SESSION["user"]['headimg'] = $headimg;
    $_SESSION["user"]['nickname'] = $nickname;


    $http = "http://".$_SERVER['HTTP_HOST'].__ROOT__;

    $action  = I("action");//跳转的地址
   // $schoolid = I("schoolid");//学校ID
    $type = I("type");//类型

//    header("location:".$http."/index.php/weixin/Menusession/index?schoolid=".$schoolid."&action=".$action."&type=".$type);
    header("location:".$http."/index.php/weixin/Menusession/index?action=".$action."&type=".$type);

}
function https_request($url, $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
}