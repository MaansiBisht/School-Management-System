<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Student extends CI_Controller {
    public function __construct(){
        parent::__construct();

        $this->load->database();
        $this->load->library('session');


        /* LOADING ALL THE MODELS HERE */
        //$this->load->model('Crud_model',     'crud_model');
		$this->load->model('User_model',     'user_model');
		$this->load->model('Settings_model', 'settings_model');
		$this->load->model('Crud_model', 'crud_model');

		if($this->session->userdata('student_login') != 1){
			redirect(site_url('login'), 'refresh');
		}
    }
    //INDEX 
    public function index(){
        redirect(site_url('student/dashboard'), 'refresh');
    }

    //DASHBOARD
	public function dashboard(){
		$page_data['page_title'] = 'Dashboard';
		$page_data['folder_name'] = 'dashboard';
        $page_data['utype'] = 'dashboard';
		$this->load->view('backend/index', $page_data);
	}

   
	//..................................START TEACHER section........................................................//
	public function teacher($param1 = '', $param2 = '', $param3 = ''){
		$page_data['folder_name'] = 'teacher';
		$page_data['page_title'] = 'techers';
		$this->load->view('backend/index', $page_data);
	}
	//....................................END TEACHER section.........................................................//



	//.................................START DAILY ATTENDANCE section..................................................//
	public function attendance($param1 = '', $param2 = '', $param3 = ''){
		if($param1 == 'filter'){
			$date = '01 '.$this->input->post('month').' '.$this->input->post('year');
			$page_data['attendance_date'] = strtotime($date);
			$page_data['class_id'] = $this->input->post('class_id');
			$page_data['section_id'] = $this->input->post('section_id');
			$page_data['month'] = $this->input->post('month');
			$page_data['year'] = $this->input->post('year');
			$this->load->view('backend/student/attendance/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'attendance';
			$page_data['page_title'] = 'attendance';
			$this->load->view('backend/index', $page_data);
		}
	}
	//........................................END DAILY ATTENDANCE section.......................................//


//..............................................START CLASS section.............................................//
public function manage_class($param1 = '', $param2 = '', $param3 = ''){
	if($param1 == 'section'){
		$response = $this->crud_model->section_update($param2);
		echo $response;
	}

	// show data from database
	if ($param1 == 'list') {
		$this->load->view('backend/student/class/list');
	}

	if(empty($param1)){
		$page_data['folder_name'] = 'class';
		$page_data['page_title'] = 'class';
		$this->load->view('backend/index', $page_data);
	}
}
//............................................END CLASS section.................................................//
//............................................SECTION STARTED...................................................//
public function section($action = "", $id = "") {

	// PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
	if ($action == 'list') {
		$page_data['class_id'] = $id;
		$this->load->view('backend/student/section/list', $page_data);
	}
}
//.............................................SECTION ENDED....................................................//

//..............................................START SUBJECT section..........................................//
public function subject($param1 = '', $param2 = ''){

	if($param1 == 'list'){
		$page_data['class_id'] = $param2;
		$this->load->view('backend/student/subject/list', $page_data);
	}

	if(empty($param1)){
		$page_data['folder_name'] = 'subject';
		$page_data['page_title'] = 'subject';
		$this->load->view('backend/index', $page_data);
	}
}

public function class_wise_subject($class_id) {

	// PROVIDE A LIST OF SUBJECT ACCORDING TO CLASS ID
	$page_data['class_id'] = $class_id;
	$this->load->view('backend/student/subject/dropdown', $page_data);
}
//...............................END SUBJECT section.............................................//


//...............................START SYLLABUS section..........................................//
public function syllabus($param1 = '', $param2 = '', $param3 = ''){

	if($param1 == 'list'){
		$page_data['class_id'] = $param2;
		$page_data['section_id'] = $param3;
		$this->load->view('backend/student/syllabus/list', $page_data);
	}

	if(empty($param1)){
		$page_data['folder_name'] = 'syllabus';
		$page_data['page_title'] = 'syllabus';
		$this->load->view('backend/index', $page_data);
	}
}
//..............................END SYLLABUS section.............................................//

//.............................START CLASS ROUTINE section........................................//
public function routine($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

	if($param1 == 'filter'){
		$page_data['class_id'] = $param2;
		$page_data['section_id'] = $param3;
		$this->load->view('backend/student/routine/list', $page_data);
	}

	if(empty($param1)){
		$page_data['folder_name'] = 'routine';
		$page_data['page_title'] = 'routine';
		$this->load->view('backend/index', $page_data);
	}
}
//.............................END CLASS ROUTINE section........................................//

	//...........................BOOK LIST MANAGER.............................................//
	public function book($param1 = "", $param2 = "") {
		$page_data['folder_name'] = 'book';
		$page_data['page_title']  = 'books';
		$this->load->view('backend/index', $page_data);
	}

	//...........................BOOK ISSUED BY THE STUDENT.....................................//
	public function book_issue($param1 = "", $param2 = "") {
		// showing the index file
		$page_data['folder_name'] = 'book_issue';
		$page_data['page_title']  = 'issued_book';
		$this->load->view('backend/index', $page_data);
	}

	//...........................MANAGE PROFILE STARTS........................................//
	public function profile($param1 = "", $param2 = "") {
		if ($param1 == 'update_profile') {
			$response = $this->user_model->update_profile();
			echo $response;
		}
		if ($param1 == 'update_password') {
			$response = $this->user_model->update_password();
			echo $response;
		}
		if(empty($param1)){
			$page_data['folder_name'] = 'profile';
			$page_data['page_title']  = 'manage_profile';
			$this->load->view('backend/index', $page_data);
		}

}
}

