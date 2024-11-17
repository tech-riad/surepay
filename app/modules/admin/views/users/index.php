<?php 
  // Page header
  echo show_page_header($controller_name, ['page-options' => 'add-new', 'page-options-type' => 'ajax-modal']);
  // Page header Filter
  echo show_page_header_filter($controller_name, ['items_status_count' => $items_status_count, 'params' => $params]);
  function kyc_status($value='')
    {
      switch($value){
        case '1':
          $c = 'badge-info';
          $t = 'Verified';
          break;
        default:
          $c = 'badge-warning';
          $t = 'Not verified';

      }
      $xhtml = sprintf('<span class="badge light %s">%s</span>', $c, $t);
      return $xhtml;
    }
?>
 
<div class="row">
  <?php if(!empty($items)){
  ?>
    <div class="col-md-12 col-xl-12">
      <div class="card">
        <div class="card-body">
          <div class="card-header">
            <h3 class="card-title"><?=lang("Lists")?></h3>
            <div class="card-options">
              <?php echo show_bulk_btn_action($controller_name); ?>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-vcenter card-table">
              <?php echo render_table_thead($columns); ?>
              <tbody>
                <?php if (!empty($items)) {
                  $i = $from;
                  foreach ($items as $key => $item) {
                    $i++;
                    $item_checkbox      = show_item_check_box('check_item', $item['ids']);
                    $full_name = show_high_light(esc($item['first_name']), $params['search'], 'first_name') . " " . show_high_light(esc($item['last_name']), $params['search'], 'last_name');
                    $email = show_high_light(esc($item['email']), $params['search'], 'email');
                    $phone = show_high_light(esc($item['phone']), $params['search'], 'phone');
                    $item_status        = show_item_status($controller_name, $item['ids'], $item['status'], 'switch');
                    $created            = show_item_datetime($item['created_at'], 'long');
                    $show_item_buttons  = show_item_button_action($controller_name, $item['ids']);
                ?>
                  <tr class="tr_<?php echo esc($item['ids']); ?>">
                    <th class="text-center w-1"><?php echo $item_checkbox; ?></th>
                    <td class="text-center text-muted"><?=$i?></td>
                    <td>
                      <img src="<?=get_avatar('','merchant',$item['id'])?>" height="20px" class="float-start rounded-circle">
                      <div class="title"><?php echo $full_name; ?></div>
                      <div class="sub text-muted"><?php echo $phone; ?></small></div>
                      <div class="sub text-muted"><?php echo $email; ?></small></div>
                    </td>
                    <td class="text-center w-10p"><?php echo (double)$item['balance']; ?></td></td>
                    <td class="text-center w-15p"><?php echo $created; ?></td>
                    <td class="text-center w-5p"><?php echo $item_status; ?></td>
                    <td class="text-center w-5p"><?php echo $show_item_buttons; ?></td>
                  </tr>
                <?php }}?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php echo show_pagination($pagination); ?>
  <?php }else{
    echo show_empty_item();
  }?>
</div>
