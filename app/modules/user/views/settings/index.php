<style> .container {overflow: hidden; white-space: nowrap; } .mnavbar {transition: transform 0.3s ease-in-out; } .list-group-item:first-child {border-top-left-radius: 15px; border-top-right-radius: 0px; border-bottom-left-radius: 15px; } .list-group-item:last-child {border-bottom-left-radius: 0; border-top-right-radius: 15px; border-bottom-right-radius: 15px; } .myC{overflow-x: auto !important; } ::-webkit-scrollbar:horizontal{height: 2px; background-color: red; } .container-fluid{padding-left: 0; padding-right: 0; } </style> 
<div class="justify-content-center">
  <div class="col-md-12 col-lg-12">
    <div class="row">
      <div class="col-md-12 container">
        <?php include 'sidebar.php'; ?>
      </div>
      <div class="col-md-12">
        <?php include "elements/$tab.php"; ?>
      </div>
    </div>
  </div>
</div>


<script src="<?=PATH?>assets/plugins/jquery/jquery-3.4.1.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    plugin_editor('.plugin_editor', {height: 100});
    $('.automatic-selection').select2({
          selectOnClose: true
    });
    
  });
</script>