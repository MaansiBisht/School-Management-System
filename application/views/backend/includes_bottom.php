
<!-- bundle -->
<script src="<?php echo base_url(); ?>assets/backend/js/app.min.js"></script>

<!-- third party js -->
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.bootstrap4.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.keyTable.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/Chart.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/pages/demo.datatable-init.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/pages/demo.form-wizard.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/fullcalendar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/summernote-bs4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/pages/demo.summernote.js"></script>


<!--Notify for ajax-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
<!-- demo app -->
<script src="<?php echo base_url(); ?>assets/backend/js/pages/demo.dashboard.js"></script>
<!-- end demo js-->

<!--Custom JS-->
<script src="<?php echo base_url(); ?>assets/backend/js/ajax_form_submission.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/custom.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/content-placeholder.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/addon.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/init.js"></script>

<!-- dragula js-->
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/dragula.min.js"></script>
<!-- component js -->
<script src="<?php echo base_url(); ?>assets/backend/js/ui/component.dragula.js"></script>

<script>
	function error_required_field() {
	  $.NotificationApp.send("<?php echo get_phrase('oh_snap'); ?>!", "<?php echo get_phrase('please_fill_all_the_required_fields'); ?>" ,"top-right","rgba(0,0,0,0.2)","error");
	}
</script>