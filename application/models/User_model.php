<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

class User_model extends CI_Model {

	protected $school_id;
	protected $active_session;

	public function __construct()
	{
		parent::__construct();
		$this->school_id = school_id();
		$this->active_session = active_session();

	}

	
	//GET SUPERADMIN DETAILS

	public function get_superadmin($userid ='', $column_name = ''){
		$this->db->where('role', 'superadmin');
		return $this->db->get('users')->row_array();
	}

	public function get_user_details($user_id = '', $column_name = '') {
		if($column_name != ''){
			return $this->db->get_where('users', array('id' => $user_id))->row($column_name);
		}else{
			return $this->db->get_where('users', array('id' => $user_id))->row_array();
		}
	}
		function get_all_users($user_id = ""){
			if($user_id > 0){
				$this->db->where('id', $user_id);
			}
	
			$this->db->where('school_id', $this->school_id);
			return $this->db->get_where('users');
		}

		// Get User Image Starts
	public function get_user_image($user_id) {
		if (file_exists('uploads/users/'.$user_id.'.jpg'))
		return base_url().'uploads/users/'.$user_id.'.jpg';
		else
		return base_url().'uploads/users/placeholder.jpg';
	}
	// Get User Image Ends
	

//.............................ADMIN PANEL.............................//
//create admin
public function create_admin() {
	$data['school_id'] = html_escape($this->input->post('school_id'));
	$data['name'] = html_escape($this->input->post('name'));
	$data['email'] = html_escape($this->input->post('email'));
	$data['password'] = sha1($this->input->post('password'));
	$data['phone'] = html_escape($this->input->post('phone'));
	$data['gender'] = html_escape($this->input->post('gender'));
	$data['blood_group'] = html_escape($this->input->post('blood_group'));
	$data['address'] = html_escape($this->input->post('address'));
	$data['role'] = 'admin';
	$data['watch_history'] = '[]';

	// check email duplication
	$duplication_status = $this->check_duplication('on_create', $data['email']);
	if($duplication_status){
		$this->db->insert('users', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('admin_added_successfully')
		);
	}else{
		$response = array(
			'status' => false,
			'notification' => get_phrase('sorry_this_email_has_been_taken')
		);
	}
	return json_encode($response);
	
}

public function update_admin($param1 = '')      //update admin
{
	$data['name'] = html_escape($this->input->post('name'));
	$data['email'] = html_escape($this->input->post('email'));
	$data['phone'] = html_escape($this->input->post('phone'));
	$data['gender'] = html_escape($this->input->post('gender'));
	$data['blood_group'] = html_escape($this->input->post('blood_group'));
	$data['address'] = html_escape($this->input->post('address'));
	$data['school_id'] = html_escape($this->input->post('school_id'));
	// check email duplication
	$duplication_status = $this->check_duplication('on_update', $data['email'], $param1);
	if($duplication_status){
		$this->db->where('id', $param1);
		$this->db->update('users', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('admin_has_been_updated_successfully')
		);

	}else{
		$response = array(
			'status' => false,
			'notification' => get_phrase('sorry_this_email_has_been_taken')
		);
	}
	
	return json_encode($response);
}

public function delete_admin($param1 = '')   //delete admin
{
	$this->db->where('id', $param1);
	$this->db->delete('users');

	$response = array(
		'status' => true,
		'notification' => get_phrase('admin_has_been_deleted_successfully')
	);
	
	return json_encode($response);
}
//.............................END ADMIN PANEL........................//




// ..........................STUDENT PANEL ........................... //
//START STUDENT AND ADMISSION section
public function single_student_create(){
	$user_data['name'] = html_escape($this->input->post('name'));
	$user_data['email'] = html_escape($this->input->post('email'));
	$user_data['password'] = sha1(html_escape($this->input->post('password')));
	$user_data['birthday'] = strtotime(html_escape($this->input->post('birthday')));
	$user_data['gender'] = html_escape($this->input->post('gender'));
	$user_data['blood_group'] = html_escape($this->input->post('blood_group'));
	$user_data['address'] = html_escape($this->input->post('address'));
	$user_data['phone'] = html_escape($this->input->post('phone'));
	$user_data['role'] = 'student';
	$user_data['school_id'] = $this->school_id;
	$user_data['watch_history'] = '[]';
	
		// check email duplication
		$duplication_status = $this->check_duplication('on_create', $user_data['email']);
		if($duplication_status){
			$this->db->insert('users', $user_data);
			$user_id = $this->db->insert_id();

			$student_data['code'] = student_code();
			$student_data['user_id'] = $user_id;
			$student_data['parent_id'] = html_escape($this->input->post('parent_id'));
			$student_data['session'] = $this->active_session;
			$student_data['school_id'] = $this->school_id;
			$this->db->insert('students', $student_data);
			$student_id = $this->db->insert_id();

			$enroll_data['student_id'] = $student_id;
			$enroll_data['class_id'] = html_escape($this->input->post('class_id'));
			$enroll_data['section_id'] = html_escape($this->input->post('section_id'));
			$enroll_data['session'] = $this->active_session;
			$enroll_data['school_id'] = $this->school_id;
			$this->db->insert('enrols', $enroll_data);

			move_uploaded_file($_FILES['student_image']['tmp_name'], 'uploads/users/'.$user_id.'.jpg');

			$response = array(
				'status' => true,
				'notification' => get_phrase('student_added_successfully')
			);
		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}
		
		return json_encode($response);
	}





//STUDENT UPDATE

public function student_update($student_id = '', $user_id = ''){
	$student_data['parent_id'] = html_escape($this->input->post('parent_id'));

	$enroll_data['class_id'] = html_escape($this->input->post('class_id'));
	$enroll_data['section_id'] = html_escape($this->input->post('section_id'));

	$user_data['name'] = html_escape($this->input->post('name'));
	$user_data['email'] = html_escape($this->input->post('email'));
	$user_data['birthday'] = strtotime(html_escape($this->input->post('birthday')));
	$user_data['gender'] = html_escape($this->input->post('gender'));
	$user_data['blood_group'] = html_escape($this->input->post('blood_group'));
	$user_data['address'] = html_escape($this->input->post('address'));
	$user_data['phone'] = html_escape($this->input->post('phone'));
	
	// Check Duplication
	$duplication_status = $this->check_duplication('on_update', $user_data['email'], $user_id);
	if ($duplication_status) {
		$this->db->where('id', $student_id);
		$this->db->update('students', $student_data);

		$this->db->where('student_id', $student_id);
		$this->db->update('enrols', $enroll_data);

		$this->db->where('id', $user_id);
		$this->db->update('users', $user_data);

		if(!empty($_FILES['image_file'])){
		move_uploaded_file($_FILES['student_image']['tmp_name'], 'uploads/users/'.$user_id.'.jpg');}

		$response = array(
			'status' => true,
			'notification' => get_phrase('student_updated_successfully')
		);

	}else{
		$response = array(
			'status' => false,
			'notification' => get_phrase('sorry_this_email_has_been_taken')
		);
	}
	return json_encode($response);
}
// STUDENT DELETE
public function delete_student($student_id, $user_id) {
	$this->db->where('id', $student_id);
	$this->db->delete('students');

	$this->db->where('student_id', $student_id);
	$this->db->delete('enrols');

	$this->db->where('id', $user_id);
	$this->db->delete('users');

	$path = 'uploads/users/'.$user_id.'.jpg';
	if(file_exists($path)){
		unlink($path);
	}

	$response = array(
		'status' => true,
		'notification' => get_phrase('student_deleted_successfully')
	);
    
	return json_encode($response);
}
//............................END STUDENT section......................................................//

//GET LOGGED IN USERS CLASS ID AND SECTION ID (FOR STUDENT LOGGED IN VIEW)
public function get_logged_in_student_details() {
	$user_id = $this->session->userdata('user_id');
	$student_data = $this->db->get_where('students', array('user_id' => $user_id))->row_array();
	$student_details = $this->get_student_details_by_id('student', $student_data['id']);
	return $student_details;
}


//  ............START TEACHER SECTION ................. //   
// create teacher
public function create_teacher()
{
	$data['school_id'] = html_escape($this->input->post('school_id'));
	$data['name'] = html_escape($this->input->post('name'));
	$data['email'] = html_escape($this->input->post('email'));
	$data['password'] = sha1($this->input->post('password'));
	$data['phone'] = html_escape($this->input->post('phone'));
	$data['gender'] = html_escape($this->input->post('gender'));
	$data['blood_group'] = html_escape($this->input->post('blood_group'));
	$data['address'] = html_escape($this->input->post('address'));
	$data['role'] = 'teacher';
	$data['watch_history'] = '[]';

	// check email duplication
	$duplication_status = $this->check_duplication('on_create', $data['email']);
	if($duplication_status){
		$this->db->insert('users', $data);


		$teacher_id = $this->db->insert_id();
		$teacher_table_data['user_id'] = $teacher_id;
		$teacher_table_data['about'] = html_escape($this->input->post('about'));
		$social_links = array(
			'facebook' => $this->input->post('facebook_link'),
			'twitter' => $this->input->post('twitter_link'),
			'linkedin' => $this->input->post('linkedin_link')
		);
		$teacher_table_data['social_links'] = json_encode($social_links);
		$teacher_table_data['department_id'] = html_escape($this->input->post('department'));
		$teacher_table_data['designation'] = html_escape($this->input->post('designation'));
		$teacher_table_data['school_id'] = html_escape($this->input->post('school_id'));
		$teacher_table_data['show_on_website'] = $this->input->post('show_on_website');
		$this->db->insert('teachers', $teacher_table_data);

		if ($_FILES['image_file']['name'] != "") {
				move_uploaded_file($_FILES['image_file']['tmp_name'], 'uploads/users/'.$teacher_id.'.jpg');
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('teacher_added_successfully')
		);
	}else{
		$response = array(
			'status' => false,
			'notification' => get_phrase('sorry_this_email_has_been_taken')
		);
	}
	return json_encode($response);
}


// UPDATE TEACHER INFO
public function update_teacher($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));

		// check email duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $param1);
		if($duplication_status){
			$this->db->where('id', $param1);
			$this->db->where('school_id', $this->input->post('school_id'));
			$this->db->update('users', $data);

			$teacher_table_data['department_id'] = html_escape($this->input->post('department'));
			$teacher_table_data['designation'] = html_escape($this->input->post('designation'));
			$teacher_table_data['about'] = html_escape($this->input->post('about'));
			$social_links = array(
				'facebook' => $this->input->post('facebook_link'),
				'twitter' => $this->input->post('twitter_link'),
				'linkedin' => $this->input->post('linkedin_link')
			);
			$teacher_table_data['social_links'] = json_encode($social_links);
			$teacher_table_data['show_on_website'] = $this->input->post('show_on_website');
			$this->db->where('school_id', $this->input->post('school_id'));
			$this->db->where('user_id', $param1);
			$this->db->update('teachers', $teacher_table_data);

			if ($_FILES['image_file']['name'] != "") {
				move_uploaded_file($_FILES['image_file']['tmp_name'], 'uploads/users/'.$param1.'.jpg');
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('teacher_has_been_updated_successfully')
			);

		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function delete_teacher($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('users');

		$this->db->where('user_id', $param1);
		$this->db->delete('teachers');


		$response = array(
			'status' => true,
			'notification' => get_phrase('teacher_has_been_deleted_successfully')
		);
		return json_encode($response);
	}

	// GET ALL TEACHER INFO
	public function get_teachers() {
		$checker = array(
			'school_id' => $this->school_id,
			'role' => 'teacher'
		);
		return $this->db->get_where('users', $checker);
	}

// ..................................END TEACHER SECTION........................................//

//....................................START PARENT SECTION ......................................//
//START PARENT section
public function parent_create()
{
	$data['name'] = html_escape($this->input->post('name'));
	$data['email'] = html_escape($this->input->post('email'));
	$data['password'] = sha1($this->input->post('password'));
	$data['phone'] = html_escape($this->input->post('phone'));
	$data['gender'] = html_escape($this->input->post('gender'));
	$data['blood_group'] = html_escape($this->input->post('blood_group'));
	$data['address'] = html_escape($this->input->post('address'));
	$data['school_id'] = $this->school_id;
	$data['role'] = 'parent';
	$data['watch_history'] = '[]';

	// check email duplication
	$duplication_status = $this->check_duplication('on_create', $data['email']);
	if($duplication_status){

		$this->db->insert('users', $data);

		$parent_data['user_id'] = $this->db->insert_id();
		$parent_data['school_id'] = $this->school_id;
		$this->db->insert('parents', $parent_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('parent_added_successfully')
		);
	}else{
		$response = array(
			'status' => false,
			'notification' => get_phrase('sorry_this_email_has_been_taken')
		);
	}
		return json_encode($response);
}

public function parent_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));

		// check email duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $param1);
		if($duplication_status){

			$this->db->where('id', $param1);
			$this->db->update('users', $data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('parent_updated_successfully')
			);
		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}
		return json_encode($response);
	}


