<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class NewsController extends AdminbaseController{

		protected $news_model;
	public function __construct()
	{
		parent::__construct();
		$this->news_model = D('Common/News');
	}

	/*
	 * 新闻首页显示
	 */
	public function index(){
		$start_time = strtotime(I('post.start_time'));
		$end_time   = strtotime(I('post.end_time'));
		$keyword    = I('post.keyword');

		if(empty($start_time) || empty($end_time)){
			if(empty($keyword)){

				$count = $this->news_model->count();
				$page = $this->page($count,20);
				$list = $this->news_model->order('create_time desc')->select();

			}else{
				$map['title'] = array("like","%".$keyword."%");
				$count = $this->news_model->where($map)->count();
				$page = $this->page($count,20);
				$list = $this->news_model->where($map)->limit($page->firstRow.','.$page->listRows)->order('create_time desc')->select();
			}
		}else{
			$time = "create_time>='{$start_time}' and create_time<='{$end_time}'";
			if(empty($keyword)){

				$count = $this->news_model->where($time)->count();
				$page = $this->page($count,20);
				$list = $this->news_model->where($time)->limit($page->firstRow.','.$page->listRows)->order('create_time desc')->select();

			}else{
				$map['title'] = array("like","%".$keyword."%");
				$count = $this->news_model->where($time)->where($map)->count();
				$page = $this->page($count,20);
				$list = $this->news_model->where($time)->limit($page->firstRow.','.$page->listRows)->where($map)->order('create_time desc')->select();
			}
		}

		for($i=0;$i<count($list);$i++){
			if( $list[$i]['status'] == 0 )  $list[$i]['status'] = "不推荐";
			if( $list[$i]['status'] == 1 )  $list[$i]['status'] = "推荐";
		}
		$this->assign('lists', $list);
		$this->assign("page", $page->show('Admin'));
		$this->display('index');
	}
	
	/*
	 * 新闻增加页面
	 */
	public function add_list(){
		$this->display('add_list');
	}

	/**
	 * 增加新闻
	 */
	public function add(){
		if($this->news_model->create()){
			$data = $this->news_model->create();
			$data['create_time'] = time();
			$data['content'] = htmlspecialchars_decode($data['content']);
		   $result	= $this->news_model->add($data);
			if($result){
				$this->success('成功',U('Admin/News/index'));
			}else{
				$this->error('失败');
			}
		}else{
			$this->error($this->news_model->getError());
		}
	}

	/*
	 * 删除新闻
	 */
	public function del(){
		$nid = I('get.nid');
		$result = $this->news_model->where('nid='.$nid)->delete();
		if($result){
			$this->success('删除成功');
		}else{
			$this->error("删除失败");
		}
	}

	/**
	 * 修改新闻列表
	 */
	public function edit_list(){
		$nid = I('get.nid');
		$list = $this->news_model->where('nid='.$nid)->find();

		if( $list['status'] == 1 ) {
			$str = "	<label class=\"radio\"><input type=\"radio\" name=\"status\" value=\"0\" >不推荐</label>
								<label class=\"radio\"><input type=\"radio\" name=\"status\" value=\"1\" checked>推荐</label>";

		}else{
			$str = "	<label class=\"radio\"><input type=\"radio\" name=\"status\" value=\"0\" checked>不推荐</label>
								<label class=\"radio\"><input type=\"radio\" name=\"status\" value=\"1\" >推荐</label>";
			}
		$this->assign('str',$str);
		$this->assign('list',$list);
		$this->display('edit_list');

	}

	/**
	 * 修改
	 */
	public function edit(){
		$picture = $this->news_model->where(array('nid'=>I('nid')))->field('thumb')->find();
		if($this->news_model->create()){
			$data = $this->news_model->create();
			$data['content'] = htmlspecialchars_decode($data['content']);
			if(empty($data['thumb'])){
				$data['thumb'] = $picture['thumb'];
			}
			$result	= $this->news_model->where('nid='.I('post.nid'))->save($data);
			if($result){
				$this->success('成功',U('Admin/News/index'));
			}else{
				$this->error('失败');
			}
		}else{
			$this->error( $this->news_model->getError());
		}
	}
}