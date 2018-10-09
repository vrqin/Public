<?php

/**
 * 后台Controller
 */
//定义是后台
namespace Common\Controller;
use Common\Controller\AppframeController;

class TeacherbaseController extends AppframeController {


	
	public function __construct() {
		$admintpl_path=C("SP_TEACHER_TMPL_PATH").C("SP_TEACHER_DEFAULT_THEME")."/";
		C("TMPL_ACTION_SUCCESS",$admintpl_path.C("SP_TEACHER_TMPL_ACTION_SUCCESS"));
		C("TMPL_ACTION_ERROR",$admintpl_path.C("SP_TEACHER_TMPL_ACTION_ERROR"));
		parent::__construct();
		$time=time();
		$this->assign("js_debug",APP_DEBUG?"?v=$time":"");
	}

    function getUrlQuery($array_query)
    {
        $tmp = array();
        foreach($array_query as $k=>$param)
        {
            $tmp[] = $k.'='.$param;
        }
        $params = implode('&',$tmp);
        return $params;
    }
    function convertUrlQuery($query)
    {
        $queryParts = explode('&', $query);
        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }

    function _initialize(){





        $button_level = I("button_level");


        if($button_level)
        {
            $newUrl = strtolower(MODULE_NAME).'/'.strtolower(CONTROLLER_NAME).'/'.strtolower(ACTION_NAME);
            $flag = $this->checkUrl($newUrl);
            if ($flag == false){

                if(IS_AJAX){
//                    echo "<script type='text/javascript'>alert('您没有权限');</script>";
                    $this->error("您没有该权限！"," ",1);
                    exit();
                }else{
                    $this->error("您没有该权限！");
                    exit();
                }
            }
        }





       parent::_initialize();
        if(isset($_SESSION['USER_ID'])){
            $users_obj= M("wxtuser");
            $id=$_SESSION['USER_ID'];
            $where['id']=$id;
            // var_dump($where);
            $user=$users_obj->where($where)->find();
            // if(!$user){
            //  $this->error("您没有访问权限！");
            //  exit();
            // }
            // var_dump($user);
            $this->assign("user",$user);
        }else{
            echo("<script laguage='javascript'>  var mymessage=confirm('用户闲置过久，会话已过期！');  
            if(mymessage==true)  
            {  
                 window.parent.location.href='http://up.zhixiaoyuan.net'; 
                 exit();

            }else{
               window.parent.location.href='http://up.zhixiaoyuan.net';   
               exit();
            } </script>");
            
        }
    }

    private function checkUrl($url){
         //判断权限
        if($url) {
            $sid = $_SESSION['schoolid'];
            $uid = $_SESSION['USER_ID'];
            $where['dt.schoolid'] = $sid;
            $where['dt.teacher_id'] = $uid;
            $where['a.type'] = 'teacher_url';
            $auth = M('school_duty')
                ->alias('d')
                ->where($where)
                ->order("d.level ASC")
                ->join('wxt_duty_teacher as dt on d.id=dt.duty_id')
                ->join('wxt_school_authaccess as a on d.id=a.role_id')
                ->field('a.rule_name')
                ->select();
            foreach ($auth as $v) {
                $urls[] = $v['rule_name'];
            }
            if (in_array($url, $urls)) {

                return true;
            } else {
                return false;
            }

        }else{
            return false;
        }
    }
    //TODO以前的
//    private function checkUrl($url){
//        if ($_SERVER['QUERY_STRING']){
//
//            return true;
//        }else{
//            $sid = $_SESSION['schoolid'];
//            $uid = $_SESSION['USER_ID'];
//            $where['dt.schoolid'] = $sid;
//            $where['dt.teacher_id'] = $uid;
//            $where['a.type'] = 'teacher_url';
//            $auth = M('school_duty')
//                ->alias('d')
//                ->where($where)
//                ->order("d.level ASC")
//                ->join('wxt_duty_teacher as dt on d.id=dt.duty_id')
//                ->join('wxt_school_authaccess as a on d.id=a.role_id')
//                ->field('a.rule_name')
//                ->select();
//            foreach ($auth as $v){
//                $urls[] = $v['rule_name'];
//            }
//            if (in_array($url, $urls)){
//
//                return true;
//            }else{
//                return false;
//            }
//        }
//
//    }

    /**
     * 消息提示
     * @param type $message
     * @param type $jumpUrl
     * @param type $ajax 
     */
    public function success($message = '', $jumpUrl = '', $ajax = false) {
        parent::success($message, $jumpUrl, $ajax);
    }

//    public function error($message = '', $jumpUrl = '', $ajax = true) {
//        parent::error($message, $jumpUrl, $ajax);
//    }
    /**
     * 模板显示
     * @param type $templateFile 指定要调用的模板文件
     * @param type $charset 输出编码
     * @param type $contentType 输出类型
     * @param string $content 输出内容
     * 此方法作用在于实现后台模板直接存放在各自项目目录下。例如Admin项目的后台模板，直接存放在Admin/Tpl/目录下
     */
    public function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
        parent::display($this->parseTemplate($templateFile), $charset, $contentType);
    }
    
    
    /**
     * 自动定位模板文件
     * @access protected
     * @param string $template 模板文件规则
     * @return string
     */
    public function parseTemplate($template='') {
    	$tmpl_path=C("SP_TEACHER_TMPL_PATH");
		// 获取当前主题名称
		$theme      =    C('SP_TEACHER_DEFAULT_THEME');

		if(is_file($template)) {
			// 获取当前主题的模版路径
			define('THEME_PATH',   $tmpl_path.$theme."/");
			return $template;
		}
		$depr       =   C('TMPL_FILE_DEPR');
		$template   =   str_replace(':', $depr, $template);
		
		// 获取当前模块
		$module   =  MODULE_NAME."/";
		if(strpos($template,'@')){ // 跨模块调用模版文件
			list($module,$template)  =   explode('@',$template);
		}
		// 获取当前主题的模版路径
		define('THEME_PATH',   $tmpl_path.$theme."/");
		
		// 分析模板文件规则
		if('' == $template) {
			// 如果模板文件名为空 按照默认规则定位
			$template = CONTROLLER_NAME . $depr . ACTION_NAME;
		}elseif(false === strpos($template, '/')){
			$template = CONTROLLER_NAME . $depr . $template;
		}
		
		C("TMPL_PARSE_STRING.__TMPL__",__ROOT__."/".THEME_PATH);
		
		C('SP_VIEW_PATH',$tmpl_path);
		C('DEFAULT_THEME',$theme);

		$file=THEME_PATH.$module.$template.C('TMPL_TEMPLATE_SUFFIX');
		if(!is_file($file)) E(L('_TEMPLATE_NOT_EXIST_').':'.$file);
		return $file;
    }


