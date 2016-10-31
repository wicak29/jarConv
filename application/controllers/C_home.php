<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_home extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('upload_image', array('error' => ' ' ));
	}

	public function viewUploadImage()
	{
		$this->load->view('upload_image', array('error' => ' ' ));
	}

	public function ConvertBMP2GD($src, $dest = false) 
	{
		if(!($src_f = fopen($src, "rb"))) 
		{
			return false;
		}
		if(!($dest_f = fopen($dest, "wb"))) 
		{
			return false;
		}
		$header = unpack("vtype/Vsize/v2reserved/Voffset", fread($src_f,14));
		$info = unpack("Vsize/Vwidth/Vheight/vplanes/vbits/Vcompression/Vimagesize/Vxres/Vyres/Vncolor/Vimportant",fread($src_f, 40));

		extract($info);
		extract($header);

		if($type != 0x4D42) 
		{ // signature "BM"
			return false;
		}

		$palette_size = $offset - 54;
		$ncolor = $palette_size / 4;
		$gd_header = "";
		// true-color vs. palette
		$gd_header .= ($palette_size == 0) ? "\xFF\xFE" : "\xFF\xFF";
		$gd_header .= pack("n2", $width, $height);
		$gd_header .= ($palette_size == 0) ? "\x01" : "\x00";
		if($palette_size) 
		{
			$gd_header .= pack("n", $ncolor);
		}

		// no transparency
		$gd_header .= "\xFF\xFF\xFF\xFF";

		fwrite($dest_f, $gd_header);

		if($palette_size) 
		{
			$palette = fread($src_f, $palette_size);
			$gd_palette = "";
			$j = 0;
			while($j < $palette_size) 
			{
				$b = $palette{$j++};
				$g = $palette{$j++};
				$r = $palette{$j++};
				$a = $palette{$j++};
				$gd_palette .= "$r$g$b$a";
			}
			$gd_palette .= str_repeat("\x00\x00\x00\x00", 256 - $ncolor);
			fwrite($dest_f, $gd_palette);
		}

		$scan_line_size = (($bits * $width) + 7) >> 3;
		$scan_line_align = ($scan_line_size & 0x03) ? 4 - ($scan_line_size &
		0x03) : 0;

		for($i = 0, $l = $height - 1; $i < $height; $i++, $l--) 
		{
		// BMP stores scan lines starting from bottom
			fseek($src_f, $offset + (($scan_line_size + $scan_line_align) *
			$l));
			$scan_line = fread($src_f, $scan_line_size);
			if($bits == 24) 
			{
				$gd_scan_line = "";
				$j = 0;
				while($j < $scan_line_size) 
				{
					$b = $scan_line{$j++};
					$g = $scan_line{$j++};
					$r = $scan_line{$j++};
					$gd_scan_line .= "\x00$r$g$b";
				}
			}
			else if($bits == 8) 
			{
				$gd_scan_line = $scan_line;
			}
			else if($bits == 4) 
			{
				$gd_scan_line = "";
				$j = 0;
				while($j < $scan_line_size) 
				{
					$byte = ord($scan_line{$j++});
					$p1 = chr($byte >> 4);
					$p2 = chr($byte & 0x0F);
					$gd_scan_line .= "$p1$p2";
				} 
				$gd_scan_line = substr($gd_scan_line, 0, $width);
			}
			else if($bits == 1) 
			{
				$gd_scan_line = "";
				$j = 0;
				while($j < $scan_line_size) 
				{
					$byte = ord($scan_line{$j++});
					$p1 = chr((int) (($byte & 0x80) != 0));
					$p2 = chr((int) (($byte & 0x40) != 0));
					$p3 = chr((int) (($byte & 0x20) != 0));
					$p4 = chr((int) (($byte & 0x10) != 0));
					$p5 = chr((int) (($byte & 0x08) != 0));
					$p6 = chr((int) (($byte & 0x04) != 0));
					$p7 = chr((int) (($byte & 0x02) != 0));
					$p8 = chr((int) (($byte & 0x01) != 0));
					$gd_scan_line .= "$p1$p2$p3$p4$p5$p6$p7$p8";
				} 
				$gd_scan_line = substr($gd_scan_line, 0, $width);
			}
			fwrite($dest_f, $gd_scan_line);
		}
		fclose($src_f);
		fclose($dest_f);
		return true;
	}

	public function imagecreatefrombmp($filename) 
	{
		$tmp_name = tempnam("/tmp", "GD");
		if($this->ConvertBMP2GD($filename, $tmp_name)) 
		{
			$img = imagecreatefromgd($tmp_name);
			unlink($tmp_name);
			return $img;
		} 
		return false;
	}

	public function do_upload()
	{
		$start = microtime(true);
		$config = array(
			'upload_path' => "./uploads/",
			'allowed_types' => "bmp|jpg",
			'overwrite' => TRUE,
			'max_size' => "204800", // Can be set to particular file size , here it is 2 MB(2048 Kb)
			'max_height' => "2000",
			'max_width' => "2000"
		);
		$this->load->library('upload', $config);

		if($this->upload->do_upload())
		{
			$data = array('upload_data' => $this->upload->data());

			$jpg_path = "./compressed/compress_".$data['upload_data']['raw_name'].".jpg";
			$png_path = "./compressed/compress_".$data['upload_data']['raw_name'].".png";
			$gif_path = "./compressed/compress_".$data['upload_data']['raw_name'].".gif";
			$wbmp_path = "./compressed/compress_".$data['upload_data']['raw_name'].".wbmp";

			$img = $this->imagecreatefrombmp("./uploads/".$data['upload_data']['file_name']);
			// $img = imagecreatefromjpeg("./uploads/".$data['upload_data']['file_name']);
			imagejpeg($img, $jpg_path, 100);
			imagepng($img, $png_path);
			imagegif($img, $gif_path);
			imagewbmp($img, $wbmp_path);

			$data['size_bmp'] = number_format((float)$data['upload_data']['file_size']/1.024, 2, '.', '');
			$data['size_jpg'] = number_format((float)filesize($jpg_path)/1024, 2, '.', '');
			$data['size_png'] = number_format((float)filesize($png_path)/1024, 2, '.', '');
			$data['size_gif'] = number_format((float)filesize($gif_path)/1024, 2, '.', '');
			$data['exec_time'] = number_format((float)microtime(true) - $start, 3, '.', '');

			$data['bmp_ratio'] = number_format((float)$data['upload_data']['file_size']/(float)$data['upload_data']['file_size']*100, 2, '.', '');
			$data['jpg_ratio'] = number_format((float)$data['size_jpg']/(float)$data['upload_data']['file_size']*100, 2, '.', '');
			$data['png_ratio'] = number_format((float)$data['size_png']/(float)$data['upload_data']['file_size']*100, 2, '.', '');
			$data['gif_ratio'] = number_format((float)$data['size_gif']/(float)$data['upload_data']['file_size']*100, 2, '.', '');
			// print_r($data);
			$this->load->view('upload_sukses',$data);
		}
		else
		{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('upload_image', $error);
		}
	}

	public function LoadJpeg($imgname)
	{
	    /* Attempt to open */
	    $im = @imagecreatefromjpeg($imgname);

	    /* See if it failed */
	    if(!$im)
	    {
	        /* Create a black image */
	        $im  = imagecreatetruecolor(150, 30);
	        $bgc = imagecolorallocate($im, 255, 255, 255);
	        $tc  = imagecolorallocate($im, 0, 0, 0);

	        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

	        /* Output an error message */
	        imagestring($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
	    }
	    else
	    {
	    	imagejpeg($im,"./compressed/temp_img.jpg",50);
	    }

	    return $im;
	}

	public function do_upload1()
	{
		$start = microtime(true);
		$out = $this->input->post('outType');
		$quality = $this->input->post('quality');
		// print_r($quality);
		// return;
		$config = array(
			'upload_path' => "./uploads/",
			'allowed_types' => "jpg",
			'overwrite' => TRUE,
			'max_size' => "204800", // Can be set to particular file size , here it is 2 MB(2048 Kb)
			'max_height' => "20000",
			'max_width' => "20000"
		);
		$this->load->library('upload', $config);

		if($this->upload->do_upload())
		{
			ini_set('memory_limit','512M');
			$data = array('upload_data' => $this->upload->data());

			$jpg_path = "./compressed/compress_".$data['upload_data']['raw_name'].".jpg";
			$png_path = "./compressed/compress_".$data['upload_data']['raw_name'].".png";
			$gif_path = "./compressed/compress_".$data['upload_data']['raw_name'].".gif";
			$wbmp_path = "./compressed/compress_".$data['upload_data']['raw_name'].".bmp";
			$tiff_path = "./compressed/compress_".$data['upload_data']['raw_name'].".tiff";

			// $img = $this->imagecreatefrombmp("./uploads/".$data['upload_data']['file_name']);
			// $img = imagecreatefromjpeg("./uploads/".$data['upload_data']['file_name']);
			$loadimg = $this->LoadJpeg("./uploads/".$data['upload_data']['file_name']);
			$img = imagecreatefromjpeg("./compressed/temp_img.jpg");
			// $img = imagejpeg($img, $jpg_path, 50);

			// imagejpeg($img, $jpg_path, 100);
			$data['size_ori'] = number_format((float)$data['upload_data']['file_size']/1.024, 2, '.', '');
			$data['ori_ratio'] = number_format((float)$data['upload_data']['file_size']/(float)$data['upload_data']['file_size']*100, 2, '.', '');

			if ($out=="png")
			{
				imagepng($img, $png_path, $quality/10);	
				$data['size'] = number_format((float)filesize($png_path)/1024, 2, '.', '');
				$data['ratio'] = number_format((float)$data['size']/(float)$data['upload_data']['file_size']*100, 2, '.', '');
				$data['tipe'] = 1;
			}
			elseif ($out=="gif") 
			{
				imagegif($img, $gif_path);
				$data['size'] = number_format((float)filesize($gif_path)/1024, 2, '.', '');
				$data['ratio'] = number_format((float)$data['size']/(float)$data['upload_data']['file_size']*100, 2, '.', '');
				$data['tipe'] = 2;
			}
			elseif ($out=="jpg") 
			{
				imagejpeg($img, $jpg_path, $quality);
				$data['size'] = number_format((float)filesize($jpg_path)/1024, 2, '.', '');
				$data['ratio'] = number_format((float)$data['size']/(float)$data['upload_data']['file_size']*100, 2, '.', '');
				$data['tipe'] = 3;
			}
			elseif ($out=="bmp") 
			{
				imagewbmp($img, $wbmp_path);
				$data['size'] = number_format((float)filesize($wbmp_path)/1024, 2, '.', '');
				$data['ratio'] = number_format((float)$data['size']/(float)$data['upload_data']['file_size']*100, 2, '.', '');
				$data['tipe'] = 4;
			}
			elseif ($out=="tiff") 
			{
				imagejpeg($img, $tiff_path, $quality);
				$data['size'] = number_format((float)filesize($tiff_path)/1024, 2, '.', '');
				$data['ratio'] = number_format((float)$data['size']/(float)$data['upload_data']['file_size']*100, 2, '.', '');
				$data['tipe'] = 5;
			}
			
			// imagewbmp($img, $wbmp_path);

			// $data['size_bmp'] = number_format((float)$data['upload_data']['file_size']/1.024, 2, '.', '');
			
			
			$data['exec_time'] = number_format((float)microtime(true) - $start, 3, '.', '');

			// $data['bmp_ratio'] = number_format((float)$data['upload_data']['file_size']/(float)$data['upload_data']['file_size']*100, 2, '.', '');
			
			
			// print_r($data);
			$this->load->view('upload_sukses1',$data);
		}
		else
		{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('upload_image', $error);
		}
	}
}


// http://www.codingforums.com/archive/index.php/t-136009.html