<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class WeChatUserController extends AdminbaseController{

	/**
	 * 用户统计首页
	 */
	public function index(){

		if(!empty(I('post.keyword'))){
			$map['user_email'] = I('post.keyword');
			$count = D('user')->where($map)->count();
			$page  = $this->page($count,20);
			$list  = D('user')->where($map)->limit($page->firstRow.','.$page->listRows)->select();

		}else{
			$count = D('user')->count();
			$page  = $this->page($count,20);
			$list  = D('user')->limit($page->firstRow.','.$page->listRows)->select();
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
		$result = D('user')->where(array('id'=>I('get.id')))->delete();
		if($result){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}

}