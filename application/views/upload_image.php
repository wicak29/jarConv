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
				          <div class="panel-heading">JPG to PNG, JPG, GIF, BMP, AND TIFF</div>
				          <div class="panel-body">
				            <div class="col-sm-12">
				            	<!-- Aplikasi ini digunakan untuk mengkonversi gambar dari .bmp ke .jpg, .png, dan .gif -->
					          	<?php echo $error;?> <!-- Error Message will show up here -->
								<form enctype="multipart/form-data" action="<?php echo site_url('C_home/do_upload1');?>" method='POST'>
									<div class="form-group"> 
										<label>Upload .jpg file: </label>
										<input type="file" name="userfile" size="20" class="form-control">
									</div>
									<div class="form-group"> 
										<label>Output File: </label>
										<select class="form-control" name="outType">
											<option value="png">PNG</option>
											<option value="gif">GIF</option>
											<option value="jpg">JPG</option>
											<option value="bmp">BMP</option>
											<option value="tiff">TIFF</option>
										</select>
									</div>
									<div class="form-group">
										<label>Quality: </label>
										<input type="range" name="quality" min="10" max="90" value="50" id="fader" step="1" oninput="outputUpdate(value)">
										<output for="fader" id="volume">50</output>
									</div>
									<div class="form-group">
										<button type="submit" name="submit" class="btn btn-primary"><i class="glyphicon glyphicon-cloud-upload"></i> Upload</button>
									</div>
								</form>
					          </div>
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

<script type="text/javascript">
function outputUpdate(vol) {
	document.querySelector('#volume').value = vol;
}
</script>