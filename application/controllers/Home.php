<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

class Home extends CI_Controller {
	protected $theme;
	protected $active_school_id;

	public function __construct(){
		parent::__construct();

		$this->load->database();
		$this->load->library('session');

		/*LOADING ALL THE MODELS HERE*/
		$this->load->model('Crud_model',     'crud_model');
		$this->load->model('User_model',     'user_model');
		$this->load->model('Settings_model', 'settings_model');
		$this->load->model('Frontend_model', 'frontend_model');
		$this->load->model('Email_model', 'email_model');

		/*cache control*/
		$this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");

		/*SET DEFAULT TIMEZONE*/
		timezone();

		$this->theme = get_frontend_settings('theme');
		$this->active_school_id = $this->frontend_model->get_active_school_id();
        }
        public function index() {
            $page_data['page_name']  = 'home';
            $page_data['page_title'] = get_phrase('home');
            $this->load->view('frontend/'.$this->theme.'/index', $page_data);
        }
		//ABOUT PAGE
	function about() {
		$page_data['page_name']  = 'about';
		$page_data['page_title'] = get_phrase('about_us');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	// TEACHERS PAGE
	function teachers() {
	/*	$count_teachers = $this->db->get_where('users', array('role' => 'teacher', 'school_id' => $this->active_school_id))->num_rows();
		$config = array();
		$config = manager($count_teachers, 2);
		$config['base_url']  = site_url('home/teachers/');
		$this->pagination->initialize($config);
		$page_data['links'] = $this->pagination->create_links();
		$page_data['results'] =  $this->Users->get_current_page_records($total_rows, $per_page_item); */
		

		//$page_data['per_page']    = $config['per_page'];
		$page_data['page_name']  = 'teacher';
		$page_data['page_title'] = get_phrase('teachers');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}
	
	//GET THE CONTACT PAGE
	function contact($param1 = '') {

		if ($param1 == 'send') {
			/*if(!$this->crud_model->check_recaptcha() && get_common_settings('recaptcha_status') == true){
				redirect(site_url('home/contact'), 'refresh');
			} */
			$this->frontend_model->send_contact_message();
			redirect(site_url('home/contact'), 'refresh');
		}
		$page_data['page_name']  = 'contact';
		$page_data['page_title'] = get_phrase('contact_us');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	//GET THE PRIVACY POLICY PAGE
	function privacy_policy() {
		$page_data['page_name']  = 'privacy_policy';
		$page_data['page_title'] = get_phrase('privacy_policy');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	//GET THE TERMS AND CONDITION PAGE
	function terms_conditions() {
		$page_data['page_name']  = 'terms_conditions';
		$page_data['page_title'] = get_phrase('terms_and_conditions');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}
	// NOTICEBOARD
	function noticeboard() {
		/*$count_notice = $this->db->get_where('noticeboard', array('show_on_website' => 1, 'school_id' => $this->active_school_id, 'session' => active_session()))->num_rows();
		$config = array();
		$config = manager($count_notice, 2);
		$config['base_url']  = site_url('home/noticeboard/');
		$this->pagination->initialize($config); */
		

		//$page_data['per_page']    = $config['per_page'];
		$page_data['page_name']  = 'noticeboard';
		$page_data['page_title'] = get_phrase('noticeboard');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	function notice_details($notice_id = '') {
		$page_data['notice_id'] = $notice_id;
		$page_data['page_name']  = 'notice_details';
		$page_data['page_title'] = get_phrase('notice_details');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}
    }