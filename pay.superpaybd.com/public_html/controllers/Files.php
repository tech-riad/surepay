<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends CI_Controller {
	public $tb_file_manage;

	public function upload_files()
    {
		// if (!$this->input->is_ajax_request()) redirect(base_url());
        get_upload_folder();
        $path = './assets/uploads/user' . sha1(session("uid"));
        $allowed_types = 'jpg|png';
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

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('fileToUpload')) {
            ms(array(
                "status" => "error",
                "message" => $this->upload->display_errors(),
            ));
        } else {
            $file_info = (object) $this->upload->data();
            $data = array(
                "ids" => ids(),
                "uid" => session("uid"),
                "file_name" => $file_info->file_name,
                "file_type" => $file_info->file_type,
                "file_size" => $file_info->file_size,
                "is_image" => $file_info->is_image,
                "image_width" => $file_info->image_width,
                "image_height" => $file_info->image_height,
                "file_ext" => str_replace(".", "", strtolower($file_info->file_ext)),
                "created" => now(),
            );
            $this->db->insert('general_file_manager', $data);
            ms(array(
                "status" => "success",
                "link" => get_link_file($file_info->file_name),
                "ids" => $data["ids"],
                "message" => 'Upload successfully',
            ));
        }

    }

}

/* End of file Files.php */
/* Location: .//E/laragon/www/payment/app/controllers/Files.php */