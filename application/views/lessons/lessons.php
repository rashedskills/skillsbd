<?php
$course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
$my_course_url = strtolower($this->session->userdata('role')) == 'user' ? site_url('home/my_courses') : 'javascript::';
$course_details_url = site_url("home/course/".slugify($course_details['title'])."/".$course_id);
?>
<div class="container-fluid course_container">
    <!-- Top bar -->
    <div class="row">
        <div class="col-lg-9 course_header_col">
            <h5>
                <img src="<?php echo base_url().'uploads/system/logo-light-sm.png';?>" height="25"> |
                <?php echo $course_details['title']; ?>
            </h5>
        </div>
        <div class="col-lg-3 course_header_col">
            <a href="javascript::" class="course_btn" onclick="toggle_lesson_view()"><i class="fa fa-arrows-alt-h"></i></a>
            <a href="<?php echo $my_course_url; ?>" class="course_btn"> <i class="fa fa-chevron-left"></i> <?php echo get_phrase('my_courses'); ?></a>
            <a href="<?php echo $course_details_url; ?>" class="course_btn"><?php echo get_phrase('course_details'); ?> <i class="fa fa-chevron-right"></i></a>
            <a href="" class="course_btn" data-toggle="modal" data-target="#exampleModalCenter"><?php echo get_phrase('report'); ?> <i class="fab fa-font-awesome-flag"></i></a>
        </div>
    </div>
    
    <div class="row" id = "lesson-container">
        <?php if (isset($lesson_id)): ?>
            <!-- Course content, video, quizes, files starts-->
            <?php include 'course_content_body.php'; ?>
            <!-- Course content, video, quizes, files ends-->
        <?php endif; ?>

        <!-- Course sections and lesson selector sidebar starts-->
        <?php include 'course_content_sidebar.php'; ?>
        <!-- Course sections and lesson selector sidebar ends-->
    </div>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id=""><strong>Report abuse</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="reportAbouse" action="<?php echo site_url('user/reportSubmit'); ?>" method="post">
      <div class="modal-body">        
            <p>Flagged content is reviewed by Skillsbd staff to determine whether it violates Terms of Service or Community Guidelines. If you have a question or technical issue, please contact our <a href="mailto:support@skillsbd.com">Support@skillsbd.com</a></p>
            <input type="hidden" name="user_id" value=<?php echo $this->session->userdata('user_id'); ?>>
            <input type="hidden" name="course_id" value=<?php echo $course_id; ?>>
            <div class="form-group">
                <strong for="issueType">Issue Type</strong>
                <select name="issue_type" class="form-control" id="issueType">
                <option value="0">--Select One--</option>
                <option value="Inappropriate Course Content">Inappropriate Course Content</option>
                <option value="Inappropriate Behavior">Inappropriate Behavior</option>
                <option value="Skillsbd Policy Violation">Skillsbd Policy Violation</option>
                <option value="Spammy Content">Spammy Content</option>
                <option value="Other">Other</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <textarea name="issue_details" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Issue Describe..."></textarea>
                <small>If, you have any course watching issue please mention the course name, section, chapter correctly.</small>
            </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Send</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
