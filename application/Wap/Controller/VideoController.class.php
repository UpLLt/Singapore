<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/18
 * Time: 15:06
 */
namespace Wap\Controller;
use Think\Controller;
class VideoController extends BaseController{

    /**
     * 首页
     */
    public function index(){
    	$list = D('picture')->order('create_time desc')->select();	
    	for ($i=0; $i <count($list) ; $i++) { 
   
    			$map['fid'] = $list[$i]['id'];
    			$list[$i]['picture'] = D('pic_pic')->where($map)->order('create_time desc')->field('picture')->select();
   
    		}	
   	

   		$video = D('video')->order('create_time desc')->select();
   		
   		$this->assign('video',$video);
   		$this->assign('list',$list);
        $this->display('index');
    }


    /**
     * 视频页首页
     */
    public function video(){
      $list = D('picture')->order('create_time desc')->select();  
      for ($i=0; $i <count($list) ; $i++) { 
   
          $map['fid'] = $list[$i]['id'];
          $list[$i]['picture'] = D('pic_pic')->where($map)->order('create_time desc')->field('picture')->limit(6)->select();
   
        } 

      $video = D('video')->order('create_time desc')->select();

      $this->assign('video',$video);
      $this->assign('list',$list);
        $this->display('video');
    }


}