<html>
<head>
	<title>Upload Form</title>
		<meta charset="utf-8">
	    <title>Documentation - Bootflat</title>
	    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
	    
	    <!-- site css -->
	    <link rel="stylesheet" href="<?php echo base_url('assets/bootflat');?>/css/site.min.css ">
	    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700,400italic,600italic,700italic,800italic,300italic" rel="stylesheet" type="text/css">
	    
	    <script type="text/javascript" src="<?php echo base_url('assets/bootflat');?>/js/site.min.js"></script>
</head>
<body style="background-color: rgb(241, 242, 246);">
		<div class="container documents">
			<div class="example">
				<div class="row">
					<h1 style="text-align: center; ">Hasil Konverter</h1>
					<p style="text-align: center; "><strong>Waktu Eksekusi: </strong><?php echo $exec_time; ?> detik</p>
					<div class="col-md-3">
						<div class="jumbotron">
						  <div class="jumbotron-photo">
						  	<img src="<?php echo base_url('uploads/'.$upload_data['file_name']); ?>">
						  </div>
						  <div class="jumbotron-contents">
						    <h2>BMP (Original)</h2>
						    <p><?php echo $size_bmp; ?> KB</p>
						    <p><small><strong>Ratio: </strong> <?php echo $bmp_ratio; ?> %</small></p>
						  </div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="jumbotron">
						  <div class="jumbotron-photo">
						  	<img src="<?php echo base_url('compressed/compress_'.$upload_data['raw_name'].'.bmp'); ?>">
						  </div>
						  <div class="jumbotron-contents">
						    <h2>JPG</h2>
						    <p><?php echo $size_jpg; ?> KB</p>
						    <p><small><strong>Ratio: </strong> <?php echo $jpg_ratio; ?> %</small></p>
						  </div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="jumbotron">
						  <div class="jumbotron-photo">
						  	<img src="<?php echo base_url('compressed/compress_'.$upload_data['raw_name'].'.png'); ?>">
						  </div>
						  <div class="jumbotron-contents">
						    <h2>PNG</h2>
						    <p><?php echo $size_png; ?> KB</p>
						    <p><small><strong>Ratio: </strong> <?php echo $png_ratio; ?> %</small></p>
						  </div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="jumbotron">
						  <div class="jumbotron-photo">
						  	<img src="<?php echo base_url('compressed/compress_'.$upload_data['raw_name'].'.gif'); ?>">
						  </div>
						  <div class="jumbotron-contents">
						    <h2>GIF</h2>
						    <p><?php echo $size_gif; ?> KB</p>
						    <p><small><strong>Ratio: </strong> <?php echo $gif_ratio; ?> %</small></p>
						  </div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="sm-md-12" style="text-align: center; ">
						<a href="<?php echo site_url('C_home/viewUploadImage'); ?>" class="btn btn-danger">
							Upload lagi!
						</a>
					</div>
				</div>
			</div>
		</div>
	</body>
	<!-- <ul>
		<?php foreach ($upload_data as $item => $value):?>
		<li><?php echo $item;?>: <?php echo $value;?></li>
		<?php endforeach; ?>
	</ul> -->
</html>