<style>
.intructor-banner-area {
    background-image: url(https://udemy-images.udemy.com/teaching/header-image.jpg);
    background-position: center center;
    background-size: cover;
    background-repeat: no-repeat;
    padding: 100px 0px 130px;
    color: #fff;
}

.home-banner-wrap .btn {
    padding: 10px 14px 12px;
    font-size: 20px;
    background-color: #fbb034;
    background-image: linear-gradient(315deg, #fbb034 0%, #ffdd00 74%);
    border-color: 1px solid #fbb034;
    border-radius: 0;
    color: #36373c;
}
.home-banner-wrap .btn:hover {
    padding: 10px 14px 12px;
    font-size: 20px;
    background: #ffd723;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to left, #ffb606, #ffd723);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to left, #ffb606, #ffd723); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    border-color: 1px solid #ffd723;
    opacity: 0.9;
    color: #36373c;
}
</style>
<section class="intructor-banner-area">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <div class="home-banner-wrap">
                    <h2>Make a global impact</h2>
                    <p>Create an online video course and earn money by teaching people around the world.</p>
                    <a class="btn" href="<?php echo site_url('home/login'); ?>">Become an Instructor</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="category-course-list-area">
    <div class="container">
        <div class="row">
            <div class="col" style="padding: 35px;">
                <?php // echo get_frontend_settings('about_us'); ?>
                <h1>Instructor</h1>
            </div>
        </div>
    </div>
</section>
