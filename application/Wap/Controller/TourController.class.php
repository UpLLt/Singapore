<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/18
 * Time: 15:06
 */
namespace Wap\Controller;
use Think\Controller;
class TourController extends BaseController{
    protected $tour_model;

    public function __construct()
    {
        parent::__construct();
        $this->tour_model = D('tour');
    }

    /**
     * 首页
     */
    public function index(){
        $list = $this->tour_model->order('create_time desc')->where(array('status'=>1))->limit('6')->select();
        for($i=0;$i<count($list);$i++){
            if( $list[$i]['type'] == 1 )  $list[$i]['url'] = U('Wap/Tour/good_food_detail',array('nid'=>$list[$i]['nid']));
            if( $list[$i]['type'] == 2 )  $list[$i]['url'] = U('Wap/Tour/hot_place_detail',array('nid'=>$list[$i]['nid']));
            if( $list[$i]['type'] == 3 )  $list[$i]['url'] = U('Wap/Tour/shopping_place_detail',array('nid'=>$list[$i]['nid']));
            if( $list[$i]['type'] == 4 )  $list[$i]['url'] = U('Wap/Tour/in_history_detail',array('nid'=>$list[$i]['nid']));
        }
        $this->assign('list',$list);
        $this->display('index');
    }

    /**
     * 地道美食首页
     */
    public function good_food(){
        $list = $this->tour_model->where(array('type'=>1))->order('create_time desc')->limit(3)->select();
        $this->assign('list',$list);
        $this->display('good_food');

    }

    /**
     * 热门地点首页
     */
    public function hot_place(){
        $list = $this->tour_model->where(array('type'=>2))->order('create_time desc')->limit(3)->select();
        $this->assign('list',$list);
        $this->display('hot_place');

    }

    /**
     * 购物天堂首页
     */
    public function shopping_place(){
        $list = $this->tour_model->where(array('type'=>3))->order('create_time desc')->limit(3)->select();
        $this->assign('list',$list);
        $this->display('shopping_place');

    }

    /**
     * 走入历史首页
     */
    public function in_history(){
        $list = $this->tour_model->where(array('type'=>4))->order('create_time desc')->limit(3)->select();
        $this->assign('list',$list);
        $this->display('in_history');

    }
    /**
     * 地道美食分页
     */
    public function good_food_page(){
        $page     = I('post.page');
        $pagenum  = 3;
        $start    = ($page-1)*$pagenum;
        $list = $this->tour_model->limit($start.','.$pagenum)->where(array('type'=>1))->order('create_time desc')->field('nid,create_time,title,describe,thumb')->select();
        $a = json_encode($list);
        echo $a;exit;
        $this->AjaxReturn($a);
    }

    /**
     * 热门地点分页
     */
    public function hot_place_page(){
        $page     = I('post.page');
        $pagenum  = 3;
        $start    = ($page-1)*$pagenum;
        $list = $this->tour_model->limit($start.','.$pagenum)->where(array('type'=>2))->order('create_time desc')->field('nid,create_time,title,describe,thumb')->select();
        $a = json_encode($list);
        echo $a;exit;
        $this->AjaxReturn($a);
    }


    /**
     * 购物天堂分页
     */
    public function shopping_place_page(){
        $page     = I('post.page');
        $pagenum  = 3;
        $start    = ($page-1)*$pagenum;
        $list = $this->tour_model->limit($start.','.$pagenum)->where(array('type'=>3))->order('create_time desc')->field('nid,create_time,title,describe,thumb')->select();
        $a = json_encode($list);
        echo $a;exit;
        $this->AjaxReturn($a);
    }

    /**
     * 走入历史分页
     */
    public function in_history_page(){
        $page     = I('post.page');
        $pagenum  = 3;
        $start    = ($page-1)*$pagenum;
        $list = $this->tour_model->limit($start.','.$pagenum)->where(array('type'=>4))->order('create_time desc')->field('nid,create_time,title,describe,thumb')->select();
        $a = json_encode($list);
        echo $a;exit;
        $this->AjaxReturn($a);
    }

    /**
     * 地道美食详情
     */

    public function good_food_detail(){
        $nid = I('nid');
        $list = $this->tour_model->where(array('nid'=>$nid))->find();
        $this->assign('list',$list);
        $this->display('good_food_detail');
    }

    /**
     * 热门地点详情
     */

    public function hot_place_detail(){
        $nid = I('nid');
        $list = $this->tour_model->where(array('nid'=>$nid))->find();
        $this->assign('list',$list);
        $this->display('hot_place_detail');
    }

    /**
     * 购物天堂详情
     */

    public function shopping_place_detail(){
        $nid = I('nid');
        $list = $this->tour_model->where(array('nid'=>$nid))->find();
        $this->assign('list',$list);
        $this->display('shopping_place_detail');
    }

    /**
     * 走入历史详情
     */

    public function in_history_detail(){
        $nid = I('nid');
        $list = $this->tour_model->where(array('nid'=>$nid))->find();
        $this->assign('list',$list);
        $this->display('in_history_detail');
    }
}