<!--title-->
<div class="row ">
      <div class="col-xl-12">
          <div class="card">
              <div class="card-body">
                  <h4 class="page-title">
                      <i class="mdi mdi-account-multiple-plus title_icon"></i> <?php echo get_phrase('student_admission_form'); ?>
                  </h4>
                  <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                  <li class="nav-item">
                    <a href="<?php echo route('student/create'); ?>" class="nav-link rounded-0">
                        <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                        <span class="d-none d-lg-block"><?php echo get_phrase('single_student_admission'); ?></span>
                    </a>
                </li>
                </ul>
              </div> <!-- end card body-->
          </div> <!-- end card -->
      </div><!-- end col-->
  </div>
<div class="row">
    <div class="col-12">
        <div class="card pt-0">
            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                <li class="nav-item">

            <div class="tab-content">
                <div class="tab-pane active">
                    <?php
                        
                            include 'single_student_admission.php';
                        
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