public function parent_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('users');

		$this->db->where('user_id', $param1);
		$this->db->delete('parents');

		$response = array(
			'status' => true,
			'notification' => get_phrase('parent_has_been_deleted_successfully')
		);
		return json_encode($response);
	}
		public function get_parents() {
			$checker = array(
				'school_id' => $this->school_id,
				'role' => 'parent'
			);
			return $this->db->get_where('users', $checker);
		}
	
		public function get_parent_by_id($parent_id = "") {
			$checker = array(
				'school_id' => $this->school_id,
				'id' => $parent_id
			);
			$result = $this->db->get_where('parents', $checker)->row_array();
			return $this->db->get_where('users', array('id' => $result['user_id']));
		}
	

//..........................END PARENT SECTION .....................................//

//STUDENT OF EACH SESSION
public function get_session_wise_student() {
	$checker = array(
		'session' => $this->active_session,
		'school_id' => $this->school_id
	);
	return $this->db->get_where('enrols', $checker);
}


// ................... CHECK USER DUPLICATION ..................... //
public function check_duplication($action = "", $email = "", $user_id = "") {
	$duplicate_email_check = $this->db->get_where('users', array('email' => $email));

	if ($action == 'on_create') {
		if ($duplicate_email_check->num_rows() > 0) {
			return false;
		}else {
			return true;
		}
	}elseif ($action == 'on_update') {
		if ($duplicate_email_check->num_rows() > 0) {
			if ($duplicate_email_check->row()->id == $user_id) {
				return true;
			}else {
				return false;
			}
		}else {
			return true;
		}
	}
}
// ........................................
public function get_student_details_by_id($type = "", $id = "") {
	$enrol_data = array();
	if ($type == "section") {
		$checker = array(
			'section_id' => $id,
			'session' => $this->active_session,
			'school_id' => $this->school_id
		);
		$enrol_data = $this->db->get_where('enrols', $checker)->result_array();
		foreach ($enrol_data as $key => $enrol) {
			$student_details = $this->db->get_where('students', array('id' => $enrol['student_id']))->row_array();
			$enrol_data[$key]['code'] = $student_details['code'];
			$enrol_data[$key]['user_id'] = $student_details['user_id'];
			$enrol_data[$key]['parent_id'] = $student_details['parent_id'];
			$user_details = $this->db->get_where('users', array('id' => $student_details['user_id']))->row_array();
			$enrol_data[$key]['name'] = $user_details['name'];
			$enrol_data[$key]['email'] = $user_details['email'];
			$enrol_data[$key]['role'] = $user_details['role'];
			$enrol_data[$key]['address'] = $user_details['address'];
			$enrol_data[$key]['phone'] = $user_details['phone'];
			$enrol_data[$key]['birthday'] = $user_details['birthday'];
			$enrol_data[$key]['gender'] = $user_details['gender'];
			$enrol_data[$key]['blood_group'] = $user_details['blood_group'];

			$class_details = $this->crud_model->get_class_details_by_id($enrol['class_id'])->row_array();
			$section_details = $this->crud_model->get_section_details_by_id('section', $enrol['section_id'])->row_array();

			$enrol_data[$key]['class_name'] = $class_details['name'];
			$enrol_data[$key]['section_name'] = $section_details['name'];
		}
	}
	elseif ($type == "class") {
		$checker = array(
			'class_id' => $id,
			'session' => $this->active_session,
			'school_id' => $this->school_id
		);
		$enrol_data = $this->db->get_where('enrols', $checker)->result_array();
		foreach ($enrol_data as $key => $enrol) {
			$student_details = $this->db->get_where('students', array('id' => $enrol['student_id']))->row_array();
			$enrol_data[$key]['code'] = $student_details['code'];
			$enrol_data[$key]['user_id'] = $student_details['user_id'];
			$enrol_data[$key]['parent_id'] = $student_details['parent_id'];
			$user_details = $this->db->get_where('users', array('id' => $student_details['user_id']))->row_array();
			$enrol_data[$key]['name'] = $user_details['name'];
			$enrol_data[$key]['email'] = $user_details['email'];
			$enrol_data[$key]['role'] = $user_details['role'];
			$enrol_data[$key]['address'] = $user_details['address'];
			$enrol_data[$key]['phone'] = $user_details['phone'];
			$enrol_data[$key]['birthday'] = $user_details['birthday'];
			$enrol_data[$key]['gender'] = $user_details['gender'];
			$enrol_data[$key]['blood_group'] = $user_details['blood_group'];

			$class_details = $this->crud_model->get_class_details_by_id($enrol['class_id'])->row_array();
			$section_details = $this->crud_model->get_section_details_by_id('section', $enrol['section_id'])->row_array();

			$enrol_data[$key]['class_name'] = $class_details['name'];
			$enrol_data[$key]['section_name'] = $section_details['name'];
		}
	}
	elseif ($type == "student") {
		$checker = array(
			'student_id' => $id,
			'session' => $this->active_session,
			'school_id' => $this->school_id
		);
		$enrol_data = $this->db->get_where('enrols', $checker)->row_array();
		$student_details = $this->db->get_where('students', array('id' => $enrol_data['student_id']))->row_array();
		$enrol_data['code'] = $student_details['code'];
		$enrol_data['user_id'] = $student_details['user_id'];
		$enrol_data['parent_id'] = $student_details['parent_id'];
		$user_details = $this->db->get_where('users', array('id' => $student_details['user_id']))->row_array();
		$enrol_data['name'] = $user_details['name'];
		$enrol_data['email'] = $user_details['email'];
		$enrol_data['role'] = $user_details['role'];
		$enrol_data['address'] = $user_details['address'];
		$enrol_data['phone'] = $user_details['phone'];
		$enrol_data['birthday'] = $user_details['birthday'];
		$enrol_data['gender'] = $user_details['gender'];
		$enrol_data['blood_group'] = $user_details['blood_group'];

		$class_details = $this->crud_model->get_class_details_by_id($enrol_data['class_id'])->row_array();
		$section_details = $this->crud_model->get_section_details_by_id('section', $enrol_data['section_id'])->row_array();

		$enrol_data['class_name'] = $class_details['name'];
		$enrol_data['section_name'] = $section_details['name'];
	}
	return $enrol_data;
}


	//...............................................GET LOGGED IN USER DATA...................................................//
	public function get_profile_data() {
		return $this->db->get_where('users', array('id' => $this->session->userdata('user_id')))->row_array();
	}

	public function update_profile() {
		$response = array();
		$user_id = $this->session->userdata('user_id');
		$data['name'] = $this->input->post('name');
		$data['email'] = $this->input->post('email');
		$data['phone'] = $this->input->post('phone');
		$data['address'] = $this->input->post('address');
		// Check Duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $user_id);
		if($duplication_status) {
			$this->db->where('id', $user_id);
			$this->db->update('users', $data);

			move_uploaded_file($_FILES['profile_image']['tmp_name'], 'uploads/users/'.$user_id.'.jpg');

			$response = array(
				'status' => true,
				'notification' => get_phrase('profile_updated_successfully')
			);
		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function update_password() {
		$user_id = $this->session->userdata('user_id');
		if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
			$user_details = $this->get_user_details($user_id);
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password');
			$confirm_password = $this->input->post('confirm_password');
			if ($user_details['password'] == sha1($current_password) && $new_password == $confirm_password) {
				$data['password'] = sha1($new_password);
				$this->db->where('id', $user_id);
				$this->db->update('users', $data);

				$response = array(
					'status' => true,
					'notification' => get_phrase('password_updated_successfully')
				);
			}else {

				$response = array(
					'status' => false,
					'notification' => get_phrase('mismatch_password')
				);
			}
		}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('password_can_not_be_empty')
			);
		}
		return json_encode($response);

}
//.....................................END PROFILE SETTING section...................................................//
// GET STUDENT LIST BY PARENT
public function get_student_list_of_logged_in_parent() {
	$parent_id = $this->session->userdata('user_id');
	$parent_data = $this->db->get_where('parents', array('user_id' => $parent_id))->row_array();
	$checker = array(
		'parent_id' => $parent_data['id'],
		'session' => $this->active_session,
		'school_id' => $this->school_id
	);
	$students = $this->db->get_where('students', $checker)->result_array();
	foreach ($students as $key => $student) {
		$checker = array(
			'student_id' => $student['id'],
			'session' => $this->active_session,
			'school_id' => $this->school_id
		);
		$enrol_data = $this->db->get_where('enrols', $checker)->row_array();

		$user_details = $this->db->get_where('users', array('id' => $student['user_id']))->row_array();
		$students[$key]['student_id'] = $student['id'];
		$students[$key]['name'] = $user_details['name'];
		$students[$key]['email'] = $user_details['email'];
		$students[$key]['role'] = $user_details['role'];
		$students[$key]['address'] = $user_details['address'];
		$students[$key]['phone'] = $user_details['phone'];
		$students[$key]['birthday'] = $user_details['birthday'];
		$students[$key]['gender'] = $user_details['gender'];
		$students[$key]['blood_group'] = $user_details['blood_group'];
		$students[$key]['class_id'] = $enrol_data['class_id'];
		$students[$key]['section_id'] = $enrol_data['section_id'];

		$class_details = $this->crud_model->get_class_details_by_id($enrol_data['class_id'])->row_array();
		$section_details = $this->crud_model->get_section_details_by_id('section', $enrol_data['section_id'])->row_array();

		$students[$key]['class_name'] = $class_details['name'];
		$students[$key]['section_name'] = $section_details['name'];
	}
	return $students;
}
/*
public function get_current_page_records($limit, $start) 
    {
        $this->db->limit($limit, $start);
        $query = $this->db->get_where('users', array('role' => 'teacher', 'school_id' => $this->active_school_id));
 
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) 
            {
                $data[] = $row;
            }
             
            return $data;
        }
 
        return false;
    }
     */

}

