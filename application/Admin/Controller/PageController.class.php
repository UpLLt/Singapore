<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class PageController extends AdminbaseController{

	//旅游
	public function tour(){
		$list = D('sinpage')->where(array('status'=>1))->find();
		if(empty($list['mid'])){
			$data = array(
				'content'=>'',
				'status'=>'1',
				'create_time'=>time()
			);
			D('sinpage')->add($data);
			$list = D('sinpage')->where(array('status'=>1))->find();
		}
		$this->assign('list',$list);
		$this->display('tour');

	}


	//教育
	public function education(){
		$list = D('sinpage')->where(array('status'=>2))->find();
		if(empty($list['mid'])){
			$data = array(
				'content'=>'',
				'status'=>'2',
				'create_time'=>time()
			);
			D('sinpage')->add($data);
			$list = D('sinpage')->where(array('status'=>2))->find();
		}
		$this->assign('list',$list);
		$this->display('education');

	}

	//投资
	public function invest(){
		$list = D('sinpage')->where(array('status'=>3))->find();
		if(empty($list['mid'])){
			$data = array(
				'content'=>'',
				'status'=>'3',
				'create_time'=>time()
			);
			D('sinpage')->add($data);
			$list = D('sinpage')->where(array('status'=>3))->find();
		}
		$this->assign('list',$list);
		$this->display('invest');

	}

	//关于我们
	public function about_us(){
		$list = D('sinpage')->where(array('status'=>4))->find();
		if(empty($list['mid'])){
			$data = array(
				'content'=>'',
				'status'=>'4',
				'create_time'=>time()
			);
			D('sinpage')->add($data);
			$list = D('sinpage')->where(array('status'=>4))->find();
		}


		$this->assign('list',$list);
		$this->display('about_us');
	}

	//旅游编辑
	public function edit(){

		$data   = I('post.');
		$data['content'] = $contnt = htmlspecialchars_decode($data['content']);
		$thumb = D('sinpage')->where(array('mid'=>I('post.mid')))->field('thumb')->find();
		if(empty($thumb)){
			$data['thumb'] = $thumb['thumb'];
		}
		$result = D('sinpage')->where(array('mid'=>I('post.mid')))->save($data);
		if($result){
			$this->success('修改成功');
		}else{
			$this->error('修改失败');
		}
	}
	
}