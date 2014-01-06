<!DOCTYPE html>
<html>
	<head>
        <meta charset='utf-8'>
		<title>Akurat Avto Service</title>
        <?php echo $this->tag->stylesheetLink('/../css/foundation.min.css'); ?>
        <?php echo $this->tag->stylesheetLink('/../css/custom.css'); ?>
	</head>
	<body>
         <div id="container">
            <div id="header">
                    <?php echo $this->elements->getTopBarMenu(); ?>
            </div>
            <div id="main">
                <div class="message-block">
                    <?php  echo $this->flashSession->output(); ?>
                </div>
		        <?php echo $this->getContent(); ?>
            </div>
              <div id="footer"><h2>FOOTER</h2></div>
         </div>
        <?php echo $this->tag->javascriptInclude('/../js/jquery-2.0.3.min.js'); ?>
        <?php echo $this->tag->javascriptInclude('/../js/foundation.min.js'); ?>
        <?php echo $this->tag->javascriptInclude('/../js/modernizr.js'); ?>
        <?php echo $this->tag->javascriptInclude('/../libraries/flexslider/jquery.flexslider-min.js'); ?>
        <?php echo $this->tag->javascriptInclude('/../js/custom.js'); ?>
	</body>
</html>