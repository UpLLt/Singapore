<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class VideoController extends AdminbaseController{

	protected $house_model;
    protected $picture_model;
    protected $pic_pic_model;
	protected $video_model;
    public function __construct()
	{
		parent::__construct();

		$this->house_model = D('house');
        $this->picture_model = D('picture');
        $this->pic_pic_model = D('pic_pic');
	    $this->video_model   = D('video');
    }

	/*
	 * 图片首页显示
	 */
	public function index(){

        $count = $this->picture_model->count();
        $page = $this->page($count,20);
        $list = $this->picture_model->order('create_time desc')->select();
		$this->assign('lists', $list);
		$this->assign("page", $page->show('Admin'));
		$this->display('index');
	}

    /*
	 * 视频首页显示
	 */
    public function video(){

        $count = $this->video_model->count();
        $page = $this->page($count,20);
        $list = $this->video_model->order('create_time desc')->select();
        $this->assign('lists', $list);
        $this->assign("page", $page->show('Admin'));
        $this->display('video');
    }

    /**
     * 增加类别页
     */

    public function add_leibie_list(){
        $this->display('leibie');
    }

    /**
     * 增加视频页
     */

    public function add_video_list(){
        $this->display('video_list');
    }

    /**
     * 增加类别
     */
    public function add_leibie(){
        $data['title']  = I('post.title');
        $data['create_time'] = time();
        $result = $this->picture_model->add($data);
        if($result){
            $this->success('添加成功',U('Admin/Video/index'));
        }else{
            $this->error('添加失败');
        }
    }

    /**
     * 增加视频
     */
    public function add_video(){
        $data['title']  = I('post.title');
        $data['create_time'] = time();
        $data['url']    = I('post.url');
        $result = $this->video_model->add($data);
        if($result){
            $this->success('添加成功',U('Admin/Video/video'));
        }else{
            $this->error('添加失败');
        }
    }

    /**
    * 删除类别
    */
    public function del_leibie(){
        $nid = I('get.id');
        $result = $this->picture_model->where('id='.$nid)->delete();
        if($result){
            $this->success('删除成功');
        }else{
            $this->error("删除失败");
        }
    }


    /**
     * 删除视频
     */
    public function del_video(){
        $nid = I('get.id');
        $result = $this->video_model->where('id='.$nid)->delete();
        if($result){
            $this->success('删除成功');
        }else{
            $this->error("删除失败");
        }
    }

    /**
     * 修改类别列表
     */
    public function edit_list(){
        $nid = I('get.id');
        $list = $this->picture_model->where('id='.$nid)->find();
        $this->assign('list',$list);
        $this->display('edit_list');

    }

    /**
     * 修改视频列表
     */
    public function edit_video_list(){
        $nid = I('get.id');
        $list = $this->video_model->where('id='.$nid)->find();
        $this->assign('list',$list);

        $this->display('edit_video');

    }


    /**
     * 修改
     */
    public function edit(){

        $result = $this->picture_model->where('id='.I('id'))->setField('title',I('title'));
        if($result){
            $this->success('修改成功');
        }else{
            $this->error('修改失败');
        }

    }

    /**
     * 修改视频
     */
    public function edit_video(){
        $data = I('post.');

        $result = $this->video_model->where('id='.I('id'))->save($data);
        if($result){
            $this->success('修改成功');
        }else{
            $this->error('修改失败');
        }

    }


    /**
     * 图片首页
     */

    public function picture_list(){
        $fid   = I('id');
        $title = $this->picture_model->where(array('id'=>$fid))->field('title')->find();
        $list  = $this->pic_pic_model->where(array('fid'=>$fid))->select();
        $this->assign('fid',$fid);
        $this->assign('list',$list);
        $this->assign('title',$title);
        $this->display('picture');

    }

    /**
     *删除图片
     */
    public function del_picture(){
        $id = I('id');
        $result = $this->pic_pic_model->where(array('id'=>$id))->delete();
        if($result){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    /**
     * 增加图片页面
     */

    public function add_picture_list(){
        $this->assign('fid',I('fid'));
        $this->display('add_picture');
    }


	/**
	 * 增加图片
	 */

	public function add_picture(){
		if(empty(I('picture'))){
			$this->error('图片不能为空');
		}
		$data = I('post.');
		$data['create_time'] = time();
		$result = $this->pic_pic_model->add($data);
		if($result){
			$this->success('添加成功');
		}else{
			$this->error('添加失败');
		}
	}







}