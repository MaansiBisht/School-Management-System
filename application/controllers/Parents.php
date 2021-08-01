<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Parents extends CI_Controller {
    public function __construct(){
        parent::__construct();

        $this->load->database();
        $this->load->library('session');


        /* LOADING ALL THE MODELS HERE */
        //$this->load->model('Crud_model',     'crud_model');
		$this->load->model('User_model',     'user_model');
		$this->load->model('Settings_model', 'settings_model');
        $this->load->model('Crud_model', 'crud_model');

		//lOGIN CHECK
		if($this->session->userdata('parent_login') != 1){
			redirect(site_url('login'), 'refresh');
		}
    }
    //INDEX 
    public function index(){
        redirect(site_url('parents/dashboard'), 'refresh');
    }

    //DASHBOARD
	public function dashboard(){
		$page_data['page_title'] = 'Dashboard';
		$page_data['folder_name'] = 'dashboard';
        $page_data['utype'] = 'parent';
		$this->load->view('backend/index', $page_data);
	}
    public function class_wise_subject($class_id) {

		// PROVIDE A LIST OF SUBJECT ACCORDING TO CLASS ID
		$page_data['class_id'] = $class_id;
		$this->load->view('backend/parent/subject/dropdown', $page_data);
	}
	//END SUBJECT section


	//START SYLLABUS section
	public function syllabus($param1 = '', $param2 = '', $param3 = ''){

		if($param1 == 'list'){
			$page_data['class_id'] = $param2;
			$page_data['section_id'] = $param3;
			$this->load->view('backend/parent/syllabus/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'syllabus';
			$page_data['page_title'] = 'syllabus';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END SYLLABUS section


	//START TEACHER section
	public function teacher($param1 = '', $param2 = '', $param3 = ''){
		$page_data['folder_name'] = 'teacher';
		$page_data['page_title'] = 'techers';
		$this->load->view('backend/index', $page_data);
	}
	//END TEACHER section

	//START CLASS ROUTINE section
	public function routine($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

		if($param1 == 'filter'){
			$page_data['class_id'] = $param2;
			$page_data['section_id'] = $param3;
			$this->load->view('backend/parent/routine/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'routine';
			$page_data['page_title'] = 'routine';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END CLASS ROUTINE section


	//START DAILY ATTENDANCE section
	public function attendance($param1 = '', $param2 = '', $param3 = ''){

		if($param1 == 'filter'){
			$date = '01 '.$this->input->post('month').' '.$this->input->post('year');
			$page_data['attendance_date'] = strtotime($date);
			$page_data['class_id'] = $this->input->post('class_id');
			$page_data['section_id'] = $this->input->post('section_id');
			$page_data['month'] = $this->input->post('month');
			$page_data['year'] = $this->input->post('year');
			$page_data['student_id'] = $this->input->post('student_id');
			$this->load->view('backend/parent/attendance/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'attendance';
			$page_data['page_title'] = 'attendance';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END DAILY ATTENDANCE section


	

	// This function is needed for Ajax calls only
	public function get_student_details_by_id($look_up_value = "", $student_id = "") {
		$student_details = $this->user_model->get_student_details_by_id('student', $student_id);
		echo $student_details[$look_up_value];
	}
	//END STUDENT ADN ADMISSION section



	// BACKOFFICE SECTION

	//...................................BOOK LIST MANAGER.........................................................//
	public function book($param1 = "", $param2 = "") {
		// showing the list of book
		if ($param1 == 'list') {
			$this->load->view('backend/parent/book/list');
		}

		// showing the index file
		if(empty($param1)){
			$page_data['folder_name'] = 'book';
			$page_data['page_title']  = 'books';
			$this->load->view('backend/index', $page_data);
		}
	}
    //..................................END BOOK LIST MANAGER......................................................//

	//................................MANAGE PROFILE STARTS........................................................//
	public function profile($param1 = "", $param2 = "") {
		if ($param1 == 'update_profile') {
			$response = $this->user_model->update_profile();
			echo $response;
		}
		if ($param1 == 'update_password') {
			$response = $this->user_model->update_password();
			echo $response;
		}

		// showing the Smtp Settings file
		if(empty($param1)){
			$page_data['folder_name'] = 'profile';
			$page_data['page_title']  = 'manage_profile';
			$this->load->view('backend/index', $page_data);
		}
	}
   //...............................END MANAGE PROFILE.............................................................//

}