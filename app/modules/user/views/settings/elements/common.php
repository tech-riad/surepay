<?php
  $brand_elements = [];
  $active_elements = [];

  $brand_elements[] = [
    'label'      => 'Active Brand Payment',
    'element'    => '',
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ];
  if (!empty($brands)) {
     //Default payment
    $limit_brands = [];
    $active_payments = [];
    if (!empty($payment_settings->id)) {
      $settings = json_decode($payment_settings->params);

      if (isset($settings->limit_brands)) {
        $limit_brands = (array)$settings->limit_brands;
      } else {
        foreach ($brands as $key => $brand) {
          $limit_brands[$brand->id] = 0;
        }
      }

      if (isset($settings->active_payments)) {
        $active_payments = (array)$settings->active_payments;
      }else{
        foreach ($active as $key => $act){
          $active_payments[$key] = 0;
        }
      }
    }
        
    foreach ($brands as $key => $brand) {
      $brand_value = (isset($limit_brands[$brand->id]) && $limit_brands[$brand->id]) ? 1 : 0;
      $brand_check = ($brand_value) ? TRUE : FALSE;
      $hidden_value = form_hidden(["limit_brands[$brand->id]" => 0]);

      $brand_elements[] = [
        'label'      => $brand->domain,
        'element'    => $hidden_value . form_checkbox(['name' => "limit_brands[$brand->id]", 'value' => 1, 'checked' => $brand_check, 'class' => 'custom-switch-input']),
        'class_main' => "col-md-4 col-sm-6 col-xs-6",
        'type'       => "switch",
      ];
    }
      

    if (!empty($active)) {
      $brand_elements[] = [
        'label'      => 'Active Payment Type',
        'element'    => '',
        'class_main' => "col-md-12 col-sm-12 col-xs-12",
      ];
      foreach ($active as $key => $act) {
        $active_value = (isset($active_payments[$key]) && $active_payments[$key]) ? 1 : 0;
        $active_check = ($active_value) ? TRUE : FALSE;
        $hidden_value = form_hidden(["active_payments[$key]" => 0]);

        $active_elements[] = [
          'label'      => $act,
          'element'    => $hidden_value . form_checkbox(['name' => "active_payments[$key]", 'value' => 1, 'checked' => $active_check, 'class' => 'custom-switch-input my','data-id'=>$key]),
          'class_main' => "col-md-3 col-sm-4 col-xs-4",
          'type'       => "switch",
        ];
      }
    }


  }
  $general_elements = array_merge($general_elements, $brand_elements);
  $general_elements = array_merge($general_elements, $active_elements);
