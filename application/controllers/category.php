<style type="">
    .thumb {
    position: relative;
    border-radius: 3px;
    border: 1px solid transparent;
}

.caption {
    position: absolute;
    top: 35%;
    left: 0;
    width: 100%;
    color: #fff;
    font-size: 1.7rem;
    font-weight: 600;

}
.thumb:hover {
    opacity: 0.8;
    transition: opacity .25s ease-in-out;
  -moz-transition: opacity .25s ease-in-out;
  -webkit-transition: opacity .25s ease-in-out;
}

</style>
    <div class="row" style="margin-top: 50px; margin-bottom: 30px;">
        <div class="col-md-4">
            <a href="<?php echo base_url() ?>trainings/onlyWeekend.jsp">
                <div class="thumb text-center view">
                    <img src="<?php echo base_url() ?>image/companylogo/one1.png" alt="" class="img-rounded">
                    <div class="caption">
                        <p>Weekend</p>
                    </div>
                </div>  
            </a>     
        </div>
        <div class="col-md-4">
            <a href="<?php echo base_url() ?>trainings/onlyTrending.jsp">
                <div class="thumb text-center view">
                    <img src="<?php echo base_url() ?>image/companylogo/two2.png" alt="" class="img-rounded">
                    <div class="caption">
                        <p>Trending</p>
                    </div>
                </div> 
            </a>      
        </div>
        <div class="col-md-4">
            <a href="">
                <div class="thumb text-center view">
                    <img src="<?php echo base_url() ?>image/companylogo/three3.png" alt="" class="img-rounded">
                    <div class="caption">
                        <p>Certificate</p>
                    </div>
                </div> 
            </a>      
        </div>
    </div>
    

<div class="section category-items job-category-items  text-center" style="display: none;">
    <ul class="category-list"> 
    <?php    
    if ($cate) {
            foreach ($cate as  $acategory) {
                $file_dir = "../images/icon/".$acategory->caticon;
             ?> 
        <li class="category-item">
            <a href="<?php echo base_url();?>trainings/cate/<?php echo $acategory->id; ?>">
                <div class="category-icon"><img src="<?php echo $file_dir; ?>" alt="images" class="img-responsive"></div>
                <span class="category-title"><?php echo $acategory->cname; ?></span>
                <span class="category-quantity">(1298)</span>
            </a>
        </li><!-- category-item -->
    <?php
        } 
    } ?>                
    </ul>               
</div><!-- category ad -->     
                

