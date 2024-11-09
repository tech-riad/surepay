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
<script src="<?=PATH?>assets/plugins/jquery-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="<?=PATH?>assets/plugins/jquery-upload/js/jquery.iframe-transport.js"></script>
<script src="<?=PATH?>assets/plugins/jquery-upload/js/jquery.fileupload.js"></script>
<?php if(segment(2)=='payments'|| segment(2)=='faqs'|| segment(2)=='plans'){?>

<?=script_asset('jquery-ui.min')?>
<script>
$(document).ready(function () {
    $(".sortable").sortable({
      
        update: function (event, ui) {
          var url=$(this).data('action')
            var methods = [];
            $('.sortable tr').each(function (key, val) {
                let methodCode = $(val).data('code');
                methods.push(methodCode);
            });
            var data = $.param({ sort: methods ,token: token});
            $.post(url, data, function (_result) {
                _result = JSON.parse(_result);
                setTimeout(function () {
                    notify(_result.message, _result.status);
                }, 100);
            });
        }
    });
    $("#sortable").disableSelection();
});
</script>
<?php } ?>