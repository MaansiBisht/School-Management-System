<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontend_model extends CI_Model {

  protected $school_id;
	protected $active_session;

	public function __construct()
	{
		parent::__construct();
		$this->school_id = school_id();
		$this->active_session = active_session();
	}

   //GET ACTIVE SCHOOL ID
   public function get_active_school_id() {
    if (addon_status('multi-school')) {
      if ($this->session->userdata('active_school_id') > 0) {
        return $this->session->userdata('active_school_id');
      }else{
        $active_school_id = get_settings('school_id');
        $this->session->set_userdata('active_school_id', $active_school_id);
        return $this->session->userdata('active_school_id');
      }
    }else{
      $active_school_id = get_settings('school_id');
      $this->session->set_userdata('active_school_id', $active_school_id);
      return $this->session->userdata('active_school_id');
    }
  }
  // GET HEADER LOGO
  public function get_header_logo() {
    return base_url('uploads/system/logo/header-logo.png');
  }
  
  //GET ABOUT IMAGE
  public function get_about_image() {
    return base_url('uploads/images/about_us/about-us.jpg');
  }

   // send message from contact form
   function send_contact_message() {
    $first_name = html_escape($this->input->post('first_name'));
    $last_name = html_escape($this->input->post('last_name'));
    $email = html_escape($this->input->post('email'));
    $phone = html_escape($this->input->post('phone'));
    $address = html_escape($this->input->post('address'));
    $comment = html_escape($this->input->post('comment'));

    $receiver_email = get_settings('system_email');

    $msg = '<p>'.nl2br($comment)."</p>";
    $msg .= '<p>'.$first_name." ".$last_name.'</p>';
    $msg .= "<p>Phone : ".$phone.'</p>';
    $msg .= "<p>Address : ". $address.'</p>';

    $this->email_model->contact_message_email($email, $receiver_email, $msg);
  }
}
