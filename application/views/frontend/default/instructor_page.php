<?php
$instructor_details = $this->user_model->get_all_user($instructor_id)->row_array();
$social_links  = json_decode($instructor_details['social_links'], true);
$course_ids = $this->crud_model->get_instructor_wise_courses($instructor_id, 'simple_array');
?>
<section class="instructor-header-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="instructor-name">
                <?php
                if($instructor_details['is_institute'] == 1){
                    echo $instructor_details['institute_name'];
                } else{
                    echo $instructor_details['first_name'].' '.$instructor_details['last_name'];
                }
                 ?></h1>
                <h2 class="instructor-title"><?php echo $instructor_details['title']; ?></h2>
            </div>
        </div>
    </div>
</section>

<section class="instructor-details-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="instructor-left-box text-center">
                    <div class="instructor-image">
                        <img src="<?php echo $this->user_model->get_user_image_url($instructor_details['id']);?>" alt="" class="img-fluid">
                    </div>
                    <div class="instructor-social">
                        <ul>
                            <li><a href="<?php echo $social_links['twitter']; ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="<?php echo $social_links['facebook']; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="<?php echo $social_links['linkedin']; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="instructor-right-box">

                    <div class="biography-content-box view-more-parent">
                        <!-- <div class="view-more" onclick="viewMore(this,'hide')"><b><?php echo get_phrase('show_full_biography'); ?></b></div> -->
                        <div class="biography-content">
                        <?php if($instructor_details['is_institute'] == 1){ ?>
                         <h5><strong><?php echo get_phrase('about_institute') ?></strong></h5>
                         <?php } ?>
                            <?php echo $instructor_details['biography']; ?>
                        </div>
                        <?php if($instructor_details['is_institute'] == 1){ ?>
                            <ul class="list-unstyled">
                            <li><i class="fas fa-at"></i> <strong style="color: #555555">E-mail</strong>: <?php echo $instructor_details['institute_email'] ?></li>
                            <li><i class="fas fa-phone"></i> <strong style="color: #555555">Phone</strong>: <?php echo $instructor_details['institute_phone'] ?></li>
                            <li><i class="fas fa-map-marker-alt"></i> <strong style="color: #555555">Location</strong>: <?php echo $instructor_details['institute_address'] ?></li>
                        </ul>
                        <?php } ?>
                        
                    </div>

                    <div class="instructor-stat-box">
                        <ul>
                            <li>
                                <div class="small"><?php echo get_phrase('total_student'); ?></div>
                                <div class="num">
                                    <?php
                                    $this->db->select('user_id');
                                    $this->db->distinct();
                                    $this->db->where_in('course_id', $course_ids);
                                    echo $this->db->get('enrol')->num_rows();?>
                                </div>
                            </li>
                            <li>
                                <div class="small"><?php echo get_phrase('courses'); ?></div>
                                <div class="num"><?php echo sizeof($course_ids); ?></div>
                            </li>
                            <li>
                                <div class="small"><?php echo get_phrase('reviews'); ?></div>
                                <div class="num"><?php echo $this->crud_model->get_instructor_wise_course_ratings($instructor_id, 'course')->num_rows(); ?></div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
