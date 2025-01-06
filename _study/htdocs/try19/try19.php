<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY19</title>
</head>
<body>
	<?php
		$arrFruit = ['りんご', 'ばなな', 'ぶどう', 'もも'];
		$arrVegetable = ['きゃべつ', 'とまと', 'にんじん', 'なす'];
		$arrFood = array($arrFruit, $arrVegetable);
	?>
	<pre>
		<?php
			print_r($arrFood);
			print $arrFood[0][2];
		?>
	</pre>
</body>
</html>
