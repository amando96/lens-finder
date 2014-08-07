<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	include('config.php');
	
	function getLensType($val_id, $val_name){
		if($val_id == 604 && $val_name == "70-200mm"){
			return 'desporto';
		} elseif($val_id == 594 && $val_name == "50mm"){
			return 'retrato';
		}
	}
	
	function getLensSpeed($val_id, $val_name){
		if($val_id == 671 && $val_name == "f/2.8 f/32"){
			return 'fast';
		}
	}
	
	function getLensFor($desc){
		if(strpos($desc, 'Canon')){
			echo 'canon';
		} else if(strpos($desc, 'Nikon')){
			return 'nikon';
		}
	}
	
	$s['for']        = isset($_GET['for']) ? $_GET['for'] : false;
	$s['price_min']  = isset($_GET['price_min']) ? $_GET['price_min'] : false;
	$s['price_max']  = isset($_GET['price_max']) ? $_GET['price_max'] : false;
	$s['speed']      = isset($_GET['speed']) ? $_GET['speed'] : false;
	$s['type']       = isset($_GET['type']) ? $_GET['type'] : false;
	$s['is']         = isset($_GET['is']) ? $_GET['is'] : false;
	if($s['for'] !== false){
		$sql = "SELECT 
			lensfinder.lens_id, 
			lensfinder.lens_niobo_id, 
			pa.options_id,
			pa.options_values_id, 
			pa.products_id,
			pd.products_name,
			pd.products_id,
			p.products_price,			
			p.products_id,	
			pov.products_options_values_id, 
			pov.products_options_values_name, 
			po.products_options_id, 
			po.products_options_name 
			FROM lensfinder 
			JOIN products_attributes pa ON pa.products_id = lensfinder.lens_niobo_id AND pa.options_id = '42' OR pa.options_id = '43'
			JOIN products_description pd ON pd.products_id = lensfinder.lens_niobo_id 
			JOIN products p ON p.products_id = lensfinder.lens_niobo_id 
			JOIN products_options_values pov ON pov.products_options_values_id = pa.options_values_id 
				AND (
						(pov.products_options_values_id = 604 AND pov.products_options_values_name = '70-200mm')
						OR 
						(pov.products_options_values_id = 594 AND pov.products_options_values_name = '50mm')
						OR 
						(
					)
			JOIN products_options po ON po.products_options_id = pa.options_id GROUP BY(lens_niobo_id)";
		$stmt = $db->query($sql);
		
		
		$lenses = $stmt->fetchAll();
		$parsed = array();
		foreach($lenses as $lens){
			if($lens['products_price'] >= $s['price_min'] && $lens['products_price'] <= $s['price_max']){
				$parsed[] = array(
					'lens_name' => $lens['products_name'], 
					'lens_niobo_id' => $lens['lens_niobo_id'], 
					'lens_price' => $lens['products_price'],
					'lens_type' => getLensType($lens['products_options_values_id'], $lens['products_options_values_name']),
					'lens_speed' => getLensSpeed($lens['products_options_values_id'], $lens['products_options_values_name']),
					'lens_for' => getLensFor($lens['products_name'])
				);
			}
		}
		?> <pre> <?php
		print_r($parsed);
		?> </pre> <?php
		$parsed_lenses = $parsed;
		$results = array();
		$added = array();
		foreach($parsed_lenses as $parsed_lens){			
			if($parsed_lens['lens_type'] == $s['type']){
				$results[] = '<tr><td><a target="_BLANK" href="http://niobo.pt/shop/index.php?main_page=product_info&products_id='.$parsed_lens['lens_niobo_id'].'">'.$parsed_lens['lens_name'].'</a></td><td>'.round($parsed_lens['lens_price'], 2).'€</td></tr>';
			}			
		}
		var_dump($added);
		if(!empty($results)){
			echo 'Baseado nas suas necessidades, recomendamos a(s) seguinte(s) objectiva(s):<br/>';
			?>
			
			<table border="0">
				<tr>
					<td style="width:300px">Objectiva</td>
					<td>Preço</td>
				</tr>
			<?php
				foreach($results as $result){
					echo $result;
				}
			?>
			</table>
			<?php
		} else {
			echo 'Sem resultados, expanda os termos da pesquisa.';
		}
	}
?>