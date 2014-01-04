<!DOCTYPE html>
<html>
	<head>
        <meta charset='utf-8'>
		<title>Akurat Avto car tracking app</title>
        <?php echo $this->tag->stylesheetLink('../css/foundation.min.css'); ?>
        <?php echo $this->tag->stylesheetLink('../css/custom.css'); ?>
	</head>
	<body>
		<?php echo $this->getContent(); ?>
        <?php echo $this->tag->javascriptInclude('../js/jquery-2.0.3.min.js'); ?>
        <?php echo $this->tag->javascriptInclude('../js/foundation.min.js'); ?>
        <?php echo $this->tag->javascriptInclude('../js/modernizr.js'); ?>
        <?php echo $this->tag->javascriptInclude('../js/custom.js'); ?>
	</body>
</html>