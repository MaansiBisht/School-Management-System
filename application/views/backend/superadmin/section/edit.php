<?php $classes = $this->db->get_where('classes', array('id' => $class_id))->result_array(); ?>
<?php foreach($classes as $class){ ?>
<?php $sections = $this->db->get_where('sections', array('id'=>$class_id))->result_array(); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('manage_class/section/form/'.$class_id.'/'.$); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('section_name'); ?></label>
            <input type="text" class="form-control" value="<?php echo $section['name']; ?>" id="name" name = "name" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_section_name'); ?></small>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_class'); ?></button>
        </div>
    </div>
</form>
<?php } ?>
