<html>
	<head>
		<title>Upload Form</title>
	</head>
	<body>
		<?php echo $error;?> <!-- Error Message will show up here -->
		<form enctype="multipart/form-data" action="<?php echo site_url('C_home/do_upload');?>" method='POST'>
			<input type="file" name="userfile" size="20">
			<input type="submit" name="submit" value="upload">
		</form>
	</body>
</html>