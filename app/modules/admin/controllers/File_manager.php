<?php
defined('BASEPATH') or exit('No direct script access allowed');

class File_manager extends MX_Controller
{
    public $tb_file_manage;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(get_class($this) . '_model', 'model');
        $this->tb_file_manage = FILE_MANAGER;
		$this->controller_name   = strtolower(get_class($this));
    }

    public function index()
    {
        redirect(cn()); 
    }

    public function upload_files()
    {
		if (!$this->input->is_ajax_request()) redirect(cn());
        get_upload_folder();
        $path = './assets/uploads/user' . sha1(session("uid"));
        $allowed_types = 'jpg|png';
        $max_size = 10 * 1024;
        $width = 1024;
        $height = 768;
        // config
        $config = array(
            'upload_path'   => $path,
            'allowed_types' => $allowed_types,
            'max_size'      => $max_size,
            'width'         => $width,
            'encrypt_name'  => true,
        );

        if (!empty($_FILES)) {
            $files = $_FILES;
            for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
                $_FILES['files']['name']     = $files['files']['name'][$i];
                $_FILES['files']['type']     = $files['files']['type'][$i];
                $_FILES['files']['tmp_name'] = $files['files']['tmp_name'][$i];
                $_FILES['files']['error']    = $files['files']['error'][$i];
                $_FILES['files']['size']     = $files['files']['size'][$i];

                // load libary;
                $this->load->library('upload', $config);

                $this->upload->initialize($config);
                if (!$this->upload->do_upload('files')) {
                    ms(array(
                        "status" => "error",
                        "message" => $this->upload->display_errors(),
                    ));
                } else {
                    
                    $file_info = (object) $this->upload->data();

                    $type = array('image/png'=>'png','image/jpg'=>'jpg','image/jpeg'=>'jpg');
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $path.'/'.$file_info->file_name;
                    $config['quality'] = '50%';

                    $this->load->library('image_lib');
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();


                    $data = array(
                        "ids" => ids(), 
                        "uid" => session("uid"),
                        "file_name" => $file_info->file_name,
                        "file_type" => $file_info->file_type,
                        "file_size" => $file_info->file_size,
                        "is_image" =>  $file_info->is_image,
                        "image_width" => $file_info->image_width,
                        "image_height" => $file_info->image_height,
                        "file_ext" => str_replace(".", "", strtolower($file_info->file_ext)),
                        "created" => now(),
                    );
                    $this->db->insert($this->tb_file_manage, $data);
                    ms(array(
                        "status" => "success",
                        "link" => get_link_file($file_info->file_name),
                        "ids" => $data["ids"],
                        "message" => 'Media uploaded successfully...',
                    ));
                }
            }
        } else {
             ms(array(
                "status" => "error",
                "message" => 'No Image',
            ));
        }
    }
    public function upload_all_files()
    {
        if (!$this->input->is_ajax_request()) redirect(cn());
        get_upload_folder();
        $path = './assets/uploads/user' . sha1(session("uid"));
        $allowed_types = 'jpg|png|jpeg|pdf';
        $max_size = 5 * 1024;
        $width = 1024;
        $height = 768;
        // config
        $config = array(
            'upload_path'   => $path,
            'allowed_types' => $allowed_types,
            'max_size'      => $max_size,
            'width'         => $width,
            'encrypt_name'  => true,
        );

        if (!empty($_FILES)) {
            $files = $_FILES;
            for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
                $_FILES['files']['name']     = $files['files']['name'][$i];
                $_FILES['files']['type']     = $files['files']['type'][$i];
                $_FILES['files']['tmp_name'] = $files['files']['tmp_name'][$i];
                $_FILES['files']['error']    = $files['files']['error'][$i];
                $_FILES['files']['size']     = $files['files']['size'][$i];

                // load libary;
                $this->load->library('upload', $config);

                $this->upload->initialize($config);
                if (!$this->upload->do_upload('files')) {
                    ms(array(
                        "status" => "error",
                        "message" => $this->upload->display_errors(),
                    ));
                } else {
                    
                    $file_info = (object) $this->upload->data();

                    $type = array('image/png'=>'png','image/jpg'=>'jpg','image/jpeg'=>'jpg');
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $path.'/'.$file_info->file_name;
                    $config['quality'] = '50%';

                    $this->load->library('image_lib');
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();


                    $data = array(
                        "ids" => ids(), 
                        "uid" => session("uid"),
                        "file_name" => $file_info->file_name,
                        "file_type" => $file_info->file_type,
                        "file_size" => $file_info->file_size,
                        "is_image" =>  $file_info->is_image,
                        "image_width" => $file_info->image_width,
                        "image_height" => $file_info->image_height,
                        "file_ext" => str_replace(".", "", strtolower($file_info->file_ext)),
                        "created" => now(),
                    );
                    $this->db->insert($this->tb_file_manage, $data);
                    ms(array(
                        "status" => "success",
                        "link" => get_link_file($file_info->file_name),
                        "ids" => $data["ids"],
                        "message" => 'Document uploaded successfully...',
                    ));
                }
            }
        } else {
             ms(array(
                "status" => "error",
                "message" => 'No Image',
            ));
        }
    }

    public function view_files($id=''){
        if (!$this->input->is_ajax_request()) {redirect(current_url());}
        $this->params = ['ids'=>$id];
        $item = $this->model->get_item($this->params,['task' => 'get-kyc']);
        $data['item']=$item; 
        $this->load->view('layouts/common/modal/files_reader',$data);
    }

    
}
