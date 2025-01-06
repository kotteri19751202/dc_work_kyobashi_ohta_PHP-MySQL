<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORK14</title>
</head>
<body>
	<?php
		$arrRandom = array(); // 配列作成

		// 配列に乱数を入れる
		for( $i = 0 ; $i < 5 ; $i++ )
		{
			array_push( $arrRandom, rand( 1, 100 ) );
		}
		
		// 配列の検証
		for( $i = 0 ; $i < count( $arrRandom ) ; $i++ )
		{
			// 偶数の時
			if( $arrRandom[ $i ] % 2 == 0 )
			{
				echo( $arrRandom[ $i ]."（偶数）<br>");
			}
			else // 奇数の時
			{
				echo( $arrRandom[ $i ]."（奇数）<br>");
			}
		}
	?>
</body>
</html>
