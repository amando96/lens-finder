<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9/jquery.min.js"></script>
		<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<script src="slider/js/bootstrap-slider.js" type="text/javascript"></script>
		<link rel="stylesheet" href="slider/css/slider.css"/>
		
		<script type="text/javascript">
			$(document).ready(function(){
				alert('poop');
				($("#ex2").slider({});
			});
		</script>
	</head>
	<body>
		Filter by price interval: <b>€ 10</b> <input id="ex2" type="text" class="span2" value="" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[250,450]"/> <b>€ 1000</b>
	</body>
</html>