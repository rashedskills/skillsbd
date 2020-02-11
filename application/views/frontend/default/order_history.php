<?php
$this->db->where('user_id', $this->session->userdata('user_id'));
$order_history = $this->db->get('order_new',$per_page, $this->uri->segment(3));
?>
<section class="page-header-area my-course-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="page-title"><?php echo get_phrase('order_history'); ?></h1>
                <ul>
                    <li><a href="<?php echo site_url('home/my_courses'); ?>"><?php echo get_phrase('all_courses'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_wishlist'); ?>"><?php echo get_phrase('wishlists'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_messages'); ?>"><?php echo get_phrase('my_messages'); ?></a></li>
                    <li><a href="<?php echo site_url('home/purchase_history'); ?>"><?php echo get_phrase('purchase_history'); ?></a></li>
                    <li class="active"><a href="<?php echo site_url('home/order_history'); ?>"><?php echo get_phrase('my_order'); ?></a></li>
                    <li><a href="<?php echo site_url('home/profile/user_profile'); ?>"><?php echo get_phrase('user_profile'); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>


<section class="purchase-history-list-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <ul class="purchase-history-list">
                    <li class="purchase-history-list-header">
                        <div class="row">
                            <div class="col-sm-6" style="text-indent: 15px"><p><?php echo get_phrase('Course_title'); ?> </p></div>
                            <div class="col-sm-6 hidden-xxs hidden-xs">
                                <div class="row">
                                    <div class="col-sm-3"> <?php echo get_phrase('order_date'); ?> </div>
                                    <div class="col-sm-3"> <?php echo get_phrase('bKash_number'); ?> </div>
                                    <div class="col-sm-4"> Trainsaction ID </div>
                                    <div class="col-sm-2"> <?php echo get_phrase('actions'); ?> </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php if ($order_history->num_rows() > 0):
                        foreach($order_history->result_array() as $each_order):
                            $course_details = $this->crud_model->get_course_by_id($each_order['course_id'])->row_array();?>
                            <li class="purchase-history-items mb-2">
                                <div class="row">
                                    <div class="col-sm-6">
                                        
                                        <a class="purchase-history-course-title" href="<?php echo site_url('home/course/'.slugify($course_details['title']).'/'.$course_details['id']); ?>" >
                                            <?php
                                            echo $course_details['title'];
                                            ?>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 purchase-history-detail">
                                        <div class="row">
                                            <div class="col-sm-3 date">
                                                <?php echo date('D, d-M-Y', $each_order['date_added']); ?>
                                            </div>
                                            <div class="col-sm-3 price"><b>
                                                <?php echo $each_order['bkashNo']; ?>
                                            </b></div>
                                            <div class="col-sm-4 payment-type">
                                                <?php echo $each_order['bkashTID']; ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <a href="<?php echo site_url('home/remove_order/'.$each_order['id']); ?>" class="btn btn-receipt" OnClick="return confirm('Are you sure you want to remove this order?');"><?php echo get_phrase('remove'); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>
                            <div class="row" style="text-align: center;">
                                <?php echo get_phrase('no_records_found'); ?>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<nav>
    <?php echo $this->pagination->create_links(); ?>
</nav>

<section>
<div class="container">
    <div class="row mb-5">
            <div class="col-md-12">
            <strong>If you have any queries please contact us: 01752992444 </strong>
            </div>  
    
    </div>

</div>

</section>
