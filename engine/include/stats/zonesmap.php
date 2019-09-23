<svg width="600" height="600" xmlns="http://www.w3.org/2000/svg">
    <image x="0" y="0" width="600" height="600" xlink:href="http://109.227.228.4/engine/include/MTA/stats/SanAndreas.jpg"/>

	
	<?php
	
		$dat = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/stats/zones.arr'), true);
		while(list($key, $val) = each($dat)){
			while(list($x, $val2) = each($val)){
				while(list($y, $val3) = each($val2)){
					$x = ($x+3000)/10;
					$y = (6000-($y+3000))/10;
					echo '<circle fill-opacity="'.($val3/2).'" r="1" cx="'.$x.'" cy="'.$y.'" fill="red"/>';
				}
			}
		}
	?>
</svg>