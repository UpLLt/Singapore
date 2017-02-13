<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/18
 * Time: 15:06
 */
namespace Wap\Controller;
use Think\Controller;
class MedicalController extends BaseController{

    /**
     * 首页
     */
    public function index(){
        $list = D('medical')->order('create_time desc')->limit(3)->select();
        $this->assign('list',$list);
        $this->display('medical');
    }

    /**
     * 医疗分页
     */
    public function news_page(){
        $page     = I('post.page');
        $pagenum  = 3;
        $start    = ($page-1)*$pagenum;
        $list = D('medical')->limit($start.','.$pagenum)->order('create_time desc')->field('nid,create_time,title,describe,thumb')->select();
        $a = json_encode($list);
        echo $a;exit;
        $this->AjaxReturn($a);
    }


    /**
     * 医疗详情
     */

     public function detail(){
         $nid = I('nid');

         $list = D('medical')->where(array('nid'=>$nid))->find();

         $this->assign('list',$list);
         $this->display('detail');
     }
}