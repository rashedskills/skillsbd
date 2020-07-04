<?php 
    $api = SSLCZ_IS_SANDBOX ? 'https://sandbox.sslcommerz.com/embed.min.js?' : 'https://seamless-epay.sslcommerz.com/embed.min.js?';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php if ($page_name == 'course_page'):
        $title = $this->crud_model->get_course_by_id($course_id)->row_array()?>
        <title><?php echo $title['title'].' | '.get_settings('system_name'); ?></title>
    <?php else: ?>
        <title><?php echo 'Checkout'.' | '.get_settings('system_name'); ?></title>
    <?php endif; ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="<?php echo get_settings('author') ?>" />

    <?php
    $seo_pages = array('course_page');
    if (in_array($page_name, $seo_pages)):
    $course_details = $this->crud_model->get_course_by_id($course_id)->row_array();?>
        <meta name="keywords" content="<?php echo $course_details['meta_keywords']; ?>"/>
        <meta name="description" content="<?php echo $course_details['meta_description']; ?>" />
    <?php else: ?>
        <meta name="keywords" content="<?php echo get_settings('website_keywords'); ?>"/>
        <meta name="description" content="<?php echo get_settings('website_description'); ?>" />
    <?php endif; ?>

    <link name="favicon" type="image/x-icon" href="<?php echo base_url().'uploads/system/favicon.png' ?>" rel="shortcut icon" />
    <?php include 'includes_top.php';?>

    <script type="text/javascript">
        (function (window, document) {
            var loader = function () {
                var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
                script.src = "<?php echo $api; ?>" + Math.random().toString(36).substring(7);
                tag.parentNode.insertBefore(script, tag);
            };

            window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
        })(window, document);
    </script>
    <style type="text/css">
        .cart-course-wrapper .details {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 70% !important;
            flex: 0 0 70% !important;
            max-width: 70% !important;
            padding-left: 10px;
        }
        .cart-sidebar .total-price {
            font-size: 20px !important;
            line-height: 50px !important;
            color: #36373c;
            font-weight: 700 !important;
        }
    </style>
</head>
<body class="gray-bg">
<?php 
    if ($this->session->userdata('user_login')) {
        include 'logged_in_header.php';
    }else {
        include 'logged_out_header.php';
    }
?>
<?php 
    $_SESSION['fname']  = $user_details['first_name']; 
    $_SESSION['lname']  = $user_details['last_name'];
    $_SESSION['uemail'] = $user_details['email'];
    $_SESSION['uphone'] = $user_details['phone'];
?>
<!--required for getting the stripe token-->
<section class="page-header-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('home'); ?>"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#"><?php echo get_phrase('checkout'); ?></a></li>
                    </ol>
                </nav>
                <h1 class="page-title"><?php echo get_phrase('checkout'); ?></h1>
            </div>
        </div>
    </div>
