<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/18
 * Time: 15:06
 */
namespace Wap\Controller;
use Think\Controller;
class IndexController extends BaseController{

    /**
     * 首页
     */
    public function index(){

        $banner   = D('exhibition')->order('create_time desc')->field('picture,url')->limit(5)->select();
        $about_us = D('sinpage')->where(array('status'=>4))->find();
        $news     = D('news')->where(array('status'=>1))->order('create_time desc')->order(3)->select();


        $this->assign('news',$news);
        $this->assign('about_us',$about_us);
        $this->assign('banner',$banner);
        $this->display('index');
    }

    /**
     * 关于我们
     */

    public function about_us(){
        $about_us = D('sinpage')->where(array('status'=>4))->find();
        $this->assign('list',$about_us);
        $this->display('about');
    }
}