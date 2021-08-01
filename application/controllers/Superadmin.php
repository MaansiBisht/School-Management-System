<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

class Superadmin extends CI_Controller {
  public function __construct(){

    parent::__construct();

    $this->load->database();
    $this->load->library('session');

    //LOADING MODEL
    $this->load->model('Settings_model', 'settings_model');
    $this->load->model('User_model', 'user_model');
    $this->load->model('Crud_model', 'crud_model');
  }
    //dashboard
  public function index(){
    redirect(route('dashboard'), 'refresh');
  }
  public function dashboard(){

    // $this->msg91_model->clickatell();
    $page_data['page_title'] = 'Dashboard';
    $page_data['folder_name'] = 'dashboard';
    $page_data['utype'] ='dashboard';
    $this->load->view('backend/index', $page_data);
  }

  //..................................START ADMIN SECTION ................................//
  public function admin($param1 = "", $param2 = "", $param3 = "") {
      if($param1 == 'create'){
        $response = $this->user_model->create_admin();
        echo $response;
      }
  
      if($param1 == 'update'){
        $response = $this->user_model->update_admin($param2);
        echo $response;
      }
  
      if($param1 == 'delete'){
        $response = $this->user_model->delete_admin($param2);
        echo $response;
      }
  
      if ($param1 == 'list') {
        $this->load->view('backend/superadmin/admin/list');
      }
  
      if(empty($param1)){
        $page_data['folder_name'] = 'admin';
        $page_data['page_title'] = 'admins';
        $this->load->view('backend/index', $page_data);
      }
   
  }

  //..................................END ADMIN SECTION....................................//
  

  //....................................... STUDENT SECTION .............................//
  public function student($param1 = '', $param2 = '', $param3 = ''){
    if($param1 == 'create'){
        $page_data['aria_expand'] = 'single';
        $page_data['working_page'] = 'create';
        $page_data['folder_name'] = 'student';
        $page_data['page_title'] = 'add_student';
        $this->load->view('backend/index', $page_data);
      
    }

    //create to database
    if($param1 == 'create_single_student'){
      $response = $this->user_model->single_student_create();
      echo $response;
    }

    // form view
    if($param1 == 'edit'){
      $page_data['student_id'] = $param2;
      $page_data['working_page'] = 'edit';
      $page_data['folder_name'] = 'student';
      $page_data['page_title'] = 'update_student_information';
      $this->load->view('backend/index', $page_data);
    }

    //updated to database
    if($param1 == 'updated'){
      $response = $this->user_model->student_update($param2, $param3);
      echo $response;
    }
    //updated to database
    if($param1 == 'id_card'){
      $page_data['student_id'] = $param2;
      $page_data['folder_name'] = 'student';
      $page_data['page_title'] = 'identity_card';
      $page_data['page_name'] = 'id_card';
      $this->load->view('backend/index', $page_data);
    }

    if($param1 == 'delete'){
      $response = $this->user_model->delete_student($param2, $param3);
      echo $response;
    }

    if($param1 == 'filter'){
      $page_data['class_id'] = $param2;
      $page_data['section_id'] = $param3;
      $this->load->view('backend/superadmin/student/list', $page_data);
    }

    if(empty($param1)){
      $page_data['working_page'] = 'filter';
      $page_data['folder_name'] = 'student';
      $page_data['page_title'] = 'student_list';
      $this->load->view('backend/index', $page_data);
    }
    
    
  }


  //....................... START TEACHER SECTION ...................................//
  public function teacher($param1 = '', $param2 = '', $param3 = ''){

    if($param1 == 'create'){
      $response = $this->user_model->create_teacher();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->user_model->update_teacher($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $teacher_id = $this->db->get_where('teachers', array('user_id' => $param2))->row('id');
      $response = $this->user_model->delete_teacher($param2, $teacher_id);
      echo $response;
    }

    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/teacher/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'teacher';
      $page_data['page_title'] = 'teachers';
      $this->load->view('backend/index', $page_data);
    }
  
  }
  //..........................................END TEACHER SECTION ..............................//


  
  //....................................START PARENT SECTION ....................................//
  public function parent($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->user_model->parent_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->user_model->parent_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->user_model->parent_delete($param2);
      echo $response;
    }

