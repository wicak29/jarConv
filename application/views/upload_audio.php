<html>
	<head>
		<title>Upload Form</title>
		<meta charset="utf-8">
	    <title>Documentation - Bootflat</title>
	    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
	    
	    <!-- site css -->
	    <link rel="stylesheet" href="<?php echo base_url('assets/bootflat');?>/css/site.min.css ">
	    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700,400italic,600italic,700italic,800italic,300italic" rel="stylesheet" type="text/css">
	    <script type="text/javascript" src="<?php echo base_url('libraries/Javascript/Jquery.php') ?>"></script>
	    <script type="text/javascript" src="<?php echo base_url('assets/bootflat');?>/js/site.min.js"></script>
	</head>
	<body style="background-color: rgb(241, 242, 246);">
		<script type="text/javascript">
		$(document).ready(function(){
			$(".hideCodec").click(function(){
				$("#codec").hide();
			});
			$(".showCodec").click(function(){
				$("#codec").show();
			})
		});
		</script>
		<div class="container documents">
			<div class="example">
				<div class="row">
					<div class="col-md-3">
					</div>
					<div class="col-md-6">
						<div class="panel panel-default">
				          <div class="panel-heading"> wav, mp3, ac3 to each other </div>
				          <div class="panel-body">
				            <div class="col-sm-12">
				            	<!-- Aplikasi ini digunakan untuk mengkonversi gambar dari .bmp ke .jpg, .png, dan .gif -->
					          	<?php echo $error;?> <!-- Error Message will show up here -->
								<form enctype="multipart/form-data" action="<?php echo site_url('Audio/upload');?>" method='POST'>
									<div class="form-group"> 
										<label>Upload audio</label>
										<input type="file" name="userfile" size="20" class="form-control">
									</div>
									<label>Output</label><br>
											<input type="radio" name="convert_to" class="hideCodec" value="ac3" checked> ac3<br>
											<input type="radio" name="convert_to" class="hideCodec" value="mp3"> mp3<br>
											<input type="radio" name="convert_to" class="showCodec" value="wav"> wav (*optional codec)<br><br>
									<div id="codec" style="display:none">
										<label>Codec</label><br>
											<input type="radio" name="codec" value="libx264">264<br>
											<input type="radio" name="codec" value="libvorbis">vorbis<br><br>
									</div>
									<label>Bitrate</label><br>
											<input type="text" name="bitrate" value="128"><br><br>
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
									<audio controls>
										<source src="<?php echo base_url()."compressed/Audio/".explode('/',$download)[2]?>" type="audio/mpeg">
											Your browser doesn't support the audio element.
									</audio><br><br>
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