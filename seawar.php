<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Sea War</title>
</head>
<body>
<script type="text/javascript">
function fire(x, y) {
}
</script>
<?php
error_reporting(E_ALL);

function pole_create() {
	$pole = array_fill(0, 10, array_fill(0, 10, '1111111'));
	$pole = pole_update($pole);
	$korabli = array(4, 3, 3, 2, 2, 2, 1, 1, 1, 1);
	foreach ($korabli as $p) {
		$yes = array();
		for ($y = 0; $y < 10; $y++) {
			for ($x = 0; $x < 10; $x++) {
				if ($pole[$y][$x] > 0 && ($a=substr($pole[$y][$x], ($p>1 ? ($p-1)*2-1 : 0), ($p>1 ? 2 : 1))) > 0) {
					$yes[] = array($x, $y, $a);
				}
			}
		}
		$pos = array_rand($yes, 1);
		$pos = $yes[$pos];
		if ($pos[2]==='11' || $pos[2]==='1') {
			$a = rand(0, 1);
		} else {
			$a = (int)substr($pos[2], 0, 1);
		}
		for ($r2 = -1; $r2 <= 1; $r2++) {
			for ($r = -1; $r <= $p; $r++) {
				$xd = (!$a)*$r+$r2*$a;
				$yd = $a*$r+$r2*(!$a);
				if (isset($pole[$pos[0]+$xd][$pos[1]+$yd])) {
					$val = ($r2 || $r==-1 || $r==$p) ? 0 : -$p;
					$pole[$pos[1]+$yd][$pos[0]+$xd] = $val;
				}
			}
		}
		$x2 = $pos[0]+1+1*$a+$p*(!$a);
		$y2 = $pos[1]+1+1*(!$a)+$p*$a;
		$pole = pole_update($pole, $pos[0]-5, $x2, $pos[1]-5, $y2);
	}
	return $pole;
}

function pole_update($pole, $x1=0, $x2=10, $y1=0, $y2=10) {
	if ($x1 < 0) $x1 = 0;
	if ($y1 < 0) $y1 = 0;
	if ($x2 > 10) $x2 = 10;
	if ($y2 > 10) $y2 = 10;
	for ($y = $y1; $y < $y2; $y++) {
		for ($x = $x1; $x < $x2; $x++) {
			if ($pole[$y][$x] > 0) {
				for ($a = 0; $a <= 1; $a++) { // направление
					$l = 4;
					for ($r = 1; $r < 4; $r++) {
						$xd = (!$a)*$r;
						$yd = $a*$r;
						if (!isset($pole[$y+$yd][$x+$xd]) || (!is_null($pole[$y+$yd][$x+$xd]) && $pole[$y+$yd][$x+$xd] <= 0)) {
							$l = $r;
							break;
						}
					}
					if ($l < 4) {
						for ($s = $l; $s < 4; $s++) {
							$p = ($s*2-1)+!$a;
							$pole[$y][$x] = substr_replace($pole[$y][$x], '0', $p, 1);
						}
					}
				}
			}
		}
	}
	return $pole;
}

function pole_show($pole) {
	echo '<table border="1">';
	for ($y=0; $y<10; $y++) {
		echo '<tr>';
		for ($x=0; $x<10; $x++) {
			switch ($pole[$y][$x]) {
				case -1:
				case -2:
				case -3:
				case -4:
					$color='ffff00';
					break;
				case 0:
					$color='ffffff';
					break;
				default:
					$color='eeeeff';
			}
			echo '<td onclick="fire('.$x.','.$y.')" align="center" valign="middle" style="width: 70px; height: 20px; cursor: pointer; background-color:#'.$color.'">';
			echo '&nbsp;'.$pole[$y][$x];
			echo '</td>';
		}
		echo "</tr>";
	}
	echo '</table>';
}

$pole = pole_create();
pole_show($pole);

?>
</body></html>