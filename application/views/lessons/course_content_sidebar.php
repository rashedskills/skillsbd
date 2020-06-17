<?php
$course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
?>
<div class="col-lg-3  order-md-2 course_col" id = "lesson_list_area">
  <div class="row">
   
    <div style="margin: 12px 25px;">
      <h5 class="float-right"><?php echo get_phrase('course_content'); ?></h5>
    </div>    
    <?php
      date_default_timezone_set("Asia/Dhaka");
      $originalEndDate = $course_details['end_date'];
      $endDate = strtotime($originalEndDate. ' +1 day'); 
      date_default_timezone_set("Asia/Dhaka");
      $todayDate = strtotime("now");
    if($endDate >= $todayDate && $course_details['course_type'] == 'Live'): ?>
    <div class="float-right" style="margin: 12px 0px;">
      <strong ><a class="text-danger" href="" data-toggle="modal" data-target="#liveModal"><i class="fas fa-video"></i> <?php echo get_phrase('live_class_here'); ?></a></strong>
    </div>
   <?php endif; ?>
  </div>  
  <div class="accordion" id="accordionExample">
    <?php
    foreach ($sections as $key => $section):
      $lessons = $this->crud_model->get_lessons('section', $section['id'])->result_array();?>
      <div class="card" style="margin:0px 0px;">
        <div class="card-header course_card" id="<?php echo 'heading-'.$section['id']; ?>">

          <h5 class="mb-0">
            <button class="btn btn-link w-100 text-left" type="button" data-toggle="collapse" data-target="<?php echo '#collapse-'.$section['id']; ?>" <?php if($opened_section_id == $section['id']): ?> aria-expanded="true" <?php else: ?> aria-expanded="false" <?php endif; ?> aria-controls="<?php echo 'collapse-'.$section['id']; ?>" style="color: #535a66; background: none; border: none; white-space: normal;" onclick = "toggleAccordionIcon(this, '<?php echo $section['id']; ?>')">
              <h6 style="color: #959aa2; font-size: 13px;">
                <?php echo get_phrase('section').' '.($key+1);?>
                <span style="float: right; font-weight: 100;" class="accordion_icon" id="accordion_icon_<?php echo $section['id']; ?>">
                  <?php if($opened_section_id == $section['id']): ?>
                    <i class="fa fa-minus"></i>
                  <?php else: ?>
                    <i class="fa fa-plus"></i>
                  <?php endif; ?>
                </span>
              </h6>
              <?php echo $section['title']; ?>
            </button>
          </h5>
        </div>

        <div id="<?php echo 'collapse-'.$section['id']; ?>" class="collapse <?php if($section_id == $section['id']) echo 'show'; ?>" aria-labelledby="<?php echo 'heading-'.$section['id']; ?>" data-parent="#accordionExample">
          <div class="card-body"  style="padding:0px;">
            <table style="width: 100%;">
              <?php foreach ($lessons as $key => $lesson): ?>

                <tr style="width: 100%; padding: 5px 0px;background-color: <?php if ($lesson_id == $lesson['id'])echo '#E6F2F5'; else echo '#fff';?>;">
                <td style="text-align: left; padding:7px 10px;">
                  <?php
                    $lesson_progress = lesson_progress($lesson['id']);
                   ?>
                  <div class="form-group">
                    <input type="checkbox" id="<?php echo $lesson['id']; ?>" onchange="markThisLessonAsCompleted(this.id);" value = 1 <?php if($lesson_progress == 1):?> checked <?php endif; ?>>
                    <label for="<?php echo $lesson['id']; ?>"></label>
                  </div>

                  <a href="<?php echo site_url('home/lesson/'.slugify($course_details['title']).'/'.$course_id.'/'.$lesson['id']); ?>" id = "<?php echo $lesson['id']; ?>" style="color: #444549;font-size: 14px;font-weight: 400;">
                    <?php echo $key+1; ?>:
                    <?php if ($lesson['lesson_type'] != 'other'):?>
                      <?php echo $lesson['title']; ?>
                    <?php else: ?>
                      <?php echo $lesson['title']; ?>
                      <!-- <i class="fa fa-paperclip"></i> -->
                    <?php endif; ?>
                  </a>

                  <div class="lesson_duration">
                    <?php if ($lesson['lesson_type'] == 'video' || $lesson['lesson_type'] == '' || $lesson['lesson_type'] == NULL): ?>
                      <?php //echo $lesson['duration']; ?>
                      <i class="far fa-play-circle"></i>
                      <?php echo readable_time_for_humans($lesson['duration']); ?>
                    <?php elseif($lesson['lesson_type'] == 'quiz'): ?>
                      <i class="far fa-question-circle"></i> <?php echo get_phrase('quiz'); ?>
                    <?php else:
                      $tmp           = explode('.', $lesson['attachment']);
                      $fileExtension = strtolower(end($tmp));?>

                      <?php if ($fileExtension == 'jpg' || $fileExtension == 'jpeg' || $fileExtension == 'png' || $fileExtension == 'bmp' || $fileExtension == 'svg'): ?>
                        <i class="fas fa-camera-retro"></i>  <?php echo get_phrase('attachment'); ?>
                      <?php elseif($fileExtension == 'pdf'): ?>
                        <i class="far fa-file-pdf"></i>  <?php echo get_phrase('attachment'); ?>
                      <?php elseif($fileExtension == 'doc' || $fileExtension == 'docx'): ?>
                        <i class="far fa-file-word"></i>  <?php echo get_phrase('attachment'); ?>
                      <?php elseif($fileExtension == 'txt'): ?>
                        <i class="far fa-file-alt"></i>  <?php echo get_phrase('attachment'); ?>
                      <?php else: ?>
                        <i class="fa fa-file"></i>  <?php echo get_phrase('attachment'); ?>
                      <?php endif; ?>

                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </table>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
</div>
<script type="text/javascript">
function toggleAccordionIcon(elem, section_id) {
  var accordion_section_ids = [];
  $(".accordion_icon").each(function(){ accordion_section_ids.push(this.id); });
  accordion_section_ids.forEach(function(item) {
    if (item === 'accordion_icon_'+section_id) {
      if ($('#'+item).html().trim() === '<i class="fa fa-plus"></i>') {
        $('#'+item).html('<i class="fa fa-minus"></i>')
      }else {
        $('#'+item).html('<i class="fa fa-plus"></i>')
      }
    }else{
      $('#'+item).html('<i class="fa fa-plus"></i>')
    }
  });
}
</script>
