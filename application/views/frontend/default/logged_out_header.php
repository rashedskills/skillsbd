<section class="menu-area">
  <div class="container-xl">
    <div class="row">
      <div class="col">
        <nav class="navbar navbar-expand-sm bg-light justify-content-center">

          <ul class="mobile-header-buttons">
            <li><a class="mobile-nav-trigger" href="#mobile-primary-nav">Menu<span></span></a></li>
            <li><a class="mobile-search-trigger" href="#mobile-search">Search<span></span></a></li>
          </ul>

          <a href="<?php echo site_url(''); ?>" class="navbar-brand" href="#">
            <img src="<?php echo base_url().'uploads/system/logo-skillsbd.svg'; ?>" alt="" height="35">
          </a>

          <?php include 'menu.php'; ?>

          <form class="inline-form" action="<?php echo site_url('home/search'); ?>" method="get" style="width: 50%;">
            <div class="input-group search-box mobile-search">
              <input type="text" name = 'query' class="form-control" placeholder="<?php echo get_phrase('enter_course,_category_or_keyword'); ?>">
              <div class="input-group-append">
                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
              </div>
            </div>
          </form>

          <?php if ($this->session->userdata('admin_login')) { ?>
            <div class="instructor-box menu-icon-box">
              <div class="icon">
                <a href="<?php echo site_url('admin'); ?>" style="border: 1px solid transparent; margin: 10px 10px; font-size: 14px; width: 100%; border-radius: 0;"><?php echo get_phrase('administrator'); ?></a>
              </div>
            </div>
          <?php }  else { ?>
            <div class="instructor-box menu-icon-box disable-on-mobile">
              <div class="icon">
                <a href="<?php echo site_url('become-an-instructor') ?>" style="border: 1px solid transparent; margin: 10px 10px; font-size: 14px; width: 100%; border-radius: 0;">Become an Instructor</a>
              </div>
            </div>
          <?php } ?>
          <div class="cart-box menu-icon-box" id = "cart_items">
            <?php include 'cart_items.php'; ?>
          </div>
          <span class="signin-box-move-desktop-helper"></span>
          <div class="sign-in-box btn-group">

            <a href="<?php echo site_url('home/login'); ?>" class="btn btn-sign-in"><?php echo get_phrase('log_in'); ?></a>

            <a href="<?php echo site_url('sign-up'); ?>" class="btn btn-sign-up"><?php echo get_phrase('sign_up'); ?></a>

          </div> <!--  sign-in-box end -->
          
        </nav>
      </div>
    </div>
  </div>
</section>
