<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Create HightLight class for match of search Field
 * @param string $input
 * @param array  $paramSearch field, value
 * @param        $field
 */
if (!function_exists('show_high_light')) {
    function show_high_light($input, $param_search = '', $field = '')
    {
        if ($param_search['query'] !== "") {
            if ($param_search['field'] == 'all' || $param_search['field'] == $field) {
                $input = preg_replace('#'. preg_quote($param_search['query']) .'#i', '<span class="bg-warning">\\0</span>', $input);
            }
        }
        return $input;
    }
}


/**
 * From V3.6
 * @param array $columns
 * @return render html table thead
 * @author Seji2906
 */
if (!function_exists('render_table_thead')) {
    function render_table_thead($columns, $check_items = true, $show_number = true, $action =  true, $params = [])
    {
        $xhtml = '<thead><tr>';
        if (isset($params['sort-table']) && $params['sort-table']) {
            $xhtml .= '<th class="text-center w-1"><i class="fe fe-move"></i></th>';
        }
        if ($check_items) {
            $data_name = (isset($params['checkbox_data_name'])) ? $params['checkbox_data_name'] : 'check_1';
            $show_check_items = show_item_check_box('check_items', '', 'check-all', $data_name);
            $xhtml .= sprintf('<th class="text-center w-1">%s</th>', $show_check_items);
        }
        if ($show_number) {
            $xhtml .= '<th class="text-center w-1">Sl.</th>';
        }
        if (!empty($columns)) {
            foreach ($columns as $column) {
                $xhtml .= sprintf('<th class="%s">%s</th>', $column['class'], $column['name']);
            }
        }
        if ($action) {
            $xhtml .= '<th class="text-center">action</th>';
        }
        $xhtml .= '</tr></thead>';
        return $xhtml;
    }
}




/** 
 * From V3.6
 * This function will create pagination for page list
 * @param $limit
 * @param array $query
 * @param $base_url
 * @param $total_row
 * @return Create Pagination link
 * @author Seji2906
 */
if (!function_exists('create_pagination')) {
    function create_pagination($params = []){
        $CI = &get_instance();
        $CI->load->library('pagination');
        $sub_url_query_string = "";
        if(!empty($params['query_string'])){
            unset($params['query_string']['p']);
            $arr_query_string = array_filter( $params['query_string'], function($value){
                return !is_null($value) && $value !== '';
            });
            $sub_url_query_string = "?".http_build_query( $arr_query_string );
        }else{
            $sub_url_query_string = "";
        }
        $config = array(
            'base_url'           => $params['base_url'] . $sub_url_query_string ,
            'total_rows'         => $params['total_rows'],
            'per_page'           => $params['per_page'],
            'use_page_numbers'   => true,
            'prev_link'          => '<i class="fas fa-angle-left"></i>',
            'first_link'         => '<i class="fas fa-angle-double-left"></i>',
            'next_link'          => '<i class="fas fa-angle-right "></i>',
            'last_link'          => '<i class="fas fa-angle-double-right"></i>',
        );
        $CI->pagination->initialize($config);
        $links = $CI->pagination->create_links();
        return $links;
    }
}

/**
 * From V3.6
 * @return render HTML for empty page
 * @author Seji2906
 */
