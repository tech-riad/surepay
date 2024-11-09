<script src="<?=PATH?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script src="<?=PATH?>assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>

<script src="<?=PATH?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?=PATH?>assets/plugins/tinymce/tinymce.min.js"></script>

<!-- datatable -->

<script src="<?=PATH?>assets/plugins/DataTables/datatables.min.js"></script>

<script src="<?=PATH?>assets/js/pages/datatables.js"></script>

<script src="<?=PATH?>assets/js/main.min.js"></script>
<script src="<?=PATH?>assets/js/notify.min.js"></script>
<script src="<?=PATH?>assets/js/select2-init.js"></script>
<script src="<?=base_url('assets/plugins/jquery-toast/js/jquery.toast.js')?>"></script>
<script src="<?=PATH?>assets/js/custom2.js"></script>
<script src="<?=PATH?>assets/js/process.js"></script>
<script src="<?=PATH?>assets/js/general.js"></script>
<script src="<?=PATH?>assets/js/admin.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
	    plugin_editor('.plugin_editor', {height: 100});

	  });
	var navLinks = $('.accordion-menu li a');
	navLinks.each(function() {
		if ($(this).attr('href') === window.location.href) {
		  // Add the "active" class to the <a> element
		  $(this).closest('li').addClass('active-page');
		  $(this).closest('a').addClass('active');
		  
		  var parentUl = $(this).closest('ul');

		  if (parentUl.attr('class')==='multi') {
		     parentUl.parent().addClass('active-page');
		  }
		}
	});
</script>


<?php
    if (!empty($msg = $this->session->flashdata('message'))) {
        ?>
<script type="text/javascript">
    notify('<?=$msg['message']?>','<?=$msg['status']?>')
</script>
        <?php
    }

?>

<?php 
   if(get_option('enable_panel_notification_popup')==1 && get_cookie('notification_popup')!=1){
   	set_cookie("notification_popup", "1", 180);
   	
?>
<div class="modal-infor">
<div class="modal" id="notification">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title"><i class="fe fe-bell"></i> <?=lang("Notification")?></h4>
      </div>

      <div class="modal-body">
        <?=get_option('notification_popup_panel_content')?>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="acceptPopup()"><?=lang("Dont show again")?></button>
      </div>
    </div>
  </div>
</div>
</div>
<script>
$(document).ready(function(){

  var is_notification_popup = "<?=get_option('enable_panel_notification_popup', 0)?>"
  setTimeout(function(){
      if (is_notification_popup == 1) {
        $("#notification").modal('show');
      }else{
        $("#notification").modal('hide');
      }
  },500); 
});
</script>
<?php } ?>

<script src="<?=PATH?>assets/plugins/jquery-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="<?=PATH?>assets/plugins/jquery-upload/js/jquery.iframe-transport.js"></script>
<script src="<?=PATH?>assets/plugins/jquery-upload/js/jquery.fileupload.js"></script>
<?=htmlspecialchars_decode(get_option('embed_javascript', ''), ENT_QUOTES)?>
