<section class="home-banner-area">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <div class="home-banner-wrap">
                    <h2 class="mb-5"><?php echo get_frontend_settings('banner_title'); ?></h2>
                    <!-- <p><?php echo get_frontend_settings('banner_sub_title'); ?></p> -->
                    <form class="" action="<?php echo site_url('home/search'); ?>" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" name = "query" placeholder="<?php echo get_phrase('enter_course,_category_or_keyword'); ?>">
                            <div class="input-group-append">
                                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    <p  class="mt-4">Download student learning app <img src="https://skillsbd.s3.ap-south-1.amazonaws.com/system/playstore_img.png" alt="playstore-img" width="130"></p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="course-carousel-area mt-5">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <h2 class="course-carousel-title"><?php echo get_phrase('trending_courses'); ?></h2>                
                <div class="course-carousel">
                    <?php $top_courses = $this->crud_model->get_top_courses()->result_array();
                    $cart_items = $this->session->userdata('cart_items');
                    foreach ($top_courses as $top_course):?>
                    <div class="course-box-wrap">
                        <a href="<?php echo site_url('home/course/'.slugify($top_course['title']).'/'.$top_course['id']); ?>" class="has-popover">
                            <div class="course-box">
                                <!-- <div class="course-badge position best-seller">Best seller</div> -->
                                <div class="course-image">                                    
                                    <?php if(file_exists('uploads/thumbnails/course_thumbnails/'.'course_thumbnail'.'_'.get_frontend_settings('theme').'_'.$top_course['id'].'.jpg')): ?>
                                    <img src="<?php echo $this->crud_model->get_course_thumbnail_url($top_course['id']); ?>" 
                                    alt="<?php echo $top_course['title'] ?>" class="img-fluid">
                                    <?php else: ?> 
                                    <img src="<?php echo 'https://skillsbd.s3.ap-south-1.amazonaws.com/thumbnails/course_thumbnails/'.'course_thumbnail'.'_'.get_frontend_settings('theme').'_'.$top_course['id'].'.jpg' ?>"
                                    alt="<?php echo $top_course['title'] ?>" class="img-fluid">
                                   <?php endif; ?>
                                </div>
                                <div class="course-details">
                                    <h5 class="title"><?php echo $top_course['title']; ?></h5>
                                    <p class="instructors"><?php echo $top_course['short_description']; ?></p>
                                    <div class="rating">
                                        <?php
                                        $total_rating =  $this->crud_model->get_ratings('course', $top_course['id'], true)->row()->rating;
                                        $number_of_ratings = $this->crud_model->get_ratings('course', $top_course['id'])->num_rows();
                                        if ($number_of_ratings > 0) {
                                            $average_ceil_rating = ceil($total_rating / $number_of_ratings);
                                        }else {
                                            $average_ceil_rating = 0;
                                        }

                                        for($i = 1; $i < 6; $i++):?>
                                        <?php if ($i <= $average_ceil_rating): ?>
                                            <i class="fas fa-star filled"></i>
                                        <?php else: ?>
                                            <i class="fas fa-star"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    <span class="d-inline-block average-rating"><?php echo $average_ceil_rating; ?></span>
                                </div>
                               <!--  <?php if ($top_course['is_free_course'] == 1): ?>
                                    <p class="price text-right"><?php echo get_phrase('free'); ?></p>
                                <?php else: ?>
                                    <?php if ($top_course['discount_flag'] == 1): ?>
                                        <p class="price text-right"><small><?php echo currency($top_course['price']); ?></small><?php echo currency($top_course['discounted_price']); ?></p>
                                    <?php else: ?>
                                        <p class="price text-right"><?php echo currency($top_course['price']); ?></p>
                                    <?php endif; ?>
                                <?php endif; ?> -->
                            </div>
                        </div>
                    </a>

                    <div class="webui-popover-content">
                        <div class="course-popover-content">
                            <?php $classRoom = $top_course['course_type']; ?>
                            <?php if($classRoom == 'Classroom' || $classRoom == 'Workshop'): ?>
                                <div class="last-updated"><?php echo get_phrase('class_start_date:').' '.date('D, d-M-Y', strtotime($top_course['start_date'])); ?></div>
                            <?php else: ?>
                            <?php if ($top_course['last_modified'] == ""): ?>
                                <div class="last-updated"><?php echo get_phrase('last_updater').' '.date('D, d-M-Y', $top_course['date_added']); ?></div>
                            <?php else: ?>
                                <div class="last-updated"><?php echo get_phrase('last_updater').' '.date('D, d-M-Y', $top_course['last_modified']); ?></div>
                            <?php endif; ?>
                            <?php endif; ?>
                            <div class="course-title">
                                <a href="<?php echo site_url('home/course/'.slugify($top_course['title']).'/'.$top_course['id']); ?>"><?php echo $top_course['title']; ?></a>
                            </div>
                            <!-- for online course -->
                            <?php
                            $classRoom = $top_course['course_type'];
                            if($classRoom == 'Classroom' || $classRoom == 'Workshop'): ?>
                                <div class="course-meta">
                                <span class=""><i class="fas fa-clock"></i>
                                
                                    <?php echo $top_course['duration']; ?>
                                </span>
                                <span class=""><i class="fas fa-clock"></i>
                                    <?php                                    
                                        echo $top_course['total_hours'].' '.get_phrase('hours');
                                    ?>
                                </span>
                                <span class=""><i class="fas fa-list"></i><?php echo $top_course['level']; ?></span>
                            </div>
                            <?php else: ?>
                            <div class="course-meta">
                                <span class=""><i class="fas fa-play-circle"></i>
                                    <?php echo $this->crud_model->get_lessons('course', $top_course['id'])->num_rows().' '.get_phrase('lessons'); ?>
                                </span>
                                <span class=""><i class="far fa-clock"></i>
                                    <?php
                                    $total_duration = 0;
                                    $lessons = $this->crud_model->get_lessons('course', $top_course['id'])->result_array();
                                    foreach ($lessons as $lesson) {
                                        if ($lesson['lesson_type'] != "other") {
                                            $time_array = explode(':', $lesson['duration']);
                                            $hour_to_seconds = $time_array[0] * 60 * 60;
                                            $minute_to_seconds = $time_array[1] * 60;
                                            $seconds = $time_array[2];
                                            $total_duration += $hour_to_seconds + $minute_to_seconds + $seconds;
                                        }
                                    }
                                    echo gmdate("H:i:s", $total_duration).' '.get_phrase('hours');
                                    ?>
                                </span>
                                <span class=""><i class="fas fa-list"></i><?php echo $top_course['level']; ?></span>
                            </div>
                                <?php endif; ?>
                            <!-- end online course -->
                            <div class="course-subtitle"><?php echo $top_course['short_description']; ?></div>
                            <div class="what-will-learn">
                                <ul>
                                    <?php
                                    $outcomes = json_decode($top_course['outcomes']);
                                    foreach ($outcomes as $outcome):?>
                                    <li><?php echo $outcome; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="popover-btns">
                            <?php if (is_purchased($top_course['id'])): ?>
                                <div class="purchased">
                                    <a href="<?php echo site_url('home/my_courses'); ?>"><?php echo get_phrase('already_enrolled'); ?></a>
                                </div>
                            <?php else: ?>
                                <?php if ($top_course['is_free_course'] == 1):
                                    if($this->session->userdata('user_login') != 1) {
                                        $url = "#";
                                    }else {
                                        $url = site_url('home/get_enrolled_to_free_course/'.$top_course['id']);
                                    }?>
                                    <a href="<?php echo $url; ?>" class="btn add-to-cart-btn big-cart-button" onclick="handleEnrolledButton()"><?php echo get_phrase('get_enrolled'); ?></a>
                                    <?php elseif ($top_course['course_type'] == 'Classroom' || $top_course['course_type'] == 'Workshop'): ?>
                                    <a href = "<?php echo site_url('home/get_enrolled_to_classroom_course/'.$top_course['id']); ?>" class="btn btn-buy-now"><?php echo get_phrase('register'); ?></a>
                                     <button type="button" class="wishlist-btn <?php if($this->crud_model->is_added_to_wishlist($top_course['id'])) echo 'active'; ?>" title="Add to wishlist" onclick="handleWishList(this)" id = "<?php echo $top_course['id']; ?>"><i class="fas fa-heart"></i></button>
                                <!-- paid course -->
                                <?php else: ?>
                                    <button type="button" class="btn add-to-cart-btn <?php if(in_array($top_course['id'], $cart_items)) echo 'addedToCart'; ?> big-cart-button-<?php echo $top_course['id'];?>" id = "<?php echo $top_course['id']; ?>" onclick="handleCartItems(this)">
                                        <?php
                                        if(in_array($top_course['id'], $cart_items))
                                        echo get_phrase('added_to_cart');
                                        else
                                        echo get_phrase('add_to_cart');
                                        ?>
                                    </button>
                                    <button type="button" class="wishlist-btn <?php if($this->crud_model->is_added_to_wishlist($top_course['id'])) echo 'active'; ?>" title="Add to wishlist" onclick="handleWishList(this)" id = "<?php echo $top_course['id']; ?>"><i class="fas fa-heart"></i></button>
                                <?php endif; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>
