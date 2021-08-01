<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
                <i class="mdi mdi-update title_icon"></i> <?php echo get_phrase('Add_Section'); ?>
            </h4>
        </div>
    </div>
</div>
</div>
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
    <form method="POST" class="d-block ajaxForm" action="<?php echo route('manage_class/sections/create/'.$class_id); ?>">
    <div class="form-row">
        <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('section_name'); ?></label>
            <input type="text" class="form-control" id="name" name = "name" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_section_name'); ?></small>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_section'); ?></button>
        </div>
    </div>
</form>
<?php //} ?>
</div>
</div>
</div>
</div>
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
                <?php include 'list.php'; ?>
            </h4>
        </div>
    </div>
</div>
</div>
<div class="row