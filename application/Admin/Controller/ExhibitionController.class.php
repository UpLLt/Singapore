<?php
namespace Admin\Controller;

use Common\Controller\AdminbaseController;
use Common\Model\ExhibitionModel;

class ExhibitionController extends AdminbaseController
{


    private $exhibition_model;

    public function __construct()
    {
        parent::__construct();
        $this->exhibition_model = D('Common/Exhibition');
    }

    /*
     * 展示页面
     */
    public function index()
    {
        if(empty(I('post.term'))){
            $count = $this->exhibition_model->count();
            $page = $this->page($count, 20);
            $list =  $this->exhibition_model->limit($page->firstRow.','.$page->listRows)->order('create_time desc')->select();
        }else{
            $map['type'] = I('post.term');
            $count = $this->exhibition_model->where($map)->count();
            $page = $this->page($count, 20);
            $list =  $this->exhibition_model->limit($page->firstRow.','.$page->listRows)->where($map)->order('create_time desc')->select();
        }


        for ($i = 0; $i < count($list); $i++) {
            if ($list[$i]['type'] == 1) $list[$i]['type'] = "首页轮播";
        }


        $this->assign('list', $list);
        $this->assign('page', $page->show('Admin'));
        $this->display('index');

    }

    /*
     * 增加显示
     */
    public function add_list()
    {
        $this->display('add');
    }

    /**
     * 添加
     */
    public function add()
    {
        if ($this->exhibition_model->create()) {
            $data = I('post.');
            $data['create_time'] = time();
            $result = $this->exhibition_model->add($data);
            if ($result) {
                $this->success('添加成功', U('Admin/Exhibition/index'));
            } else {
                $this->error('添加失败');
            }
        } else {
            $this->error($this->exhibition_model->getError());
        }
    }

    /**
     * 删除
     */

    public function del()
    {
        $result =  $this->exhibition_model->where(array('id' => I('id')))->delete();
        if ($result) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }


    /*
     * 修改显示
     */
    public function edit_list()
    {
        $list =  $this->exhibition_model->where(array('id' => I('id')))->find();
        $this->assign('list', $list);
        $this->display('edit');
    }

    /*
     * 修改
     */
    public function edit()
    {
        $picture = $this->exhibition_model->where(array('id'=>I('id')))->field('picture')->find();
        if ( $this->exhibition_model->create()) {
            $data = I('post.');
            if(empty(I('post.picture'))){
                $data['picture'] =  $picture['picture'];
            }
            $result = $this->exhibition_model->where(array('id' => I('id')))->save($data);
            if ($result) {
                $this->success('修改成功', U('Admin/Exhibition/index'));
            } else {
                $this->error('修改失败');
            }
        } else {
           $this->error($this->exhibition_model->getError());
        }
    }

}