</div>
</section>

<!-- top 10 courses -->
<section class="course-carousel-area">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <h2 class="course-carousel-title"><?php echo get_phrase('latest_courses'); ?></h2>
                <div class="course-carousel">
                    <?php
                    $latest_courses = $this->crud_model->get_latest_10_course();
                    foreach ($latest_courses as $latest_course):?>
                    <div class="course-box-wrap">
                        <a href="<?php echo site_url('home/course/'.slugify($latest_course['title']).'/'.$latest_course['id']); ?>">
                            <div class="course-box">
                                <div class="course-image">                                    
                                    <?php if(file_exists('uploads/thumbnails/course_thumbnails/'.'course_thumbnail'.'_'.get_frontend_settings('theme').'_'.$latest_course['id'].'.jpg')): ?>
                                    <img src="<?php echo $this->crud_model->get_course_thumbnail_url($latest_course['id']); ?>"
                                    alt="<?php echo $latest_course['title'] ?>" class="img-fluid">
                                    <?php else: ?> 
                                    <img src="<?php echo 'https://skillsbd.s3.ap-south-1.amazonaws.com/thumbnails/course_thumbnails/'.'course_thumbnail'.'_'.get_frontend_settings('theme').'_'.$latest_course['id'].'.jpg' ?>"
                                    alt="<?php echo $latest_course['title'] ?>" class="img-fluid">
                                   <?php endif; ?>
                                </div>
                                <div class="course-details">
                                    <h5 class="title"><?php echo $latest_course['title']; ?></h5>
                                    <p class="instructors">
                                        <?php
                                        $instructor_details = $this->user_model->get_all_user($latest_course['user_id'])->row_array();
                                        echo $instructor_details['first_name'].' '.$instructor_details['last_name']; ?>
                                    </p>
                                    <div class="rating">
                                        <?php
                                        $total_rating =  $this->crud_model->get_ratings('course', $latest_course['id'], true)->row()->rating;
                                        $number_of_ratings = $this->crud_model->get_ratings('course', $latest_course['id'])->num_rows();
                                        if ($number_of_ratings > 0) {
                                            $average_ceil_rating = ceil($total_rating / $number_of_ratings);
                                        }else {
                                            $average_ceil_rating = 0;
                                        }

                                        for($i = 1; $i < 6; $i++):?>
                                        <?php if ($i <= $average_ceil_rating): ?>
                                            <i class="fas fa-star filled"></i>
                                        <?php else: ?>
                                            <i class="fas fa-star"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    <span class="d-inline-block average-rating"><?php echo $average_ceil_rating; ?></span>
                                </div>
                                <!-- <?php if ($latest_course['is_free_course'] == 1): ?>
                                    <p class="price text-right"><?php echo get_phrase('free'); ?></p>
                                <?php else: ?>
                                    <?php if ($latest_course['discount_flag'] == 1): ?>
                                        <p class="price text-right"><small><?php echo currency($latest_course['price']); ?></small><?php echo currency($latest_course['discounted_price']); ?></p>
                                    <?php else: ?>
                                        <p class="price text-right"><?php echo currency($latest_course['price']); ?></p>
                                    <?php endif; ?>
                                <?php endif; ?> -->
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</div>
</section>
<div class="mb-5"></div>
<section class="mb-5 py-5 why-choose-us">
<div class="container-lg">
    <div class="row mb-5 mt-2">
        <div class="col">
                <h3 class="text-left">Why Choose Skillsbd.com courses...</h3>
        </div>
    </div>      
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="d-flex justify-content-center">
                <div class="col-md-10 col-sm-12">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12 advantage">
                            <img src="assets/frontend/default/img/messaing_skillsbd.png" alt="messaging_skillsbd" class="img-fluid">
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 my-auto text-box">
                            <h4 class="mb-3">Messaging with instructor</h4>                          
                            <p class="">For necessary discoussion on course lessons, students can contact with instructors directly through internal messaging system</p>
                        </div>
                    </div>
                </div>                          
            </div>
        </div>
        <div class="carousel-item">
            <div class="d-flex justify-content-center">
                <div class="col-md-10 col-sm-12">
                    <div class="row">                
                        <div class="col-md-6 col-lg-6 col-sm-12 my-auto text-box ">
                            <h4 class="mb-3">Quiz for students</h4>                          
                            <p class="">Students can take quizzes to justify thier learning status. They can take over those quizzes any number of times.</p>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 advantage">
                            <img src="assets/frontend/default/img/quiz_and_assignment_skillsbd.png" alt="messaging_skillsbd" class="img-fluid">
                        </div>
                    </div>
                </div>                          
            </div>
        </div>
        <div class="carousel-item">
            <div class="d-flex justify-content-center">
                <div class="col-md-10 col-sm-12">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12 advantage">
                            <img src="assets/frontend/default/img/course-rating-and -review.png" alt="course_video_player_skillsbd" class="img-fluid">
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 my-auto text-box">
                            <h4 class="mb-3">Course progress followup, Review course</h4>                          
                            <p class="mb-2">Cpmpletion progess can be tracked individually for each course of every students.</p>
                            <p class="">Also students can give rating, post review to every course they purchased.</p>
                        </div>
                    </div>
                </div>                          
            </div>
        </div>
        <div class="carousel-item">
            <div class="d-flex justify-content-center">
                <div class="col-md-10 col-sm-12">
                    <div class="row">                
                        <div class="col-md-6 col-lg-6 col-sm-12 my-auto text-box">
                            <h4 class="mb-3">Expert & Dedicated Educators</h4>                          
                            <p class="">In skillsbd.com, Educator's are specialist in their fields. Educator's has huge experience and friendly to communicate with students.</p>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 advantage">
                            <img src="assets/frontend/default/img/instructors-community.png" alt="instructor_skillsbd" class="img-fluid">
                        </div>
                    </div>
                </div>                          
            </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    
