<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

class Settings_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  
    // GET SYSTEM DATA
   public function last_updated_attendance_data() {
      $data['date_of_last_updated_attendance'] = strtotime(date('d-m-Y H:i:s'));
      $this->db->where('id', 1);
      $this->db->update('settings', $data);
    }
  // GET DARK LOGO
  public function get_logo_dark($type = "") {
    if ($type == 'small') {
      return base_url('uploads/system/logo/logo-dark-sm.png');
    }else{
      return base_url('uploads/system/logo/logo-dark.png');
    }

  }

  // GET LIGHT LOGO
  public function get_logo_light() {
    
      return base_url('uploads/system/logo/logo-light.png');
    }

  // GET FAVICON
  public function get_favicon() {
    return base_url('uploads/system/logo/favicon.png');
  }

   //........................................ SCHOOL SETTINGS................................................//
   public function get_current_school_data() {
    return $this->db->get_where('schools', array('id' => school_id()))->row_array();
  }

  public function update_current_school_settings() {
    $data['name'] = $this->input->post('school_name');
    $data['phone'] = $this->input->post('phone');
    $data['address'] = $this->input->post('address');
    $this->db->where('id', school_id());
    $this->db->update('schools', $data);
    $response = array(
      'status' => true,
      'notification' => get_phrase('school_settings_updated_successfully')
    );
  
    return json_encode($response);
  }

  //.........................language section..........................//
  public function get_all_languages() {
    $language_files = array();
    $all_files = $this->get_list_of_language_files();
    foreach ($all_files as $file) {
      $info = pathinfo($file);
      if( isset($info['extension']) && strtolower($info['extension']) == 'json') {
        $file_name = explode('.json', $info['basename']);
        array_push($language_files, $file_name[0]);
      }
    }
    return $language_files;
  }
  
  public function create_language() {
    saveDefaultJSONFile(trimmer($this->input->post('language')));
    $response = array(
      'status' => true,
      'notification' => get_phrase('language_added_successfully')
    );
    return json_encode($response);
  }
  public function update_language($param1 = "") {
    if (file_exists('application/language/'.$param1.'.json')) {
      unlink('application/language/'.$param1.'.json');
    }
    saveDefaultJSONFile(trimmer($this->input->post('language')));
    $response = array(
      'status' => true,
      'notification' => get_phrase('language_added_successfully')
    );
    return json_encode($response);
  }

  public function delete_language($param1 = "") {
    if (file_exists('application/language/'.$param1.'.json')) {
      unlink('application/language/'.$param1.'.json');
    }
    $response = array(
      'status' => true,
      'notification' => get_phrase('language_deleted_successfully')
    );
    return json_encode($response);
  }

 
  public function update_system_language($selected_language = "") {
    $data['language'] = $selected_language;

    $this->db->where('id', 1);
    $this->db->update('settings', $data);
  }
  
  // This function is responsible for retreving all the language file from language folder
  function get_list_of_language_files($dir = APPPATH.'/language', &$results = array()) {
    $files = scandir($dir);
    foreach($files as $key => $value){
      $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
      if(!is_dir($path)) {
        $results[] = $path;
      } else if($value != "." && $value != "..") {
        $this->get_list_of_directories_and_files($path, $results);
        $results[] = $path;
      }
    }
    return $results;
  }
  
  // This function is responsible for retreving all the files and folder
  function get_list_of_directories_and_files($dir = APPPATH, &$results = array()) {
    $files = scandir($dir);
    foreach($files as $key => $value){
      $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
      if(!is_dir($path)) {
        $results[] = $path;
      } else if($value != "." && $value != "..") {
        $this->get_list_of_directories_and_files($path, $results);
        $results[] = $path;
      }
    }
    return $results;
  }
  
  
}