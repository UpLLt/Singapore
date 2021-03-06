<?php
namespace Common\Model;
use Common\Model\CommonModel;
class NewsModel extends CommonModel
{
	
	protected $_validate = array(
		//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
		array('content', 'require', '内容不能为空！', 1, 'regex', CommonModel:: MODEL_INSERT  ),
		array('title', 'require', '标题不能为空！', 1, 'regex', CommonModel:: MODEL_INSERT ),
		array('describe', 'require', '标题不能为空！', 1, 'regex', CommonModel:: MODEL_INSERT ),


	);
	
	protected $_auto = array(
		array('create_time','time',1,'function'),
	);

}

