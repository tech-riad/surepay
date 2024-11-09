<?php
  $form_url = admin_url($controller_name."/store/");
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => get_current_url(), 'method' => "POST");
  $a  = file_get_contents(APPPATH.'./modules/developers/views/docs.php');
?>
<style type="text/css">
  .CodeMirror {
  border: 1px solid #eee;
  height: auto;
}
</style>

<div class="">

<?php echo form_open($form_url, $form_attributes); ?>
  <div class="row">
      <div class="form-group">
        <textarea rows="50" name="developers_docs" id="developers_docs"><?=$a;?></textarea>
      </div>
  </div>
  <div class="card-footer text-end">
      <button class="btn btn-primary btn-min-width text-uppercase"><?=lang("Save")?></button>
    </div>
  <?php echo form_close(); ?>
</div>

<!-- codemirror -->
<link rel="stylesheet" type="text/css" href="<?php echo BASE; ?>assets/plugins/codemirror/lib/codemirror.css">
<link rel="stylesheet" type="text/css" href="<?php echo BASE; ?>assets/plugins/codemirror/theme/monokai.css">
<script src="<?php echo BASE; ?>assets/plugins/codemirror/lib/codemirror.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo BASE; ?>assets/plugins/codemirror/mode/css/css.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
  setTimeout(function(){
    
    var editor = CodeMirror.fromTextArea(document.getElementById("developers_docs"), {
      lineNumbers: true,
      theme: "monokai",
    });
    editor.setSize("100%", "100%");
  }, 200);
</script>