</div>
</section>
<!-- testimonial -->
<section class="mb-5 course-carousel-area testimonials">
    <div class="container-lg">
        <div class="row mb-5 mt-2">
            <div class="col">
                    <h3 class="text-left">What our learners have to say...</h3>         
            </div>
        </div>         
        <div class="row">
            <div class="col">
                <div class="student-say">
                    <?php
                      $ratings = $this->db->get_where('rating', array('rating' => 5))->result_array();
                      //print_r($ratings);exit();
                      foreach($ratings as $rating):
                    ?>
                    <div class="course-box-wrap">                        
                            <div class="card">
                            <div class="card-body">
                                <div class="rating mb-2">
                                  <?php
                                  for($i = 1; $i < 6; $i++):?>
                                  <?php if ($i <= $rating['rating']): ?>
                                    <i class="fas fa-star filled" style="color: #f5c85b;"></i>
                                      <?php else: ?>
                                        <i class="fas fa-star" style="color: #abb0bb;"></i>
                                      <?php endif; ?>
                                    <?php endfor; ?>
                                </div>                                                                    
                                <p class="card-text text-secondary">
                                    <?php echo $rating['review']; ?>
                                </p>
                                
                                <div class="row pt-3">
                                    <?php $color = "#" . substr(md5(microtime()),rand(0,26),6);; ?>
                                 <div id="testimonialImage" style="background: <?php echo $color; ?>">
                                        <?php

                                            $user_details = $this->user_model->get_user($rating['user_id'])->row_array();
                                            $social_links  = json_decode($user_details['social_links'], true);
                                            $linkedin = $social_links['linkedin'];
                                            $uname = $user_details['first_name'];                                       
                                            echo '<p>'.$uname[0].'</p>';
                                        ?>
                                    </div>
                                <strong class="float-left pl-3 pt-2 text-gray-dark">
                                    <?php                                        
                                        echo $user_details['first_name'].' '.$user_details['last_name'].' '.'<a class="ml-2" href="'.$linkedin.'" target="_blank" data-toggle="tooltip" data-placement="bottom" title="profile"><i class="fab fa-linkedin"></i></a>'; 
                                    ?>
                                </strong>
                            </div>
                            </div>
                            </div>                    
                    </div>
                    <?php endforeach; ?>
                </div>
                <!-- end student say ceraosul -->
            </div>
        </div>
    </div>
