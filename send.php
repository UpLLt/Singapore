<?php 
/* 
����һ�����Գ���!!! 
*/ 
require("mclass.php"); 
$smtpserver = "smtp.163.com";//SMTP������ 
$smtpserverport = 25;//SMTP�������˿� 
$smtpusermail = "singaporcool@163.com";//SMTP���������û����� 
$smtpemailto = "1525949553@qq.com";//���͸�˭ 
$smtpuser = "singaporcool@163.com";//SMTP���������û��ʺ� 
$smtppass = "coolsg123";//SMTP���������û����� 
$mailsubject = "����";//�ʼ����� 
$mailbody = "<h1>����</h1>�����ʼ����ͣ�������";//�ʼ����� 
$mailtype = "HTML";//�ʼ���ʽ��HTML/TXT��,TXTΪ�ı��ʼ� 
$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//�������һ��true�Ǳ�ʾʹ�������֤,����ʹ�������֤. 
$smtp->debug = TRUE;//�Ƿ���ʾ���͵ĵ�����Ϣ 
$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype); 
?>