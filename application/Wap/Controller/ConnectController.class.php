<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/18
 * Time: 15:06
 */
namespace Wap\Controller;
use Think\Controller;
class ConnectController extends BaseController{

    /**
     * 首页
     */
    public function index(){
        $this->display('index');
    }

    /**
     * 联系我们
     */
    public function connect(){
        $code = I('code');
        $real_name = I('real_name');
        $tel_phone = I('tel_phone');
        $content = I('content');
        $vode = $this->check_verify($code);
        if(!$vode){
           echo '请输入正确的验证码';exit;
        }

        if(empty($real_name)){
           echo '姓名不能为空';exit;
        }

        if(empty($tel_phone)){
           echo '电话不能为空';exit;
        }
        if(empty($content)){exit;
        }

        $data = I('post.');
        $data['create_time']  = time();
        $result = D('connect')->add($data);
        if($result){
            echo '添加成功';exit;
        }else{
            echo '添加失败';exit;
        }
    }

    function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }
}