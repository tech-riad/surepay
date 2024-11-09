<?php
  $xhtml = '<nav class="navbar mnavbar navbar-expand bg-light">';
  $form_items_payment = [
    'other' => 'Payment Settings',
  ];
  $items_payment = array_combine(array_column($items_payment, 'type'), array_column($items_payment, 'name'));
    
    if (!empty($items_payment)) {
      $xhtml_child = '<div class="container-fluid myC">';
      foreach ($items_payment as $key => $item) {
        $link = client_url('settings/' . $key);
        $class_active = ($key == segment(3)) ? 'active' : '';
        $xhtml_child .= sprintf(
          '<a href="%s" class="list-group-item list-group-item-action %s"><span class="icon mr-3"></span>%s</a>', $link, $class_active, $item
        );
      }
      $xhtml_child  .= '</div>';
      $xhtml .= $xhtml_child;
    }else{
      echo show_empty_item();
    }
    $xhtml .= '</nav>';
  echo $xhtml;
?>