</section>
<section class="section-inspire py-5" style="">
    <div class="container-lg">
            <div class="row mb-5 mt-2">
                <div class="col">
                        <h3 class="text-left">Looking For Inspiration?</h3>         
                        <p class="text-left">Here's what's new and what's popular on skillsbd.com</p>          
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-lg-3 col-md-3 col-sm-6 mb-4">
                    <div class="hovereffect">
                        <img class="img-responsive rounded" src="assets/frontend/default/img/career-guide.jpg" alt="career guide for fresher in bangladesh">
                            <div class="overlay">
                                <h2>Workshop</h2>
                                <p>
                                    <a href="<?php echo base_url(); ?>home/courses?category=all&&price=all&&course_type=workshop&&level=all&&language=all&&rating=all">Veiw all courses</a>
                                </p>
                            </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-3 col-sm-6 mb-4">
                    <div class="hovereffect">
                        <img class="img-responsive" src="assets/frontend/default/img/online-course.jpg" alt="online course in bangaldesh">
                            <div class="overlay">
                                <h2>Online Learning</h2>
                                <p>
                                    <a href="<?php echo base_url(); ?>home/courses?category=all&&price=all&&course_type=online&&level=all&&language=all&&rating=all">Veiw all courses</a>
                                </p>
                            </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-3 col-sm-6 mb-4">
                    <div class="hovereffect">
                        <img class="img-responsive" src="assets/frontend/default/img/classroom-course.jpg" alt="classroom learning in bangladesh">
                            <div class="overlay">
                                <h2>Classroom Learning</h2>
                                <p>
                                    <a href="<?php echo base_url(); ?>home/courses?category=all&&price=all&&course_type=classroom&&level=all&&language=all&&rating=all">Veiw all courses</a>
                                </p>
                            </div>
                    </div>
                </div>                
                <div class="col-6 col-lg-3 col-md-3 col-sm-6 mb-4">
                    <div class="hovereffect">
                        <img class="img-responsive rounded" src="assets/frontend/default/img/free-course.jpg" alt="free learning in bangladesh">
                            <div class="overlay">
                                <h2>Free Learning</h2>
                                <p>
                                    <a href="<?php echo base_url(); ?>home/courses?category=all&&price=free&&course_type=all&&level=all&&language=all&&rating=all">Veiw all courses</a>
                                </p>
                            </div>
                    </div>
                </div>                
            </div>
    </div>                            
