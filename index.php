<?php
	function isMobile(){   
		if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|sagem|sharp|sie-|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT']))
		return true;
	else
		return false;
	}
	$mobile = (isset($_GET['mobile']) && @$_GET['mobile'] == 1 || (isMobile() == true)) ? true : false;
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<title>lens Finder</title>  
	<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>  
	<script type="text/javascript" src="https://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>    
	<script type="text/javascript" src="slider/js/touch.js"></script>    
	<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css">    
	<link rel="stylesheet" type="text/css" href="https://twitter.github.com/bootstrap/assets/css/bootstrap.css">  
	<link rel="stylesheet" type="text/css" href="main.css">
	<link rel="stylesheet" type="text/css" href="loading.css">  
	<script type='text/javascript'>
		var isDragging = false;
		

		$(window).load(function(){
			function getLens(){	
				//$("#circularG").show();
				$("#results").load('calc_lens.php?for='+$("#for").val()+'&type='+$("#estilo").val()+'&price_min='+$("#slider-range").slider("values",0)+'&price_max='+$("#slider-range").slider("values",1), function(){
					$("#circularG").hide();
				});
			}
			
			function updatePrice(){
				$.ajax({
					url: 'https://niobo.pt/lensfinder/calc_lens.php?action=getprice&for='+$("#for").val()+'&type='+$("#estilo").val(),
					cache: false,
					success: function(data){
						if(data != ''){
							$("#slider-range").slider("destroy");
							
							arr = data.split(':');
							max = arr[0] | 0;
							min = arr[1] | 0;
							 $( "#slider-range" ).slider({
								range: true,
								min: min,
								max: max,
								values: [ min, max ],
								step: 100,
								slide: function( event, ui ) {  $( "#amount" ).val( "entre " + ui.values[ 0 ] + "€ e " + ui.values[ 1 ]+'€' );
								}
							 });
							 $( "#amount" ).val( "entre " + $( "#slider-range" ).slider( "values", 0 ) + "€ e " + $( "#slider-range" ).slider( "values", 1 )+'€' );
							$("#circularG").hide();
						}
					}
				
				});
			}
		 $( "#slider-range" ).slider({
			range: true,
			min: 100,
			max: 8000,
			values: [ 100, 8000 ],
			step: 100,
			slide: function( event, ui ) {  $( "#amount" ).val( "entre " + ui.values[ 0 ] + "€ e " + ui.values[ 1 ]+'€' );
			}
		 });
		$( "#amount" ).val( "entre " + $( "#slider-range" ).slider( "values", 0 ) + "€ e " + $( "#slider-range" ).slider( "values", 1 )+'€' );

			$("#estilo").change(function(){
				$(".sub-select, .sub-sub-select").hide();
				$('#'+$(this).val()+'-details').css('display', 'block');
			});
			
			$(".sub-select").change(function(){
				$(".sub-sub-select").hide();
				$('#'+$(this).val()).show('fast');
			});
			
			$(".select").change(function(){
				getLens();
				/*updatePrice();*/
			});
			
			
			/*$(".slider-area").mousedown(function() {
				down = true;
			}).mouseup(function() {
				down = false;  
			});
			$(".slider-area").mousemove(function() {
				if(down == true){
					getLens();
				}
			});*/
			$('#slider-range').slider({
				change: function(event, ui) {
					getLens();
				}
			});	
		
		});
	</script>


	</head>
	<body>
		<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=1410894852515369";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
		<?php 
		function parsePageSignedRequest() {
			if (isset($_REQUEST['signed_request'])) {
			  $encoded_sig = null;
			  $payload = null;
			  list($encoded_sig, $payload) = explode('.', $_REQUEST['signed_request'], 2);
			  $sig = base64_decode(strtr($encoded_sig, '-_', '+/'));
			  $data = json_decode(base64_decode(strtr($payload, '-_', '+/'), true));
			  return $data;
			}
			return false;
		  }
		  if($signed_request = parsePageSignedRequest()) {
			if($signed_request->page->liked) {
			  
			} else {
			  echo 'É necessário fazer "like" para poder usar a aplicação';
			  exit;
			}
		  }
		 ?>
		<?php if($mobile == true){ ?>
			<img src="lens_finder.jpg" style="width:100%; max-width:800px; margin:0 auto 10px auto; display:block;"/>
			<div class="fb-share-button" data-href="https://www.facebook.com/niobo/app_1410894852515369" data-width="120" data-type="button_count"></div>
			<div class="main-content-mobile">
				<p class="main-phrase">
					<span style="margin-left:0px;">Procuro uma objectiva para:</span>
					<select class="select" id="for">
						<option selected="selected">Seleccione Marca</option>
						<option value="canon">Canon</option>
						<option value="nikon">Nikon</option>
						<!--<option value="olympus">Olympus</option>-->
						<option value="sony">Sony</option>
					</select>
				</p>
				
				<p class="main-phrase">
				<span class="main-phrase">Para utilizar em:</span>
				<select id="estilo" class="select main-select">
					<option selected="selected">Modalidade</option>
					<option value="interiores">Imobiliário</option>
					<option value="paisagem">Paisagem</option>
					<option value="retrato">Retrato</option>
					<option value="arquitectura">Arquitectura</option>
					<option value="lifestyle">Lifestyle</option>
					<option value="desporto">Desporto</option>
					<option value="macro">Macro</option>
					<option value="animais">Animais Selvagens</option>
					<option value="standard">Polivalente</option>
				</select>
				<div class="slider-area"><p class="main-phrase">
					<span>
						<input type="text" id="amount" style="border: 0; color: black;" />
					</span>
					<div id="slider-range"></div>
				</p></div>
					<!--
					<select id="paisagem-details" class="speed select hidden-select sub-select">
						<option value="slow">Durante o Dia</option>
						<option value="fast">Durante a Noite</option>
					</select>
								
					<select id="arquitectura-details" class="speed select hidden-select sub-select">
						<option value="slow">Durante o Dia</option>
						<option value="fast">Durante a Noite</option>
					</select>				
					
					<select id="desporto-details" class="speed select hidden-select sub-select">
						<option value="fast" >Interior</option>
						<option value="slow">Exterior</option>
					</select>
					
					<select id="macro-details" class="macro select hidden-select sub-select">
						<option value="fake">Flores, animais</option>
						<option value="real">Insectos pequenos</option>
					</select>-->
					
					<div id="circularG">
					<div id="circularG_1" class="circularG">
					</div>
					<div id="circularG_2" class="circularG">
					</div>
					<div id="circularG_3" class="circularG">
					</div>
					<div id="circularG_4" class="circularG">
					</div>
					<div id="circularG_5" class="circularG">
					</div>
					<div id="circularG_6" class="circularG">
					</div>
					<div id="circularG_7" class="circularG">
					</div>
					<div id="circularG_8" class="circularG">
					</div>
					</div>
					<div id="results"></div>
				</p>
			</div>	
		<?php } else { ?>
			<img src="lens_finder.jpg" style="width:100%; max-width:800px; margin:0 auto 20px auto; display:block;"/>
			<div class="fb-share-button" data-href="https://www.facebook.com/niobo/app_1410894852515369" data-width="120" data-type="button_count"></div>
			<div class="main-content">
				<p class="main-phrase">
					<span style="margin-left:0px;">Procuro uma objectiva para:</span>
					<select class="select" id="for">
						<option selected="selected">Seleccione Marca</option>
						<option value="canon">Canon</option>
						<option value="nikon">Nikon</option>
						<!--<option value="olympus">Olympus</option>-->
						<option value="sony">Sony</option>
					</select>
				</p>
				
				<p class="main-phrase">
				<span class="main-phrase" style="margin-left:77px;">Para utilizar em:</span>
				<select id="estilo" class="select main-select">
					<option selected="selected">Modalidade</option>
					<option value="interiores">Imobiliário</option>
					<option value="paisagem">Paisagem</option>
					<option value="retrato">Retrato</option>
					<option value="arquitectura">Arquitectura</option>
					<option value="lifestyle">Lifestyle</option>
					<option value="desporto">Desporto</option>
					<option value="macro">Macro</option>
					<option value="animais">Animais Selvagens</option>
					<option value="standard">Polivalente</option>
				</select>
				<div class="slider-area"><p class="main-phrase">
					<span style="margin-left:50px;">
						<input type="text" id="amount" style="border: 0; color: black;" />
					</span>
					<div id="slider-range"></div>
				</p></div>
					<!--
					<select id="paisagem-details" class="speed select hidden-select sub-select">
						<option value="slow">Durante o Dia</option>
						<option value="fast">Durante a Noite</option>
					</select>
								
					<select id="arquitectura-details" class="speed select hidden-select sub-select">
						<option value="slow">Durante o Dia</option>
						<option value="fast">Durante a Noite</option>
					</select>				
					
					<select id="desporto-details" class="speed select hidden-select sub-select">
						<option value="fast" >Interior</option>
						<option value="slow">Exterior</option>
					</select>
					
					<select id="macro-details" class="macro select hidden-select sub-select">
						<option value="fake">Flores, animais</option>
						<option value="real">Insectos pequenos</option>
					</select>-->
					
					<div id="circularG">
					<div id="circularG_1" class="circularG">
					</div>
					<div id="circularG_2" class="circularG">
					</div>
					<div id="circularG_3" class="circularG">
					</div>
					<div id="circularG_4" class="circularG">
					</div>
					<div id="circularG_5" class="circularG">
					</div>
					<div id="circularG_6" class="circularG">
					</div>
					<div id="circularG_7" class="circularG">
					</div>
					<div id="circularG_8" class="circularG">
					</div>
					</div>
					<div id="results"></div>
				</p>
			</div>	
		<?php } ?>
	</body>
</html>

