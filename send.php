<?php 
/* 
这是一个测试程序!!! 
*/ 
require("mclass.php"); 
$smtpserver = "smtp.163.com";//SMTP服务器 
$smtpserverport = 25;//SMTP服务器端口 
$smtpusermail = "singaporcool@163.com";//SMTP服务器的用户邮箱 
$smtpemailto = "1525949553@qq.com";//发送给谁 
$smtpuser = "singaporcool@163.com";//SMTP服务器的用户帐号 
$smtppass = "coolsg123";//SMTP服务器的用户密码 
$mailsubject = "中文";//邮件主题 
$mailbody = "<h1>中文</h1>测试邮件发送！！！！";//邮件内容 
$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件 
$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证. 
$smtp->debug = TRUE;//是否显示发送的调试信息 
$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype); 
?>