</section>

<script type="text/javascript">
function handleWishList(elem) {

    $.ajax({
        url: '<?php echo site_url('home/handleWishList');?>',
        type : 'POST',
        data : {course_id : elem.id},
        success: function(response)
        {
            if (!response) {
                window.location.replace("<?php echo site_url('login'); ?>");
            }else {
                if ($(elem).hasClass('active')) {
                    $(elem).removeClass('active')
                }else {
                    $(elem).addClass('active')
                }
                $('#wishlist_items').html(response);
            }
        }
    });
}

function handleCartItems(elem) {
    url1 = '<?php echo site_url('home/handleCartItems');?>';
    url2 = '<?php echo site_url('home/refreshWishList');?>';
    $.ajax({
        url: url1,
        type : 'POST',
        data : {course_id : elem.id},
        success: function(response)
        {
            $('#cart_items').html(response);
            if ($(elem).hasClass('addedToCart')) {
                $('.big-cart-button-'+elem.id).removeClass('addedToCart')
                $('.big-cart-button-'+elem.id).text("<?php echo get_phrase('add_to_cart'); ?>");
            }else {
                $('.big-cart-button-'+elem.id).addClass('addedToCart')
                $('.big-cart-button-'+elem.id).text("<?php echo get_phrase('added_to_cart'); ?>");
            }
            $.ajax({
                url: url2,
                type : 'POST',
                success: function(response)
                {
                    $('#wishlist_items').html(response);
                }
            });
        }
    });
}

function handleEnrolledButton() {
    $.ajax({
        url: '<?php echo site_url('home/isLoggedIn');?>',
        success: function(response)
        {
            if (!response) {
                window.location.replace("<?php echo site_url('login'); ?>");
            }
        }
    });
}

function random_bg_color() {
    var x = Math.floor(Math.random() * 256);
    var y = Math.floor(Math.random() * 256);
    var z = Math.floor(Math.random() * 256);
    var bgColor = "rgb(" + x + "," + y + "," + z + ")";
 //console.log(bgColor);
  
    document.getElementById('testimonialImage');
    }

random_bg_color();

</script>
