<svg width="600" height="600" xmlns="http://www.w3.org/2000/svg">
    <image x="0" y="0" width="600" height="600" xlink:href="http://109.227.228.4/engine/include/MTA/stats/SanAndreas.jpg"/>

	
	<?php
		include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
		$dat = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/stats/zones.arr'), true);
		
		$count = 0;
		foreach ($dat as $x => $value) {
			foreach ($value as  $y => $val3) {
				$count = $count+1;
			}
		}
		
		if($count > 50000) {
			foreach ($dat as $x => $value) {
				foreach ($value as  $y => $val3) {
					$val3 = $val3-1;
					if($val3 == 0) {
						unset($dat[$x][$y]); 
					}
				}
			}
			write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/stats/zones.arr', json_encode($dat));
		}
		
		
		foreach ($dat as $x => $value) {
			foreach ($value as  $y => $val3) {
				$x2 = ($x+3000)/10;
				$y2 = (6000-($y+3000))/10;
				echo '<circle fill-opacity="'.($val3/100).'" r="1" cx="'.$x2.'" cy="'.$y2.'" fill="red"/>';
			}
		}
	?>
</svg>
