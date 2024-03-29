<?php
$course_details = $this->crud_model->get_course_by_id($payment_info['course_id'])->row_array();
$buyer_details = $this->user_model->get_all_user($payment_info['user_id'])->row_array();
$sub_category_details = $this->crud_model->get_category_details_by_id($course_details['sub_category_id'])->row_array();
$instructor_details = $this->user_model->get_all_user($course_details['user_id'])->row_array();
?>

<section class="page-header-area my-course-area d-print-none">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="page-title" style="color: #fff;"><?php echo get_phrase('invoice'); ?></h1>
                <ul>
                  <li><a href="<?php echo site_url('home/my_courses'); ?>"><?php echo get_phrase('all_courses'); ?></a></li>
                  <li><a href="<?php echo site_url('home/my_wishlist'); ?>"><?php echo get_phrase('wishlists'); ?></a></li>
                  <li><a href="<?php echo site_url('home/my_messages'); ?>"><?php echo get_phrase('my_messages'); ?></a></li>
                  <li class="active"><a href="<?php echo site_url('home/purchase_history'); ?>"><?php echo get_phrase('purchase_history'); ?></a></li>
                  <li><a href="<?php echo site_url('home/order_history'); ?>"><?php echo get_phrase('my_order'); ?></a></li>
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
                <div style="margin-left:auto;margin-right:auto;">
                    <link href="<?php echo base_url('assets/frontend/elegant/css/print.css'); ?>" rel="stylesheet">
                    <div style="background: #eceff4;padding: 1.5rem;">
                        <table class="mb-3">
                            <tr>                                
                                <td style="font-size: 22px;" class="strong"><?php echo strtoupper(get_phrase('invoice')); ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="<?php echo base_url().'uploads/system/logo-skillsbd.svg'; ?>" width="100" class="mt-2">
                                </td>
                            </tr> 
                        </table>
                        <table>                                                           
                            <tr>
                                <td style="font-size: 1.2rem;" class="strong"><?php echo get_settings('system_name'); ?></td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="gry-color small"><?php echo get_settings('system_email'); ?></td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td class="gry-color small"><?php echo get_settings('address'); ?></td>
                            </tr>
                            <tr>
                                <td class="gry-color small"><?php echo get_phrase('phone'); ?>: <?php echo get_settings('phone'); ?></td>                                
                            </tr>
                        </table>

                    </div>

                    <div style="border-bottom:1px solid #eceff4;margin: 0 1.5rem;"></div>
                    <div style="padding: 1.5rem;">
                        <table>
                            <tr><td class="strong small gry-color"><strong><?php echo get_phrase('bill_to'); ?></strong></td></tr>
                            <tr><td class="strong"><?php echo $buyer_details['first_name'].' '.$buyer_details['last_name']; ?></td></tr>
                             <tr><td class="gry-color small"><?php echo get_phrase('phone'); ?>: <?php echo $buyer_details['phone']; ?></td>
                            </tr>
                            <tr><td class="gry-color small"><?php echo get_phrase('email'); ?>: <?php echo $buyer_details['email']; ?></td>
                            </tr>                           
                            <tr>
                                <td class="gry-color small"><?php echo get_phrase('order_number'); ?>: <span class="strong"><?php echo substr($payment_info['tran_id'], -3); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="gry-color small"><?php echo get_phrase('payment_by'); ?>: <span class="strong"><?php echo ucfirst($payment_info['payment_type']); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="gry-color small"><?php echo get_phrase('purchase_date'); ?>: <span class=" strong"><?php echo date('D, d-M-Y', $payment_info['date_added']); ?></span></td>
                            </tr>
                        </table>
                    </div>
                    <div style="">
                        <table class="table text-left small border-bottom">
                            <thead>
                                <tr class="gry-color" style="background: #eceff4;">
                                    <th width="50%"><?php echo get_phrase('course_name'); ?></th>
                                    <th width="10%"><?php echo get_phrase('category'); ?></th>
                                    <th width="20%"><?php echo get_phrase('instructor'); ?></th>
                                    <th width="20%" class="text-right"><?php echo get_phrase('total'); ?></th>
                                </tr>
                            </thead>
                            <tbody class="strong">
                                <tr class="">
                                    <td><?php echo $course_details['title']; ?></td>
                                    <td class="gry-color"><?php echo $sub_category_details['name']; ?></td>
                                    <td class="gry-color"><?php echo $instructor_details['first_name'].' '.$instructor_details['last_name']; ?></td>
                                    <td class="text-right"><?php echo currency($payment_info['amount']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-3">
                            <table style="width: 15%;margin-left:auto;" class="text-right sm-padding small strong">
                                    <tbody>
                                        <tr>
                                            <th class="gry-color text-left"><?php echo get_phrase('sub_total'); ?>:</td>
                                                <td><?php echo currency($payment_info['amount']); ?></td>
                                            </tr>
                                            <tr>
                                                <th class="text-left strong"><?php echo get_phrase('grand_total'); ?>:</td>
                                                <td><?php echo currency($payment_info['amount']); ?>
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                       <div class="mb-3">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            <p>Thank you for your purchase.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                       </div>
                    </div>
                </div>
                <div class="d-print-none mb-2 pull-right">
                    <a href="javascript:window.print()" class="btn btn-receipt"><?php echo '<i class="fa fa-print"></i>'.' '.get_phrase('print'); ?></a>
                </div>
            </div>
        </section>
