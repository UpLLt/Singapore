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

class LoginController extends Controller{

    protected $user_model;
    protected $shot_message_model;
    /**
     * 首页
     */

    public function __construct()
    {
        parent::__construct();
        $this->user_model = new UserModel();
        $this->shot_message_model = D('shot_message');
    }

    public function index(){

        $this->display();
    }

    public function login(){
        $user_pass   = md5(I('post.user_pass'));
        $user_email  = I('post.user_email');
        $map['user_pass']  = $user_pass;
        $map['user_email'] =$user_email;
        $result = $this->user_model->where($map)->field('id')->find();
        if($result){
            echo "成功";
            session('user_id',$result['id']);
        }else{
            echo "账号或密码不正确";
        }
    }

    public function lose_pass(){
        $this->display('losepass');
    }

    public function send(){
		
        $to      = I('post.user_email');

        $result = $this->user_model->where(array('user_email'=>$to))->field('id,user_nickname')->find();
        if(empty($result['id'])){
            echo 1;exit;
        }
        $number  = $this->rand_number();
       
        $subject = '新加坡酷找回密码验证码';
        $body = '您好，您的验证码是'.$number.'，过期时间15分钟,如非本人，请忽略。【新加坡酷】';
       
        /* $result = $this->think_send_mail($to, $name, $subject = '', $body, $attachment ); */
		$this->send_aaaa($to,$subject,$body);
       

        if($result == true ){

            $data['create_time'] = time();
            $data['user_email']  = $to;
            $data['expiration_time'] = strtotime("+15 minutes");
            $data['code']  = $number;

            $this->shot_message_model->add($data);

            echo 0;exit;
        }else{
            echo $result;exit;
        }
    }

	
	public function send_aaaa($smtpemailto,$mailsubject,$mailbody){
		
		
	
		vendor('Mail.mclass');
		$smtpserver = "smtp.163.com";//SMTP服务器 
		$smtpserverport = 25;//SMTP服务器端口 
		$smtpusermail = "singaporcool@163.com";//SMTP服务器的用户邮箱 
		/* $smtpemailto = "1525949553@qq.com";//发送给谁  */
		$smtpuser = "singaporcool@163.com";//SMTP服务器的用户帐号 
		$smtppass = "coolsg123";//SMTP服务器的用户密码 
/* 		$mailsubject = "中文";//邮件主题 
		$mailbody = "<h1>中文</h1>测试邮件发送！！！！";//邮件内容  */
		$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件 
		$smtp = new \smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证. 
		$smtp->debug = false;//是否显示发送的调试信息 
		$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype); 
	}
	
    public function edit_pass(){
        $user_email = I('post.user_email');
        $user_pass  = md5(I('post.user_pass'));
        $user_code  = I('post.code');
        $code = $this->shot_message_model->where(array('user_email'=>$user_email))->order('create_time desc')->find();
        if($user_code == $code['code']){
            if(time()<=$code['expiration_time']){
                $result = $this->user_model->where(array('user_email'=>$user_email))->setField('user_pass',$user_pass);
                if($result){
                    //成功
                    echo 0;exit;
                }else{
                    //失败
                    echo 3;exit;
                }
            }else{
                //验证码过期
                echo 2;exit;
            }
        }else{
            //验证码不正确
            echo 1;exit;
        }
    }



    public function rand_number(){
        return rand(100000,999999);
    }

    /**
     * 系统邮件发送函数
     * @param string $to    接收邮件者邮箱
     * @param string $name  接收邮件者名称
     * @param string $subject 邮件主题
     * @param string $body    邮件内容
     * @param string $attachment 附件列表
     * @return boolean
     */
    function think_send_mail($to, $name, $subject = '', $body = '', $attachment = null){
        $config = C('THINK_EMAIL');
        vendor('PHPMailer.class.phpmailer'); //从PHPMailer目录导class.phpmailer.php类文件
        $mail             = new \PHPMailer(); //PHPMailer对象


        $mail->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
        $mail->IsSMTP();  // 设定使用SMTP服务
        $mail->SMTPDebug  = 0;                     // 关闭SMTP调试功能
        // 1 = errors and messages
        // 2 = messages only
        $mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
        $mail->SMTPSecure = 'ssl';                 // 使用安全协议
        $mail->Host       = $config['SMTP_HOST'];  // SMTP 服务器
        $mail->Port       = $config['SMTP_PORT'];  // SMTP服务器的端口号
        $mail->Username   = $config['SMTP_USER'];  // SMTP服务器用户名
        $mail->Password   = $config['SMTP_PASS'];  // SMTP服务器密码

       
        $mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);
        $replyEmail       = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];
        $replyName        = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];
        $mail->AddReplyTo($replyEmail, $replyName);
        $mail->Subject    = $subject;
        $mail->MsgHTML($body);
        $mail->AddAddress($to, $name);
        if(is_array($attachment)){ // 添加附件
            foreach ($attachment as $file){
                is_file($file) && $mail->AddAttachment($file);
            }
        }
        return $mail->Send() ? true : $mail->ErrorInfo;
    }

}