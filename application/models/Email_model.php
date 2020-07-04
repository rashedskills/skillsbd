<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function password_reset_email($new_password = '' , $email = '')
	{
		$query = $this->db->get_where('users' , array('email' => $email));
		if($query->num_rows() > 0)
		{

			$email_msg	=	"Your password has been changed.";
			$email_msg	.=	"Your new password is : ".$new_password."<br />";

			$email_sub	=	"Password reset request";
			$email_to	=	$email;
			//$this->do_email($email_msg , $email_sub , $email_to);
			$this->send_smtp_mail($email_msg , $email_sub , $email_to);
			return true;
		}
		else
		{
			return false;
		}
	}

	public function send_email_verification_mail($to = "", $verification_code = "") {
		$redirect_url = site_url('login/verify_email_address/'.$verification_code);
		$websiteUrl = 'http://skillsbd.com';
		//$mesg = $this->load->view('template/email','',true);
		$subject 	 =  "Verify Email Address";
		$email_msg	 =	"<h3 style='margin-top: 30px; font-size: 1.2rem;'>Welcome to Skillsbd!</h3>";
		$email_msg	.=	"<p style='padding-bottom: 18px;'>Thanks so much for joining Skillsbd! To Finish signing up, you just need to confirm that we got your email right.</p>";
		$email_msg	.=	"<a style='background-color: #ffd723; padding: 12px 30px; color: #36373c; font-size: 15px; margin-top: 20px; font-weight: 600; text-decoration: none' href = ".$redirect_url." target = '_blank'>Confirm Your Email</a>";		
		$email_msg	.=	"<p style='margin-top: 30px; font-weight: bold;'>Or verify using this link:</p>";
		$email_msg	.=	"<a style='text-align: left;' href = ".$redirect_url." target = '_blank'>".$redirect_url."</a>";
		$email_msg 	.= 	"<hr>";
		$email_msg 	.= 	"<p style=''>Sent by <a href=".$websiteUrl.">skillsbd</a> 5th floor, 59 House, 04 Road, C Block, Banani, Dhaka-1213, Bangladesh.</p>";
		$this->send_smtp_mail($email_msg, $subject, $to);
	}

	public function send_purchase_notification_mail(){
		$websiteUrl 	= 'http://skillsbd.com';
		$userid 		= $this->session->userdata('user_id');
		$user_details 	= $this->user_model->get_all_user($userid)->row_array();
		$purchased_courses 	= $this->session->userdata('cart_items');	
		$email_send_from = "info@myskill.rashedjoni.website";	
		$purchase_subject 	 =  "Course Purchase Confirmation";
		$purchase_msg 	=	"<h3 style='margin-top: 20px; font-size: 1rem;'>Hi, ".$user_details['first_name']." ".$user_details['last_name']."</h3>";
		$purchase_msg	.=	"<p style='margin-top: 20px;'>Thanks for buying with us. Below is a summary of your recent purchase.</p>";
		$purchase_msg	.=	"<strong style='padding-bottom: 10px;'>Purchase Details:</strong>";
		$purchase_msg	.=	"<strong style='padding-bottom: 7px;'>Course Name:</strong>";
		foreach ($purchased_courses as $purchased_course) {
		$course_details  = $this->crud_model->get_course_by_id($purchased_course)->row_array();
		$purchase_msg	.= "<strong>".$course_details['title']."</strong>";
		$purchase_msg 	.= 	"<hr>";
		}
		$purchase_msg 	.= 	"<p style=''>Sent by <a href=".$websiteUrl.">skillsbd</a> 5th floor, 59 House, 04 Road, C Block, Banani, Dhaka-1213, Bangladesh.</p>";
		$this->send_smtp_mail($purchase_msg, $purchase_subject, $user_details['email'], $email_send_from);
	}

	public function send_mail_on_course_status_changing($course_id = "", $mail_subject = "", $mail_body = "") {
		$websiteUrl = 'https://skillsbd.com';
		$instructor_id		 = 0;
		$course_details    = $this->crud_model->get_course_by_id($course_id)->row_array();
		if ($course_details['user_id'] != "") {
			$instructor_id = $course_details['user_id'];
		}else {
			$instructor_id = $this->session->userdata('user_id');
		}
		$instuctor_details = $this->user_model->get_all_user($instructor_id)->row_array();
		$email_from = get_settings('system_email');		
		$mail_body .= "<hr>";
		$mail_body .= "<b>For others queries call us:</b> 01752 992444";
		$mail_body .= "<p style=''>Sent by <a href=".$websiteUrl.">skillsbd</a> 5th floor, 59 House, 04 Road, C Block, Banani, Dhaka-1213, Bangladesh.</p>";
		$this->send_smtp_mail($mail_body, $mail_subject, $instuctor_details['email'], $email_from);
	}

	public function send_smtp_mail($msg=NULL, $sub=NULL, $to=NULL, $from=NULL) {
		//Load email library
		$this->load->library('email');

		if($from == NULL)
			$from		=	$this->db->get_where('settings' , array('key' => 'system_email'))->row()->value;

		//SMTP & mail configuration
		$config = array(
			'protocol'  => get_settings('protocol'),
			'smtp_host' => get_settings('smtp_host'),
			'smtp_port' => get_settings('smtp_port'),
			'smtp_user' => get_settings('smtp_user'),
			'smtp_pass' => get_settings('smtp_pass'),
			'newline' => "\r\n",
			'smtp_crypto' => 'tls',
			'mailtype'  => 'html',
			'charset'   => 'utf-8'
		);
		$this->email->initialize($config);
		$this->email->set_mailtype("html");

		$htmlContent = $msg;

		$this->email->to($to);
		$this->email->from($from, get_settings('system_name'));
		$this->email->subject($sub);
		$this->email->message($htmlContent);

		//Send email
		$this->email->send();
	}
}
