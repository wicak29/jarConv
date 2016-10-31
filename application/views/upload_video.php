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
					<div class="col-md-3">
					</div>
					<div class="col-md-6">
						<div class="panel panel-default">
				          <div class="panel-heading"> Mp4 to avi, flv </div>
				          <div class="panel-body">
				            <div class="col-sm-12">
				            	<!-- Aplikasi ini digunakan untuk mengkonversi gambar dari .bmp ke .jpg, .png, dan .gif -->
					          	<?php echo $error;?> <!-- Error Message will show up here -->
								<form enctype="multipart/form-data" action="<?php echo site_url('ControllerVideo/do_upload');?>" method='POST'>
									<div class="form-group"> 
										<label>Upload mp4</label>
										<input type="file" name="userfile" size="20" class="form-control">
									</div>
										<label>Output</label><br>
											<input type="radio" name="output" value=".avi" checked> avi<br>
											<input type="radio" name="output" value=".flv"> flv<br><br>

										<label>Codec</label><br>
											<input type="radio" name="codec" value="libxvid">libxvid<br>
											<input type="radio" name="codec" value="mpeg4">mpeg4<br>
											<input type="radio" name="codec" value="libx264">libx264<br><br>
									<div class="form-group">
										<button type="submit" name="submit" class="btn btn-primary"><i class="glyphicon glyphicon-cloud-upload"></i> Upload</button>
									</div>
								</form>
					          </div>
					          <?php 
									if(isset($ori_size)){
								?>
									<div>Ori Size : <?php echo $ori_size;?>Kb</div><br>
									<div>Com Size : <?php echo $com_size;?>Kb</div><br>
									<div>Com Ratio : <?php echo $com_ratio;?>%</div><br>
									<div>Exec Time : <?php echo $exec_time;?>sec</div><br>
									<!-- <video controls>
										<source src="<?php echo base_url()."compressed/".explode('/',$download)[2]?>" type="video/mp4">
											Your browser doesn't support the video element.
									</video><br><br> -->
									<a href="<?php echo base_url().$download?>"><button class="btn btn-info">Download Result</button></a>
								<?php } ?>

				          </div>
				        </div>
					</div>
					<div class="col-md-3">
					</div>
				</div>
			</div>
		</div>
	</body>
</html>