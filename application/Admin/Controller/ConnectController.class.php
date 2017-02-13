<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class ConnectController extends AdminbaseController{

	/*
	 * 联系我们
	 */
	public function index(){
		if(!empty(I('post.keyword'))){
			$map['real_name'] = array('like','%'.I('post.keyword').'%');
			$count = D('connect')->where($map)->count();
			$page  = $this->page($count,20);
			$list  = D('connect')->where($map)->limit($page->firstRow.','.$page->listRows)->order('create_time desc')->select();
		}else{
			$count = D('connect')->count();
			$page  = $this->page($count,20);
			$list  = D('connect')->limit($page->firstRow.','.$page->listRows)->order('create_time desc')->select();
		}

		$this->assign('keyword',I('post.keyword'));
		$this->assign('page',$page->show('Admin'));
		$this->assign('list',$list);
		$this->display('index');
	}

	/*
	 * 删除
	 */
	public function del(){
	 	$result = D('connect')->where(array('id'=>I('get.id')))->delete();
		if($result){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}

	/**
	 * 详情
	 */

	public function detail(){
		$result = D('connect')->where(array('id'=>I('get.id')))->field('content')->find();
		$this->assign('list',$result);
		$this->display('detail');
	}
}
