<script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script>
<?php

$my_courses = $this->user_model->my_courses()->result_array();

$student_data = $this->db->get_where('users', array('id' => $this->session->userdata('user_id')))->row_array();
$course_data = $this->db->get_where('course', array('id' => $this->uri->segment(3)))->row_array();
$instructor_data = $this->db->get_where('users', array('id' => $course_data['user_id']))->row_array();
$my_certificate = $this->db->get_where('certificate', array('course_id' => $this->uri->segment(3), 'user_id' => $this->session->userdata('user_id')))->row_array();

?>
<section class="page-header-area my-course-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="page-title"><?php echo get_phrase('certificate'); ?></h1>
                <ul>
                  <li class=><a href="<?php echo site_url('home/my_courses'); ?>"><?php echo get_phrase('all_courses'); ?></a></li>
                  <li><a href="<?php echo site_url('home/my_wishlist'); ?>"><?php echo get_phrase('wishlists'); ?></a></li>
                  <li><a href="<?php echo site_url('home/my_messages'); ?>"><?php echo get_phrase('my_messages'); ?></a></li>
                  <li><a href="<?php echo site_url('home/purchase_history'); ?>"><?php echo get_phrase('purchase_history'); ?></a></li>
                  <li><a href="<?php echo site_url('home/order_history'); ?>"><?php echo get_phrase('my_order'); ?></a></li>
                  <li><a href="<?php echo site_url('home/profile/user_profile'); ?>"><?php echo get_phrase('user_profile'); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<style>
.img-container{
    position: relative;
    text-align: center;
    color: #36373c;
    }
    .centered {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 1vw;
        font-weight: 600;
    }
    .bottom-right {
        position: absolute;
        bottom: 8px;
        right: 16px;
    }
</style>
<!-- certificate order section -->
<?php if(!empty($my_certificate)): ?>
    <section class="my-courses-area">
    <div class="container">

        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-12">
                <div class="img-container" id="html-content-holder">
                    <img src="<?php echo base_url().'uploads/system/certificate.png'; ?>" alt="skillsbd-certificate" class="img-responsive custom-img" style="width:100%;">
                    <div class="centered">This is to certify that <?php echo $my_certificate['std_name']; ?> successfully completed the course <?php echo $my_certificate['crs_title']; ?> on 21 July, 2019</div>
                </div>  
                <p class="mt-4 mb-4">
                This certificate above verifies that <?php echo '<strong>'.$my_certificate['std_name'].'</strong>'; ?> successfully completed the course <?php echo '<strong>'.$my_certificate['crs_title'].'</strong>'; ?>. on <?php echo '<strong>'.date('d-M-Y', $my_certificate['date_added']).'</strong>' ?> as taught by <?php echo '<strong>'.$instructor_data['first_name'].' '.$instructor_data['last_name'].'</strong>' ?> on Skillsbd. The certificate indicates the entire course was completed as validated by the student.
                </p> 
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12">
                <div class="row mb-4">
                    <div class="card" style="width: 18rem;">
                        <div class="card-header">
                            <strong><i class="fas fa-download"></i> Download</strong>
                        </div>
                        <ul class="list-group list-group-flush">
                           
                            <li class="list-group-item">
                               <small><strong>Certificate no:</strong></small><br> <?php echo $my_certificate['certificate_code']; ?>
                            </li>
                            <li class="list-group-item">
                                    <a id="btn-Convert-Html2Image" href="#"><strong>.jpg</strong></a>
                            </li>
                        </ul>
                    </div>
                    <div id="previewImage" style="display: none;">
                    </div>
                </div>
                <div class="row mb-3" style="display: none">
                    <div class="card" style="width: 18rem;">
                        <div class="card-header">
                            <strong><i class="fas fa-share-alt"></i> Share Link</strong>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A//staging.skillsbd.com/home/course/gift-this-course-the-web-developer-bootcamp/1">Share on Facebook</a>

                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="card" style="width: 18rem;">
                        <div class="card-header">
                            <strong><i class="fas fa-external-link-alt"></i> Copy Link</strong>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                    <input type="text" class="form-control" value="<?php echo base_url() ?>home/certificate/<?php echo $my_certificate['certificate_code'] ?>">
                                    <em></em>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php else: ?>
<!-- certificate template -->
<section class="my-courses-area">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form action="<?php echo (site_url('home/get_certificate')) ?>" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                    <input type="hidden" name="course_id" value="<?php echo $this->uri->segment(3); ?>" >
                    <div class="form-group">
                        <label for="userName" class="text-dark">Course: </label>
                        <strong><?php echo $course_data['title']; ?></strong>
                        <input type="hidden" name="crs_title" class="form-control" value="<?php echo $course_data['title'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="userName" class="text-dark">Your Name</label>
                        <input type="text" name="std_name" class="form-control" value="<?php echo $student_data['first_name'].' '.$student_data['last_name']; ?>" readonly>
                        <small>If you have any correction in your name <a href="<?php echo (base_url('home/profile/user_profile')) ?>"><strong>click here</strong></a></small>
                    </div>
                    
                    <input type="hidden" name="certificate_code" value="<?php echo 'SBD'.'-'.random_string('alnum',6); ?>">
                    <div class="form-group">
                        <input type="submit" class="btn btn-warning" value="Get Certificate">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

 <script>
        $(document).ready(function () {
            var element = $("#html-content-holder"); // global variable
            var getCanvas; // global variable

            html2canvas(element, {
                onrendered: function (canvas) {
                    $("#previewImage").append(canvas);
                    getCanvas = canvas;
                }
            });

            $("#btn-Convert-Html2Image").on('click', function () {
                var imgageData = getCanvas.toDataURL("image/png");
                // Now browser starts downloading it instead of just showing it
                var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
                $("#btn-Convert-Html2Image").attr("download", "your_pic_name.png").attr("href", newData);
            });
        });
</script>