    // show data from database
    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/parent/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'parent';
      $page_data['page_title'] = 'parent';
      $this->load->view('backend/index', $page_data);
    }
  
  }
  //....................................................END PARENT SECTION..................................//



  //................................................START CLASS SECTION.....................................//
  public function manage_class($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

      if($param1 == 'create'){
        $response = $this->crud_model->class_create();
        echo $response;
      }
  
      if($param1 == 'delete'){
        $response = $this->crud_model->class_delete($param2);
        echo $response;
      }
  
      if($param1 == 'update'){
        $response = $this->crud_model->class_update($param2);
        echo $response;
      }
  
      if($param1 == 'section'){
        $response = $this->crud_model->section_update($param2);
        echo $response;
      }
  
      // show data from database
      if ($param1 == 'list') {
        $this->load->view('backend/superadmin/class/list');
      }
  
      if(empty($param1)){
        $page_data['folder_name'] = 'class';
        $page_data['page_title'] = 'class';
        $this->load->view('backend/index', $page_data);
      }
    
  }
  //.....................................END CLASS section...................................................//


 //..................................	SECTION STARTED......................................................//
public function section($action = "", $id = "") {

  // PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
  if ($action == 'list') {
    $page_data['class_id'] = $id;
    $this->load->view('backend/superadmin/section/list', $page_data);
  }
}
//..............................SECTION ENDED...............................................................//


//....................................START CLASS_ROOM section
public function class_room($param1 = '', $param2 = ''){

  if($param1 == 'create'){
    $response = $this->crud_model->class_room_create();
    echo $response;
  }

  if($param1 == 'update'){
    $response = $this->crud_model->class_room_update($param2);
    echo $response;
  }

  if($param1 == 'delete'){
    $response = $this->crud_model->class_room_delete($param2);
    echo $response;
  }

  // PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
  if ($param1 == 'list') {
    $this->load->view('backend/superadmin/class_room/list');
  }

  if($param1 == 'edit'){
    $page_data['class_room_id'] = $param2;
    $page_data['utype'] = 'class_room_update';
    $page_data['page_title'] = 'Update_class_room';
    $this->load->view('backend/index', $page_data);
  }

  
  if($param1 == 'form'){
    $page_data['school_id'] = $param2;
    $page_data['utype'] = 'class_room_create';
    $page_data['page_title'] = 'add_class_room';
    $this->load->view('backend/index', $page_data);
  }


  if(empty($param1)){
    $page_data['folder_name'] = 'class_room';
    $page_data['page_title'] = 'class_room';
    $page_data['utype'] = 'class_room';
    $this->load->view('backend/index', $page_data);
  }
}
//....................................END CLASS_ROOM section .....................................//

//....................................START SUBJECT section.......................................//

 //START SUBJECT section
 public function subject($param1 = '', $param2 = ''){

  if($param1 == 'create'){
    $response = $this->crud_model->subject_create();
    echo $response;
  }
  if($param1 == 'edit'){
    $page_data['subject_id'] = $param2;
    $page_data['utype'] = 'subject_update';
    $page_data['page_title'] = 'Update_class_room';
    $this->load->view('backend/index', $page_data);
  }

  
  if($param1 == 'form'){
    $page_data['school_id'] = $param2;
    $page_data['utype'] = 'subject_create';
    $page_data['page_title'] = 'add_subject';
    $this->load->view('backend/index', $page_data);
  }

  if($param1 == 'update'){
    $response = $this->crud_model->subject_update($param2);
    echo $response;
  }

  if($param1 == 'delete'){
    $response = $this->crud_model->subject_delete($param2);
    echo $response;
  }

  if($param1 == 'list'){
    $page_data['class_id'] = $param2;
    $this->load->view('backend/superadmin/subject/list', $page_data);
  }

  if(empty($param1)){
    $page_data['folder_name'] = 'subject';
    $page_data['page_title'] = 'subject';
    $page_data['utype'] = 'subject';
    $this->load->view('backend/index', $page_data);
  }
}

public function class_wise_subject($class_id) {

  // PROVIDE A LIST OF SUBJECT ACCORDING TO CLASS ID
  $page_data['class_id'] = $class_id;
  $this->load->view('backend/superadmin/subject/dropdown', $page_data);
}

//....................................END SUBJECT section..........................................//

