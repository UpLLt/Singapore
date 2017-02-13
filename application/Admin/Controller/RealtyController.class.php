<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class RealtyController extends AdminbaseController{

	protected $realty_model;
	protected $realty_banner_model;
	protected $realty_pic_model;
	protected $house_model;
	public function __construct()
	{
		parent::__construct();
		$this->realty_model = D('Common/Realty');
		$this->realty_banner_model = D('realty_banner');
		$this->realty_pic_model = D('realty_pic');
		$this->house_model = D('house');
	}

	/*
	 * 地产首页显示
	 */
	public function index(){
		$start_time = strtotime(I('post.start_time'));
		$end_time   = strtotime(I('post.end_time'));
		$keyword    = I('post.keyword');

		if(empty($start_time) || empty($end_time)){
			if(empty($keyword)){

				$count = $this->realty_model->count();
				$page = $this->page($count,20);
				$list = $this->realty_model->limit($page->firstRow.','.$page->listRows)->order('create_time desc')->select();

			}else{
				$map['title'] = array("like","%".$keyword."%");
				$count = $this->realty_model->where($map)->count();
				$page = $this->page($count,20);
				$list = $this->realty_model->limit($page->firstRow.','.$page->listRows)->where($map)->order('create_time desc')->select();
			}
		}else{
			$time = "create_time>='{$start_time}' and create_time<='{$end_time}'";
			if(empty($keyword)){

				$count = $this->realty_model->where($time)->count();
				$page = $this->page($count,20);
				$list = $this->realty_model->limit($page->firstRow.','.$page->listRows)->where($time)->order('create_time desc')->select();

			}else{
				$map['title'] = array("like","%".$keyword."%");
				$count = $this->realty_model->where($time)->where($map)->count();
				$page = $this->page($count,20);
				$list = $this->realty_model->limit($page->firstRow.','.$page->listRows)->where($time)->where($map)->order('create_time desc')->select();
			}
		}


		$this->assign('lists', $list);
		$this->assign("page", $page->show('Admin'));
		$this->display('index');
	}

	/**
	 * 房产详情
	 */

	public function detail(){
		$id = I('id');
		$list = $this->realty_model->where(array('id'=>$id))->find();
		$this->assign('list',$list);
		$this->display('detail');
	}


	/*
	 * 地产增加页面
	 */
	public function add_list(){
		$this->display('add_list');
	}

	/**
	 * 增加地产
	 */
	public function add(){
		if($this->realty_model->create()){
			$data = $this->realty_model->create();
			$data['create_time'] = time();
			$data['content'] = htmlspecialchars_decode($data['content']);
		   $result	= $this->realty_model->add($data);
			if($result){
				$this->success('成功',U('Admin/Realty/index'));
			}else{
				$this->error('失败');
			}
		}else{
			$this->error($this->realty_model->getError());
		}
	}

	/*
	 * 删除地产
	 */
	public function del(){
		$nid = I('get.id');
		$result = $this->realty_model->where('id='.$nid)->delete();
		if($result){
			$this->success('删除成功');
		}else{
			$this->error("删除失败");
		}
	}

	/**
	 * 修改地产列表
	 */
	public function edit_list(){
		$nid = I('get.id');
		$list = $this->realty_model->where('id='.$nid)->find();

		$this->assign('list',$list);
		$this->display('edit_list');

	}

	/**
	 * 修改
	 */
	public function edit(){

		$picture = $this->realty_model->where(array('id'=>I('id')))->field('thumb')->find();
		if($this->realty_model->create()){
			$data = $this->realty_model->create();
			$data['content'] = htmlspecialchars_decode($data['content']);
			if(empty($data['thumb'])){
				$data['thumb'] = $picture['thumb'];
			}
			$result	= $this->realty_model->where('id='.I('post.id'))->save($data);
			if($result){
				$this->success('成功',U('Admin/Realty/index'));
			}else{
				$this->error('失败');
			}
		}else{
			$this->error( $this->realty_model->getError());
		}
	}

	/**
	 * banner图片首页
	 */

	public function banner_list(){
		$fid   = I('id');
		$title = $this->realty_model->where(array('id'=>$fid))->field('title')->find();
		$list  = $this->realty_banner_model->where(array('fid'=>$fid))->select();
		$this->assign('fid',$fid);
		$this->assign('list',$list);
		$this->assign('title',$title);
		$this->display('banner');

	}

	/**
	 * 图片首页
	 */

	public function pic_list(){
		$fid   = I('id');
		$title = $this->realty_model->where(array('id'=>$fid))->field('title')->find();
		$list  = $this->realty_pic_model->where(array('fid'=>$fid))->select();
		$this->assign('fid',$fid);
		$this->assign('list',$list);
		$this->assign('title',$title);
		$this->display('pic');

	}


	/**
	 *删除Banner图片
	 */
	public function del_banner(){
		$id = I('id');
		$result = $this->realty_banner_model->where(array('id'=>$id))->delete();
		if($result){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}

	/**
	 *删除图片
	 */
	public function del_pic(){
		$id = I('id');
		$result = $this->realty_pic_model->where(array('id'=>$id))->delete();
		if($result){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}


	/**
	 * 增加Banner图片页面
	 */

	public function add_banner_list(){
		$this->assign('fid',I('fid'));
		$this->display('add_banner');
	}

	/**
	 * 增加Banner图片页面
	 */

	public function add_pic_list(){
		$this->assign('fid',I('fid'));
		$this->display('add_pic');
	}

	/**
	 * 增加Banner图片
	 */

	public function add_banner(){
			if(empty(I('picture'))){
				$this->error('图片不能为空');
			}
			$data = I('post.');
			$data['create_time'] = time();
			$result = $this->realty_banner_model->add($data);
			if($result){
				$this->success('添加成功',U('Admin/Realty/banner_list',array('id'=>I('post.fid'))));
			}else{
				$this->error('添加失败');
			}
	}

	/**
	 * 增加图片
	 */

	public function add_pic(){



		if(empty(I('picture'))){
			$this->error('图片不能为空');
		}
		$data = I('post.');
		$data['create_time'] = time();
		$result = $this->realty_pic_model->add($data);
		if($result){
			$this->success('添加成功',U('Admin/Realty/pic_list',array('id'=>I('post.fid'))));
		}else{
			$this->error('添加失败');
		}
	}



	/**
	 * 编辑户型页
	 */
	public function add_house_list(){
		$id = I('id');
		$list = $this->house_model->where(array('fid'=>$id))->find();
		if(empty($list)){
			$data['fid'] = $id;
			$data['create_time'] = time();
			$this->house_model->add($data);
		}

		$this->assign('id',$id);
		$this->assign('list',$list);
		$this->display('add_house');
	}

	/**
	 * 编辑户型
	 */
	public function add_house(){
		$data   = I('post.');
		$data['create_time'] = time();
		$is_exist = $this->house_model->where(array('fid'=>I('post.fid')))->find();
		if(empty($data['thumb'])){
			$data['thumb'] = $is_exist['thumb'];
		}

		$result   = $this->house_model->where(array('fid'=>I('post.fid')))->save($data);
		
		if($result){
			$this->success('修改成功');
		}else{
			$this->error('修改失败');
		}
	}

}