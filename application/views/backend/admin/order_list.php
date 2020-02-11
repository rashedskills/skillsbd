
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
              <h4 class="mb-3 header-title"><?php echo get_phrase('Orders'); ?></h4>
              <div class="table-responsive-sm mt-4">
                <table id="basic-datatable" class="table table-striped table-centered mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?php echo get_phrase('course_title'); ?></th>
                      <th><?php echo get_phrase('student_name'); ?></th>
                      <th><?php echo get_phrase('bkash_number'); ?></th>
                      <th><?php echo get_phrase('transactino_id'); ?></th>
                      <th><?php echo get_phrase('date'); ?></th>
                      <th><?php echo get_phrase('status'); ?></th>
                      <th><?php echo get_phrase('actions'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                       foreach ($new_order->result_array() as $orderlist): 
                        $user_data = $this->db->get_where('users', array('id' => $orderlist['user_id']))->row_array();
                        $course_data = $this->db->get_where('course', array('id' => $orderlist['course_id']))->row_array();
                        ?>
                       
                       
                          <tr>
                              <td><?php echo $key+1; ?></td>
                              <td>
                              <strong><a href="<?php echo site_url('admin/course_form/course_edit/'.$course_data['id']); ?>" target="_blank"><?php echo $course_data['title']; ?></a></strong>
                                      <p class="text-danger"><?php echo get_phrase('Reg.Date:').' '.date('j M, y', strtotime($course_data['reg_last_date'])) ?></p>
                                      
                              </td>
                              <td><?php echo $user_data['first_name'].' '.$user_data['last_name'].' - '.'0'.$user_data['phone'];; ?></td>
                              <td><?php echo $orderlist['bkashNo']; ?></td>
                              <td><?php echo $orderlist['bkashTID']; ?></td>
                              <td><?php echo date('D, d-M-Y', $orderlist['date_added']); ?></td>
                              <td>
                              <?php
                                $checkStatus = $orderlist['status'];
                                if($checkStatus != 1){
                                  echo "Pending";
                                }else{
                                  echo "<b class='text-success'>Success</b>";
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

<!-- Modal -->
<!-- <div class="modal fade" id="UpdateOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form action="<?php echo site_url('home/order_now'); ?>" method="post">
              <input type="hidden" value="<?php echo $orderlist['id'] ?>">
              <div class="form-group">
                  <label for="status">Penyment Confirmation</label>
                  <input type="text" name="status" value="success" class="form-control">
              </div>
              <input type="submit" class="btn btn-success" value="success">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div> -->

