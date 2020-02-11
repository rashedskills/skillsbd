
<div class="row ">
    <div class="col-md-10 col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-user title_icon text-center"></i> <?php echo get_phrase('instructor_edit'); ?></h4>
                <hr>
                <div class="d-flex justify-content-center">
                    <div class="col-md-8">
                        <form action="<?php echo site_url('user/instructor_update/'.$instructor_info['id']) ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="user_id" class="form-control" id="" value="<?php echo $this->session->userdata('user_id'); ?>">
                            <div class="form-group">
                                <label for="fullName" class="text-dark"><?php echo get_phrase('instructor_full_name'); ?></label>
                                <input type="text" name="instructor_full_name" class="form-control" id="fullName" required value="<?php echo $instructor_info['instructor_full_name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="specialist" class="text-dark"><?php echo get_phrase('specialist_area'); ?></label>
                                <input type="text" name="specialist_in" placeholder="<?php echo get_phrase('Exp: Chief Technical Office'); ?>" class="form-control" id="specialist" value="<?php echo $instructor_info['specialist_in']; ?>"> 
                            </div>
                            <div class="form-group">
                                <label for="Biography" class="text-dark"><?php echo get_phrase('biography_about_instructor'); ?>:</label>
                                <textarea class="form-control author-biography-editor" rows="10" name = "instructor_biography" id="Biography" required><?php echo $instructor_info['instructor_biography']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="linkedinLink" class="text-dark"><?php echo get_phrase('linkedin_profile_link'); ?></label>
                                <input type="text" name="linkedin_link" class="form-control" id="linkedinLink" value="<?php echo $instructor_info['linkedin_link']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="instructorPhoto" class="text-dark"><?php echo get_phrase('instructor_photo'); ?></label>
                                <input type="file" name="instructor_photo" class="form-control-file" id="instructorPhoto" value="<?php echo $instructor_info['instructor_photo']; ?>">
                                <small id="photoHelp" class="form-text text-danger">Photo must be JPG, PNG, JPEG format and maximize filesize 256kb.</small>
                            </div>
                            <button type="submit" class="btn btn-warning">Update</button>
                        </form>
                    </div>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>