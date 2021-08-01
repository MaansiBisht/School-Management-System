<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

class Email_model extends CI_Model {

	protected $school_id;
	protected $active_session;

	public function __construct()
	{
		parent::__construct();
		$this->school_id = school_id();
		$this->active_session = active_session();
	}

     //.........................................CONTACT MESSAGE EMAIL.........................................//
    function contact_message_email($email_from, $email_to, $email_message) {
		$email_sub = "Message from School Website";
		$this->send_mail_using_smtp($email_message, $email_sub, $email_to, $email_from);

		/* if (get_smtp('mail_sender') == 'php_mailer') {
			$this->send_mail_using_php_mailer($email_message, $email_sub, $email_to, $email_from);
		}else{
			$this->send_mail_using_smtp($email_message, $email_sub, $email_to, $email_from);
		} */
	}
    public function send_mail_using_smtp($msg=NULL, $sub=NULL, $to=NULL, $from=NULL) {
		//Load email library
		$this->load->library('email');

		if($from == NULL){
			$from		=	get_settings('system_email');
		}

		//SMTP & mail configuration
		$config = array(
			'protocol'  => 'smtp',
			'smtp_host' => get_smtp('smtp_host'),
			'smtp_port' => get_smtp('smtp_port'),
			'smtp_user' => get_smtp('smtp_username'),
			'smtp_pass' => get_smtp('smtp_password'),
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'smtp_timeout' => '30',
			'mailpath' => '/usr/sbin/sendmail',
			'wordwrap' => TRUE
		);
	//	print_r($config); die;
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");

		$htmlContent = $msg;

		$this->email->to($to);
		$this->email->from($from, get_smtp('smtp_set_from'));
		$this->email->subject($sub);
		$this->email->message($htmlContent);

		//Send email
		$this->email->send();
	}

/*	public function send_mail_using_php_mailer($message=NULL, $subject=NULL, $to=NULL, $from=NULL) {
		// Load PHPMailer library
		$this->load->library('phpmailer_lib');

		// PHPMailer object
		$mail = $this->phpmailer_lib->load();

		// SMTP configuration
		$mail->isSMTP();
		$mail->Host       = get_smtp('smtp_host');
		$mail->SMTPAuth   = true;
		$mail->Username   = get_smtp('smtp_username');
		$mail->Password   = get_smtp('smtp_password');
		$mail->SMTPSecure = get_smtp('smtp_secure');
		$mail->Port       = get_smtp('smtp_port');

		$mail->setFrom(get_smtp('smtp_username'), get_smtp('smtp_set_from'));
		$mail->addReplyTo(get_settings('system_email'), get_settings('system_name'));

		// Add a recipient
		$mail->addAddress($to);

		// Email subject
		$mail->Subject = $subject;

		// Set email format to HTML
		$mail->isHTML(true);

		// Enabled debug
		$mail->SMTPDebug = false;

		// Email body content
		$mailContent = $message;
		$mail->Body = $mailContent;

		// Send email
		if(!$mail->send()){
			// echo 'Message could not be sent.';
			// echo 'Mailer Error: ' . $mail->ErrorInfo;
			return false;
		}else{
			//echo 'Message has been sent';
			return true;
		}
	}*/
    //..................................END CONTACT MESSAGE section..................................................//
}