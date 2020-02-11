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
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> 
                    <i class="mdi mdi-user title_icon"></i> Instructors
                    <a href="<?php echo site_url('user/add_instructor') ?>" class="btn btn-dark btn-rounded alignToTitle">
                        <i class="mdi mdi-plus"></i>Add new instuctor
                    </a>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
              
              <h4 class="mb-3 header-title"><?php echo get_phrase('all_instructors'); ?></h4>
              <div class="table-responsive-sm mt-4">
                <table id="basic-datatable" class="table table-striped table-centered mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?php echo get_phrase('photo'); ?></th>
                      <th><?php echo get_phrase('instructo_name'); ?></th>
                      <th><?php echo get_phrase('Specialist_area'); ?></th>
                      <th><?php echo get_phrase('status'); ?></th>
                      <th><?php echo get_phrase('actions'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                       foreach ($all_instructors->result_array() as $instructors): 
                       $user_data = $this->db->get_where('users', array('id' => $instructors['user_id']))->row_array();
                        ?>
                          <tr>
                              <td><?php echo $key+1; ?></td>
                              <td><img src="<?php echo site_url(); ?><?php echo $instructors['instructor_photo']; ?>" class="rounded-circle" width="50" alt="<?php echo $instructors['instructor_full_name']; ?>"></td>
                              <td><?php echo $instructors['instructor_full_name']; ?></td>
                              <td><?php echo $instructors['specialist_in']; ?></td>
                              <td>
                                <?php
                                 if($instructors['status'] == 0){
                                     echo '<span class="badge badge-success">Active</span>';
                                    } else {
                                     echo '<span class="badge badge-danger">Inactive</span>';
                                 }
                                ?>
                              </td>
                              <td>
                                  <div class="dropright dropright">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                       <li><a class="dropdown-item" href="<?php echo site_url('user\instructor_edit') ?>\<?php echo $instructors['id'] ?>"><i class="mdi mdi-eye"></i> <?php echo get_phrase('view'); ?></a></li>
                                       <li><a class="dropdown-item" href="<?php echo site_url('user\instructor_edit') ?>\<?php echo $instructors['id'] ?>"><i class="mdi mdi-pencil"></i> <?php echo get_phrase('edit'); ?></a></li>
                                       <div class="dropdown-divider"></div>
                                       <li><a class="dropdown-item" href="<?php echo site_url('user\instructor_delete') ?>\<?php echo $instructors['id'] ?>" onClick="return confirm('Are you sure you want to delete instructor?')"><i class="mdi mdi-cancel"></i> <?php echo get_phrase('delete'); ?></a></li>
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


