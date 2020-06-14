<?php
    $course_details = $this->crud_model->get_course_by_id($param3)->row_array();
    $section_details = $this->crud_model->get_section('section', $param2)->row_array();
?>
<form action="<?php echo site_url('user/sections/'.$param3.'/edit/'.$param2); ?>" method="post">
    <div class="form-group">
        <label for="title"><?php echo get_phrase('title'); ?></label>
        <input class="form-control" type="text" name="title" id="title" value="<?php echo $section_details['title']; ?>" required>
        <small class="text-muted"><?php echo get_phrase('provide_a_section_name'); ?></small>
    </div>
    <div class="form-group">
        <label><?php echo get_phrase('details'); ?></label>
        <textarea rows="4" class="form-control" name="details" id="topics" placeholder="goal, skills, objective, topic">
            <?php echo $section_details['details']; ?>
        </textarea>
    </div>
    <div class="text-right">
        <button class = "btn btn-success" type="submit" name="button"><?php echo get_phrase('submit'); ?></button>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function () {
    initSummerNote(['#topics']);
    });
</script>
