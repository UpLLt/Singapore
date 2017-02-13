<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/18
 * Time: 15:06
 */
namespace Wap\Controller;
use Think\Controller;
class NewsController extends BaseController{

    /**
     * 首页
     */
    public function index(){
        $list = D('news')->order('create_time desc')->limit(3)->select();
        $this->assign('list',$list);
        $this->display('news');
    }

    /**
     * 新闻分页
     */
    public function news_page(){
        $page     = I('post.page');
        $pagenum  = 3;
        $start    = ($page-1)*$pagenum;
        $list = D('news')->limit($start.','.$pagenum)->order('create_time desc')->field('nid,create_time,title,describe,thumb')->select();
        $a = json_encode($list);
        echo $a;exit;
        $this->AjaxReturn($a);
    }


    /**
     * 新闻详情
     */

     public function detail(){
         $nid = I('nid');

         $list = D('news')->where(array('nid'=>$nid))->find();

         $up['nid']       = array('lt',$nid);
         $down['nid']     = array('gt',$nid);
         $front = D('news')->where($up)->order('nid desc')->limit('1')->find();
         $after = D('news')->where($down)->order('nid asc')->limit('1')->find();
         $a     = D('news')-> field('nid')->order('nid desc')->limit('1')->find();
         $b     = D('news')-> field('nid')->order('nid asc')->limit('1')->find();

         if(empty($front)){
             $front['post_title'] = "上一篇文章";
             $front['nid'] = $b['nid'];
         }
         if(empty($after)){
             $after['post_title'] = "下一篇文章";
             $after['nid'] = $a['nid'];
         }

         $this->assign('front',$front);
         $this->assign('after',$after);
         $this->assign('list',$list);
         $this->display('detail');
     }
}