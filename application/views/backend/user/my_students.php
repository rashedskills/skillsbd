<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?>
               
            </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
              <div class="table-responsive-sm">
                <table id="basic-datatable" class="table table-striped table-centered mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?php echo get_phrase('photo'); ?></th>
                      <th><?php echo get_phrase('student_name'); ?></th>
                      <th><?php echo get_phrase('student_email'); ?></th>
                      <th><?php echo get_phrase('student_phone'); ?></th>
                      <th><?php echo get_phrase('enrolled_course'); ?></th>
                      <th><?php echo get_phrase('enrol_date'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                       foreach ($users->result_array() as $key => $user): 
                                $student_data = $this->db->get_where('users', array('id' => $user['studentid']))->row_array();
                       ?>
                          <tr>
                              <td style="width: 5px"><?php echo $key+1 ?></td>
                              <td>
                                  <img src="<?php echo $this->user_model->get_user_image_url($student_data['id']);?>" alt="" height="40" width="40" class="img-fluid rounded-circle">
                              </td>
                              <td><?php echo $student_data['first_name'].' '.$student_data['last_name']; ?></td>
                              <td><?php echo $student_data['email']; ?></td>
                              <td><?php echo $student_data['phone']; ?></td>
                              <td><?php echo $user['title']; ?></td>
                              <td>
                                <?php
                                    echo date('D, d-M-Y', $user['date_added'])
                               ?>
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
