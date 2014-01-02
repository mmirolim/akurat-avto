<!DOCTYPE html>
<html>
	<head>
		<title>Akurat Avto car tracking app</title>
        {{ stylesheet_link('../css/foundation.min.css')}}
        {{ stylesheet_link('../css/custom.css')}}
	</head>
	<body>
		{{ content() }}
        {{ javascript_include("../js/jquery-2.0.3.min.js") }}
        {{ javascript_include("../js/foundation.min.js") }}
        {{ javascript_include("../js/modernizr.js") }}
        {{ javascript_include("../js/custom.js") }}
	</body>
</html>