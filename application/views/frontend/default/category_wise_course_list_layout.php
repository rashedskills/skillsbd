<ul>

    <?php foreach($courses as $course):
     $instructor_details = $this->user_model->get_all_user($course['user_id'])->row_array();?>
    <li>
        <div class="course-box-2">
            <div class="course-image">
                <a href="<?php echo site_url('home/course/'.slugify($course['title']).'/'.$course['id']) ?>">
                    <img src="<?php echo $this->crud_model->get_course_thumbnail_url($course['id']); ?>" alt="" class="img-fluid">
                </a>
            </div>
            <div class="course-details">
                <a href="<?php echo site_url('home/course/'.slugify($course['title']).'/'.$course['id']); ?>" class="course-title"><?php echo $course['title']; ?></a>
                <i class="course-subtitle">
                    <?php
                        if($course['course_type'] == 'Workshop'){
                            echo 'Workshop';
                        } 
                        else {
                            echo $course['course_type'].' '.'course';
                        }
                    ?>
                </i>
                <!-- <a href="<?php echo site_url('home/instructor_page/'.$instructor_details['id']) ?>" class="course-instructor">
                    <span class="instructor-name"><?php echo $instructor_details['first_name'].' '.$instructor_details['last_name']; ?></span> -
                </a> -->
                
                <div class="course-subtitle mt-1">
                    <?php echo $course['short_description']; ?>
                </div>
                <?php if($course['course_type'] == 'Classroom' || $course['course_type'] == 'Workshop' ): ?>
                    <div class="course-meta">                    
                    <span class="" data-toggle="tooltip" data-placement="top" title="Class time"><i class="far fa-clock"></i>
                        <?php echo $course['duration'] ?>
                    </span>
                    <span class="" data-toggle="tooltip" data-placement="top" title="Start Date"><i class="far fa-calendar-alt"></i>
                        <?php echo date('j M', $course['start_date']) ; ?>
                    </span>
                    <span class="" data-toggle="tooltip" data-placement="top" title="Level"><i class="fas fa-sliders-h"></i>
                        <?php echo ucfirst($course['level']).' Lavels'; ?>
                    </span>
                </div>
                <?php else: ?>
                <div class="course-meta">
                    <span class=""><i class="fas fa-play-circle"></i>
                        <?php
                            $number_of_lessons = $this->crud_model->get_lessons('course', $course['id'])->num_rows();
                            echo $number_of_lessons.' '.get_phrase('lessons');
                         ?>
                    </span>
                    <span class=""><i class="far fa-clock"></i>
                        <?php echo $this->crud_model->get_total_duration_of_lesson_by_course_id($course['id']); ?>
                    </span>
                    
                    <span class="" data-toggle="tooltip" data-placement="top" title="Level"><i class="fas fa-sliders-h"></i><?php echo ucfirst($course['level']).' Lavels'; ?></span>
                </div>
                <?php endif; ?>
            </div>
            <div class="course-price-rating">
                <div class="course-price">
                    <?php if ($course['is_free_course'] == 1): ?>
                        <span class="current-price"><?php echo get_phrase('free'); ?></span>
                    <?php else: ?>
                        <?php if($course['discount_flag'] == 1): ?>
                            <span class="current-price"><?php echo currency($course['discounted_price']); ?></span>
                            <span class="original-price"><?php echo currency($course['price']); ?></span>
                        <?php else: ?>
                            <span class="current-price"><?php echo currency($course['price']); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="rating">
                    <?php
                        $total_rating =  $this->crud_model->get_ratings('course', $course['id'], true)->row()->rating;
                        $number_of_ratings = $this->crud_model->get_ratings('course', $course['id'])->num_rows();
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
                <div class="rating-number">
                    <?php echo $this->crud_model->get_ratings('course', $course['id'])->num_rows().' '.get_phrase('ratings'); ?>
                </div>
            </div>
        </div>
    </li>
<?php endforeach; ?>
</ul>
