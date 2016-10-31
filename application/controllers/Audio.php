<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audio extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['error'] = '';
        $this->load->view('templates/template_header');
        $this->load->view('upload_audio', $data);
    }

    public function upload()
    {
        $start = microtime(true);
        $input_audio = $this->input->post();
        $convert_to = $input_audio['convert_to'];
        if(isset($input_audio['bitrate']))
            $bitrate = $input_audio['bitrate']+'k';
        else
            $bitrate = false;

        if(isset($input_audio['codec']))
            $codec = $input_audio['codec'];
        else
            $codec = false;

        $config = array(
            'upload_path' => "./uploads/Audio/",
            'allowed_types' => "wav|ac3|mp3",
            'overwrite' => TRUE,
            'max_size' => "20480000"
        );
        $this->load->library('upload', $config);

        if($this->upload->do_upload())
        {
            $data = array('upload_data' => $this->upload->data());
            $file_name = $data['upload_data']['file_name'];

            $output = "";

            if(!$bitrate)
                exec("python audio.py -f ".$file_name." -c ".$convert_to." 2>&1", $output);
            else{
                if(!$codec)
                    exec("python audio.py -f ".$file_name." -c ".$convert_to." -b ".$bitrate." 2>&1", $output);
                else
                    exec("python audio.py -f ".$file_name." -c ".$convert_to." -b ".$bitrate." -e ".$codec." 2>&1", $output);
            }

           // var_dump($output);
           // return;
            $data['ori_size'] = filesize('./uploads/Audio/'.$file_name);
            $file_name = explode('.', $file_name);
            $data['com_size'] = filesize('./compressed/Audio/'.$file_name[0].'.'.$convert_to);
            $data['com_ratio'] = number_format((float)$data['ori_size']/$data['com_size'], 2, '.', '');
            $data['exec_time'] = number_format((float)microtime(true) - $start, 2, '.', '');
            $data['download'] = 'Audio/download/'.$file_name[0].'.'.$convert_to;

            // var_dump($data);
            // exit();
            $data['error'] = '';
            $this->load->view('templates/template_header');
            $this->load->view('upload_audio', $data);
        }
        else
        {
            $error = array('error' => $this->upload->display_errors());
            // var_dump($error);
            // exit();
            $this->load->view('templates/template_header');
            $this->load->view('upload_audio',$error);
        }
    }

    public function download($file_name){
        force_download('./compressed/Audio/'.$file_name, NULL);
    }
}
