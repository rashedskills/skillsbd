<script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script>
<?php 
$certificate_data = $this->db->get_where('certificate', array('certificate_code' => $this->uri->segment(3)))->row_array();
$course_data = $this->db->get_where('course', array('id' => $certificate_data['course_id']))->row_array();
$instructor_data = $this->db->get_where('users', array('id' => $course_data['user_id']))->row_array();
?>
<style>
.img-container{
    position: relative;
    text-align: center;
    color: #36373c;
    }
    .centered {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 1vw;
        font-weight: 600;
    }
    .bottom-right {
        position: absolute;
        bottom: 8px;
        right: 16px;
    }
</style>
<section class="mt-5 mb-5">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-9 col-lg-9 col-sm-12">
                <div class="img-container" id="html-content-holder">
                    <img src="<?php echo base_url().'uploads/system/certificate.png'; ?>" alt="skillsbd-certificate" class="img-responsive custom-img" style="width:100%;">
                    <div class="centered">This is to certify that <?php echo $certificate_data['std_name']; ?> successfully completed the course <?php echo $certificate_data['crs_title']; ?> on <?php echo date('d-M-Y', $certificate_data['date_added']) ?></div>
                </div> 
                <p class="mt-4 mb-4">
                This certificate above verifies that <?php echo '<strong>'.$certificate_data['std_name'].'</strong>'; ?> successfully completed the course <?php echo '<strong>'.$certificate_data['crs_title'].'</strong>'; ?>. on <?php echo '<strong>'.date('d-M-Y', $certificate_data['date_added']).'</strong>' ?> as taught by <?php echo '<strong>'.$instructor_data['first_name'].' '.$instructor_data['last_name'].'</strong>' ?> on Skillsbd. The certificate indicates the entire course was completed as validated by the student.
                </p>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-12">
                <div class="row mb-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-header">
                        <strong>About the course</strong>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <p><?php echo $certificate_data['crs_title']; ?></p>
                            <a href="<?php echo base_url() ?>home/course/<?php echo $certificate_data['crs_title']; ?>/<?php echo $certificate_data['course_id']; ?>"><small><strong>View Course</strong></small></a>
                        </li>
                    </ul>
                </div>
                </div>
                
                <div class="row mb-4">
                    <div class="card" style="width: 18rem;">
                        <div class="card-header">
                            <strong><i class="fas fa-download"></i> Download</strong>
                        </div>
                        <ul class="list-group list-group-flush">
                            
                            <li class="list-group-item">
                                    <a id="btn-Convert-Html2Image" href="#"><strong>.jpg</strong></a>
                            </li>
                        </ul>
                    </div>
                    <div id="previewImage" style="display: none;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
        $(document).ready(function () {
            var element = $("#html-content-holder"); // global variable
            var getCanvas; // global variable

            html2canvas(element, {
                onrendered: function (canvas) {
                    $("#previewImage").append(canvas);
                    getCanvas = canvas;
                }
            });

            $("#btn-Convert-Html2Image").on('click', function () {
                var imgageData = getCanvas.toDataURL("image/png");
                // Now browser starts downloading it instead of just showing it
                var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
                $("#btn-Convert-Html2Image").attr("download", "certificate.png").attr("href", newData);
            });
        });
</script>


