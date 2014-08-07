<?php
	include('config.php');
	echo $_GET['details'];
	$s['for']        = isset($_GET['for']) ? $_GET['for'] : false;
	$s['price_min']  = isset($_GET['price_min']) ? $_GET['price_min'] : false;
	$s['price_max']  = isset($_GET['price_max']) ? $_GET['price_max'] : false;
	$s['speed']      = isset($_GET['speed']) ? $_GET['speed'] : false;
	$s['type']       = isset($_GET['type']) ? $_GET['type'] : false;
	$s['is']         = isset($_GET['is']) ? $_GET['is'] : false;
	if($s['for'] !== false){
		$stmt = $db->query(
			'SELECT * FROM lensfinder 
			JOIN products_attributes 
			JOIN products
				ON products_attributes.products_id = lensfinder.lens_niobo_id AND products.products_id = lensfinder.lens_niobo_id
			JOIN products_description pd ON pd.products_id = lensfinder.lens_niobo_id
			GROUP BY(lensfinder.lens_niobo_id) ORDER BY(products.products_price)'
		);
		$lenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$results = array();
		foreach($lenses as $lens){
			if(isset($s['for']) && isset($s['type']) && isset($s['price_min']) && isset($s['price_max'])){
				if($s['for'] == $lens['lens_for'] && (strpos($lens['lens_type'], $s['type']) !== false) && $lens['products_price'] >= $s['price_min'] && $lens['products_price'] <= $s['price_max']){
					$results[] = '<td><a target="_BLANK" href="http://niobo.pt/shop/index.php?main_page=product_info&products_id='.$lens['lens_niobo_id'].'">'.$lens['products_name'].'</a></td><td>'.number_format(round($lens['products_price'], 2), 2).'€</td>';
				}
			} elseif(isset($s['for']) && isset($s['type'])){
				if($s['for'] == $lens['lens_for'] && $s['type'] == $lens['lens_type']){
					$results[] = $lens['name'];
				}
			} elseif(isset($s['for'])){
				if($s['for'] == $lens['lens_for']){
					$results[] = $lens['name'];
				}
			}
		}
		if(!empty($results)){
			echo 'Baseado nas suas necessidades, recomendamos a(s) seguinte(s) objectiva(s):<br/>';
			?>
			
			<table border="0">
				<tr>
					<td style="width:500px">Objectiva</td>
					<td>Preço</td>
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
	}
?>