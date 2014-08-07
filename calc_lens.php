<?php
	header('Content-Type: text/html; charset=iso-8859-1');
	include('config.php');
	$s['for']        = isset($_GET['for']) ? $_GET['for'] : false;
	$s['price_min']  = isset($_GET['price_min']) ? (int)$_GET['price_min'] : false;
	$s['price_max']  = isset($_GET['price_max']) ? (int)$_GET['price_max'] : false;
	$s['speed']      = isset($_GET['speed']) ? $_GET['speed'] : false;
	$s['type']       = isset($_GET['type']) ? $_GET['type'] : false;
	$s['is']         = isset($_GET['is']) ? $_GET['is'] : false;
	
	$for = array(
		'canon' => "pd.products_name LIKE '%canon%'", 
		'nikon' => "pd.products_name LIKE '%nikon%'",
		'olympus' => "pd.products_name LIKE '%olympus%'",
		'sony' => "pd.products_name LIKE '%sony%'"
	);
	
	$type = array(
		'desporto' => 
			"
				pd.products_name NOT LIKE '%18-%' AND (
				(pd.products_name LIKE '%100mm%' AND pd.products_name NOT LIKE '%-100%') OR
				(pd.products_name LIKE '%135mm%' AND pd.products_name NOT LIKE '%-135%') OR
				(pd.products_name LIKE '%150mm%' AND pd.products_name NOT LIKE '%40-%' AND pd.products_name NOT LIKE '%14-%') OR
				(pd.products_name LIKE '%200mm%') OR 
				(pd.products_name LIKE '%70-200mm%') OR 
				pd.products_name LIKE '%270mm%' OR
				pd.products_name LIKE '%300mm%' OR 			
				pd.products_name LIKE '%400mm%' OR
				pd.products_name LIKE '%500mm%' OR
				pd.products_name LIKE '%600mm%')
			",			
		'standard' => 
			"
				pd.products_name LIKE '%15-%' OR
				pd.products_name LIKE '%16-%' OR
				pd.products_name LIKE '%17-%' OR
				pd.products_name LIKE '%18-%' OR 
				pd.products_name LIKE '%24-%' OR			
				pd.products_name LIKE '%28-%'			
			",
		'paisagem' => 
			"
				(pd.products_name LIKE '%10%' AND pd.products_name NOT LIKE '%100%' AND pd.products_name NOT LIKE '%105%') OR
				pd.products_name LIKE '%11-%' OR
				(pd.products_name LIKE '%-14%' AND pd.products_name NOT LIKE '%140%') OR
				(pd.products_name LIKE '%15%' AND pd.products_name NOT LIKE '%150%') OR 
				(pd.products_name LIKE '%-16%' AND pd.products_name NOT LIKE '%160%') OR				
				(pd.products_name LIKE '%-24%' AND pd.products_name NOT LIKE '%140%')
				
			",
		'interiores' => 
			"
				(
					(pd.products_name LIKE '%10%' AND pd.products_name NOT LIKE '%100%' AND pd.products_name NOT LIKE '%105%') OR
					(pd.products_name LIKE '%11%') OR
					(pd.products_name LIKE '%14%' AND pd.products_name NOT LIKE '%140%') OR
					(pd.products_name LIKE '%15%' AND pd.products_name NOT LIKE '%150%') OR 
					(pd.products_name LIKE '%16%' AND pd.products_name NOT LIKE '%160%') OR				
					(pd.products_name LIKE '%24%' AND pd.products_name NOT LIKE '%140%')
				) AND (pd.products_name LIKE '%2.8%' OR pd.products_name LIKE '%3.5%' OR pd.products_name LIKE '%2,8%' OR pd.products_name LIKE '%1,4%')
				
			",
		'arquitectura' => 
			"
				(
					(
						(pd.products_name LIKE '%8%' AND pd.products_name NOT LIKE '%40%') OR
						(pd.products_name LIKE '%10%' AND pd.products_name NOT LIKE '%100%') OR
						(pd.products_name LIKE '%11%') OR
						(pd.products_name LIKE '%14%' AND pd.products_name NOT LIKE '%140%') OR
						(pd.products_name LIKE '%15%') OR 
						(pd.products_name LIKE '%16%' AND pd.products_name NOT LIKE '%160%') OR				
						(pd.products_name LIKE '%24%' AND pd.products_name NOT LIKE '%140%')
					) AND (pd.products_name LIKE '%2.8%' OR pd.products_name LIKE '%3.5%' OR pd.products_name LIKE '%3.8%' OR pd.products_name LIKE '%3,8%' OR pd.products_name LIKE '%3,5%' OR pd.products_name LIKE '%2,8%')
				) AND (pd.products_name NOT LIKE '%55%' AND pd.products_name NOT LIKE '%125%' AND pd.products_name NOT LIKE '%200%' AND pd.products_name NOT LIKE '%270%' AND pd.products_name NOT LIKE '%250%' AND pd.products_name NOT LIKE '%300%' AND pd.products_name NOT LIKE '%105%' AND pd.products_name NOT LIKE '%135%' AND pd.products_name NOT LIKE '%150%' AND pd.products_name NOT LIKE '%macro%' AND pd.products_name NOT LIKE '%5.6%' AND pd.products_name NOT LIKE '%5,6%')
				
			",
		'retrato' =>
			"
			(
				(pd.products_name LIKE '%35mm%') OR
				(pd.products_name LIKE '%50mm%' AND pd.products_name NOT LIKE '%-50mm%' AND pd.products_name NOT LIKE '%55%' AND pd.products_name NOT LIKE '%18-%' AND pd.products_name NOT LIKE '%28-%') OR
				(pd.products_name LIKE '%85mm%') OR
				(pd.products_name LIKE '%100mm%') OR
				(pd.products_name LIKE '%90mm%') OR
				(pd.products_name LIKE '%135mm%' AND pd.products_name NOT LIKE '%-135mm%') 
				
			) AND (
					pd.products_name LIKE '%1.4%' OR 
					pd.products_name LIKE '%1.8%' OR 
					pd.products_name LIKE '%2%' OR 
					pd.products_name LIKE '%1,4%' OR 
					pd.products_name LIKE '%1,8%' OR 
					pd.products_name LIKE '%2,8%' OR 
					pd.products_name LIKE '%2.8%'
			) 			
			AND(
				pd.products_name NOT LIKE '%28-%' AND
				pd.products_name NOT LIKE '%18-%' AND
				pd.products_name NOT LIKE '%TS-E%' AND 
				pd.products_name NOT LIKE '%Tilt%' AND
				pd.products_name NOT LIKE '%4,5%' AND
				pd.products_name NOT LIKE '%4.5%' AND
				pd.products_name NOT LIKE '%-4%'
				
			)
			",
		'lifestyle' =>
			"
				((pd.products_name LIKE '%17%') OR			
				(pd.products_name LIKE '%18%') OR	
				(pd.products_name LIKE '%24%') OR	
				(pd.products_name LIKE '%28%') OR
				(pd.products_name LIKE '%35%') OR
				(pd.products_name LIKE '%50%')) AND ((pd.products_name NOT LIKE '%TS-E%' AND pd.products_name NOT LIKE '%tilt-shift%') AND pd.products_name LIKE '%4%' OR pd.products_name LIKE '%2.8%' OR pd.products_name LIKE '%f/2%' OR pd.products_name LIKE '%f/1.8%' OR pd.products_name LIKE '%1.4%')
			",
		'animais' =>
			"	
				pd.products_name LIKE '%150-%' OR
				pd.products_name LIKE '%160-%' OR
				pd.products_name LIKE '%200-%' OR 					 		
				pd.products_name LIKE '%300-%' OR 			
				pd.products_name LIKE '%400mm%' OR
				pd.products_name LIKE '%500mm%' OR
				pd.products_name LIKE '%600mm%' OR 
				pd.products_name LIKE '%800mm%'
				
			",
		'macro' =>
			"pd.products_name LIKE '%macro%'"
	);
	
	$ex = array(
		'desporto' => 'Para desporto recomendamos teleobjectivas, se for para uso com condições de luz fracas recomendamos objectivas com aberturas grandes(f2.8)',
		'paisagem' => 'Objectivas grande angulares para capturar panorâmicas espetaculares.',
		'interiores' => 'Para fotografias de interiores de casas/edifícios, são objectivas grande angulares com grandes aberturas.',
		'arquitectura' => 'Para fotografias dentro e fora de edifícios.',
		'retrato' => 'São objectivas com grandes aberturas(f1.2, f1.4, f1.8, f2.8) possibilitam o desfoque do fundo, indicadas também para fotos com pouca luz.',
		'lifestyle' => 'Objectivas para o dia-a-dia, familia, férias, animais de estimação.',
		'animais' => 'Objectivas com grandes distâncias focais para poder aumentar animais/pássaros distantes.',		
		'standard' => 'Para quem quer fazer um pouco de tudo sem ter de trocar de objectiva.',
		'macro' => 'Para capturar detalhes pequenos, flores, insectos, etc.'	
	);
	
	if($s['for'] !== false && $s['type'] !== false){		
		$filter = $type[$s['type']];		
		$brand = $for[$s['for']];
		$explanation = $ex[$s['type']];
		
		if(isset($_GET['action'])){
			/* TODO */
		}
		
		$stmt = $db->query(
			'SELECT * FROM products
			JOIN products_description pd ON pd.products_id = products.products_id 
			AND ('.$brand.') 
			AND ('.$filter.') 
			AND pd.products_name NOT LIKE "%EOS%" 
			AND pd.products_name NOT LIKE "%+%" 
			AND pd.products_name NOT LIKE "%flash%" 
			AND pd.products_name NOT LIKE "%MB%"
			AND pd.products_name NOT LIKE "%phottix%" 
			AND pd.products_name NOT LIKE "%ring lite%" 
			AND products.products_status = 1
			GROUP BY(products.products_id) ORDER BY(products.products_price)'
		);
		
		$lenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$results = array();
		foreach($lenses as $lens){
			if(isset($s['price_min']) && isset($s['price_max'])){
				if($lens['products_price'] >= $s['price_min'] && $lens['products_price'] <= $s['price_max']){
					$results[] = '<td><div class="hidden" id="prod_img_'.$lens['products_id'].'"><img src="https://niobo.pt/shop/images/'.$lens['products_image'].'" alt="" title=""/></div><a class="unhide" id="'.$lens['products_id'].'_a_link" target="_BLANK" href="http://niobo.pt/shop/index.php?main_page=product_info&products_id='.$lens['products_id'].'">'.$lens['products_name'].'</a></td>
					<td>
						'.($lens['products_price_sorter'] < $lens['products_price'] ? '<span class="price price-before">'.number_format(round($lens['products_price'], 2), 2).'&euro;&nbsp;</span><span class="price promotion">'.number_format(round($lens['products_price_sorter'], 2), 2).'&euro;</span>' : '<span class="price">'.number_format(round($lens['products_price'], 2), 2).'&euro;</span>').'
					</td>';
				}
			}
		}
		if(!empty($results)){
			echo '<div class="explanation"><blockquote>'.$explanation.'</blockquote></div>';
			echo '<div style="clear:both; margin: 20px 0 20px 0;">Baseado nos dados que submeteu, recomendamos a(s) seguinte(s) objectiva(s):</div>';
			?>
			<div id="fb-root"></div>
			<script>
			$(document).ready(function(){
				$(".unhide").hover(function(){
					id = parseInt($(this).attr('id'));
					$("#prod_img_"+id).slideToggle('fast');
				}, function(){
					$("#prod_img_"+id).slideToggle('fast');
				});
			
			});
			</script>
			<table class="results-table" border="0">
				<tr>
					<td>Objectiva</td>
					<td>Pre&ccedil;o</td>
				</tr>
			<?php
				foreach($results as $result){
					echo '<tr>'.$result.'</tr>';
				}
			?>
			</table>
			<?php
		} else {
			echo 'Sem resultados, expanda os termos da pesquisa.';
		}
	} else { 
		if($s['for'] === false){
			echo 'Tem de seleccionar a marca<br/>';
		}
		if($s['type'] === false){
			echo 'Tem de seleccionar o uso pretendido<br/>';
		}
	}
?>