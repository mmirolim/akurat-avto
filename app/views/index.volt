<!DOCTYPE html>
<html>
	<head>
        <meta charset='utf-8'>
		<title>Akurat Avto Service</title>
        {{ stylesheet_link('/../css/foundation.css')}}
        {{ stylesheet_link('/../css/custom.css')}}
	</head>
	<body>
         <div id="container">
            <div id="header">
                    <?php echo $this->elements->getTopBarMenu(); ?>
            </div>
            <div id="main">
                <div class="message-block" onclick="$(this).toggle();">
                    <?php  echo $this->flashSession->output(); ?>
                </div>
		        {{ content() }}
            </div>
              <div id="footer" class="row">
                 <div class="large-9 large-centered columns">
                  <div class="large-4 columns">
                      <h4>List One</h4>
                      <ul>
                          <li>Pellentesque non mi non lectus ultricies molestie.</li>
                          <li>Sed sit amet nunc eu diam rutrum accumsan laoreet a diam.</li>
                          <li>Curabitur ornare ligula cursus commodo accumsan.</li>
                          <li>Aenean tristique neque non libero elementum porttitor.</li>
                          <li>Ut rhoncus nibh in sapien dapibus, a scelerisque lectus laoreet.</li>
                      </ul>
                  </div>
                  <div class="large-4 columns">
                      <h4>List Two</h4>
                      <ul>
                          <li>Nulla eget enim dapibus arcu pharetra eleifend eu eu augue.</li>
                          <li>Nulla at velit non magna pellentesque fermentum.</li>
                          <li>Maecenas non sapien interdum, ultrices est eget, aliquet nunc.</li>
                          <li>Proin nec dolor a erat ultrices tincidunt.</li>
                          <li>Integer commodo nulla vitae pulvinar fermentum.</li>
                          <li>Maecenas eget velit sit amet leo facilisis aliquet quis nec libero.</li>
                      </ul>
                  </div>
                  <div class="large-4 columns">
                      <h4>List Three</h4>
                      <ul>
                          <li>Phasellus nec lectus eu diam varius ultrices.</li>
                          <li>Quisque eget purus a felis consectetur laoreet.</li>
                          <li>Etiam id diam mollis, laoreet ligula a, consequat eros.</li>
                          <li>Ut consequat lectus id varius auctor.</li>
                          <li>Fusce convallis massa et iaculis adipiscing.</li>
                          <li>Suspendisse non eros tempus, rhoncus lorem vel, facilisis lectus.</li>
                      </ul>
                  </div>
                </div>
               <div class="row"><h4 class="large-12 columns copyright">AKURAT AVTO all rights registered @ 2014</h4></div>
             </div>
         </div>
        {{ javascript_include("/../js/jquery-2.0.3.min.js") }}
        {{ javascript_include("/../js/foundation.min.js") }}
        {{ javascript_include("/../js/modernizr.js") }}
        {{ javascript_include("/../libraries/flexslider/jquery.flexslider-min.js") }}
        {{ javascript_include("/../js/custom.js") }}
	</body>
</html>