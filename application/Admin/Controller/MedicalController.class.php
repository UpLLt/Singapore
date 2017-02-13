<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class MedicalController extends AdminbaseController{

		protected $Medical_model;
	public function __construct()
	{
		parent::__construct();
		$this->Medical_model = D('Common/Medical');
	}

	/*
	 * 医疗首页显示
	 */
	public function index(){
		$start_time = strtotime(I('post.start_time'));
		$end_time   = strtotime(I('post.end_time'));
		$keyword    = I('post.keyword');

		if(empty($start_time) || empty($end_time)){
			if(empty($keyword)){

				$count = $this->Medical_model->count();
				$page = $this->page($count,20);
				$list = $this->Medical_model->limit($page->firstRow.','.$page->listRows)->order('create_time desc')->select();

			}else{
				$map['title'] = array("like","%".$keyword."%");
				$count = $this->Medical_model->where($map)->count();
				$page = $this->page($count,20);
				$list = $this->Medical_model->limit($page->firstRow.','.$page->listRows)->where($map)->order('create_time desc')->select();
			}
		}else{
			$time = "create_time>='{$start_time}' and create_time<='{$end_time}'";
			if(empty($keyword)){

				$count = $this->Medical_model->where($time)->count();
				$page = $this->page($count,20);
				$list = $this->Medical_model->limit($page->firstRow.','.$page->listRows)->where($time)->order('create_time desc')->select();

			}else{
				$map['title'] = array("like","%".$keyword."%");
				$count = $this->Medical_model->where($time)->where($map)->count();
				$page = $this->page($count,20);
				$list = $this->Medical_model->limit($page->firstRow.','.$page->listRows)->where($time)->where($map)->order('create_time desc')->select();
			}
		}

		$this->assign('lists', $list);
		$this->assign("page", $page->show('Admin'));
		$this->display('index');
	}
	
	/*
	 * 增加医疗页面
	 */
	public function add_list(){
		$this->display('add_list');
	}

	/**
	 * 增加医疗
	 */
	public function add(){
		if($this->Medical_model->create()){
			$data = $this->Medical_model->create();
			$data['create_time'] = time();
			$data['content'] = htmlspecialchars_decode($data['content']);
		   $result	= $this->Medical_model->add($data);
			if($result){
				$this->success('成功',U('Admin/Medical/index'));
			}else{
				$this->error('失败');
			}
		}else{
			$this->error($this->Medical_model->getError());
		}
	}

	/*
	 * 删除医疗
	 */
	public function del(){
		$nid = I('get.nid');
		$result = $this->Medical_model->where('nid='.$nid)->delete();
		if($result){
			$this->success('删除成功');
		}else{
			$this->error("删除失败");
		}
	}

	/**
	 * 修改医疗列表
	 */
	public function edit_list(){
		$nid = I('get.nid');
		$list = $this->Medical_model->where('nid='.$nid)->find();
		;
		$this->assign('list',$list);
		$this->display('edit_list');

	}

	/**
	 * 修改
	 */
	public function edit(){
		$picture = $this->Medical_model->where(array('nid'=>I('nid')))->field('thumb')->find();
		if($this->Medical_model->create()){
			$data = $this->Medical_model->create();
			$data['content'] = htmlspecialchars_decode($data['content']);
			if(empty($data['thumb'])){
				$data['thumb'] = $picture['thumb'];
			}
			$result	= $this->Medical_model->where('nid='.I('post.nid'))->save($data);
			if($result){
				$this->success('成功',U('Admin/Medical/index'));
			}else{
				$this->error('失败');
			}
		}else{
			$this->error( $this->Medical_model->getError());
		}
	}
}