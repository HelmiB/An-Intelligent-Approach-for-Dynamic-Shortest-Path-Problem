<?php
function FloydWarshall($graph, $verticesCount){
	$distance = array();

	for ($i = 1; $i <= $verticesCount; ++$i)
		for ($j = 1; $j <= $verticesCount; ++$j)
			$distance[$i][$j] = $graph[$i][$j];

	for ($k = 1; $k <= $verticesCount; ++$k){
		for ($i = 1; $i <= $verticesCount; ++$i){
			for ($j = 1; $j <= $verticesCount; ++$j){
				if ($distance[$i][$k] + $distance[$k][$j] < $distance[$i][$j])
					$distance[$i][$j] = $distance[$i][$k] + $distance[$k][$j];
			}
		}
	}
}
?>