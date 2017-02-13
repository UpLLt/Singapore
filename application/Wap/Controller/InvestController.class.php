<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/18
 * Time: 15:06
 */
namespace Wap\Controller;
use Think\Controller;
class InvestController extends BaseController{

    protected $realty_model;
    protected $realty_banner_model;
    protected $realty_pic_model;
    protected $house_model;

    public function __construct()
    {
        parent::__construct();
        $this->realty_model = D('realty');
        $this->realty_banner_model = D('realty_banner');
        $this->realty_pic_model = D('realty_pic');
        $this->house_model = D('house');
    }

    /**
     * 首页
     */
    public function index(){
        $exhibi = D('sinpage')->where(array('status'=>3))->find();
        $list   = $this->realty_model->order('create_time desc')->limit(4)->field('thumb,id,title')->select();
        $this->assign('list',$list);
        $this->assign('exhibi',$exhibi);
        $this->display('index');
    }

    /**
     * 详情
     */
    public function detail(){
        $id = I('id');
        $list   = $this->realty_model->where(array('id'=>$id))->order('create_time desc')->find();
        $banner = $this->realty_banner_model->where(array('fid'=>$id))->order('create_time desc')->limit(1)->find();
        $p      = $this->realty_pic_model->where(array('fid'=>$id))->order('create_time desc')->select();
        $count  = $this->realty_pic_model->where(array('fid'=>$id))->count();

        for($i=0;$i<count($p);$i++){
            $pic[$i] = array(
                'href' => U('Wap/Invest/own_detail',array('id'=>$p[$i]['id'],'title'=>$list['title'])),
                'pic'  => $p[$i]['picture'],
                'title'=>''

            );
        }    
        $picture = json_encode($pic);
        $this->assign('count',$count);
        $this->assign('list',$list);
        $this->assign('banner',$banner);
        $this->assign('pic',$picture);
        $this->display('detail');
    }


    /**
     * 房屋详情
     */
    public function own_detail(){
       
        $fid = I('id');
        $list = $this->house_model->where(array('fid'=>$fid))->find();
        $list['title'] = I('title');
        $this->assign('list',$list);
        $this->display('own_detail');

    }
}