<?php
return array(
		//'SHOW_ERROR_MSG'        =>  true,
		'URL_MODEL' => 2,
		//'URL_CASE_INSENSITIVE'  =>  false,
		//'TMPL_EXCEPTION_FILE'   => './404.html',
		'SESSION_OPTIONS'=> array(
		'expire'=>'300000000',
		),


	'THINK_EMAIL' => array(
		'SMTP_HOST'   => 'smtp.163.com', //SMTP服务器
		'SMTP_PORT'   => '25', //SMTP服务器端口
		'SMTP_USER'   => 'singaporcool@163.com', //SMTP服务器用户名
		'SMTP_PASS'   => 'coolsg123', //SMTP服务器密码
		'FROM_EMAIL'  => 'singaporcool@163.com', //发件人EMAIL
		'FROM_NAME'   => '新加坡酷', //发件人名称
		'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）
		'REPLY_NAME'  => '', //回复名称（留空则为发件人名称）
	),

);