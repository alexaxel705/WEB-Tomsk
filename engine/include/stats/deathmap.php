<svg width="600" height="600" xmlns="http://www.w3.org/2000/svg">
    <image x="0" y="0" width="600" height="600" xlink:href="http://109.227.228.4/engine/include/MTA/stats/SanAndreas.jpg"/>

	
	<?php
	
		$dat = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/stats/deaths.arr'), true);
		
		while(list($key, $val) = each($dat)){
			while(list($key2, $val2) = each($val)){
				$key = ($key+3000)/10;
				$key2 = (6000-($key2+3000))/10;
				echo '<circle fill-opacity="0.5" r="'.($val2*2).'" cx="'.$key.'" cy="'.$key2.'" fill="red"/>';
			}
		}
	?>
</svg>