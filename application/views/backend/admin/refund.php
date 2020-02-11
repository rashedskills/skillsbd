<style>
.badge {
    display: inline-block;
    padding: .50em .6em .5em !important;
    font-size: 75%;
    font-weight: 700 !important;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25rem;
}
</style>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
              <h4 class="mb-3 header-title"><?php echo get_phrase('all_refund'); ?></h4>
              <div class="table-responsive-sm mt-4">
                <table id="basic-datatable" class="table table-striped table-centered mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?php echo get_phrase('course_title'); ?></th>
                      <th><?php echo get_phrase('student_name'); ?></th>
                      <th><?php echo get_phrase('refund_cause'); ?></th>
                      <th><?php echo get_phrase('enrolment_date'); ?></th>
                      <th><?php echo get_phrase('request_date'); ?></th>
                      <th><?php echo get_phrase('status'); ?></th>
                      <th><?php echo get_phrase('actions'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                       foreach ($all_refund->result_array() as $refunds): 
                        $user_data      = $this->db->get_where('users', array('id'          => $refunds['user_id']))->row_array();
                    $course_data    = $this->db->get_where('course', array('id'             => $refunds['course_id']))->row_array();
                        $enroll_data    = $this->db->get_where('enrol', array('course_id'   => $refunds['course_id']))->row_array();
                        ?>
                          <tr>
                              <td><?php echo $key+1; ?></td>
                              <td>
                              <strong><a href="<?php echo site_url('admin/course_form/course_edit/'.$course_data['id']); ?>" target="_blank"><?php echo $course_data['title']; ?></a></strong>                                      
                                      
                              </td>
                              <td><?php echo $user_data['first_name'].' '.$user_data['last_name'].' - '.'0'.$user_data['phone'].'<br><a href="mailto:'.$user_data['email'].'?Subject=Refund%20Request%20-%20Skillsbd" target="_top">'.$user_data['email'].'</a>'; ?></td>
                              <td><?php echo $refunds['refund_cause']; ?></td>
                              <?php 
                                $enroldate      = date('d-m-Y', $enroll_data['date_added']);
                                $requestDate    = date('d-m-Y', $refunds['date_added']);
                                //$datediff       = $requestDate - $enroldate;    
                                $totalDay = ($requestDate - $enroldate);                            
                              ?>
                              <td><?php echo date('D, d-M-Y', $enroll_data['date_added']); ?></td>
                              <td><?php echo date('D, d-M-Y', $refunds['date_added']).'<br>'.$totalDay.' days before.'; ?></td>
                              <td>
                                <?php
                                if($refunds['status'] == 1){
                                    echo '<span class="badge badge-warning">Pending</span>';
                                }elseif($refunds['status'] == 2){
                                    echo '<span class="badge badge-danger">Cancelled</span>';
                                }else{
                                    echo '<span class="badge badge-success">Success</span>';
                                }
                                ?>
                              </td>
                              <td>
                                  <div class="dropright dropright">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                       <li><a class="dropdown-item" href="<?php echo site_url('admin/update_order_status/'.$orderlist['id']) ?>"><?php echo get_phrase('success'); ?></a></li>
                                    </ul>
                                </div>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
              </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>


