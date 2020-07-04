<section class="page-header-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('home'); ?>"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#"><?php echo get_phrase('shopping_cart'); ?></a></li>
                    </ol>
                </nav>
                <h1 class="page-title"><?php echo get_phrase('shopping_cart'); ?></h1>
            </div>
        </div>
    </div>
</section>


<section class="cart-list-area">
    <div class="container">
        <div class="row" id = "cart_items_details">
            <div class="col-lg-9">

                <div class="in-cart-box">
                    <div class="title"><?php echo sizeof($this->session->userdata('cart_items')).' '.get_phrase('courses_in_cart'); ?></div>
                    <div class="">
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
                                            <a href="<?php echo site_url('home/course/'.slugify($course_details['title']).'/'.$course_details['id']); ?>">                                                
                                                <?php if(file_exists('uploads/thumbnails/course_thumbnails/'.'course_thumbnail'.'_'.get_frontend_settings('theme').'_'.$cart_item.'.jpg')): ?>
                                                <img src="<?php echo $this->crud_model->get_course_thumbnail_url($cart_item); ?>" alt="<?php echo $course['title'] ?>" class="img-fluid">
                                                <?php else: ?> 
                                                <img src="<?php echo 'https://skillsbd.s3.ap-south-1.amazonaws.com/thumbnails/course_thumbnails/'.'course_thumbnail'.'_'.get_frontend_settings('theme').'_'.$cart_item.'.jpg' ?>" alt="<?php echo $course['title'] ?>" class="img-fluid">
                                               <?php endif; ?>

                                            </a>
                                        </div>
                                        <div class="details">
                                            <a href="<?php echo site_url('home/course/'.slugify($course_details['title']).'/'.$course_details['id']); ?>">
                                                <div class="name"><?php echo $course_details['title']; ?></div>
                                            </a>
                                            <a href="<?php echo site_url('home/instructor_page/'.$instructor_details['id']); ?>">
                                                <div class="instructor">
                                                    <?php echo get_phrase('by'); ?>
                                                    <span class="instructor-name"><?php echo $instructor_details['first_name'].' '.$instructor_details['last_name']; ?></span>,
                                                </div>
                                            </a>
                                        </div>
                                        <div class="move-remove">
                                            <div id = "<?php echo $course_details['id']; ?>" onclick="removeFromCartList(this)"><?php echo get_phrase('remove'); ?></div>
                                            <!-- <div>Move to Wishlist</div> -->
                                        </div>
                                        <div class="price">
                                            <a href="">
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
                                                <span class="coupon-tag">
                                                    <i class="fas fa-tag"></i>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-lg-3">
                <div class="cart-sidebar">
                    <div class="total"><?php echo get_phrase('total'); ?>:</div>
                    <span id = "total_price_of_checking_out" hidden><?php echo $total_price; ?></span>
                    <?php $_SESSION['tprice'] = $total_price; ?>
                    <div class="total-price"><?php echo currency($total_price);  ?></div>
                    <div class="total-original-price">
                        <span class="original-price"><?php echo currency($actual_price);  ?></span>
                        <!-- <span class="discount-rate">95% off</span> -->
                    </div>
                    
                    <!-- Custom order --> 
                    <!-- <button type="button" class="btn btn-warning btn-block" onclick="orderTemporary()"><?php echo get_phrase('checkout'); ?></button>-->

                    <!-- ssl checkout -->
                    <a  href="<?php echo site_url('home/ssl_checkout'); ?>" 
                        type="button" 
                        class="btn btn-warning btn-block" 
                        onclick="handleCheckOut()"
                        ><?php echo get_phrase('checkout'); ?>                        
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://www.paypalobjects.com/js/external/dg.js"></script>
<script>
    var dgFlow = new PAYPAL.apps.DGFlow({ trigger: 'submitBtn' });
    dgFlow = top.dgFlow || top.opener.top.dgFlow;
    dgFlow.closeFlow();
    // top.close();
</script>

