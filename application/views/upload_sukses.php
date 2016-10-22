<html>
<head>
	<title>Upload File Specification</title>
</head>
<body>
	<h2>Your file was successfully uploaded!</h3>
	<!-- Uploaded file specification will show up here -->
	<ul>
		<?php foreach ($upload_data as $item => $value):?>
		<li><?php echo $item;?>: <?php echo $value;?></li>
		<?php endforeach; ?>
	</ul>
	<h3>Original</h3>
	<img src="<?php echo base_url('uploads/'.$upload_data['file_name']); ?>">
	<h3>Compressed</h3>
	<img src="<?php echo base_url('compressed/compress_'.$upload_data['raw_name'].'.jpg'); ?>">
	<br>
	<a href="<?php echo site_url('C_home/viewUploadImage'); ?>">Upload lagi!</a>
</body>
</html>