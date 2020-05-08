<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function get_admin_details() {
        return $this->db->get_where('users', array('role_id' => 1));
    }

    

    public function get_user($user_id = 0) {
        if ($user_id > 0) {
            $this->db->where('id', $user_id);
        }
        $this->db->where('role_id', 2);
        return $this->db->get('users');
    }

    public function get_students($user_id = 0) {
        if ($user_id > 0) {
            $this->db->where('id', $user_id);
        }       
        $this->db->select('course.id as courseid, course.title, enrol.user_id as studentid, enrol.date_added');
        $this->db->join('enrol', 'enrol.course_id = course.id');
        $this->db->where('course.user_id', $this->session->userdata('user_id'));
        return $this->db->get('course');        
    }

    public function enrol_history_by_course_id($course_id = "") {
        return $this->db->get_where('enrol', array('user_id' => $course_id));
      }

    public function get_all_instructor($user_id = 0) {
        if ($user_id > 0) {
            $this->db->where('course.id', $user_id);
        }
        $this->db->join('course', 'users.id = course.user_id');
        $this->db->where('users.role_id', 2);
        $this->db->group_by('course.user_id');
        $this->db->order_by('users.id', 'DESC');
        return $this->db->get('users');
    }

    public function get_all_orders() {       
        $this->db->order_by('order_new.id', 'DESC');
        return $this->db->get('order_new');              
    }

    public function get_all_refund() {   
        return $this->db->get('my_refund');              
    }

    public function get_all_user($user_id = 0) {
        if ($user_id > 0) {
            $this->db->where('id', $user_id);
        }
        return $this->db->get('users');
    }

    public function get_all_institute_insctructor(){
        
    }
    

    public function add_user() {
        $validity = $this->check_duplication('on_create', $this->input->post('email'));
        if ($validity == false) {
            $this->session->set_flashdata('error_message', get_phrase('email_duplication'));
        }else {
            $data['first_name'] = html_escape($this->input->post('first_name'));
            $data['last_name'] = html_escape($this->input->post('last_name'));
            $data['email'] = html_escape($this->input->post('email'));
            $data['password'] = sha1(html_escape($this->input->post('password')));
            $social_link['facebook'] = html_escape($this->input->post('facebook_link'));
            $social_link['twitter'] = html_escape($this->input->post('twitter_link'));
            $social_link['linkedin'] = html_escape($this->input->post('linkedin_link'));
            $data['social_links'] = json_encode($social_link);
            $data['biography'] = $this->input->post('biography');
            $data['role_id'] = 2;
            $data['date_added'] = strtotime(date("Y-m-d H:i:s"));
            $data['wishlist'] = json_encode(array());
            $data['watch_history'] = json_encode(array());
            $data['status'] = 1;
            // Add paypal keys
            $paypal_info = array();
            $paypal['production_client_id'] = html_escape($this->input->post('paypal_client_id'));
            array_push($paypal_info, $paypal);
            $data['paypal_keys'] = json_encode($paypal_info);
            // Add Stripe keys
            $stripe_info = array();
            $stripe_keys = array(
                'public_live_key' => html_escape($this->input->post('stripe_public_key')),
                'secret_live_key' => html_escape($this->input->post('stripe_secret_key'))
            );
            array_push($stripe_info, $stripe_keys);
            $data['stripe_keys'] = json_encode($stripe_info);

            $this->db->insert('users', $data);
            $user_id = $this->db->insert_id();
            $this->upload_user_image($user_id);
            $this->session->set_flashdata('flash_message', get_phrase('user_added_successfully'));
        }
    }

    


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

    public function edit_user($user_id = "") { // Admin does this editing
        $validity = $this->check_duplication('on_update', $this->input->post('email'), $user_id);
        if ($validity) {
            $data['first_name'] = html_escape($this->input->post('first_name'));
            $data['last_name'] = html_escape($this->input->post('last_name'));
            $data['phone'] = html_escape($this->input->post('phone'));            
            if (isset($_POST['email'])) {
                $data['email'] = html_escape($this->input->post('email'));
            }
            $social_link['facebook'] = html_escape($this->input->post('facebook_link'));
            $social_link['twitter'] = html_escape($this->input->post('twitter_link'));
            $social_link['linkedin'] = html_escape($this->input->post('linkedin_link'));
            $data['social_links'] = json_encode($social_link);
            $data['biography'] = $this->input->post('biography');
            $data['is_institute'] = html_escape($this->input->post('is_institute'));
            $data['institute_name'] = html_escape($this->input->post('institute_name'));
            $data['institute_email'] = html_escape($this->input->post('institute_email'));
            $data['institute_phone'] = html_escape($this->input->post('institute_phone'));
            $data['institute_address'] = html_escape($this->input->post('institute_address'));
            $data['title'] = html_escape($this->input->post('title'));
            $data['last_modified'] = strtotime(date("Y-m-d H:i:s"));
            // print_r($data);exit();
            // Update paypal keys
            $paypal_info = array();
            $paypal['production_client_id'] = html_escape($this->input->post('paypal_client_id'));
            array_push($paypal_info, $paypal);
            $data['paypal_keys'] = json_encode($paypal_info);
            // Update Stripe keys
            $stripe_info = array();
            $stripe_keys = array(
                'public_live_key' => html_escape($this->input->post('stripe_public_key')),
                'secret_live_key' => html_escape($this->input->post('stripe_secret_key'))
            );
            array_push($stripe_info, $stripe_keys);
            $data['stripe_keys'] = json_encode($stripe_info);

            $this->db->where('id', $user_id);
            $this->db->update('users', $data);
            $this->upload_user_image($user_id);
            $this->session->set_flashdata('flash_message', get_phrase('user_update_successfully'));
        }else {
            $this->session->set_flashdata('error_message', get_phrase('email_duplication'));
        }

        $this->upload_user_image($user_id);
    }
    public function delete_user($user_id = "") {
        $this->db->where('id', $user_id);
        $this->db->delete('users');
        $this->session->set_flashdata('flash_message', get_phrase('user_deleted_successfully'));
    }

    public function unlock_screen_by_password($password = "") {
        $password = sha1($password);
        return $this->db->get_where('users', array('id' => $this->session->userdata('user_id'), 'password' => $password))->num_rows();
    }

    public function register_user($data) {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function my_courses($user_id = "") {
        if ($user_id == "") {
            $user_id = $this->session->userdata('user_id');
        }
        return $this->db->get_where('enrol', array('user_id' => $user_id));
    }

    public function getWishLists($user_id = "") {
    if ($user_id == "") {
      $user_id = $this->session->userdata('user_id');
    }
    $user_details = $this->user_model->get_user($user_id)->row_array();
    return json_decode($user_details['wishlist']);
  }

    public function my_refund_request($user_id = "") {
        if ($user_id == "") {
            $user_id = $this->session->userdata('user_id');
        }
        return $this->db->get_where('my_refund', array('user_id' => $user_id));
    }

    public function upload_user_image($user_id) {
        if (isset($_FILES['user_image']) && $_FILES['user_image']['name'] != "") {
            move_uploaded_file($_FILES['user_image']['tmp_name'], 'uploads/user_image/'.$user_id.'.jpg');
            $this->session->set_flashdata('flash_message', get_phrase('user_update_successfully'));
        }
    }

    public function update_account_settings($user_id) {
        $validity = $this->check_duplication('on_update', $this->input->post('email'), $user_id);
        if ($validity) {
            if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
                $user_details = $this->get_user($user_id)->row_array();
                $current_password = $this->input->post('current_password');
                $new_password = $this->input->post('new_password');
                $confirm_password = $this->input->post('confirm_password');
                if ($user_details['password'] == sha1($current_password) && $new_password == $confirm_password) {
                    $data['password'] = sha1($new_password);
                }else {
                    $this->session->set_flashdata('error_message', get_phrase('mismatch_password'));
                    return;
                }
            }
            $data['email'] = html_escape($this->input->post('email'));
            $this->db->where('id', $user_id);
            $this->db->update('users', $data);
            $this->session->set_flashdata('flash_message', get_phrase('updated_successfully'));
        }else {
            $this->session->set_flashdata('error_message', get_phrase('email_duplication'));
        }
    }

    public function change_password($user_id) {
        $data = array();
        if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
            $user_details = $this->get_all_user($user_id)->row_array();
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');

            if ($user_details['password'] == sha1($current_password) && $new_password == $confirm_password) {
                $data['password'] = sha1($new_password);
            }else {
                $this->session->set_flashdata('error_message', get_phrase('mismatch_password'));
                return;
            }
        }

        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
        $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
    }


    public function get_instructor($id = 0) {
        if ($id > 0) {
            return $this->db->get_all_user($id);
        }else {
            if ($this->check_if_instructor_exists()) {
                $this->db->select('user_id');
                $this->db->distinct('user_id');
                $query_result =  $this->db->get('course');
                $ids = array();
                foreach ($query_result->result_array() as $query) {
                    if ($query['user_id']) {
                        array_push($ids, $query['user_id']);
                    }
                }

                $this->db->where_in('id', $ids);
                return $this->db->get('users')->result_array();
            }
            else {
                return array();
            }
        }
    }

    public function check_if_instructor_exists() {
        $this->db->where('user_id >', 0);
        $result = $this->db->get('course')->num_rows();
        if ($result > 0) {
            return true;
        }else {
            return false;
        }
    }

    public function get_user_image_url($user_id) {

         if (file_exists('uploads/user_image/'.$user_id.'.jpg'))
             return base_url().'uploads/user_image/'.$user_id.'.jpg';
        else
            return base_url().'uploads/user_image/placeholder.png';
    }
    public function get_instructor_list() {
        $query1 = $this->db->get_where('course', array('status' => 'active'))->result_array();
        $instructor_ids = array();
        $query_result = array();
        foreach ($query1 as $row1) {
            if (!in_array($row1['user_id'], $instructor_ids) && $row1['user_id'] != "") {
                array_push($instructor_ids, $row1['user_id']);
            }
        }
        if (count($instructor_ids) > 0) {
            $this->db->where_in('id', $instructor_ids);
            $query_result = $this->db->get('users');
        }else {
            $query_result = $this->get_admin_details();
        }

        return $query_result;
    }

   

    public function update_instructor_bank_settings($user_id = '') {
        // Update bank account payment information
        $data['bank_acc_name'] = html_escape($this->input->post('bank_acc_name'));
        $data['bank_acc_number'] = html_escape($this->input->post('bank_acc_number'));
        $data['payment_others_info'] = html_escape($this->input->post('payment_others_info'));
        $data['bkash_number'] = html_escape($this->input->post('bkash_number'));
        $data['bkash_acc_type'] = html_escape($this->input->post('bkash_acc_type'));
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
    }

    public function update_instructor_details_by_id($instructor_id = "", $data){
        
        $this->db->where('id', $instructor_id);
        $this->db->update('my_instructors', $data);
        return $this->db->affected_rows();
    }

    public function instructor_delete_by_id($instructor_id = ""){
        $this->db->where('id', $instructor_id);
        $this->db->delete('my_instructors');
        $this->session->set_flashdata('flash_message', get_phrase('instructor_deleted_successfully'));
    }

    public function update_instructor_paypal_settings($user_id = '') {
        // Update paypal keys
        $paypal_info = array();
        $paypal['production_client_id'] = html_escape($this->input->post('paypal_client_id'));
        array_push($paypal_info, $paypal);
        $data['paypal_keys'] = json_encode($paypal_info);
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
    }
    public function update_instructor_stripe_settings($user_id = '') {
        // Update Stripe keys
        $stripe_info = array();
        $stripe_keys = array(
            'public_live_key' => html_escape($this->input->post('stripe_public_key')),
            'secret_live_key' => html_escape($this->input->post('stripe_secret_key'))
        );
        array_push($stripe_info, $stripe_keys);
        $data['stripe_keys'] = json_encode($stripe_info);
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
    }
}
