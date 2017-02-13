<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/18
 * Time: 15:06
 */
namespace Wap\Controller;
use Think\Controller;
use Wap\Model\UserModel;

class RegisterController extends Controller{
	protected $user_model;


    public function __construct(){
        parent::__construct();
        $this->user_model = new UserModel();
    }

    /**
     * 首页
     */
    public function index(){

        $this->display();

    }

    public function register(){
        if($this->user_model->create()){
           $result = $this->user_model->add();
           if($result){
               echo "成功";
           }else{
               echo "失败";
           }
        }else{
            echo $this->user_model->getError();
        }
    }


}