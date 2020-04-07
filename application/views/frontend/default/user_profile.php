<?php
    $social_links = json_decode($user_details['social_links'], true);
 ?>
 <section class="page-header-area my-course-area">
     <div class="container">
         <div class="row">
             <div class="col">
                 <h1 class="page-title"><?php echo get_phrase('profile'); ?></h1>
                 <ul>
                     <li><a href="<?php echo site_url('home/my_courses'); ?>"><?php echo get_phrase('all_courses'); ?></a></li>
                     <li><a href="<?php echo site_url('home/my_wishlist'); ?>"><?php echo get_phrase('wishlists'); ?></a></li>
                     <li><a href="<?php echo site_url('home/my_messages'); ?>"><?php echo get_phrase('my_messages'); ?></a></li>
                     <li><a href="<?php echo site_url('home/purchase_history'); ?>"><?php echo get_phrase('purchase_history'); ?></a></li>
                     <li><a href="<?php echo site_url('home/order_history'); ?>"><?php echo get_phrase('my_order'); ?></a></li>
                     <li class="active"><a href=""><?php echo get_phrase('user_profile'); ?></a></li>
                 </ul>
             </div>
         </div>
     </div>
 </section>

<section class="user-dashboard-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="user-dashboard-box">
                    <div class="user-dashboard-sidebar">
                        <div class="user-box">
                            <?php
                                $filename = 'uploads/user_image/'.$this->session->userdata('user_id').'.jpg';

                                if (file_exists($filename)) { ?>
                                    <img src="<?php echo base_url().'uploads/user_image/'.$this->session->userdata('user_id').'.jpg';?>" alt="" class="img-fluid">
                                <?php } else { ?>
                                    <img src="<?php echo 'https://skillsbd.s3.ap-south-1.amazonaws.com/user_image/'.$this->session->userdata('user_id').'.jpg';?>" alt="" class="img-fluid">
                               <?php }
                            ?> 
                            <div class="name">
                                <div class="name"><?php echo $user_details['first_name'].' '.$user_details['last_name']; ?></div>
                            </div>
                        </div>
                        <div class="user-dashboard-menu">
                            <ul>
                                <li class="active"><a href="<?php echo site_url('home/profile/user_profile'); ?>"><?php echo get_phrase('profile'); ?></a></li>
                                <li><a href="<?php echo site_url('home/profile/user_credentials'); ?>"><?php echo get_phrase('account'); ?></a></li>
                                <li><a href="<?php echo site_url('home/profile/user_photo'); ?>"><?php echo get_phrase('photo_/_Logo'); ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="user-dashboard-content">
                        <div class="content-title-box">
                            <div class="title"><?php echo get_phrase('profile'); ?></div>
                            <div class="subtitle"><?php echo get_phrase('add_information_about_yourself_or_your_institute_to_share_on_your_profile'); ?>.</div>
                        </div>
                        <form action="<?php echo site_url('home/update_profile/update_basics'); ?>" method="post">
                            <div class="content-box">
                                <div class="basic-group">
                                    <div class="form-group">
                                        <label for="FristName"><?php echo get_phrase('basics'); ?>:</label>
                                        <input type="text" class="form-control" name = "first_name" id="FristName" placeholder="<?php echo get_phrase('first_name'); ?>" value="<?php echo $user_details['first_name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name = "last_name" placeholder="<?php echo get_phrase('last_name'); ?>" value="<?php echo $user_details['last_name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="Phone"><?php echo get_phrase('mobile_number'); ?>:</label>
                                        <input type="number" class="form-control" name = "phone" placeholder="<?php echo get_phrase('mobile_number'); ?>" value="<?php echo $user_details['phone']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="Biography"><?php echo get_phrase('biography_about_you_or_your_institute'); ?>:</label>
                                        <textarea class="form-control author-biography-editor" name = "biography" id="Biography"><?php echo $user_details['biography']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="Institiute" class="text-dark"><strong><?php echo get_phrase('do_you_have_any_training_institute?'); ?></strong>:</label>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" id="yesCheck" onclick="yesnoCheck();" type="radio" name="is_institute" value="1" <?php if($user_details['is_institute'] == "1") echo 'checked'; ?>>
                                            <label class="form-check-label text-dark" for="inlineRadio1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_institute" id="infoInsHide" onclick="yesnoCheck();" value="0" <?php if($user_details['is_institute'] == "0") echo 'checked'; ?>>
                                            <label class="form-check-label text-dark" for="inlineRadio2">Not yet</label>
                                        </div>
                                    </div>                                    
                                </div>
                                <style>
                                .hideInstitute{
                                    display: none;
                                }
                                </style>
                                <div class="<?php echo $user_details['is_institute'] == "0" ? 'hideInstitute' : ''; ?>" id="ifYes">
                                    <div class="form-group">
                                        <label for="instituteName"><?php echo get_phrase('institute_name'); ?>:</label>
                                        <input type="text" class="form-control" name = "institute_name" placeholder="<?php echo get_phrase('institute_name'); ?>" value="<?php echo $user_details['institute_name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="instituteEmail"><?php echo get_phrase('institute_official_email'); ?>:</label>
                                        <input type="email" class="form-control" name = "institute_email" placeholder="<?php echo get_phrase('institute_official_email'); ?>" value="<?php echo $user_details['institute_email']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="institutePhoneNumber"><?php echo get_phrase('institute_phone_number'); ?>:</label>
                                        <input type="text" class="form-control" name = "institute_phone" placeholder="<?php echo get_phrase('institute_phone'); ?>" value="<?php echo $user_details['institute_phone']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="instituteAddress"><?php echo get_phrase('institute_present_address'); ?>:</label>
                                        <input type="text" class="form-control" name = "institute_address" placeholder="<?php echo get_phrase('institute_address'); ?>" value="<?php echo $user_details['institute_address']; ?>">
                                    </div>
                                </div>
                                <div class="link-group">
                                    <div class="form-group">
                                        <input type="text" class="form-control" maxlength="60" name = "twitter_link" placeholder="<?php echo get_phrase('twitter_link'); ?>" value="<?php echo $social_links['twitter']; ?>">
                                        <small class="form-text text-muted"><?php echo get_phrase('add_twitter_link'); ?>.</small>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" maxlength="60" name = "facebook_link" placeholder="<?php echo get_phrase('facebook_link'); ?>" value="<?php echo $social_links['facebook']; ?>">
                                        <small class="form-text text-muted"><?php echo get_phrase('add_facebook_link'); ?>.</small>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" maxlength="60" name = "linkedin_link" placeholder="<?php echo get_phrase('linkedin_link'); ?>" value="<?php echo $social_links['linkedin']; ?>">
                                        <small class="form-text text-muted"><?php echo get_phrase('add_linkedin_link'); ?>.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="content-update-box">
                                <button type="submit" class="btn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
function yesnoCheck() {
        if (document.getElementById('yesCheck').checked) {
           document.getElementById('ifYes').style.display = 'block';           
        } else {
           document.getElementById('ifYes').style.display = 'none';
        }
    }
</script>
