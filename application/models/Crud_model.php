<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/
class Crud_model extends CI_Model {

	protected $school_id;
	protected $active_session;

	public function __construct()
	{
		parent::__construct();
		$this->school_id = school_id();
		$this->active_session = active_session();
	}
	//..................SCHOOL DETAILS
	public function get_schools() {
		if (!addon_status('multi-school')) {
			$this->db->where('id', school_id());
		}
		$schools = $this->db->get('schools');
		return $schools;
	}
	
	public function get_school_details_by_id($school_id = "") {
		return $this->db->get_where('schools', array('id' => $school_id))->row_array();
	}

	//.....................  START CLASS .......................................//
	public function get_classes($id = "") {

		$this->db->where('school_id', $this->school_id);

		if ($id > 0) {
			$this->db->where('id', $id);

		}
		return $this->db->get('classes');


	}
	public function class_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['school_id'] = $this->school_id;
		$this->db->insert('classes', $data);

		$insert_id = $this->db->insert_id();
		$section_data['name'] = 'A';
		$section_data['class_id'] = $insert_id;
		$this->db->insert('sections', $section_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('class_added_successfully')
		);
		return json_encode($response);
	}

	public function class_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$this->db->where('id', $param1);
		$this->db->update('classes', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('class_added_successfully')
		);
		return json_encode($response);
	}

	public function section_update($param1 = '')
	{
		$section_id = html_escape($this->input->post('section_id'));
		$section_name = html_escape($this->input->post('name'));
		foreach($section_id as $key => $value){
			if($value == 0){
				$data['class_id'] = $param1;
				$data['name'] = $section_name[$key];
				$this->db->insert('sections', $data);
			}
			if($value != 0 && $value != 'delete'){
				$data['name'] = $section_name[$key];
				$this->db->where('class_id', $param1);
				$this->db->where('id', $value);
				$this->db->update('sections', $data);
			}

			$section_value = null;
			if (strpos($value, 'delete') == true) {
				$section_value = str_replace('delete', '', $value);
			}
			if($value == $section_value.'delete'){
				$data['name'] = $section_name[$key];
				$this->db->where('class_id', $param1);
				$this->db->where('id', $section_value);
				$this->db->delete('sections');
			}
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('section_list_updated_successfully')
		);
		return json_encode($response);
	}

	
	public function class_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('classes');

		$this->db->where('class_id', $param1);
		$this->db->delete('sections');

		$response = array(
			'status' => true,
			'notification' => get_phrase('class_deleted_successfully')
		);
		
		return json_encode($response);
	}


	//.........................END CLASS.........................................//


	//.......................... START SECTION....................................//
	
	
	public function section_create($class_id = ''){
		$data['name'] = html_escape($this->input->post('name'));
		$data['class_id'] = $class_id;
		$this->db->insert('sections', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('sections_added_successfully')
		);
		
		return json_encode($response);
	}

	//section delete
	public function section_delete($param1 = '')
	{

		$this->db->where('id', $param1);
		$this->db->delete('sections');

		$response = array(
			'status' => true,
			'notification' => get_phrase('section_deleted_successfully')
		);
	
		return json_encode($response);
	}

 //..............................END SECTION ............................//
 
	public function get_section_details_by_id($type = "", $id = "") {
		$section_details = array();
		if ($type == 'class') {
			$section_details = $this->db->get_where('sections', array('class_id' => $id));
		}elseif ($type == 'section') {
			$section_details = $this->db->get_where('sections', array('id' => $id));
		}
		return $section_details;
	}

	//get Class details by id
	public function get_class_details_by_id($id) {
		$class_details = $this->db->get_where('classes', array('id' => $id));
		return $class_details;
	}
	//...........................END SECTION.....................................//



	
	//..............................START CLASS_ROOM section......................//
	public function class_room_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$this->db->insert('class_rooms', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('classroom_added_successfully')
		);
	
		return json_encode($response);
	}

	public function class_room_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$this->db->where('id', $param1);
		$this->db->update('class_rooms', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('classroom_updated_successfully')
		);

		return json_encode($response);
	}

	public function class_room_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('class_rooms');

		$response = array(
			'status' => true,
			'notification' => get_phrase('classroom_deleted_successfully')
		);
		return json_encode($response);
	}
	//.............................END CLASS_ROOM section...............................//


	//..............................START SUBJECT section.................................//
	public function subject_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['session'] = html_escape($this->input->post('session'));
		$this->db->insert('subjects', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('subject_has_been_added_successfully')
		);

		return json_encode($response);
	}
	public function subject_update($param1 = '')
	{
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['name'] = html_escape($this->input->post('name'));
		$this->db->where('id', $param1);
		$this->db->update('subjects', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('subject_has_been_updated_successfully')
		);
	
		return json_encode($response);
	}

	public function subject_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('subjects');

		$response = array(
			'status' => true,
			'notification' => get_phrase('subject_has_been_deleted_successfully')
		);
		return json_encode($response);
	}

	public function get_subject_by_id($subject_id = '') {
		return $this->db->get_where('subjects', array('id' => $subject_id))->row_array();
	}

   //................................END SUBJECT section................................//


   //................................START DEPARTMENT section ..........................//

   public function department_create()
   {
	   $data['name'] = html_escape($this->input->post('name'));
	   $data['school_id'] = html_escape($this->input->post('school_id'));
	   $this->db->insert('departments', $data);

	   $response = array(
		   'status' => true,
		   'notification' => get_phrase('department_has_been_added_successfully')
	   );
	
	   return json_encode($response);
   }

   public function department_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$this->db->where('id', $param1);
		$this->db->update('departments', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('department_has_been_updated_successfully')
		);
		
		return json_encode($response);
	}

	public function department_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('departments');

		$response = array(
			'status' => true,
			'notification' => get_phrase('department_has_been_deleted_successfully')
		);

	
		return json_encode($response);
	}


   //.................................END DEPARTMENT section............................//

   //.................................START SYLLABUS section............................//
  public function syllabus_create($param1 = '')
	{
		$data['title'] = html_escape($this->input->post('title'));
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$data['subject_id'] = html_escape($this->input->post('subject_id'));
		$data['session_id'] = html_escape($this->input->post('session_id'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$file_ext = pathinfo($_FILES['syllabus_file']['name'], PATHINFO_EXTENSION);
		$data['file'] = md5(rand(10000000, 20000000)).'.'.$file_ext;
		move_uploaded_file($_FILES['syllabus_file']['tmp_name'], 'uploads/syllabus/'.$data['file']);
		$this->db->insert('syllabuses', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('syllabus_added_successfully')
		);
		
		return json_encode($response);
	}
	public function syllabus_delete($param1){
		$syllabus_details = $this->get_syllabus_by_id($param1);
		$this->db->where('id', $param1);
		$this->db->delete('syllabuses');
		$path = 'uploads/syllabus/'.$syllabus_details['file'];
		if (file_exists($path)){
				unlink($path);
		}
		$response = array(
			'status' => true,
			'notification' => get_phrase('syllabus_deleted_successfully')
		);
		return json_encode($response);
	}

	public function get_syllabus_by_id($syllabus_id = "") {
		return $this->db->get_where('syllabuses', array('id' => $syllabus_id))->row_array(); 
	} 

   //.................................END SYLLABUS section.............................//
   //.................................START ROUTINE section ...........................//
   public function routine_create()
	{
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$data['subject_id'] = html_escape($this->input->post('subject_id'));
		$data['teacher_id'] = html_escape($this->input->post('teacher_id'));
		$data['room_id'] = html_escape($this->input->post('class_room_id'));
		$data['day'] = html_escape($this->input->post('day'));
		$data['starting_hour'] = html_escape($this->input->post('starting_hour'));
		$data['starting_minute'] = html_escape($this->input->post('starting_minute'));
		$data['ending_hour'] = html_escape($this->input->post('ending_hour'));
		$data['ending_minute'] = html_escape($this->input->post('ending_minute'));
		$data['school_id'] = $this->school_id;
		$data['session_id'] = $this->active_session;
		
		
		$duplication_status = $this->check_routine_duplication('on_create', $data['starting_hour'] , $data['day']);
		if($duplication_status){
		    $this->db->insert('routines', $data);
				$response = array(
			'status' => true,
			'notification' => get_phrase('class_routine_added_successfully')
		);
	}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('Time slot is not available for the day')
			);

		}
		
		return json_encode($response);
	
	}
	public function routine_update($param1 = '')
	{
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$data['subject_id'] = html_escape($this->input->post('subject_id'));
		$data['teacher_id'] = html_escape($this->input->post('teacher_id'));
		$data['room_id'] = html_escape($this->input->post('class_room_id'));
		$data['day'] = html_escape($this->input->post('day'));
		$data['starting_hour'] = html_escape($this->input->post('starting_hour'));
		$data['starting_minute'] = html_escape($this->input->post('starting_minute'));
		$data['ending_hour'] = html_escape($this->input->post('ending_hour'));
		$data['ending_minute'] = html_escape($this->input->post('ending_minute'));
		
		
		$duplication_status = $this->check_routine_duplication('on_update', $data['starting_hour'] , $data['day'], $param1);
		if($duplication_status){
			$this->db->where('id', $param1);
		    $this->db->update('routines', $data);
			$response = array(
			'status' => true,
			'notification' => get_phrase('class_routine_updated_successfully')
		);
	}else{
			$response = array(
				'status' => false,
				'notification' => get_phrase('Time slot is not available for the day')
			);

		}
		

		return json_encode($response);
	}

	public function routine_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('routines');

		$response = array(
			'status' => true,
			'notification' => get_phrase('class_routine_deleted_successfully')
		);

		
		return json_encode($response);
	}
	
	//....Routine duplication check
    public function check_routine_duplication($action = "", $starting_hour = "", $day = "" ,$routine_id=""){
			$duplication_check = $this->db->get_where('routines', array('starting_hour' => $starting_hour,'day'=>$day));
	
			if ($action == 'on_create') {
				if ($duplication_check->num_rows() > 0) {
					return false;
				}else {
					return true;
				}
			}elseif ($action == 'on_update') {
				if ($duplication_check->num_rows() > 0) {
					if ($duplication_check->row()->id == $routine_id) {
						return true;
					}else {
						return false;
					}
				}else {
					return true;
				}
			}
		}

		//..........................................END ROUTINE section.......................................//

	//.......................................START DAILY ATTENDANCE section..................................//
	public function take_attendance()
	{
		$students = $this->input->post('student_id');
		$data['timestamp'] = strtotime($this->input->post('date'));
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$data['school_id'] = $this->school_id;
		$data['session_id'] = $this->active_session;
		$check_data = $this->db->get_where('daily_attendances', array('timestamp' => $data['timestamp'], 'class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'session_id' => $data['session_id'], 'school_id' => $data['school_id']));
		if($check_data->num_rows() > 0){
			foreach($students as $key => $student):
				$data['status'] = $this->input->post('status-'.$student);
				$data['student_id'] = $student;
				$attendance_id = $this->input->post('attendance_id');
				$this->db->where('id', $attendance_id[$key]);
				$this->db->update('daily_attendances', $data);
			endforeach;
		}else{
			foreach($students as $student):
				$data['status'] = $this->input->post('status-'.$student);
				$data['student_id'] = $student;
				$this->db->insert('daily_attendances', $data);
			endforeach;
		}

		$this->settings_model->last_updated_attendance_data();

		$response = array(
			'status' => true,
			'notification' => get_phrase('attendance_updated_successfully')
		);

		return json_encode($response);
	}

	public function get_todays_attendance() {
		$checker = array(
			'timestamp' => strtotime(date('Y-m-d')),
			'school_id' => $this->school_id,
			'status'    => 1
		);
		$todays_attendance = $this->db->get_where('daily_attendances', $checker);
		return $todays_attendance->num_rows();
	}
	//...................................END DAILY ATTENDANCE section..............................................//
  //....................................BOOK LIST section.........................................................//
	public function get_books() {
		$checker = array(
			'session' => $this->active_session,
			'school_id' => $this->school_id
		);
		return $this->db->get_where('books', $checker);
	}

	public function get_book_by_id($id = "") {
		return $this->db->get_where('books', array('id' => $id))->row_array();
	}

	public function create_book() {
		$data['name']      = $this->input->post('name');
		$data['author']    = $this->input->post('author');
		$data['copies']    = $this->input->post('copies');
		$data['school_id'] = $this->school_id;
		$data['session']   = $this->active_session;
		$this->db->insert('books', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('books_added_successfully')
		);
		return json_encode($response);
	}

	public function update_book($id = "") {
		$data['name']      = $this->input->post('name');
		$data['author']    = $this->input->post('author');
		$data['copies']    = $this->input->post('copies');
		$data['school_id'] = $this->school_id;
		$data['session']   = $this->active_session;

		$this->db->where('id', $id);
		$this->db->update('books', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('books_updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_book($id = "") {
		$this->db->where('id', $id);
		$this->db->delete('books');

		$response = array(
			'status' => true,
			'notification' => get_phrase('books_deleted_successfully')
		);
		return json_encode($response);
	}


//.............................................END BOOK LIST section....................................//
//.............................................START BOOK ISSUE section.................................//
public function get_book_issues($date_from = "", $date_to = "") {
	$this->db->where('session', $this->active_session);
	$this->db->where('school_id', $this->school_id);
	$this->db->where('issue_date >=', $date_from);
	$this->db->where('issue_date <=', $date_to);
	return $this->db->get('book_issues');
}
public function get_number_of_issued_book_by_id($id) {
	return $this->db->get_where('book_issues', array('book_id' => $id, 'status' => 0))->num_rows();
}
public function get_book_issues_by_student_id($student_id = "") {
	$this->db->where('student_id', $student_id);
	return $this->db->get('book_issues');
}

public function get_book_issue_by_id($id = "") {
	return $this->db->get_where('book_issues', array('id' => $id))->row_array();
}

public function create_book_issue() {
	$data['book_id']    = $this->input->post('book_id');
	$data['class_id']   = $this->input->post('class_id');
	$data['student_id'] = $this->input->post('student_id');
	$data['issue_date'] = strtotime($this->input->post('issue_date'));
	$data['school_id'] = $this->school_id;
	$data['session']   = $this->active_session;

	$this->db->insert('book_issues', $data);

	$response = array(
		'status' => true,
		'notification' => get_phrase('added_successfully')
	);
	return json_encode($response);
}

public function update_book_issue($id = "") {
	$data['book_id']    = $this->input->post('book_id');
	$data['class_id']   = $this->input->post('class_id');
	$data['student_id'] = $this->input->post('student_id');
	$data['issue_date'] = strtotime($this->input->post('issue_date'));
	$data['school_id'] = $this->school_id;
	$data['session']   = $this->active_session;

	$this->db->where('id', $id);
	$this->db->update('book_issues', $data);

	$response = array(
		'status' => true,
		'notification' => get_phrase('updated_successfully')
	);
	
	return json_encode($response);
}

public function return_issued_book($id = "") {
	$data['status']   = 1;

	$this->db->where('id', $id);
	$this->db->update('book_issues', $data);

	$response = array(
		'status' => true,
		'notification' => get_phrase('returned_successfully')
	);
	return json_encode($response);
}



public function delete_book_issue($id = "") {
	$this->db->where('id', $id);
	$this->db->delete('book_issues');

	$response = array(
		'status' => true,
		'notification' => get_phrase('deleted_successfully')
	);
	return json_encode($response);
}

//.............................................END BOOK ISSUE section...................................//

//.............................................START NOTICEBOARD section...............................//
public function create_notice() {
	$data['notice_title'] = html_escape($this->input->post('notice_title'));
	$data['notice']  = html_escape($this->input->post('notice'));
	$data['show_on_website']  = $this->input->post('show_on_website');
	$data['date'] = $this->input->post('date').' 00:00:1';
	$data['school_id'] = $this->school_id;
	$data['session'] = $this->active_session;
	if ($_FILES['notice_photo']['name'] != '') {
		$data['image']  = random(15).'.jpg';
		move_uploaded_file($_FILES['notice_photo']['tmp_name'], 'uploads/images/notice_images/'. $data['image']);
	}else{
		$data['image']='placeholder.png';
	}
	$this->db->insert('noticeboard', $data);

	$response = array(
		'status' => true,
		'notification' => get_phrase('notice_has_been_created')
	);
	return json_encode($response);
}
public function update_notice($notice_id) {
	$data['notice_title']     = html_escape($this->input->post('notice_title'));
	$data['notice']           = html_escape($this->input->post('notice'));
	$data['show_on_website']  = $this->input->post('show_on_website');
	$data['date'] 						= $this->input->post('date').' 00:00:1';
	if ($_FILES['notice_photo']['name'] != '') {
		$data['image']  = random(15).'.jpg';
		move_uploaded_file($_FILES['notice_photo']['tmp_name'], 'uploads/images/notice_images/'. $data['image']);
	}
	$this->db->where('id', $notice_id);
	$this->db->update('noticeboard', $data);

	$response = array(
		'status' => true,
		'notification' => get_phrase('notice_has_been_updated')
	);

	return json_encode($response);
}

public function delete_notice($notice_id) {
	$this->db->where('id', $notice_id);
	$this->db->delete('noticeboard');

	$response = array(
		'status' => true,
		'notification' => get_phrase('notice_has_been_deleted')
	);
    
	return json_encode($response);
}
public function get_all_the_notices() {
	$notices = $this->db->get_where('noticeboard', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
	return json_encode($notices);
}

public function get_noticeboard_image($image) {
	if (file_exists('uploads/images/notice_images/'.$image))
	return base_url().'uploads/images/notice_images/'.$image;
	else
	return base_url().'uploads/images/notice_images/placeholder.png';
}
//.............................................END NOTICEBOARD section.................................//



}