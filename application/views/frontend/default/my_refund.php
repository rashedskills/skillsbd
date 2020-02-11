<style>
.badge {
    display: inline-block;
    padding: .35em .6em .5em !important;
    font-size: 75%;
    font-weight: 600 !important;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25rem;
}
</style>
<?php
$my_courses = $this->user_model->my_courses()->result_array();
$my_refunds = $this->user_model->my_refund_request()->result_array();

$categories = array();
foreach ($my_courses as $my_course) {
    $course_details = $this->crud_model->get_course_by_id($my_course['course_id'])->row_array();
    if (!in_array($course_details['category_id'], $categories)) {
        array_push($categories, $course_details['category_id']);
    }
}
?>
<section class="page-header-area my-course-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="page-title"><?php echo get_phrase('refund'); ?></h1>
                <ul>
                  <li><a href="<?php echo site_url('home/my_courses'); ?>"><?php echo get_phrase('all_courses'); ?></a></li>
                  <li><a href="<?php echo site_url('home/my_wishlist'); ?>"><?php echo get_phrase('wishlists'); ?></a></li>
                  <li><a href="<?php echo site_url('home/my_messages'); ?>"><?php echo get_phrase('my_messages'); ?></a></li>
                  <li><a href="<?php echo site_url('home/purchase_history'); ?>"><?php echo get_phrase('purchase_history'); ?></a></li>
                  <li><a href="<?php echo site_url('home/order_history'); ?>"><?php echo get_phrase('my_order'); ?></a></li>
                  <li><a href="<?php echo site_url('home/profile/user_profile'); ?>"><?php echo get_phrase('user_profile'); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="my-courses-area">
    <div class="container">
    <div class="d-flex justify-content-center">
        <div class="col-md-10">
            <h4 class="header-title"><p><?php echo get_phrase('refund_request'); ?></p></h4>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div class="col-md-10 mb-5">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col">Request Date</th>
                    <th scope="col">Course Title</th>
                    <th scope="col" class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody style="background-color: #fff">
                <?php foreach ($my_refunds as $my_refund):
                        $course_details = $this->crud_model->get_course_by_id($my_refund['course_id'])->row_array();
                    ?>
                    <tr>                    
                        <td><?php echo date('D, d-M-Y', $my_refund['date_added']); ?></td>
                        <td><?php echo $course_details['title'] ?></td>
                        <td class="text-center">
                            <?php
                                if($my_refund['status'] == 1){
                                    echo '<span class="badge badge-warning">Pending</span>';
                                }elseif($my_refund['status'] == 2){
                                    echo '<span class="badge badge-danger">Cancelled</span>';
                                }else{
                                    echo '<span class="badge badge-success">Success</span>';
                                }
                            ?>
                        </td>                    
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center">
    <h4 class="header-title"><p><?php echo get_phrase('request_a_refund'); ?></p></h4>
    </div>
    <div class="d-flex justify-content-center">
        <div class="col-md-10">
            <form id="refundRequest" action="<?php echo site_url('user/my_refund_request'); ?>" method="post">
                <input type="hidden" name="user_id" class="form-control" id="" value="<?php echo $this->session->userdata('user_id'); ?>">
                <div class="form-group">
                    <label class="text-dark" for="CourseTitle">Course Title</label>
                    <select name="course_id" id="" class="form-control" required>
                    <option value="">--Select course--</option>
                    <?php foreach ($my_courses as $my_course):
                        $course_details = $this->crud_model->get_course_by_id($my_course['course_id'])->row_array();
                        $instructor_details = $this->user_model->get_all_user($course_details['user_id'])->row_array();?>                        
                        <option value="<?php echo $my_course['course_id']; ?>"><?php echo $course_details['title'] ?></option>
                    <?php endforeach; ?>
                    </select>
                    <small id="" class="form-text text-muted">Before refund please read the <strong><a href="">Refund Policy</a></strong></small>
                </div>
                <div class="form-group">
                    <label class="text-dark" for="refundCause">Refund Cause</label>
                    <select name="refund_cause" class="form-control" id="cause" onchange="causeTypes(this);">
                        <option value="not mention">--Select reason--</option>
                        <option value="Course Conent Not Relavent">Course Conent Not Relavent</option>
                        <option value="Video Quality Not So Good">Video Quality Not So Good</option>
                        <option value="Spam conent show">Span Contnet show</option>
                        <option value="others">Others</option>
                    </select>
                </div>
                <div class="form-group" id="otherCause" style="display: none">
                    <label class="text-dark" for="refundCause">Others Cause</label>
                    <input type="text" name="others_cause" class="form-control" id="refundCause">
                </div>
                <div class="form-group">
                    <label class="text-dark" for="refundCause">Message</label>
                    <textarea name="refund_message" id="" cols="30" rows="3" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    
    </div>
</section>
<script>
    function causeTypes(){
        if(document.getElementById('cause').value == 'others'){
            document.getElementById('otherCause').style.display = 'block';
        }else{
            document.getElementById('otherCause').style.display = 'none';
        }
       
    }
</script>
<script>
var form = document.getElementById('refundRequest');
form.onsubmit = function () {
    // this method is cancelled if window.confirm returns false
    return window.confirm('Are you sure that you want to refund this course?');
}
</script>

