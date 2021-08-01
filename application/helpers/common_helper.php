<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

if (! function_exists('get_settings')) {
  function get_settings($type = '') {
    $CI	=&	get_instance();
    $CI->load->database();
    $result = $CI->db->get_where('settings', array('id' => 1))->row_array();
    return $result[$type];
  }
}

if (! function_exists('get_common_settings')) {
  function get_common_settings($type = '') {
    $CI =&  get_instance();
    $CI->load->database();

    $CI->db->where('type', $type);
    $result = $CI->db->get('common_settings')->row('description');
    return $result;
  }
}



if (! function_exists('timezone')) {
  function timezone($type = '') {
    $CI	=&	get_instance();
    $CI->load->database();
    $result = $CI->db->get_where('settings', array('id' => 1))->row_array();
    date_default_timezone_set($result['timezone']);
  }
}

if (! function_exists('get_frontend_settings')) {
  function get_frontend_settings($type = '') {
    $CI	=&	get_instance();
    $CI->load->database();
    $result = $CI->db->get_where('frontend_settings', array('id' => 1))->row_array();
    return $result[$type];
  }
}

if (! function_exists('get_current_school_data')) {
  function get_current_school_data($type = '') {
    $CI	=&	get_instance();
    $CI->load->database();
    $result = $CI->settings_model->get_current_school_data();
    return $result[$type];
  }
}


if (! function_exists('get_smtp')) {
  function get_smtp($type = '') {
    $CI	=&	get_instance();
    $CI->load->database();
    $result = $CI->db->get_where('smtp_settings', array('id' => 1))->row_array();
    return $result[$type];
  }
}


if (! function_exists('get_sms')) {
  function get_sms($type = '') {
    $CI	=&	get_instance();
    $CI->load->database();
    $result = $CI->db->get_where('sms_settings', array('id' => 1))->row_array();
    return $result[$type];
  }
}

if (! function_exists('route')) {
  function route($path = '') {
    $CI	=&	get_instance();
    $controller = "";
    if ($CI->session->userdata('user_type') == 'parent') {
      $controller = 'parents';
    }else{
      $controller = $CI->session->userdata('user_type');
    }
    return site_url($controller.'/'.$path);
  }
}

if ( ! function_exists('trimmer'))
{
  function trimmer($text) {
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    $text = trim($text, '-');
    $text = strtolower($text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    if (empty($text))
    return 'n-a';
    return $text;
  }
}

if ( ! function_exists('get_menu'))
{
  function get_menu($menu_id, $parameter) {
    $CI	=&	get_instance();
    if ($lookup_value == 'parent') {
      $menu_detail = $CI->db->get_where('menus', array('id' => $menu_id))->row_array();
      return $menu_detail['parent'];
    }
  }
}







//SCHOOL ID
if (! function_exists('school_id')) {
  function school_id() {
    $CI =&  get_instance();
    if ($CI->session->userdata('user_type') == 'superadmin') {
      return get_settings('school_id');
    }else{
      if ($CI->session->userdata('school_id') > 0) {
        return $CI->session->userdata('school_id');
      }
      else{
        return get_settings('school_id');
      }
    }
  }
}

//ACTIVE SESSION
if (! function_exists('active_session')) {
  function active_session($param1 = '') {
    $CI =&  get_instance();
    $CI->load->database();
    if($param1 == ''){
      $session_details = $CI->db->get_where('sessions', array('status' => 1))->row_array();
      return $session_details['id'];
    }else{
      $session_details = $CI->db->get_where('sessions', array('status' => 1))->row_array();
      return $session_details[$param1];
    }
  }
}



// RANDOM NUMBER GENERATOR FOR STUDENT CODE
if (! function_exists('student_code')) {
  function student_code($length_of_string = 8) {
    // String of all numeric character
    $str_result = '0123456789';
    // Shufle the $str_result and returns substring of specified length
    $unique_id = substr(str_shuffle($str_result), 0, $length_of_string);
    $splited_unique_id = str_split($unique_id, 4);
    $running_year = date('Y');
    $student_code = $running_year.'-'.$splited_unique_id[0].'-'.$splited_unique_id[1];
    return $student_code;
  }
}

// RANDOM NUMBER GENERATOR FOR ELSEWHERE
if (! function_exists('random')) {
  function random($length_of_string) {
    // String of all alphanumeric character
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    // Shufle the $str_result and returns substring
    // of specified length
    return substr(str_shuffle($str_result), 0, $length_of_string);
  }
}


// ------------------------------------------------------------------------
/* End of file common_helper.php */
