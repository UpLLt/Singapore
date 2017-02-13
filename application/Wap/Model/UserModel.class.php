<?php
namespace Wap\Model;
use Think\Model;
class UserModel extends Model
{
	protected $tableName = "user";
	protected $_validate = array(
		//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
		
		array('user_pass', 'require', '用户密码不能为空！', 1, 'regex', Model:: MODEL_INSERT  ),
		array('user_pass', 'require', '密码不能为空！', 1, 'regex', Model:: MODEL_INSERT ),
		array('user_pass', 'require', '密码不能为空！', 0, 'regex', Model:: MODEL_UPDATE  ),
		array('user_email','','邮箱帐号已经存在！',0,'unique',Model:: MODEL_BOTH ), // 验证user_email字段是否唯一
		array('user_email','email','邮箱格式不正确！',0,'',Model:: MODEL_BOTH ), // 验证user_email字段格式是否正确
	);

	protected $_auto = array(
	    array('create_time','mGetDate',Model:: MODEL_INSERT,'callback'),
		array('user_pass','md5',Model:: MODEL_BOTH,'function') ,
	);

	//用于获取时间，格式为2012-02-03 12:12:12,注意,方法不能为private
	function mGetDate() {
		return date('Y-m-d H:i:s');
	}
	
}

