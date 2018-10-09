<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
    <style>
        * {
            font-family: "微软雅黑"
        }
        
        ul {
            margin: 0;
            padding: 0;
        }
        
        li {
            list-style: none;
        }
        
        a {
            text-decoration: none;
        }
        
        .nav {
            width: 1200px;
            height: 60px;
            margin-left: auto;
            margin-right: auto;
            background-color: #FFF;
        }
        
        .nav ul {
            float: right;
            padding-right: 100px;
        }
        
        .nav li {
            float: left;
            padding-top: 5px;
        }
        
        .nav a {
            padding-right: 40px;
            padding-left: 40px;
            padding-bottom: 22px;
            padding-top: 22px;
            color: #303030;
            font-size: 16px;
            line-height: 50px;
        }
        /*.nav a:hover{ background-color:#06c18e;color:#FFF;}s*/
        
        .clearfix {
            clear: both;
        }
        
        .banner {
            height: 640px;
            position: relative;
            background-image: url(/weixiaotong2016/tpl/zhixiaoyuanweb/Public/images/banner.png);
            background-repeat: no-repeat;
            background-position: center;
        }
        
        .erweima {
            position: absolute;
            left: 300px;
            ;
            top: 56%;
        }
        
        .erweima_left {
            float: left;
        }
        
        .erweima_right {
            float: right;
        }
        
        .login {
            width: 300px;
            ;
            background-color: #FFF;
            position: absolute;
            left: 57%;
            top: 50px;
        }
        
        .saoyisao {
            float: right;
        }
        
        .login_sao {
            width: 300px;
            ;
            background-color: #FFF;
            position: absolute;
            left: 57%;
            top: 50px;
        }
        
        .zhanghao {
            float: right;
        }
        
        .footer {
            color: #4f4f4f;
            padding-top: 20px;
        }
        
        .check_box img {
            width: 100%
        }
        
        .qqcontact {
            width: 182px;
            height: 227px;
            background: url(/weixiaotong2016/tpl/zhixiaoyuanweb/Public/images/qqcontact.png) repeat;
            position: fixed;
            right: -150px;
            top: 50%;
            cursor: pointer;
            z-index: 100;
            margin-top: -140px;
        }
        
        .qqcontact #BizQQWPA {
            width: 117px;
            height: 37px;
            display: block;
            margin: 66px 0px 0 46px;
        }
        
        .lvtiao {
            display: none;
        }
        
        .tiaolei {
            display: block;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0,user-scalable=no">
    <title>登录</title>
    <link rel="stylesheet" href="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/css/bootstrap.css">
    <link rel="stylesheet" href="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/css/style.css">
    <script type="text/javascript" src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/js/bootstrap.min.js"></script>
    <script src="/weixiaotong2016/statics/js/layer/layer.js" type="text/javascript"></script>



</head>

<body>
    <div class="nav">
        <img src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/images/logo.png" style=" float:left;">
        <b style="color:#06c18e; font-size:24px; line-height:60px; float:left;"> 智校园</b>
        <ul>
            <li><a href="<?php echo U('PageFirst/first');?>" style=" text-decoration:none; color:inherit;">首　页</a>
                <div style=" height:5px; background-color:#06c18e; " class="lvtiao"></div>
            </li>
            <li><a href="<?php echo U('PageFirst/product_presentation');?>" style=" text-decoration:none; color:inherit;">产品介绍</a>
                <div style=" height:5px; background-color:#06c18e; " class="lvtiao"></div>
            </li>
            <li><a href="<?php echo U('PageFirst/down');?>" style=" text-decoration:none; color:inherit;">下载中心</a>
                <div style=" height:5px; background-color:#06c18e; " class="lvtiao"></div>
            </li>
            <li><a href="#" style=" text-decoration:none; color:inherit;">校园门户</a>
                <div style=" height:5px; background-color:#06c18e; " class="lvtiao"></div>
            </li>
            <li><a href="<?php echo U('PageFirst/join_us');?>" style=" text-decoration:none; color:inherit;">加盟合作</a>
                <div style=" height:5px; background-color:#06c18e; " class="lvtiao"></div>
            </li>
            <li><a href="<?php echo U('PageFirst/about_us');?>" style=" text-decoration:none; color:inherit;">关于我们</a>
                <div style=" height:5px; background-color:#06c18e; " class="lvtiao"></div>
            </li>
            <img src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/images/qq.png" style="margin-top:20px;">
            <div class="clearfix"></div>
        </ul>
    </div>
    </div>
 
        <!--卡号start-->
     <div style=" background-color:rgba(0,0,0,0.7); position: fixed; top: 0;right: 0;bottom: 0; left: 0;z-index: 1040; display: none;" class="daitan"  >
        <div style=" width:470px; background-color:white; margin-left:auto; margin-right:auto; margin-top:8%; padding:20px; z-index: 1000; position:relative;">
          <form class="layui-form" action="">
            <div style="">
              <div style=" border:1px solid #dddddd; border-bottom:none; width:100px; text-align:center; line-height:30px;">教师学校选择</div>
              <div style=" border-bottom:1px solid #dddddd; margin-left:100px;"></div>
            </div>
            <div><img src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/images/t1.jpg" style="margin-top:20px;     margin-left: 17%;"></div>
            <div style=" margin-top:30px; margin-bottom:15px; margin-left:30px;" class="numberic">

              <div class="clearfix"></div>
              <span>请选择学校:</span>
            </div>
            <!-- <div style=" margin-bottom:10px; margin-left:30px;">
                      确认卡号：<input type="text" placeholder="卡号长度10位数" style=" margin-top:8px; height:30px;">
                    </div> -->
            <div style="  margin-left:auto; margin-right:auto; margin-left: 41%; margin-top:20px;">
              <button  type="button" class="tijiao"  value="保&nbsp;存" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px; cursor: pointer;" >点击进入</button>

            </div>
          </form>
          <!--关闭start-->
          <img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="guan">
          <!--关闭end-->
        </div>



      </div>
      <!--end-->


    <div class="banner">
        <div class="login_sao">
            <img src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/images/zhang.png" class="zhanghao img-responsive">
            <br/><br/>
            <center style="color:#06c18e; font-size:20px; margin-left:70px;">
                <b>智校园管理系统</b>
            </center>
            <br/>
            <center>
                <img src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/images/weixin.jpg" width="145px" height="145px">
            </center>
            <br/>
            <center>
                <img src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/images/saomiao.png"><b style=" margin-left:40px;">扫一扫登录</b>
            </center>
            <br/><br/><br/>
        </div>
        <div class="erweima">
            <div class="erweima_left">
                <img src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/images/download.png" class="img-responsive" width="145px" height="145px">
                <br/><br/>
                <center>APP下载</center>
            </div>
            <div class="erweima_right" style="margin-left:100px;">
                <img src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/images/weixin.jpg" class="img-responsive" width="145px" height="145px">
                <br/><br/>
                <center>微信公众号</center>
            </div>
        </div>
        <div class="login">
            <img src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/images/sao.png" class="saoyisao">
            <form role="form" id="teacher_from" action="<?php echo U('teacher_login_pc');?>" method="post">
                <div class="form-group">
                    <br/><br/>
                    <center style="color:#06c18e; font-size:20px; margin-left:70px;">
                        <b>智校园管理系统</b>
                    </center>
                    <br/>
                    <center>
                        <div class="input-group" style=" width:220px;">
                            <span class="input-group-addon"><img src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/images/user.png"></span>
                            <input id="teacher_user" type="text" class="form-control" id="phone" placeholder="手机号码">
                        </div>
                    </center>
                </div>
                <div class="form-group">
                    <center>
                        <div class="input-group" style=" width:220px;">
                            <span class="input-group-addon"><img src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/images/lock.png"></span>
                            <input type="password" class="form-control" id="teacher_password" name="password" placeholder="请输入密码">
                        </div>
                    </center>
                </div>
                <div class="form-group" style="background-image:url(img/%E4%BA%8C%E7%BB%B4%E7%A0%81.png); background-repeat:no-repeat; background-position:160PX ;">
                    <input type="text" class="form-control" name="verify" id="verrify" placeholder="输入验证码" style=" width:100px; margin-left:40px; float: left;">
                    <div style="float:left; width: 120px; margin-left: 10px;" class="check_box"><?php echo sp_verifycode_img('length=4&font_size=25','style="cursor: pointer;" title="点击获取"');?></div>
                    <div style="clear: both;"></div>
                </div>
                <div class="form-group">
                    <input type="checkbox" style=" margin-left:40px;"> 记住账号
                    <a class="reset"  data-toggle="modal" data-target="#myModal3" data-na="123" style="float:right; margin-right:40px;">忘记密码?</a>
                </div>
                <div class="form-group">
                    <center>
                        <a href="#">
                            <button type="submit" class="form-control btn btn-default" style="border:none; background-color:#06c18e; color:#FFF; font-size:18px;width:285px;"> 登 录 </button>
                        </a>
                    </center>
                    <div class="login_verification">
                        <div class="verification_loading"></div>
                        <div class="verification_text"></div>
                    </div>
                    <br/><br/>
                </div>
            </form>
        </div>
        <div id="myCarousel" class="carousel slide" style="position:absolute; left:57%; top:420px; width:300px; ">
            <!-- 轮播（Carousel）指标 -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <!-- 轮播（Carousel）项目 -->
            <div class="carousel-inner">
                <div class="item active">
                    <img src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/images/lunbo.png" alt="First slide">
                </div>
                <div class="item">
                    <img src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/images/lunbo.png" alt="Second slide">
                </div>
                <div class="item">
                    <img src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/images/lunbo.png" alt="Third slide">
                </div>
            </div>
            <!-- 轮播（Carousel）导航 -->
            <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
            <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
            <!-- 控制按钮 -->
        </div>
    </div>

    <!--忘记密码-->
    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="    display: none;">
        <div class="modal-dialog" style="width:280px">
            <div class="modal-content">
                <div class="modal-header" style="background: white">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="myModalLabel" style="color: black; font-weight:bold;">重置密码</h5>
                </div>
                <div class="modal-body2">

                    <div class="input-group input-group">
                        <input type="text" name="pwdphone"  class="pwdphone form-control" placeholder="手机号">
                    </div>
                    <div class="input-group input-group">
                        <input type="text" class="vcode form-control" name="vcode" placeholder="短信验证码" >
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-info"  id="yzm">获取验证码</button>
                    </span>
                    </div>
                    <div class="input-group input-group">
                        <input type="password" class="czrel form-control" name="password" placeholder="请输入新密码" >
                    </div>
                    <div class="input-group input-group">
                        <input type="password" class="czpwd form-control" placeholder="请再次输入新密码">
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success pwdtj" style="width:210px;font-weight:bold;margin-right:15px;" >提交</button>
                </div>

            </div>
        </div>
    </div>
    <!--忘记密码end-->
    <style>
        .input-group{
            width:210px;
            margin: 20px 35px 0 35px;
        }
    </style>
    <div class="footer">
        <center>| 温州韵途科技有限公司 | 智校园官方网站 | <img src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/images/qq.png"><br/> 浙ICP备16026974号-1 Copyright © 2016 Wenzhou Yuntu Science And Technology Co., Ltd.<br/>温州韵途科技有限公司 版权所有<br/> 加盟热线:400-182-9666.
            <br/>
        </center>
    </div>
    <div class="qqcontact" onclick="showqq();" style="right:-150px;">
        <div id="BizQQWPA"></div>
    </div>

    <script>


    $(function() {  
        var userAgent = window.navigator.userAgent.toLowerCase();  
        var version = /msie/.test(navigator.userAgent.toLowerCase()); 


        // if (version=='9.0' || version=='8.0' || version=='7.0' || version=='6.0') {
        //   alert('您的浏览器版本过低，请升级浏览器或更换浏览器！否则将无法使用某些功能!');

        // }
  

        if (!$.support.leadingWhitespace) {
            alert('您的浏览器版本过低，请升级浏览器或更换浏览器！否则将无法使用某些功能!');
        }
    });  



$(document).on("click",'.dbzr',function(){
 //     $("input[name='school']").each(function(){
 //    console.log($(this).removeAttr("checked"));
 // })

         $(this).find('input').prop("checked", true);
               



})



        $(function() {
            // 初始化轮播
            $("#myCarousel").carousel('cycle');
        });
        $(".saoyisao").click(
            function() {
                $(".login").hide()
            }
        )
        $(".zhanghao").click(
            function() {
                $(".login").show()
            }
        )

        function showqq() {
            var flag = $(".qqcontact").css("right");
            if (flag == "-150px") {
                $(".qqcontact").animate({
                    right: '0'
                });
            } else {
                $(".qqcontact").animate({
                    right: '-150'
                });
            }
        };

        $(".guan").click(
                function() {
                    $(".daitan").hide()
                    console.log('我是关掉的');
                     var re =  $('body').find(".dbzr");
           re.remove();
                }
          


            )
    </script>
    <script src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/js/validate.min.js"></script>
    <script src="/weixiaotong2016/tpl/zhixiaoyuanweb/Public/js/login_from.js"></script>

    <script>
        $(".reset").click(function(){
            var teacher_name = $("#teacher_user").val();
            console.log(teacher_name);
            $('.pwdphone').val(teacher_name);

        })
        $('.pwdtj').click(function(){
            var phone = $('.pwdphone').val();
            var password = $('.czpwd').val();
            var rel = $('.czrel').val();
            var vcode = $('.vcode').val();
            if(phone == '')
            {
                layer.msg('手机号不能为空', {
                    icon: 2
                    ,shade: false,
                });
                return false;
            }
            if(vcode == '')
            {
                layer.msg('验证码不能为空', {
                    icon: 2
                    ,shade: false,
                });
                return false;
            }
            if(password == '' || rel == '')
            {
                layer.msg('密码不能为空', {
                    icon: 2
                    ,shade: false,
                });
                return false;
            }

            if(password!=rel){
                layer.msg('两次密码输入的不一致', {
                    icon: 2
                    ,shade: false,
                });
                return false;
            }
            // console.log(teacherid);


            // console.log(pwd);
            // console.log(js);
            $.ajax({
                type: "post",
                async: false,
                dataType:'json',
                url: "<?php echo U('Apps/ResetPassword/ResetPwd');?>",
                data: {
                    phone:phone,
                    password:password,
                    vcode:vcode,

                },
                success: function(data) {

                    if(data.status){
                        layer.msg(data.info , {
                            icon: 1
                            ,shade:  false,
                        });
                        $(".fade").hide();
                    }else{
                        layer.msg(data.info , {
                            icon: 2
                            ,shade: false,
                        });
                    }
                },
                //请求失败
                error:function(){
                    alert('请求失败');
                }
            });

        })


        $(".nav a").mouseenter(
            function() {
                $(this).siblings(".lvtiao").addClass("tiaolei")

            }
        )
        $(".nav a").mouseleave(
            function() {
                $(this).siblings(".lvtiao").removeClass("tiaolei")
            }
        )
        $(".nav li").mouseenter(
            function() {
                $(this).animate({
                    marginTop: -20
                }, 300).animate({
                    marginTop: 0
                }, 300)
            }
        )

        function invokeSettime(obj){
            var countdown=60;
            settime(obj);
            function settime(obj) {
                if (countdown == 0) {
                    $(obj).attr("disabled",false);
                    $(obj).text("获取验证码");
                    countdown = 60;
                    return;
                } else {
                    $(obj).attr("disabled",true);
                    $(obj).text("(" + countdown + ") s 重新发送");
                    countdown--;
                }
                setTimeout(function() {
                        settime(obj) }
                    ,1000)
            }
        }
        $("#yzm").click(function(){
            var phone = $('.pwdphone').val();
            if(phone == '')
            {
                layer.msg('手机号不能为空', {
                    icon: 2
                    ,shade: 0.01,
                });
                return false;
            }
            $.ajax({
                type: "post",
                async: false,
                dataType:'json',
                url: "<?php echo U('Apps/ResetPassword/SendVcode');?>",
                data: {
                    phone:phone,
                },
                success: function(data) {

                    if(data.status){
                        new invokeSettime("#yzm");
                        layer.msg(data.info , {
                            icon: 1
                            ,shade:  false,
                        });
                    }else{
                        layer.msg(data.info , {
                            icon: 2
                            ,shade:  false,
                        });
                    }
                },
                //请求失败
                error:function(){
                    alert('请求失败');
                }
            });

        })
    </script>
</body>

</html>