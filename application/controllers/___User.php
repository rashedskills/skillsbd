<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');

        if (get_settings('allow_instructor') != 1){
            redirect(site_url('home'), 'refresh');
        }
    }

    public function index() {
        if ($this->session->userdata('user_login') == true) {
            $this->courses();
        }else {
            redirect(site_url('login'), 'refresh');
        }
    }

    public function courses() {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['selected_category_id']   = isset($_GET['category_id']) ? $_GET['category_id'] : "all";
        $page_data['selected_instructor_id'] = $this->session->userdata('user_id');
        $page_data['selected_price']         = isset($_GET['price']) ? $_GET['price'] : "all";
        $page_data['selected_status']        = isset($_GET['status']) ? $_GET['status'] : "all";
        $page_data['courses']                = $this->crud_model->filter_course_for_backend($page_data['selected_category_id'], $page_data['selected_instructor_id'], $page_data['selected_price'], $page_data['selected_status']);
        $page_data['page_name']              = 'courses-server-side';
        $page_data['categories']             = $this->crud_model->get_categories();
        $page_data['page_title']             = get_phrase('active_courses');
        $this->load->view('backend/index', $page_data);
    }

    // This function is responsible for loading the course data from server side for datatable SILENTLY
    public function get_courses() {
      if ($this->session->userdata('user_login') != true) {
        redirect(site_url('login'), 'refresh');
      }
      $courses = array();
      // Filter portion
      $filter_data['selected_category_id']   = $this->input->post('selected_category_id');
      $filter_data['selected_instructor_id'] = $this->input->post('selected_instructor_id');
      $filter_data['selected_price']         = $this->input->post('selected_price');
      $filter_data['selected_status']        = $this->input->post('selected_status');

      // Server side processing portion
      $columns = array(
        0 => '#',
        1 => 'title',
        2 => 'category',
        3 => 'course_type',
        4 => 'lesson_and_section',
        5 => 'enrolled_student',
        6 => 'status',
        7 => 'price',
        8 => 'actions',
        9 => 'course_id'
      );

      // Coming from databale itself. Limit is the visible number of data
      $limit = html_escape($this->input->post('length'));
      $start = html_escape($this->input->post('start'));
      $order = "";
      $dir   = $this->input->post('order')[0]['dir'];

      $totalData = $this->lazyload->count_all_courses($filter_data);
      $totalFiltered = $totalData;

      // This block of code is handling the search event of datatable
      if(empty($this->input->post('search')['value'])) {
        $courses = $this->lazyload->courses($limit, $start, $order, $dir, $filter_data);
      }
      else {
        $search = $this->input->post('search')['value'];
        $courses =  $this->lazyload->course_search($limit, $start, $search, $order, $dir, $filter_data);
        $totalFiltered = $this->lazyload->course_search_count($search);
      }

      // Fetch the data and make it as JSON format and return it.
      $data = array();
      if(!empty($courses)) {
        foreach ($courses as $key => $row) {
          $instructor_details = $this->user_model->get_all_user($row->user_id)->row_array();
          $category_details = $this->crud_model->get_category_details_by_id($row->sub_category_id)->row_array();
          $sections = $this->crud_model->get_section('course', $row->id);
          $lessons = $this->crud_model->get_lessons('course', $row->id);
          $enroll_history = $this->crud_model->enrol_history($row->id);

          $status_badge = "badge-success-lighten";
          if ($row->status == 'pending') {
              $status_badge = "badge-danger-lighten";
          }elseif ($row->status == 'draft') {
              $status_badge = "badge-dark-lighten";
          }

          $price_badge = "badge-dark-lighten";
          $price = 0;
          if ($row->is_free_course == null){
            if ($row->discount_flag == 1) {
              $price = currency($row->discounted_price);
            }else{
              $price = currency($row->price);
            }
          }elseif ($row->is_free_course == 1){
            $price_badge = "badge-success-lighten";
            $price = get_phrase('free');
          }

          $view_course_on_frontend_url = site_url('home/course/'.slugify($row->title).'/'.$row->id);
          $edit_this_course_url = site_url('user/course_form/course_edit/'.$row->id);
          $section_and_lesson_url = site_url('user/course_form/course_edit/'.$row->id);

          if ($row->status == 'active' || $row->status == 'pending') {
            $course_status_changing_action = "confirm_modal('".site_url('user/course_actions/draft/'.$row->id)."')";
            $course_status_changing_message = get_phrase('mark_as_drafted');
          }else{
            $course_status_changing_action = "confirm_modal('".site_url('user/course_actions/publish/'.$row->id)."')";
            $course_status_changing_message = get_phrase('publish_this_course');
          }

          $delete_course_url = "confirm_modal('".site_url('user/course_actions/delete/'.$row->id)."')";

          $action = '
          <div class="dropright dropright">
            <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="mdi mdi-dots-vertical"></i>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="'.$view_course_on_frontend_url.'" target="_blank">'.get_phrase("view_course_on_frontend").'</a></li>
                <li><a class="dropdown-item" href="'.$edit_this_course_url.'">'.get_phrase("edit_this_course").'</a></li>
                <li><a class="dropdown-item" href="'.$section_and_lesson_url.'">'.get_phrase("section_and_lesson").'</a></li>
                <li><a class="dropdown-item" href="javascript::" onclick="'.$course_status_changing_action.'">'.$course_status_changing_message.'</a></li>
                <li><a class="dropdown-item" href="javascript::" onclick="'.$delete_course_url.'">'.get_phrase("delete").'</a></li>
            </ul>
        </div>
        ';

          $nestedData['#'] = $key+1;

          $nestedData['title'] = '<strong><a href="'.site_url('user/course_form/course_edit/'.$row->id).'">'.$row->title.'</a></strong><br>
          <small class="text-muted">'.get_phrase('instructor').': <b>'.$instructor_details['first_name'].' '.$instructor_details['last_name'].'</b></small>';

          $nestedData['category'] = '<span class="badge badge-dark-lighten">'.$category_details['name'].'</span>';
          $nestedData['course_type'] = '<span class="">'.$row->course_type.'</span>';
          $nestedData['lesson_and_section'] = '
            <small class="text-muted"><b>'.get_phrase('total_section').'</b>: '.$sections->num_rows().'</small><br>
            <small class="text-muted"><b>'.get_phrase('total_lesson').'</b>: '.$lessons->num_rows().'</small><br>';

          $nestedData['enrolled_student'] = '<small class="text-muted"><b>'.get_phrase('total_enrolment').'</b>: '.$enroll_history->num_rows().'</small>';

          $nestedData['status'] = '<span class="badge '.$status_badge.'">'.get_phrase($row->status).'</span>';

          $nestedData['price'] = '<span class="badge '.$price_badge.'">'.get_phrase($price).'</span>';

          $nestedData['actions'] = $action;

          $nestedData['course_id'] = $row->id;

          $data[] = $nestedData;
        }
      }

      $json_data = array(
        "draw"            => intval($this->input->post('draw')),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $data
      );

      echo json_encode($json_data);
    }

    public function course_actions($param1 = "", $param2 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == "add") {
            $course_id = $this->crud_model->add_course();
            redirect(site_url('user/course_form/course_edit/'.$course_id), 'refresh');

        }
        elseif ($param1 == "edit") {
            $this->is_the_course_belongs_to_current_instructor($param2);
            $this->crud_model->update_course($param2);
            redirect(site_url('user/courses'), 'refresh');

        }
        elseif ($param1 == 'delete') {
            $this->is_the_course_belongs_to_current_instructor($param2);
            $this->crud_model->delete_course($param2);
            redirect(site_url('user/courses'), 'refresh');
        }
        elseif ($param1 == 'draft') {
            $this->is_the_course_belongs_to_current_instructor($param2);
            $this->crud_model->change_course_status('draft', $param2);
            redirect(site_url('user/courses'), 'refresh');
        }
        elseif ($param1 == 'publish') {
            $this->is_the_course_belongs_to_current_instructor($param2);
            $this->crud_model->change_course_status('pending', $param2);
            redirect(site_url('user/courses'), 'refresh');
        }
    }

    public function course_form($param1 = "", $param2 = "") {

        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'add_course') {
            $page_data['languages']	= $this->crud_model->get_all_languages();
            $page_data['categories'] = $this->crud_model->get_categories();
            $page_data['page_name'] = 'course_add';
            $page_data['page_title'] = get_phrase('add_course');
            $this->load->view('backend/index', $page_data);

        }elseif ($param1 == 'course_edit') {
            $this->is_the_course_belongs_to_current_instructor($param2);
            $page_data['page_name'] = 'course_edit';
            $page_data['course_id'] =  $param2;
            $page_data['page_title'] = get_phrase('edit_course');
            $page_data['languages']	= $this->crud_model->get_all_languages();
            $page_data['categories'] = $this->crud_model->get_categories();
            $this->load->view('backend/index', $page_data);
        }
    }

    public function payment_settings($param1 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'bank_settings') {
            $this->user_model->update_instructor_bank_settings($this->session->userdata('user_id'));
            redirect(site_url('user/payment_settings'), 'refresh');
        }

        if ($param1 == 'paypal_settings') {
            $this->user_model->update_instructor_paypal_settings($this->session->userdata('user_id'));
            redirect(site_url('user/payment_settings'), 'refresh');
        }
        if ($param1 == 'stripe_settings') {
            $this->user_model->update_instructor_stripe_settings($this->session->userdata('user_id'));
            redirect(site_url('user/payment_settings'), 'refresh');
        }

        $page_data['page_name'] = 'payment_settings';
        $page_data['page_title'] = get_phrase('payment_settings');
        $this->load->view('backend/index', $page_data);
    }

    public function instructor_revenue($param1 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        $page_data['payment_history'] = $this->crud_model->get_instructor_revenue();
        $page_data['page_name'] = 'instructor_revenue';
        $page_data['page_title'] = get_phrase('instructor_revenue');
        $this->load->view('backend/index', $page_data);
    }

    public function preview($course_id = '') {
        if ($this->session->userdata('user_login') != 1)
        redirect(site_url('login'), 'refresh');

        $this->is_the_course_belongs_to_current_instructor($course_id);
        if ($course_id > 0) {
            $courses = $this->crud_model->get_course_by_id($course_id);
            if ($courses->num_rows() > 0) {
                $course_details = $courses->row_array();
                redirect(site_url('home/lesson/'.slugify($course_details['title']).'/'.$course_details['id']), 'refresh');
            }
        }
        redirect(site_url('user/courses'), 'refresh');
    }

    public function sections($param1 = "", $param2 = "", $param3 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param2 == 'add') {
            $this->crud_model->add_section($param1);
            $this->session->set_flashdata('flash_message', get_phrase('section_has_been_added_successfully'));
        }
        elseif ($param2 == 'edit') {
            $this->crud_model->edit_section($param3);
            $this->session->set_flashdata('flash_message', get_phrase('section_has_been_updated_successfully'));
        }
        elseif ($param2 == 'delete') {
            $this->crud_model->delete_section($param1, $param3);
            $this->session->set_flashdata('flash_message', get_phrase('section_has_been_deleted_successfully'));
        }
        redirect(site_url('user/course_form/course_edit/'.$param1));
    }

    public function lessons($course_id = "", $param1 = "", $param2 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        if ($param1 == 'add') {
            $this->crud_model->add_lesson();
            $this->session->set_flashdata('flash_message', get_phrase('lesson_has_been_added_successfully'));
            redirect('user/course_form/course_edit/'.$course_id);
        }
        elseif ($param1 == 'edit') {
            $this->crud_model->edit_lesson($param2);
            $this->session->set_flashdata('flash_message', get_phrase('lesson_has_been_updated_successfully'));
            redirect('user/course_form/course_edit/'.$course_id);
        }
        elseif ($param1 == 'delete') {
            $this->crud_model->delete_lesson($param2);
            $this->session->set_flashdata('flash_message', get_phrase('lesson_has_been_deleted_successfully'));
            redirect('user/course_form/course_edit/'.$course_id);
        }
        elseif ($param1 == 'filter') {
            redirect('user/lessons/'.$this->input->post('course_id'));
        }
        $page_data['page_name'] = 'lessons';
        $page_data['lessons'] = $this->crud_model->get_lessons('course', $course_id);
        $page_data['course_id'] = $course_id;
        $page_data['page_title'] = get_phrase('lessons');
        $this->load->view('backend/index', $page_data);
    }

    // This function checks if this course belongs to current logged in instructor
    function is_the_course_belongs_to_current_instructor($course_id) {
        $course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
        if ($course_details['user_id'] != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error_message', get_phrase('you_do_not_have_right_to_access_this_course'));
            redirect(site_url('user/courses'), 'refresh');
        }
    }

    // Manage Quizes
    public function quizes($course_id = "", $action = "", $quiz_id = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($action == 'add') {
            $this->crud_model->add_quiz($course_id);
            $this->session->set_flashdata('flash_message', get_phrase('quiz_has_been_added_successfully'));
        }
        elseif ($action == 'edit') {
            $this->crud_model->edit_quiz($quiz_id);
            $this->session->set_flashdata('flash_message', get_phrase('quiz_has_been_updated_successfully'));
        }
        elseif ($action == 'delete') {
            $this->crud_model->delete_section($course_id, $quiz_id);
            $this->session->set_flashdata('flash_message', get_phrase('quiz_has_been_deleted_successfully'));
        }
        redirect(site_url('user/course_form/course_edit/'.$course_id));
    }

    // Manage Quize Questions
    public function quiz_questions($quiz_id = "", $action = "", $question_id = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $quiz_details = $this->crud_model->get_lessons('lesson', $quiz_id)->row_array();

        if ($action == 'add') {
            $response = $this->crud_model->add_quiz_questions($quiz_id);
            echo $response;
        }

        elseif ($action == 'edit') {
            $response = $this->crud_model->update_quiz_questions($question_id);
            echo $response;
        }

        elseif ($action == 'delete') {
            $response = $this->crud_model->delete_quiz_question($question_id);
            $this->session->set_flashdata('flash_message', get_phrase('question_has_been_deleted'));
            redirect(site_url('user/course_form/course_edit/'.$quiz_details['course_id']));
        }
    }

    function manage_profile() {
        redirect(site_url('home/profile/user_profile'), 'refresh');
    }

    function invoice($payment_id = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name'] = 'invoice';
        $page_data['payment_details'] = $this->crud_model->get_payment_details_by_id($payment_id);
        $page_data['page_title'] = get_phrase('invoice');
        $this->load->view('backend/index', $page_data);
    }
    // Ajax Portion
    public function ajax_get_video_details() {
        $video_details = $this->video_model->getVideoDetails($_POST['video_url']);
        echo $video_details['duration'];
    }

    // this function is responsible for managing multiple choice question
    function manage_multiple_choices_options() {
        $page_data['number_of_options'] = $this->input->post('number_of_options');
        $this->load->view('backend/user/manage_multiple_choices_options', $page_data);
    }

    public function ajax_sort_section() {
        $section_json = $this->input->post('itemJSON');
        $this->crud_model->sort_section($section_json);
    }
    public function ajax_sort_lesson() {
        $lesson_json = $this->input->post('itemJSON');
        $this->crud_model->sort_lesson($lesson_json);
    }
    public function ajax_sort_question() {
        $question_json = $this->input->post('itemJSON');
        $this->crud_model->sort_question($question_json);
    }

    // Mark this lesson as completed codes
    function save_course_progress() {
        $response = $this->crud_model->save_course_progress();
        echo $response;
    }
}
