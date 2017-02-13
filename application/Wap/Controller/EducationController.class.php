<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/18
 * Time: 15:06
 */
namespace Wap\Controller;
use Think\Controller;
class EducationController extends BaseController{

    /**
     * 首页
     */
    public function index(){
        $list = D('sinpage')->where(array('status'=>2))->field('content')->limit(1)->find();
        $this->assign('list',$list);
        $this->display('index');
    }


}