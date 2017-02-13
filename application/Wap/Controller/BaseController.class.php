<?php
namespace Wap\Controller;
use Think\Controller;
class BaseController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->get_weixin_openid();
    }

    /**
     * 检测是否登陆
     */
 /*    private function is_login(){
        $user_id    = session('user_id');
        if(!$user_id){
            $this->redirect('Wap/login/index');
        }
    } */ 


   public function get_weixin_openid()
   {

       vendor('WxPayPubHelper.WxPayPubHelper.php');
       $this->assign('title', '登录');
       header("Content-type:text/html;charset=utf-8");
       ini_set('date.timezone', 'Asia/Shanghai');
       layout(false);

       $b = $this->is_weixin();

       if ($b) {
           vendor('WxPayPubHelper.WxPayPubHelper');
           $jsApi = new \JsApi_pub();


           //获取用户openid
           if (!isset($_GET['code'])) {
               //触发微信返回code码；
               $url = $jsApi->createOauthUrlForCode("http://" . $_SERVER['HTTP_HOST'] ."/index.php?g=Wap&m=Index&a=index");
               header("Location: $url");
           } else {
               $code = I('get.code');


               if (!empty($code)) {
                   $jsApi->setCode($code);
                   $result_wechat = $jsApi->getWxInfomation();
                   if($result_wechat){
                       $open_id = D('wechatuser')->where(array('openid'=>$result_wechat['openid']))->field('openid')->find();
                       if(empty($open_id)){
                           $resut = D('wechatuser')->add($result_wechat);
                       }

                   }
               }

           }

       }

	}

   public function is_weixin(){
       if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
           return true;
       }
       return false;
   }
}




