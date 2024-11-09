<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Settings extends My_AdminController {

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');
        if (!is_current_logged_staff()) redirect(admin_url('logout'));
        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "settings";
        $this->params            = [];
    }

    public function index($tab = ""){
        $lang_db = null;
        $path              = APPPATH.'./modules/admin/views/settings/elements';
        $elements = get_name_of_files_in_dir($path, ['.php']);
        if (!in_array($tab, $elements) || $tab == "") {
            $tab = 'website_setting';
        }

        $data = array(
            "module" => get_class($this),
            "controller_name"   => $this->controller_name,
            "tab"               => $tab,
        );
        $this->template->build( $this->path_views . '/index', $data);
 
    }

    public function store()
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $data = $this->input->post();
        $default_home_page = $this->input->post("default_home_page");
        if (!empty($_POST['slug'])) {
            $data=null;

            foreach( $_POST['slug'] as $key => $slug ) {

                $data[$slug]=$_POST['value'][$key];
            }
            $this->create_php_lang_file($data);
            
        }elseif (is_array($data)) {
            foreach ($data as $key => $value) {

                if (in_array($key, ['embed_javascript','currency_code', 'embed_head_javascript', 'manual_payment_content'])) {
                    $value = htmlspecialchars(@$_POST[$key], ENT_QUOTES);
                }
                if ($key == 'new_currecry_rate') {
                    $value = (float)$value;
                    if ($value <= 0) {
                        $value = 1;
                    }
                }
                update_option($key, $value);
                // update_configs(['slug' => $key, 'value' => $value]);
            }
        }
        if ($default_home_page != "") {
            $theme_file = fopen(APPPATH . "../themes/config.json", "w");
            $txt = '{ "theme" : "' . $default_home_page . '" }';
            fwrite($theme_file, $txt);
            fclose($theme_file);
        }
        
        

        ms(["status"  => "success", "message" => 'Update successfully']);
    }

    private function create_php_lang_file($data_lang)
    {
        $path = realpath($_SERVER["DOCUMENT_ROOT"]).'/themes/'.get_theme(). "/theme_lang.php";        

        $languages = "<?php" . "\n";
        $languages .= "defined('BASEPATH') OR exit('No direct script access allowed');\n";
        foreach ($data_lang as $key => $value) {
            $languages .= '' . '$lang["' . $key . '"]' . ' ' . '=' . ' ' . '"' . trim(addslashes($value)) . '";' . "\n";
        }
        file_put_contents($path, $languages, LOCK_EX);
        if (file_exists($path)) {
            return true;
        }

    }
}