//....................................START DEPARTMENT section....................................//
public function department($param1 = '', $param2 = ''){

  if($param1 == 'create'){
    $response = $this->crud_model->department_create();
    echo $response;
  }

  if($param1 == 'update'){
    $response = $this->crud_model->department_update($param2);
    echo $response;
  }

  if($param1 == 'delete'){
    $response = $this->crud_model->department_delete($param2);
    echo $response;
  }

  // Get the data from database
  if($param1 == 'list'){
    $this->load->view('backend/superadmin/department/list');
  }
  if($param1 == 'edit'){
    $page_data['department_id'] = $param2;
    $page_data['utype'] = 'department_update';
    $page_data['page_title'] = 'Update_department';
    $this->load->view('backend/index', $page_data);
  }

  
  if($param1 == 'form'){
    $page_data['utype'] = 'department_create';
    $page_data['page_title'] = 'add_department';
    $this->load->view('backend/index', $page_data);
  }

  if(empty($param1)){
    $page_data['folder_name'] = 'department';
    $page_data['page_title'] = 'department';
    $page_data['utype'] = 'department';
    $this->load->view('backend/index', $page_data);
  }
}
//....................................END DEPARTMENT section .....................................//

//.....................................START SYLLABUS section....................................//
  public function syllabus($param1 = '', $param2 = '', $param3 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->syllabus_create();
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->syllabus_delete($param2);
      echo $response;
    }

    if($param1 == 'list'){
      $page_data['class_id'] = $param2;
      $page_data['section_id'] = $param3;
      $this->load->view('backend/superadmin/syllabus/list', $page_data);
    }
    
  
    if($param1 == 'form'){
      $page_data['utype'] = 'syllabus_create';
      $page_data['page_title'] = 'add_syllabus';
      $this->load->view('backend/index', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'syllabus';
      $page_data['page_title'] = 'syllabus';
      $page_data['utype'] ='syllabus';
      $this->load->view('backend/index', $page_data);
    }
  }
  //..................................END SYLLABUS section..........................................//

  //..................................START CLASS ROUTINE section...................................//
  public function routine($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->routine_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->routine_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->routine_delete($param2);
      echo $response;
    }

    if($param1 == 'filter'){
      $page_data['class_id'] = $param2;
      $page_data['section_id'] = $param3;
      $this->load->view('backend/superadmin/routine/list', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'routine';
      $page_data['page_title'] = 'routine';
      $this->load->view('backend/index', $page_data);
    }
  }
  //............................................END CLASS ROUTINE section.................................../


  //START DAILY ATTENDANCE section
  public function attendance($param1 = '', $param2 = '', $param3 = ''){

    if($param1 == 'take_attendance'){
      $response = $this->crud_model->take_attendance();
      echo $response;
    }

    if($param1 == 'filter'){
      $date = '01 '.$this->input->post('month').' '.$this->input->post('year');
      $page_data['attendance_date'] = strtotime($date);
      $page_data['class_id'] = $this->input->post('class_id');
      $page_data['section_id'] = $this->input->post('section_id');
      $page_data['month'] = $this->input->post('month');
      $page_data['year'] = $this->input->post('year');
      $this->load->view('backend/superadmin/attendance/list', $page_data);
    }

    if($param1 == 'student'){
      $page_data['attendance_date'] = strtotime($this->input->post('date'));
      $page_data['class_id'] = $this->input->post('class_id');
      $page_data['section_id'] = $this->input->post('section_id');
      $this->load->view('backend/superadmin/attendance/student', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'attendance';
      $page_data['page_title'] = 'attendance';
      $this->load->view('backend/index', $page_data);
    }
  }

 //.......................................END ATTENDANCE SECTION....................................//

//....................................BOOK LIST MANAGER..............................................//
public function book($param1 = "", $param2 = "") {
  if ($param1 == 'create') {
    $response = $this->crud_model->create_book();
    echo $response;
  }

  // update book
  if ($param1 == 'update') {
    $response = $this->crud_model->update_book($param2);
    echo $response;
  }

  // deleting book
  if ($param1 == 'delete') {
    $response = $this->crud_model->delete_book($param2);
    echo $response;
  }
  // showing the list of book
  if ($param1 == 'list') {
    $this->load->view('backend/superadmin/book/list');
  }

  // showing the index file
  if(empty($param1)){
    $page_data['folder_name'] = 'book';
    $page_data['page_title']  = 'books';
    $this->load->view('backend/index', $page_data);
  }

}

//.......................................END BOOK LIST section....................................//

//.......................................START BOOK ISSUE section ................................//
  public function book_issue($param1 = "", $param2 = "") {
    if ($param1 == 'create') {
      $response = $this->crud_model->create_book_issue();
      echo $response;
    }

    // update book
    if ($param1 == 'update') {
      $response = $this->crud_model->update_book_issue($param2);
      echo $response;
    }

    // Returning a book
    if ($param1 == 'return') {
      $response = $this->crud_model->return_issued_book($param2);
      echo $response;
    }

    // deleting book
    if ($param1 == 'delete') {
      $response = $this->crud_model->delete_book_issue($param2);
      echo $response;
    }
    // showing the list of book
    if ($param1 == 'list') {
      $date = explode('-', $this->input->get('date'));
      $page_data['date_from'] = strtotime($date[0].' 00:00:00');
      $page_data['date_to']   = strtotime($date[1].' 23:59:59');
      $this->load->view('backend/superadmin/book_issue/list', $page_data);
    }
    if ($param1 == 'student') {
      $page_data['enrolments'] = $this->user_model->get_student_details_by_id('class', $param2);
      $this->load->view('backend/superadmin/student/dropdown', $page_data);
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'book_issue';
      $page_data['page_title']  = 'book_issue';
      $page_data['date_from'] = strtotime(date('d-M-Y', strtotime(' -30 day')).' 00:00:00');
      $page_data['date_to']   = strtotime(date('d-M-Y').' 23:59:59');
      $this->load->view('backend/index', $page_data);
    }
}
 // NOTICEBOARD MANAGER
 public function noticeboard($param1 = "", $param2 = "", $param3 = "") {
  // adding notice
  if ($param1 == 'create') {
    $response = $this->crud_model->create_notice();
    echo $response;
  }

  // update notice
  if ($param1 == 'update') {
    $response = $this->crud_model->update_notice($param2);
    echo $response;
  }

  // deleting notice
  if ($param1 == 'delete') {
    $response = $this->crud_model->delete_notice($param2);
    echo $response;
  }
  // showing the list of notice
  if ($param1 == 'list') {
    $this->load->view('backend/superadmin/noticeboard/list');
  }

  // showing the all the notices
  if ($param1 == 'all_notices') {
    $response = $this->crud_model->get_all_the_notices();
    echo $response;
  }

  if($param1 == 'form'){
    $page_data['page_title'] = 'noticeboard';
    $page_data['utype'] = 'add_notice';
    $this->load->view('backend/index', $page_data);
  }

  // showing the index file
  if(empty($param1)){
    $page_data['folder_name'] = 'noticeboard';
    $page_data['page_title']  = 'noticeboard';
    $page_data['utype'] = 'noticeboard';
    $this->load->view('backend/index', $page_data);
  }
}
  //....................................END BOOK ISSUE MANAGER section...................................................//
  //.....................................SETTINGS MANAGER................................................................//
  public function school_settings($param1 = "", $param2 = "") {
    if ($param1 == 'update') {
      $response = $this->settings_model->update_current_school_settings();
      echo $response;
    }

    // showing the System Settings file
    if(empty($param1)){
      $page_data['folder_name'] = 'settings';
      $page_data['page_title']  = 'school_settings';
      $page_data['settings_type'] = 'school_settings';
      $this->load->view('backend/index', $page_data);
    }
  }
  //.........................showing the Language Settings file.................................................//
  public function language($param1 = "", $param2 = "") {
    
     // adding language
     if ($param1 == 'create') {
      $response = $this->settings_model->create_language();
      echo $response;
    }
     // update language
     if ($param1 == 'update') {
      $response = $this->settings_model->update_language($param2);
      echo $response;
    }

    // deleting language
    if ($param1 == 'delete') {
      $response = $this->settings_model->delete_language($param2);
      echo $response;
    }

    // showing the list of language
    if ($param1 == 'list') {
      $this->load->view('backend/superadmin/language/list');
    }

    // showing the list of language
    if ($param1 == 'active') {
      $this->settings_model->update_system_language($param2);
      redirect(route('language'), 'refresh');
    }

    // showing the list of language
    if ($param1 == 'update_phrase') {
      $current_editing_language = $this->input->post('currentEditingLanguage');
      $updatedValue = $this->input->post('updatedValue');
      $key = $this->input->post('key');
      saveJSONFile($current_editing_language, $key, $updatedValue);
      echo $current_editing_language.' '.$key.' '.$updatedValue;
    }
    
    // GET THE DROPDOWN OF LANGUAGES
    if($param1 == 'dropdown') {
      $this->load->view('backend/superadmin/language/dropdown');
    }

    
    if(empty($param1)){
      $page_data['folder_name'] = 'language';
      $page_data['page_title']  = 'languages';
      $page_data['utype'] = 'languages';
      $this->load->view('backend/index', $page_data);
    }
  }
   //......................................MANAGE PROFILE STARTS.......................................................//
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