    /**
     * 初始化后台菜单
     */
    public function initMenu() {
        $Menu = F("Menu");
        if (!$Menu) {
            $Menu=D("Common/Nav")->menu_cache();
        }
        return $Menu;
    }

    /**
     *  排序 排序字段为listorders数组 POST 排序字段为：listorder
     */
    protected function _listorders($model) {
        if (!is_object($model)) {
            return false;
        }
        $pk = $model->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $model->where(array($pk => $key))->save($data);
        }
        return true;
    }

    protected function page($Total_Size = 1, $Page_Size = 0, $Current_Page = 1, $listRows = 6, $PageParam = '', $PageLink = '', $Static = FALSE) {
        import('Page');
        if ($Page_Size == 0) {
            $Page_Size = C("PAGE_LISTROWS");
        }
        if (empty($PageParam)) {
            $PageParam = C("VAR_PAGE");
        }
        $Page = new \Page($Total_Size, $Page_Size, $Current_Page, $listRows, $PageParam, $PageLink, $Static);
        $Page->SetPager('Teacher', '{first}{prev}{liststart}{list}{listend}{next}{last}', array("listlong" => "9", "first" => "首页", "last" => "尾页", "prev" => "上一页", "next" => "下一页", "list" => "*", "disabledclass" => ""));
        return $Page;
    }

    private function check_access($uid){
    	
    	//如果用户角色是1，则无需判断
    	if($uid == 1){
    		return true;
    	}
    	if(MODULE_NAME.CONTROLLER_NAME.ACTION_NAME!="TeacherIndexindex"){
    		return sp_auth_check($uid);
    	}else{
    		return true;
    	}
    }
}