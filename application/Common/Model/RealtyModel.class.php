<?php
namespace Common\Model;
use Common\Model\CommonModel;
class RealtyModel extends CommonModel
{
	
	protected $_validate = array(
		//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
		array('title', 'require', '内容不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH  ),
		array('price', 'require', '价格不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
		array('place', 'require', '位置不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
		array('size', 'require', '户型面积不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
		array('open_time', 'require', '开盘时间不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
		array('feature', 'require', '楼盘特殊不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
		
		array('address', 'require', '地址不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
		array('side_config', 'require', '周边配置不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
		array('thumb', 'require', '缩略图不能为空！', 1, 'regex', CommonModel:: MODEL_INSERT ),
		array('longitude', 'require', '地图经度不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
		array('latitude', 'require', '地图纬度不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
		array('developers', 'require', '开发商不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
		

	);
	
	protected $_auto = array(
		array('create_time','time',1,'function'),
	);

}

