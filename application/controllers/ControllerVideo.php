<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControllerVideo extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('templates/template_header');
		$this->load->view('upload_video', array('error' => ' ' ));
	}

	public function do_upload(){
		$start = microtime(true);
		$config = array(
			'upload_path' => "./uploads/",
			'allowed_types' => "mp4|avi",
			'overwrite' => TRUE,
			'max_size' => "2000480000" // Can be set to particular file size , here it is 20 MB(2048 Kb)
		);
		$this->load->library('upload', $config);
		
		if($this->upload->do_upload())
		{
			$data = array('upload_data' => $this->upload->data());

            $file_name = $data['upload_data']['file_name'];
            $codec = $_POST['codec'];
            $output_extension = $_POST['output'];
			exec("python vidConf.py ".$file_name." ".$output_extension." ".$codec." 2>&1",$output);
			// var_dump($file_name);
			// var_dump($output);
			
			// exit();
			// exec(base_url()."vidConv.py ./uploads/".$data['upload_data']['file_name']." ".$_POST['output']);

			// redirect(base_url());
			$data['ori_size'] = filesize('./uploads/'.$file_name);
            $file_name = explode('.', $file_name);
            $data['com_size'] = filesize('./compressed/'.$file_name[0].'_convert'.$output_extension);
            $data['com_ratio'] = number_format((float)$data['ori_size']/$data['com_size'], 2, '.', '');
            $data['exec_time'] = number_format((float)microtime(true) - $start, 2, '.', '');
            $data['download'] = 'ControllerVideo/download/'.$file_name[0].'_convert'.$output_extension;
            $data['error'] = '';

			$this->load->view('templates/template_header');
			$this->load->view('upload_video',$data);
		}
		else
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('templates/template_header');
			$this->load->view('upload_video',$error);
		}
	}
	public function download($file_name){
        force_download('./compressed/'.$file_name, NULL);
    }

}