if (!function_exists('show_empty_item')) {
    function show_empty_item()
    {
        $xhtml = null;
        $image_page = BASE. 'assets/images/empty_result.png';
        $content = lang("no_result_found_here");
        $xhtml = sprintf('<div class="col-md-12 data-empty text-center">
            <div class="content">
            <img class="img mb-1" src="%s" alt="Empty Data">
            <div class="title text-info">%s</div>
            </div>
        </div>', $image_page, $content);
        return $xhtml;
    }
}



/** 
 * From V3.6
 * This function will create pagination for page list
 * @return Show Pagination link
 * @author Seji2906
 */
if (!function_exists('show_pagination')) {
    function show_pagination($pagination){
        $xhtml = null;
        if(!empty($pagination)){
            $xhtml .= sprintf('<div class="col-md-12"><div class="float-end">%s</div></div>', $pagination);
        }
        return $xhtml;
    }
}

/**
 * From V3.6
 * @param array $params
 * @param name $controllerName
 * @return HTML Show Search Area
 * @author Seji2906
 */
if (!function_exists('show_search_area')) {
    function show_search_area($controller_name, $params, $task = 'admin')
    {
        $xhtml = null;
        $tmpl_search_fields   = app_config('template')['search_field'];
        $field_in_controller  = app_config('config')['search'];
        $current_controller = (array_key_exists($controller_name, $field_in_controller)) ? $controller_name : 'default'; 
        $param_search = $params['search']; 
        $xhtml_fields = null;
        $class_btn_clear = (!empty($param_search['query'])) ? '' : 'd-none';
        $search_placeholder = lang("Search_for_");
        if ($task == 'admin') {
            $xhtml_fields = '<select name="field" class="form-control" id="">';
            foreach ($field_in_controller[$current_controller] as $item) {
                $selected = ($item == $param_search['field']) ? 'selected' : '';
                $xhtml_fields .= sprintf('<option value="%s" %s>%s</option>', $item, $selected,  $tmpl_search_fields[$item]['name']);
            }
            $xhtml_fields .= '</select>';
            $search_placeholder = 'Search for…';
        }
        $xhtml = sprintf(
                '<div class="form-group">
                    <div class="input-group">
                        <input type="text" name="query" class="form-control" placeholder="%s" value="%s">
                        %s
                        <button class="btn btn-primary btn-square btn-search" type="button"><span class="fas fa-search"></span></button>
                        <button class="btn btn-outline-danger btn-square btn-clear %s" data-bs-toggle="tooltip" data-placement="bottom" title="" data-original-title="Clear" type="button"><i class="la-times las"></i></button>
                    </div>
                </div>', $search_placeholder, $param_search['query'], $xhtml_fields, $class_btn_clear);
        return $xhtml;
    }
} 

/**
 * From V3.6
 * @param int $ids - items $ids
 * @param name $controllerName
 * @param array $item_data - default null
 * @return HTML Show button action for item
 * @author Seji2906
 */
if (!function_exists('show_item_button_action')) {
    function show_item_button_action($controller_name, $ids, $format = 'dropdown', $item_data = [],$merchant='')
    {
        $xhtml = null;
        $tmpl_buttons = app_config('template')['button'];
        $btn_area = app_config('config')['button'];
        $curent_btn_area = (array_key_exists($controller_name, $btn_area)) ? $btn_area[$controller_name] : $btn_area['default'];

        // For Controllwer orders, dripfeed, subscriptions
        if (in_array($controller_name, ['order', 'dripfeed', 'subscriptions']) && !in_array($item_data['status'], ['error', 'fail'])) {
            $curent_btn_area = array_diff($curent_btn_area, ['resend']);
        } 

        switch ($format) {
            case 'btn-group':
                $xhtml .= '<div class="btn-group">';
                foreach ($curent_btn_area as $item) {
                    $current_btn = $tmpl_buttons[$item];
                    $link = $merchant=='merchant'? client_url($controller_name . $current_btn['route-name'] . $ids):admin_url($controller_name . $current_btn['route-name'] . $ids);
                    $confirm_message = "";
                    if ($item == 'delete') {
                        $confirm_message = "Are you sure you want to delete this item";
                    }
                    $xhtml .= sprintf(
                        '<a href="%s" class="btn btn-icon btn-outline-info %s" data-confirm_ms="%s" data-bs-toggle="tooltip" data-placement="bottom" title="%s">
                            <i class="%s"></i>
                        </a>', $link, $current_btn['class'], $confirm_message, $current_btn['name'], $current_btn['icon']);
                }
                $xhtml .= '</div>';
                break;
            
            default:
                $xhtml .='<div class="item-action dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="icon"><i class="fa fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu">';
                foreach ($curent_btn_area as $item) {
                    $current_btn = $tmpl_buttons[$item];
                    $link = $merchant=='merchant'? client_url($controller_name . $current_btn['route-name'] . $ids):admin_url($controller_name . $current_btn['route-name'] . $ids);
                    $confirm_message = "";
                    if ($item == 'delete') {
                        $confirm_message = "Are you sure you want to delete this item";
                    }
                    $xhtml .= sprintf('<a href="%s" class="dropdown-item %s" data-confirm_ms="%s"><i class="dropdown-icon %s"></i> %s</a>', $link, $current_btn['class'], $confirm_message, $current_btn['icon'], $current_btn['name']);
                }
                $xhtml .= '</div></div>';
                break;
        }
        return $xhtml;
    }
}

/**
 * From V3.6
 * @param name $controllerName
 * @return HTML Show Bulk button actions for controller
 * @author Seji2906
 */
if (!function_exists('show_bulk_btn_action')) {
    function show_bulk_btn_action($controller_name,$merchant='') 
    {
        $xhtml = null;
        $tmpl_buttons = app_config('template')['bulk_action'];
        $btn_area     = app_config('config')['bulk_action'];
        $curent_btn_area = (array_key_exists($controller_name, $btn_area)) ? $btn_area[$controller_name] : $btn_area['default'];

        if (in_array($controller_name, ['orders'])) {
            if (get('status') != "error") {
                $curent_btn_area = array_diff($curent_btn_area, ['resend']);
            }
        }
        $xhtml .='<div class="item-action dropdown action-options"><button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">Actions <span class="fe fe-chevrons-down"></span></button><div class="dropdown-menu dropdown-menu-right">';
        foreach ($curent_btn_area as $item) {
            $current_btn = $tmpl_buttons[$item];
            $link        = $merchant=='merchant'?client_url($controller_name . $current_btn['route-name'] . $item):admin_url($controller_name . $current_btn['route-name'] . $item);
            $action_type = 'data-type="'. $item .'"';
            $xhtml .= sprintf('<a href="%s" %s class="dropdown-item %s"><i class="dropdown-icon %s"></i> %s</a>', $link, $action_type, $current_btn['class'], $current_btn['icon'], $current_btn['name']);
        }
        $xhtml .= '</div></div>';
        return $xhtml;
    }
}

/**
 * From V3.6
 * @param $ids - items $ids
 * @param $class_input
 * @param $data_name - Input attr
 * @return HTML Created Item Check Box
 * @author Seji2906
 */
if (!function_exists('show_item_check_box')) {
    function show_item_check_box($type = null, $ids = '', $class_input = "check-all", $data_name = 'check_1')
    {
        $xhtml       = null;
        $xhtml_input = null;
        switch ($type) {
            case 'check_items':
                $xhtml_input = sprintf('<input type="checkbox" class="form-check-input check-items %s" data-name="%s">', $class_input, $data_name);
                break;
            case 'check_item':
                $xhtml_input = sprintf('<input type="checkbox" class="form-check-input check-item %s" name="ids[]" value="%s">', $data_name, $ids);
                break;
        }
        $xhtml = sprintf('<div class="custom-controls-stacked">
                            <label class="form-check">%s<span class="custom-control-label"></span>
                            </label>
                        </div>', $xhtml_input);
        return $xhtml;
    }
}

/**
 * From V3.6
 * @param $status - Status input
 * @param name $controller_name
 * @return HTML Created Item Status
 * @author Seji2906
 */
if (!function_exists('show_item_status')) {
    function show_item_status($controller_name, $id, $status, $type = null, $task = null,$merchant='')
    {
        $xhtml = null;
        switch ($type) {
            case 'switch':
                $link = $merchant=='merchant'? client_url($controller_name . '/change_status/'):admin_url($controller_name . '/change_status/');
                $checked = ($status) ? 'checked' : '';
                $xhtml = sprintf('<label class="custom-switch">      
                                    <input type="checkbox" name="item_status" data-id="%s" data-status="%s" data-action="%s" class="custom-switch-input ajaxToggleItemStatus" %s>
                                    <span class="custom-switch-indicator"></span>
                                </label>', $id, $status, $link, $checked);
                break;
            default:
                $config_status       = app_config('config')['status'];
                $current_tmpl_status = (in_array($controller_name, array_keys($config_status))) ? $controller_name . '_status' : 'status';
                if (in_array($controller_name, ['order', 'dripfeed', 'subscriptions', 'refill', 'affiliates'])) {
                    $tmpl_status         = app_config('template')['order_status'];
                } else {
                    $tmpl_status         = app_config('template')[$current_tmpl_status];
                }
                $current_tmpl_status = (array_key_exists($status, $tmpl_status)) ? $tmpl_status[$status] : $tmpl_status['1'];
                $status_name = $current_tmpl_status['name'];
                if ($task == 'user') {
                    $status_name = lang($status_name);
                }
                $xhtml = sprintf('<span class="badge %s">%s</span>', $current_tmpl_status['class-badge'], $status_name);
                break;
        }
        return $xhtml;
    }
}
if (!function_exists('show_domain_status')) {
    function show_domain_status($domain='',$uid='')
    {
        $xhtml = null;
        $status = 'Expired';
        $type='warning';
        if (domainValidation($domain,$uid)) {
            $status = 'Active';
            $type='success';
        }
        $xhtml = sprintf('<small class="ml-auto badge badge-%s">%s</small>',$type,$status);
        return $xhtml;
    }
}
if (!function_exists('show_device_status')) {
    function show_device_status($device_key='',$uid='')
    {
        $xhtml = null;
        $status = 'Expired';
        $type='warning';
        if (deviceValidation($device_key,$uid)) {
            $status = 'Active';
            $type='success';
        }
        $xhtml = sprintf('<small class="ml-auto badge badge-%s">%s</small>',$type,$status);
        return $xhtml;
    }
}
if (!function_exists('duration_type')) {
    function duration_type($name,$type,$duration,$show_name=false)
    {
        $xhtml = null;
        switch ($type) {
            case '1':
                $type ='Days';
                $status ='success';
                break;
            case '2':
                $type ='Months';
                $status = 'info';
                break;
            case '3':
                $type ='Years';
                $status = 'warning';
                break;
            
            default:
                $type = 'Not Identified';
                $status = 'danger';
                break;
        }
        if (!$show_name) {
            $name = '';
        }
        
        $xhtml = sprintf('%s (<small class="ml-auto badge badge-%s">%s %s</small>)',$name,$status,$duration,$type);
        return $xhtml;
    }
}

/**
 * @param int $sort
 * @param name $controllerName
 * @return rerturn Sort html 
 */
if (!function_exists('show_item_sort')) {
    function show_item_sort($controller_name, $id, $sort)
    {
        $xhtml = null;
        $link = admin_url($controller_name . '/change_sort/');
        $xhtml = sprintf('<input type="text" class="form-control text-center ajaxChangeSort" data-url="%s" data-id="%s" min="1" style="width:65px;" id="sort" value="%s">', $link, $id, $sort);
        return $xhtml;
    }
}

/**
 * From V3.6
 * @param array $items_status_button
 * @param name $controller_name
 * @return HTML Create Status Filter Button
 * @author Seji2906
 */
if (!function_exists('show_filter_status_button')) {
    function show_filter_status_button($controller_name, $items_status_button = "", $params,$type='')
    {
        $xhtml = null;
        $config_status       = app_config('config')['status'];
        if ( $items_status_button && count($items_status_button) > 0) {

            $current_tmpl_status = (in_array($controller_name, array_keys($config_status))) ? $controller_name . '_status' : 'status';
            $tmpl_status         = app_config('template')[$current_tmpl_status];

            $xhtml .= '<div class="btn-group w-30 m-b-10">';
            array_unshift($items_status_button, [
                'status' => 3,
                'count'  => array_sum(array_column($items_status_button, 'count'))
            ]);

            $param_search = $params['search'];
            $current_search = array_combine(array_keys($param_search), array_values($param_search));
            foreach ($items_status_button as $key => $item) {
                if ($type=='merchant') {
                    $link = client_url($controller_name) . '?status=' . $item['status'];
                }else{
                    $link = admin_url($controller_name) . '?status=' . $item['status'];
                }
                if ($current_search['query'] != "") {
                    $link .= '&' . http_build_query($current_search);
                }
                $current_status = (array_key_exists($item['status'], $tmpl_status)) ? $item['status'] : 'all'; //Default
                $current_class  = (get('status') == $item['status'] ) ? 'btn-primary' : '';
                $xhtml .= sprintf('<a href="%s" class="btn %s">%s <span class="badge light badge-pill %s">%s</span></a>',
                    $link, $current_class, $tmpl_status[$current_status]['name'], $tmpl_status[$current_status]['class'], $item['count']
                );
            }
            $xhtml .= '</div>';
        }
        return $xhtml;
    }
}

/**
 * @param str $content
 * @param $length
 * @param $prefix
 * @return Short Content for article, faqs
 */
if (!function_exists('show_content')) {
    function show_content($content, $length, $prefix = '...')
    {
        $prefix = ($length == 0) ? '' : $prefix;
        $content = strip_tags($content);
        $content = truncate_string($content, $length, $prefix);
        return $content;
    }
}



/**
 * From V3.6
 * @param $item_type
 * @return html for item news type
 */
if (!function_exists('show_item_news_type')) {
    function show_item_news_type($item_type)
    {
        $xhtml = null;
        $tmpl = app_config('template')['news'][$item_type];
        $xhtml = sprintf('<span class="badge %s">%s</span>', $tmpl['class'], $tmpl['name']);
        return $xhtml;
    }
}



/**
 * From V3.6
 * @param $item data
 * @return html for subject
 */
if (!function_exists('show_item_ticket_subject')) {
    function show_item_ticket_subject($controller_name, $item_data, $params = [])
    {
        $xhtml = null;
        $xhtml_un_read = null;
        if ($item_data['admin_read']) {
            $xhtml_un_read = '<span class="badge bg-purple-lt">Unread</span>';
        }
        $link    = admin_url($controller_name . '/view/'. $item_data['id']);
        $subject = show_high_light(esc($item_data['subject']), $params['search'], 'subject');
        
        $xhtml   = sprintf('<a href="%s">%s %s</a>', $link, $subject, $xhtml_un_read);
        return $xhtml;
    }
}

/**
 * From V3.6
 * @param $item data
 * @return html for ticket message detail
 */
if (!function_exists('show_item_ticket_message_detail')) {
    function show_item_ticket_message_detail($controller_name, $item = [], $task = '')
    {
        $xhtml = null; 
        $xhtml_footer = null;
        if (isset($item['support']) && $item['support']) {
            $class_item  = 'flex-row-reverse tr_'.$item['ids'];
            $img_class  = 'image-box ms-sm-4 ms-2 mb-4 float-end';
            $img_url          = get_avatar('','admin');
            $type='sent';
            if ($task == 'user') {
                $edit_item_link = null;
                $delete_item_link = null;
            } else {
                $edit_item_link   = admin_url($controller_name . '/edit_item_ticket_message/' . $item['ids'] );
                $delete_item_link = admin_url($controller_name . '/delete_item_ticket_message/' . $item['ids'] );
                $xhtml_footer = sprintf(
                    '<div class="msg-footer p-t-5">
                        <a href="%s" class="ajaxModal btn btn-sm btn-info" data-bs-toggle="tooltip" data-placement="bottom" data-original-title="Edit message">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="%s" class="ajaxDeleteItem btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-placement="bottom" data-confirm_ms="Are you sure to delete this?" data-original-title="Delete">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>', $edit_item_link, $delete_item_link
                );
            }
        } else {
            $class_item  = 'justify-content-start';
            $img_url = get_avatar('','user',$item['uid']);
            $img_class='image-box me-sm-4 me-2 float-start';
            $type= 'received';
        }
        $content = str_replace("\n", "<br>", esc($item['message']));
        $created = show_item_datetime($item['created'], 'long');
        $author  = $item['first_name'] . ' ' .$item['last_name'];
        if (isset($item['author'])) {
            $author  = $item['author'];
        }
        $xhtml   = sprintf(
            '<div class="media m-2 %s align-items-%s ">
                <div class="%s"><img class="rounded-circle" height="40" src="%s" alt="Image Icon" /></div>
                <div class="message-%s">
                    <div>
                        <strong>%s</strong>
                        <span class="text-muted small"> %s </span>
                    </div>
                    <div class="msg-content"> %s </div>
                    %s
                </div></div>', $class_item,$class_item,$img_class,$img_url,$type, $author, $created, $item['message'], $xhtml_footer);
        return $xhtml;
    }
}

/**
 * From V3.6
 * @param $item data
 * @return html button group in Ticket View
 */
if (!function_exists('show_view_ticket_button_group')) {
    function show_view_ticket_button_group($controller_name, $item = [])
    {
        $xhtml = null;
        $xhtml_dropdown = null;
        $closed_link = admin_url($controller_name."/change_status/closed/".$item['id']);
        $dropdowns = [
            'answered' =>  'Mark as Answered',   
            'pending'  =>  'Mark as Pending',   
            'unread'   =>  'Mark as Unread',   
        ];
        if ($dropdowns) {
            $xhtml_dropdown = '<div class="btn-group" role="group"> 
            <button id="btnGroupDrop1" type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">';
            foreach ($dropdowns as $key => $dropdown) {
                $link = admin_url($controller_name."/change_status/" . $key .'/'. $item['id']);
                $xhtml_dropdown .= sprintf('<a href="%s" class="dropdown-item">%s</a>', $link, $dropdown);
            }
            $xhtml_dropdown .= '</div></div>';
        }
        $xhtml   = sprintf(
            '<div class="btn-group float-end m-3" role="group" aria-label="Actions Group">
                <a href="%s" class="btn btn-outline-primary">Close ticket</a>
                %s
            </div>', $closed_link, $xhtml_dropdown);
        return $xhtml;
    }
}

/**
 * From V3.6
 * @param $item data
 * @return html button group in Ticket View
 */
if (!function_exists('show_items_sort_by_category')) {
    function show_items_sort_by_category($controller_name, $items = [], $params)
    {
        $xhtml = null;
        $link = admin_url($controller_name);
        $xhtml_select = null;
        if ($items ) {
            foreach ($items as $key => $item) {
                $selected = ($item['id'] == $params['sort_by']['cate_id']) ? 'selected' : '';
                $xhtml_select .= sprintf('<option value="%s" %s>%s</option>', $item['id'], $selected, $item['name']);
            }
        }
        $xhtml   = sprintf(
            '<select name="status" class="form-select order_by ajaxListServicesSortByCateogry m-t-4 m-r-10" data-url="%s">
                <option value="0">All</option>
                %s
            </select>', $link, $xhtml_select);
        return $xhtml;
    }
}

/**
 * From V3.6
 * @param $item data
 * @return html Order Details
 */
if (!function_exists('show_item_order_details')) {
    function show_item_order_details($controller_name, $item = [], $params = [], $task = 'admin')
    {
        $related_order_link = admin_url();
        if ($task == 'user') {
            return show_user_item_order_details($controller_name, $item, $params);
            $related_order_link = cn();
        }
        $xhtml = null;
        if ($controller_name != 'subscriptions') {
            $link = show_high_light(esc($item['link']), $params['search'], 'link');
            if (filter_var($item['link'], FILTER_VALIDATE_URL)) {
                $link = '<a href="https://anon.ws/?' . $item['link'] . '" class="link-word-break" target="_blank">' . show_high_light(esc($item['link']), $params['search'], 'link') . '</a>';
            }
        }

        $provider = 'Manual';
        if ($item['api_service_id']) {
            $provider = $item['api_name'] . " (ID:" . $item['api_service_id'] . ")";
            if ($item['type'] == 'api') {
                $provider .= ' <span class="badge badge-default">API</span>';
            }
        }

        switch ($controller_name) {
            case 'subscriptions':
                $username = show_high_light(esc($item['username']), $params['search'], 'username');
                $real_posts = 0; 
                if (!empty($item['sub_response_posts']) ) {
                    $link_detail = $related_order_link . 'order?subscription=' . $item['id'];
                    $real_posts = sprintf('<strong><a href="%s">%s</a></strong>', $link_detail, $item['sub_response_posts']);
                }                
                $posts = sprintf('%s / %s', $real_posts, $item['sub_posts']);

                $delay = ((int)$item['sub_delay'] > 0) ? $item['sub_delay'] . ' minutes' : 'No delay';
                $expiry = "";
                if (!empty($item['sub_expiry']) && strtotime($item['sub_expiry']) != "") {
                    $expiry = show_item_datetime($item['sub_expiry'], 'short');
                } 
                $order_attrs = [
                    'provider'      => $provider,
                    'username'      => $username,
                    'quantity'      => $item['sub_min'] . '/' . $item['sub_max'],
                    'post'          => $posts,
                    'delay'         => $delay,
                    'expiry'        => $expiry,
                ];
                break;
            case 'dripfeed':
                $real_runs = 0;
                if (!empty($item['sub_response_orders']) ) {
                    $link_detail = $related_order_link . 'order?drip-feed=' . $item['id'];
                    $real_runs = sprintf('<strong><a href="%s">%s</a></strong>', $link_detail, get_value($item['sub_response_orders'], 'runs'));
                }
                $runs = sprintf('%s / %s', $real_runs, $item['runs']);
                $order_attrs = [
                    'provider'      => $provider,
                    'link'          => $link,
                    'quantity'      => $item['dripfeed_quantity'],
                    'total charge'  => (double)$item['charge'],
                    'runs'           => $runs,
                    'interval'        => $item['interval'],
                    'total quantity'  => $item['quantity'],
                ];
                break;

            case 'refill':
                $order_attrs = [
                    'provider'      => $provider,
                    'link'          => $link,
                    'quantity'      => $item['quantity'],
                    'start counter' => ($item['start_counter']) ? $item['start_counter'] : '',
                ];
                break;
            
            default:
                $charge =  get_option("currency_symbol", "") . (double)$item['charge'];
                if ($item['formal_charge'] != 0) {
                    $charge .= ' ('. (double)$item['formal_charge']. ' / <span class="text-info">'. (double)$item['profit'] .'</span>)';
                }
                
                $order_attrs = [
                    'provider'      => $provider,
                    'link'          => $link,
                    'quantity'      => $item['quantity'],
                    'charge'        => $charge,
                    'start counter' => ($item['start_counter']) ? $item['start_counter'] : '',
                    'remain'        => ($item['remains']) ? $item['remains'] : '',
                ];
                break;
        }
        $xhtml_order_attr = null;
        $xhtml_order_attr = '<ul style="margin: 0px;">';
        foreach ($order_attrs as $key => $attr) {
            $attr_content = ucfirst($key) . ': ' . $attr;
            $xhtml_order_attr .= sprintf('<li>%s</li>', $attr_content);
        }
        // custom mention: custom comments, user mentions
        if ($controller_name == 'order') {
            $xhtml_order_attr .= show_item_mention_view($item);
        }

        $xhtml_order_attr .= '</ul>';
        $service_name = $item['service_id'] ." - ". $item['service_name'];
        $xhtml .= sprintf(
            '<div class="title">
                <h6>%s
            </div>
            <div>
                %s
            </div>', $service_name, $xhtml_order_attr);
        return $xhtml;
    }
}

/**
 * From V3.6
 * @param $item data
 * @return html Order Details in user page
 */
if (!function_exists('show_user_item_order_details')) {
    function show_user_item_order_details($controller_name, $item = [], $params = [])
    {
        $xhtml = null;
        if ($controller_name != 'subscriptions') {
            $params['search']['field'] = 'link';
            $link = show_high_light(esc($item['link']), $params['search'], 'link');
            if (filter_var($item['link'], FILTER_VALIDATE_URL)) {
                $link = '<a href="https://anon.ws/?' . $item['link'] . '" class="link-word-break" target="_blank">' . show_high_light(esc($item['link']), $params['search'], 'link') . '</a>';
            }
        }
        $related_order_link = cn();
        switch ($controller_name) {
            case 'subscriptions':
                $username = show_high_light(esc($item['username']), $params['search'], 'username');

                $real_posts = 0; 
                if (!empty($item['sub_response_posts']) ) {
                    $link_detail = $related_order_link . 'order?subscription=' . $item['id'];
                    $real_posts = sprintf('<strong><a href="%s">%s</a></strong>', $link_detail, $item['sub_response_posts']);
                }                
                $posts = sprintf('%s / %s', $real_posts, $item['sub_posts']);

                $delay = ((int)$item['sub_delay'] > 0) ? $item['sub_delay'] . ' minutes' : 'No delay';
                $expiry = "";
                if (!empty($item['sub_expiry']) && strtotime($item['sub_expiry']) != "") {
                    $expiry = show_item_datetime($item['sub_expiry'], 'short');
                } 
                $order_attrs = [
                    'username'          => ['name' => lang('Username'), 'value' => $username],
                    'quantity'          => ['name' => lang('Quantity'), 'value' => $item['sub_min'] . '/' . $item['sub_max']],
                    'posts'             => ['name' => lang('Posts'),    'value' => $posts],
                    'delay'             => ['name' => lang('Delay'),    'value' => $delay],
                    'expiry'            => ['name' => lang('Expiry'),   'value' => $expiry],
                ];
                break;
            case 'dripfeed':
                $real_runs = 0;
                if (!empty($item['sub_response_orders']) ) {
                    $link_detail = $related_order_link . 'order?drip-feed=' . $item['id'];
                    $real_runs = sprintf('<strong><a href="%s">%s</a></strong>', $link_detail, get_value($item['sub_response_orders'], 'runs'));
                }
                $runs = sprintf('%s / %s', $real_runs, $item['runs']);
                $order_attrs = [
                    'link'          => ['name' => lang('Link'), 'value' => $link],
                    'quantity'      => ['name' => lang('Quantity'), 'value' => $item['dripfeed_quantity']],
                    'total charge'  => ['name' => lang('Amount'), 'value' => (double)$item['charge']],
                    'runs'          => ['name' => lang('Runs'), 'value' => $runs],
                    'interval'        => ['name' => lang('interval'), 'value' => $item['interval']],
                    'total quantity'  => ['name' => lang('total_quantity'), 'value' => $item['quantity']],
                ];
                break;
            
            case 'refill':
                $order_attrs = [
                    'link'          => ['name' => lang('Link'), 'value' => $link],
                    'quantity'      => ['name' => lang('Quantity'), 'value' => $item['quantity']],
                    'start_counter'   => ['name' => lang('Start_counter'), 'value' => ($item['start_counter']) ? $item['start_counter'] : ''],
                ];
                break;
            
            default:
                $charge =  get_option("currency_symbol", "") . (double)$item['charge'];
                $order_attrs = [
                    'link'          => ['name' => lang('Link'), 'value' => $link],
                    'quantity'      => ['name' => lang('Quantity'), 'value' => $item['quantity']],
                    'charge'          => ['name' => lang('Charge'), 'value' => $charge],
                    'start_counter'   => ['name' => lang('Start_counter'), 'value' => ($item['start_counter']) ? $item['start_counter'] : ''],
                    'remain'  => ['name' => lang('Remains'), 'value' => ($item['remains']) ? $item['remains'] : ''],
                ];
                break;
        }
        $xhtml_order_attr = null;
        $xhtml_order_attr = '<ul style="margin: 0px;">';
        foreach ($order_attrs as $key => $attr) {
            $attr_content = ucfirst($attr['name']) . ': ' . $attr['value'];
            $xhtml_order_attr .= sprintf('<li>%s</li>', $attr_content);
        }
        $xhtml_order_attr .= '</ul>';
        $service_name = $item['service_id'] ." - ". $item['service_name'];
        $xhtml .= sprintf(
            '<div class="title">
                <h6>%s
            </div>
            <div>
                %s
            </div>', $service_name, $xhtml_order_attr);
        return $xhtml;
    }
}

/**
 * From V3.6
 * @param $item data
 * @return html Order ID
 */
if (!function_exists('show_item_order_id')) {
    function show_item_order_id($controller_name, $item = [], $params=[])
    {
        $xhtml    = null;
        $order_id     = show_high_light($item['id'], $params['search'], 'id');
        $api_order_id = '';
        if ($item['api_order_id'] > 0) {
            $api_order_id = show_high_light($item['api_order_id'], $params['search'], 'api_order_id');
        }
        $xhtml = sprintf('
            %s
            <div class="text-muted small">
                %s
            </div>
        ', $order_id, $api_order_id);
        return $xhtml;
    }
}

/**
 * From V3.6
 * @param $item mention: custom comment
 * @return html mention order View
 */
if (!function_exists('show_item_mention_view')) {
    function show_item_mention_view($item = [])
    {
        $xhtml = null;
        $mention_list = get_list_custom_mention($item);
        if (!$mention_list->exists_list) {
            return null;
        }
        $description = '';
        if ($mention_list->list) {
            $description = html_entity_decode($mention_list->list, ENT_QUOTES);
            $description = str_replace("\n", "<br>", $description);
            $params = [
                'btn-class'        => 'btn-outline-primary',
                'btn-title'        => $mention_list->title,
                'modal-id'         => 'order-'.$item['id'],
                'modal-title'            => $mention_list->title,
                'modal-body-content'     => $description,
            ];
            $xhtml =  render_modal_html($params);
        }
        return $xhtml;
    }
}


/**
 * From V4.0
 * @param $item data
 * @return html button details
 */
if (!function_exists('show_item_details')) {
    function show_item_details($controller_name, $item = [])
    {
        $xhtml = null;
        switch ($controller_name) {
            case 'refill':
                $params = [
                    'btn-class'        => 'btn-primary',
                    'btn-title'        => 'Details',
                    'modal-id'         => 'service-'.$item['id'],
                    'modal-title'            => 'Details',
                    'modal-body-content'     => render_modal_body_content($controller_name, $item),
                ];
                $xhtml =  render_modal_html($params);
                break;

            case 'services':
                if (!empty($item['desc'])) {
                    $params = [
                        'btn-class'        => 'btn-primary',
                        'btn-title'        => lang('View'),
                        'modal-id'         => 'service-'.$item['id'],
                        'modal-title'            => $item['id'] . ' - '. $item['name'],
                        'modal-body-content'     => render_modal_body_content($controller_name, $item),
                    ];
                    $xhtml =  render_modal_html($params);
                }
                break;
        }
        return $xhtml;
    }
}

/**
 * From V4.0
 * @param $item data
 * @return html item services attr
 */
if (!function_exists('show_item_service_attr')) {
    function show_item_service_attr($item = [])
    {
        $xhtml = null;
        if ($item['dripfeed']) {
            $xhtml .= ' <span class="fa fa-tint" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Drip-feed enabled"></span>';
        }
        if ($item['refill']) {
            $xhtml .= ' <span class="fe fe-repeat" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Refill allowed"></span>';
        }
        return $xhtml;
    }
}

/**
 * From V3.6
 * @param $payment_method
 * @return html for transaction payment type
 */
if (!function_exists('show_item_transaction_type')) {
    function show_item_transaction_type($payment_method)
    {
        $xhtml = null;
        $params=get_field('payments', ['type' => $payment_method], "params");
        $image_payment_path='';
        if($params){$image_payment_path = json_decode($params)->option->logo;}
        if (!empty($image_payment_path)) {
            $xhtml = sprintf('<img class="payment" src="%s" alt="%s" height="25">', base_url().$image_payment_path, $payment_method);
        } else {
            $xhtml = sprintf('<span class="badge bg-azure">%s</span>', ucfirst($payment_method));
        }
        return $xhtml;
    }
}

/**
 * From V3.6
 * @param $user_activity
 * @return str Activity type
 */
if (!function_exists('show_item_activity')) {
    function show_item_activity($user_activity)
    {
        if ($user_activity) {
            return 'check in';
        }
        return 'check out';
    }
}

/**
 * From V3.6
 * @param $dateTime
 * @return new Datetime format
 */
if (!function_exists('show_item_datetime')) {
    function show_item_datetime($datetime, $type = 'long')
    {
        $datetime = convert_timezone($datetime, 'user');
        $new_datetime = date(app_config('template')['datetime'][$type], strtotime($datetime));
        return $new_datetime;
    }
}


if (!function_exists('show_progress_report')) {
    function show_progress_report()
    {
        $arr = json_decode(get_current_user_data()->more_information);

        $i=1;
        $j=1;

        if (!empty($arr)) {
            foreach($arr as $key => $val){
                $j++;
                if (isset($arr->$key) && !empty($arr->$key)) {
                    $i++;
                }
            }
        }
        $p = intdiv($j,$i)*100;
        $a = $i.'/'.$j;
        $xhtml = null;
        $xhtml .= sprintf('<div class="d-flex justify-content-between mb-2 progress-info">
            <span class="fs-12"><i class="fas fa-star text-orange me-2"></i>Account Progress</span>
            <span class="fs-12">%s</span>
        </div>
        <div class="progress default-progress">
            <div class="progress-bar bg-gradientf progress-animated" style="width: %s; height:10px;" role="progressbar">
                <span class="sr-only">%s Complete</span>
            </div>
        </div>',$a,$p."%",$p."%");
        return $xhtml;
    }
}



