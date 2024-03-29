﻿<style>
.intructor-banner-area {
    background-image: url('./assets/backend/images/become-a-instructor-header-skillsbd.jpg');
    background-position: center center;
    background-size: cover;
    background-repeat: no-repeat;
    padding: 100px 0px 130px;
    color: #fff;
    margin-top: -22px;
}

.home-banner-wrap .btn {
    padding: 11px 30px 12px;
    font-size: 15px;
    background-color: #fbb034;
    background-image: linear-gradient(315deg, #fbb034 0%, #ffdd00 74%);
    border-color: 1px solid #fbb034;
    -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
  position: relative;
    border-radius: 2px;
    color: #36373c;
}
.home-banner-wrap .btn:hover{
    background-color: #ffb606;
    color: #36373c;
}
.info-link{
    text-decoration: underline;
}
</style>
<section class="intructor-banner-area mb-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="home-banner-wrap">
                    <h2 style="font-weight: normal">Teach on Skillsbd</h2>
                    <p>Create your class and share your skills with thousand of students today.</p>                    
                    <a class="btn" href="<?php echo site_url('home/login'); ?>">Become an Instructor</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="category-course-list-area">
    <div class="container py-3">
        <div class="row">
            <div class="col mb-3" style="padding: 35px;">
                <?php // echo get_frontend_settings('about_us'); ?>
                <h3 class="text-center">Why Teach on Skillsbd?</h3>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 col-sm-12 text-center">
                <i class="fas fa-hand-holding-usd mb-4" style="font-size: 3rem; color: #8991a5"></i>
                <h5 class="mb-2">Earn Money</h5>
                <p>Earn money every time a student purchases your course. Get paid monthly through bKash or Bank Account, it’s your choice.</p>
            </div>
            <div class="col-md-4 col-sm-12 text-center">
                <i class="fas fa-user-graduate mb-4" style="font-size: 3rem; color: #8991a5"></i>
                <h5 class="mb-2">Inspire students</h5>
                <p>Help people learn new skills, advance their careers, and explore their hobbies by sharing your knowledge.</p>
            </div>
            <div class="col-md-4 col-sm-12 text-center">
                <i class="fas fa-link mb-4" style="font-size: 3rem; color: #8991a5"></i>
                <h5 class="mb-2">Build your community</h5>
                <p>Take advantage of our platform and build your online community through your course creation process.</p>
            </div>
        </div>
    </div>
</section>

<section class="category-course-list-area" style="background-color: #36373c; color: #ffdd00">
    <div class="container py-5">
        <div class="row">
            <div class="col mb-4" style="padding: 35px;">
                <?php // echo get_frontend_settings('about_us'); ?>
                <h3 class="text-center">How Teaching Works</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 text-center">
                <i class="far fa-file-alt mb-4" style="font-size: 3rem;"></i>
                <h5>Plan your course</h5>
            </div>
            <div class="col-md-3 text-center">
                <i class="fas fa-chalkboard-teacher mb-4" style="font-size: 3rem;"></i>
                <h5>Create your first class</h5>
            </div>
            <div class="col-md-3 text-center">
                <i class="fas fa-users mb-4" style="font-size: 3rem;"></i>
                <h5>Build your following</h5>
            </div>
            <div class="col-md-3 text-center">
                <i class="fas fa-hand-holding-usd mb-4" style="font-size: 3rem;"></i>
                <h5>Earn revenue</h5>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-md-12">
                <h3 class="text-center">Frequently Asked Questions</h3>
            </div>            
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
            <h6><strong>Who can teach on skillsbd?</strong></h6>
                <p>Anyone can teach a class. As long as your class adheres to our Class Guidelines, it can be published on Skillsbd. There is no cost to publishing a class.</p>
            </div>
            <div class="col-md-6">
            <h6><strong>What's included in a Skillsbd class?</strong></h6>
                <p>Skillsbd classes include a combination of Video lessons, Quiz, and a Class project. The class project is a short assignment that helps students put their new skills into action.</p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
            <h6><strong>What should I teach?</strong></h6>
                <p>Skillsbd classes are for creators, and fall into a variety of topics, including Business, Excel, Design, Language, Marketing, Photography, Web Development, Entrepreneurship, Leadership and more.</p>
            </div>
            <div class="col-md-6">
                <h6><strong>Do I need to promote my classes?</strong></h6>
                <p>Skillsbd operates on a membership model, so your class will have a built-in audience from the start. We also have tons of tips to help you promote your class to your own community to help you maximize your success.</p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
            <h6><strong>How can I earn money?</strong></h6>
                <p>People want to learn and the Internet opened the door for everyone to continue their educations from anywhere in the world. You'll earn money montly through Bank Account in your classes.</p>
            </div>
            <div class="col-md-6">
                <h6><strong>Do you offer any resources for instructor?</strong></h6>
                <p>Yes! We offer resources like the Teacher Handbook and our 30 Day Teach Challenge to help you build a great class. We’re also available for any questions at support@skillsbd.com.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <h6><strong>Can I create more than one course?</strong></h6>
                <p>Yes! as an Instructor can create any amount of classes as per as skillsbd.com <a href="<?php echo site_url('privacy-policy') ?>" class="info-link">privacy and policy</a>.</p>
            </div>
            <div class="col-md-6">
                <h6><strong>How do I get started?</strong></h6>
                <p>You can start form anywhere and anytime. Before started you must register our on skillsbd as an instructor and read the <a href="<?php echo site_url('instructor-terms') ?>" target="_blank"><strong>Instructor terms of use</strong></a>. Get start <a href="<?php echo site_url('sign-up'); ?>" class="text-primary"><strong>sign up</strong></a> now</p>
            </div>
        </div>
    </div>
</section>

<section style="background-color: #36373c; color: #ffffff">
    <div class="container py-5" >
        <div class="row">
            <div class="col" style="padding: 35px;">
                <?php // echo get_frontend_settings('about_us'); ?>
                
                <h3 class="text-center mb-4">Ready to Start Teaching?</h3>
                <p class="text-center mb-4">Your students await. <br>Share your knowledge and help people learn new skills, advance their careers.</p>
                <div class="d-flex justify-content-center">
                    <div class="home-banner-wrap mt-1">
                    <a class="btn" href="<?php echo site_url('home/login'); ?>">Start a class</a>
                    </div>
                
                </div>
                
                      
              
                   
            </div>
        </div>
        
    </div>
</section>