<script type="text/javascript">
function removeFromCartList(elem) {
    url1 = '<?php echo site_url('home/handleCartItems');?>';
    url2 = '<?php echo site_url('home/refreshWishList');?>';
    url3 = '<?php echo site_url('home/refreshShoppingCart');?>';
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

            $.ajax({
                url: url3,
                type : 'POST',
                success: function(response)
                {
                    $('#cart_items_details').html(response);
                }
            });
        }
    });
}
function orderTemporary() {
    $.ajax({
        url: '<?php echo site_url('home/isLoggedIn');?>',
        success: function(response)
        {
            if (!response) {
                window.location.replace("<?php echo site_url('login'); ?>");
            }else {
                $('#orderModal').modal('show');
                //$('.total_price_of_checking_out').val($('#total_price_of_checking_out').text());
            }
        }
    });
}

function placeOrder() {
    $.ajax({
        url: '<?php echo site_url('home/isLoggedIn');?>',
        success: function(response)
        {
            if (!response) {
                window.location.replace("<?php echo site_url('login'); ?>");
            }else {
                $('#orderPlace').modal('show');
                $('.total_price_of_checking_out').val($('#total_price_of_checking_out').text());
            }
        }
    });
}

function handleCheckOut() {
    $.ajax({
        url: '<?php echo site_url('home/isLoggedIn');?>',
        success: function(response)
        {
            if (!response) {
                window.location.replace("<?php echo site_url('login'); ?>");
            }else {
                window.location.replace("<?php echo site_url('home/ssl_checkout'); ?>");
                //$('#paymentModal').modal('show');
                //$('.total_price_of_checking_out').val($('#total_price_of_checking_out').text());
            }
        }
    });
}

function handleCartItems(elem) {
    url1 = '<?php echo site_url('home/handleCartItems');?>';
    url2 = '<?php echo site_url('home/refreshWishList');?>';
    url3 = '<?php echo site_url('home/refreshShoppingCart');?>';
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

            $.ajax({
                url: url3,
                type : 'POST',
                success: function(response)
                {
                    $('#cart_items_details').html(response);
                }
            });
        }
    });
}


</script>

<!-- Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo site_url('home/order_now'); ?>" method="post">
        <input type="hidden" name="user_id" value=<?php echo $this->session->userdata('user_id'); ?>>
        <input type="hidden" name="course_id" value=<?php echo $course_details['id']; ?>>
            <div class="form-group">
                <strong>Course Title:</strong>
                <p><?php echo $course_details['title']; ?></p>
            </div>
            <div class="form-group">
                <strong>Please follow these steps to complete your bKash payment first-</strong>
                <ul style="list-style: none">
                    <li><small>1. Go to your bKash Mobile Menu by dialing *247# or open <strong>bKash App</strong></small></li>
                    <li><small>2. Choose “Send Money” option</small></li>
                    <li><small>3. Enter the bKash Account Number <strong>01752 992 444</strong></small></li>
                    <li><small>4. Enter the Total <?php echo '<strong>'.currency($total_price).'</strong>';  ?> amount you need to send</small></li>
                    <li><small>5. Enter your name as a reference</small></li>
                    <li><small>6. Now enter your bKash Mobile Menu PIN to confirm the transaction</small></li>
                    <li><small>7. You will get a confirmation SMS. <strong>Note the Transaction ID</strong></small></li>
                    
                </ul>
                <p>Now fill up the following fields.<br>bKash Personal Number : 01752992444</p>
            
            </div>
            <div class="form-group">
                <label for="bkashNumber" class="text-dark">Your bKash Number</label>
                <input type="text" name="bkashNo" placeholder="01..." class="form-control" required="">
            </div>
            <div class="form-group">
                <label for="tid" class="text-dark">Transection ID</label>
                <input type="text" name="bkashTID" placeholder="6LQ1J93CIP" class="form-control" required="">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-warning" onclick="removeCartItems()" value="Order Now"/>
            </div>
        </form>
      </div>
      <div class="modal-footer text-center">
        <p><i class="fa fa-phone"></i> For Support: 01839 133665</p>
      </div>
    </div>
  </div>
</div>