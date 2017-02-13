<?php
namespace Common\Model;
use Common\Model\CommonModel;
class ExhibitionModel extends CommonModel
{

	protected $tableName = "exhibition";
	protected $_validate = array(
		//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
		array('picture', 'require', '图片不能为空！', 1, 'regex', CommonModel:: MODEL_INSERT),
		array('describe', 'require', '描述不能为空！', 1, 'regex',3 ),
		array('title', 'require', '标题不能为空！', 1, 'regex', 3 ),


	);
	


}