</section>
<section class="cart-list-area">
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="col-lg-6 col-sm-12 py-2" style="border: 4px solid #ffd723">               
                <div class="in-cart-box">
                    <!-- <div class="title">
                        <?php echo sizeof($this->session->userdata('cart_items')).' '.get_phrase('courses_in_your_order'); ?>
                    </div> -->
                    <div class="title">
                        <strong>Your Order Details</strong>
                    </div>
                    <div class="pt-2">
                        <ul class="cart-course-list" id="clearCourseList">
                            <?php
                            $actual_price = 0;
                            $total_price  = 0;
                            foreach ($this->session->userdata('cart_items') as $cart_item):
                                $course_details = $this->crud_model->get_course_by_id($cart_item)->row_array();
                                $instructor_details = $this->user_model->get_all_user($course_details['user_id'])->row_array();
                                ?>
                                <li>
                                    <div class="cart-course-wrapper">     
                                        <div class="image">                            
                                            <?php if(file_exists('uploads/thumbnails/course_thumbnails/'.'course_thumbnail'.'_'.get_frontend_settings('theme').'_'.$cart_item.'.jpg')): ?>
                                            <img src="<?php echo $this->crud_model->get_course_thumbnail_url($cart_item); ?>" alt="<?php echo $course['title'] ?>" class="img-fluid">
                                            <?php else: ?> 
                                            <img src="<?php echo 'https://skillsbd.s3.ap-south-1.amazonaws.com/thumbnails/course_thumbnails/'.'course_thumbnail'.'_'.get_frontend_settings('theme').'_'.$cart_item.'.jpg' ?>" alt="<?php echo $course['title'] ?>" class="img-fluid">
                                           <?php endif; ?>
                                        </div>                                   
                                        <div class="details">                                        
                                            <div class="name"><?php echo $course_details['title']; ?></div>                     
                                        </div>
                                        <div class="price">                                            
                                                <?php if ($course_details['discount_flag'] == 1): ?>
                                                    <div class="current-price">
                                                        <?php
                                                        $total_price += $course_details['discounted_price'];
                                                        echo currency($course_details['discounted_price']);
                                                        ?>
                                                    </div>
                                                    <div class="original-price">
                                                        <?php
                                                        $actual_price += $course_details['price'];
                                                        echo currency($course_details['price']);
                                                        ?>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="current-price">
                                                        <?php
                                                        $actual_price += $course_details['price'];
                                                        $total_price  += $course_details['price'];
                                                        echo currency($course_details['price']);
                                                        ?>
                                                    </div>
                                                <?php endif; ?>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <!---end course list--->
                <div class="cart-sidebar" style="background-color: #ffffff; padding: 10px">
                    <div class="total"><?php echo get_phrase('total'); ?>:</div>
                    <span id = "total_price_of_checking_out" hidden><?php echo $total_price; ?></span>
                    <?php $_SESSION['tprice'] = $total_price; ?>
                    <div class="total-price mb-3"><?php echo currency($total_price);  ?></div>                   
                    <div class="form-check mb-3">
                      <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                      <label class="form-check-label" for="exampleRadios1">
                        SSL Commerz <img src="https://skillsbd.s3.ap-south-1.amazonaws.com/system/ssl-commerz.png" alt="sslcommerz">
                      </label>
                    </div>
                    <div class="mb-3">
                        <p><small>By completing your purchase you agree to these <strong><a href="<?php echo site_url('home/terms_and_condition'); ?>" target="_blank"><?php echo get_phrase('terms_&_condition'); ?></a></strong></small></p>
                    </div>                       
           
                    <button type="submit" id="sslczPayBtn" class="btn btn-primary btn-lg btn-block" order="<?php echo "SBD".uniqid(); ?>" endpoint="<?php echo site_url('easyendpoint'); ?>">Complete Payment</button> 
                </div>
                <!---end total price--->
            </div>
            

        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js" integrity="sha256-ifihHN6L/pNU1ZQikrAb7CnyMBvisKG3SUAab0F3kVU=" crossorigin="anonymous"></script>
<script type="text/javascript">
        function changeObj() {
            var obj = {};
cus_name='';
            if($('.firstName').val() && $('.lastName').val() ) {
                fname = $('.firstName').val();
                lname = $('.lastName').val();
                obj.cus_name = fname + " " + lname;
            }
            if($('.amount').val()) {
                obj.amount = $('.amount').val();
            }
            if($('.email').val()) {
                obj.email = $('.email').val();
            }
            if($('.phone').val()) {
                obj.phone = $('.phone').val();
            }
            if($('.address').val()) {
                obj.address = $('.address').val();
            }
            if($('.country').val()) {
                obj.country = $('.country').val();
            }
            if($('.state').val()) {
                obj.state = $('.state').val();
            }
            if($('.zip').val()) {
                obj.zip = $('.zip').val();
            }

            if($('.amount').val() && cus_name !='' && $('.email').val() && $('.phone').val() && $('.address').val()&& $('.country').val()&& $('.state').val() && $('.zip').val()) 
            {
                var obj = {  "amount": amount, "cus_name": cus_name, "cus_email": email, "cus_phone": phone, "address": address, "country": country, "state": state, "zip": zip  };
            }

            $('#sslczPayBtn').prop('postdata', obj);
        }
        changeObj();

        $(".firstName").on('change', function () {
           changeObj();
        });
        $(".lastName").on('change', function () {
           changeObj();
        });
        $(".email").on('change', function () {
           changeObj();
        });
        $(".phone").on('change', function () {
           changeObj();
        });
        $(".address").on('change', function () {
           changeObj();
        });
        $(".country").on('change', function () {
           changeObj();
        });
        $(".state").on('change', function () {
           changeObj();
        });
        $(".zip").on('change', function () {
           changeObj();
        });

    </script>
</body>
</html>
