<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class TourController extends AdminbaseController{

		protected $tour_model;
	public function __construct()
	{
		parent::__construct();
		$this->tour_model = D('Common/Tour');
	}

	/*
	 * 旅游首页显示
	 */
	public function index(){

		if(I('post.term')){
		$map['type'] = I('post.term');
		$count = $this->tour_model->where($map)->count();
		$page = $this->page($count,20);
		$list = $this->tour_model->where($map)->order('create_time desc')->select();
		}else{
			$count = $this->tour_model->count();
			$page = $this->page($count,20);
			$list = $this->tour_model->order('create_time desc')->select();
		}


		for($i=0;$i<count($list);$i++){
			if( $list[$i]['status'] == 0 )  $list[$i]['status'] = "不推荐";
			if( $list[$i]['status'] == 1 )  $list[$i]['status'] = "推荐";
			if( $list[$i]['type'] == 1 )  $list[$i]['type'] = "道地美食";
			if( $list[$i]['type'] == 2 )  $list[$i]['type'] = "热门地点";
			if( $list[$i]['type'] == 3 )  $list[$i]['type'] = "购物天堂";
			if( $list[$i]['type'] == 4 )  $list[$i]['type'] = "走入历史";

		}
		if(I('post.term')){
			if( I('post.term') == 1 ) $a = "selected='selected'";
			if( I('post.term') == 2 ) $b = "selected='selected'";
			if( I('post.term') == 3 ) $c = "selected='selected'";
			if( I('post.term') == 4 ) $d = "selected='selected'";


			$str = " <option ".$a." value='1'>道地美食</option>
            <option ".$b." value='2'>热门地点</option>
            <option ".$c." value='3'>购物天堂</option>
            <option ".$d." value='4'>走入历史</option>";


		}else{
			$str = " <option  value='1'>道地美食</option>
            <option value='2'>热门地点</option>
            <option value='3'>购物天堂</option>
            <option value='4'>走入历史</option>";
		}
		$this->assign('str',$str);
		$this->assign('lists', $list);
		$this->assign("page", $page->show('Admin'));
		$this->display('index');
	}
	
	/*
	 * 旅游增加页面
	 */
	public function add_list(){
		$this->display('add_list');
	}

	/**
	 * 增加旅游
	 */
	public function add(){
		if($this->tour_model->create()){
			$data = $this->tour_model->create();
			$data['create_time'] = time();
			$data['content'] = htmlspecialchars_decode(I('post.content'));
		    $result	= $this->tour_model->add($data);
			if($result){
				$this->success('成功',U('Admin/Tour/index'));
			}else{
				$this->error('失败');
			}
		}else{
			$this->error($this->tour_model->getError());
		}
	}

	/*
	 * 删除旅游
	 */
	public function del(){
		$nid = I('get.nid');
		$result = $this->tour_model->where('nid='.$nid)->delete();
		if($result){
			$this->success('删除成功');
		}else{
			$this->error("删除失败");
		}
	}

	/**
	 * 修改旅游列表
	 */
	public function edit_list(){
		$nid = I('get.nid');
		$list = $this->tour_model->where('nid='.$nid)->find();

		if( $list['status'] == 1 ) {
			$str = "	<label class=\"radio\"><input type=\"radio\" name=\"status\" value=\"0\" >不推荐</label>
								<label class=\"radio\"><input type=\"radio\" name=\"status\" value=\"1\" checked>推荐</label>";

		}else{
			$str = "	<label class=\"radio\"><input type=\"radio\" name=\"status\" value=\"0\" checked>不推荐</label>
								<label class=\"radio\"><input type=\"radio\" name=\"status\" value=\"1\" >推荐</label>";
			}


		if( $list['type'] == 1 ) $a = "selected='selected'";
		if( $list['type'] == 2 ) $b = "selected='selected'";
		if( $list['type'] == 3 ) $c = "selected='selected'";
		if( $list['type'] == 4 ) $d = "selected='selected'";




		$type = " <option ".$a." value='1'>道地美食</option>
            <option ".$b." value='2'>热门地点</option>
            <option ".$c." value='3'>购物天堂</option>
            <option ".$d." value='4'>走入历史</option>";



		$this->assign('type',$type);
		$this->assign('str',$str);
		$this->assign('list',$list);
		$this->display('edit_list');

	}

	/**
	 * 修改
	 */
	public function edit(){
		$picture = $this->tour_model->where(array('nid'=>I('nid')))->field('thumb')->find();
		if($this->tour_model->create()){
			$data = $this->tour_model->create();
			$data['content'] = htmlspecialchars_decode(I('post.content'));

;			if(empty($data['thumb'])){
				$data['thumb'] = $picture['thumb'];
			}
			$result	= $this->tour_model->where('nid='.I('post.nid'))->save($data);
			if($result){
				$this->success('成功',U('Admin/Tour/index'));
			}else{
				$this->error('失败');
			}
		}else{
			$this->error( $this->tour_model->getError());
		}
	}
}