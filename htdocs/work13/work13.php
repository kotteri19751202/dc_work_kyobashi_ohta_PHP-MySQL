<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORK13</title>
</head>
<body>
	<?php
		//$strResult = ""; // 結果文字列

		//----------------------------------------
		// 課題１
		//----------------------------------------
		print("<p>課題①--------</p>");
		
		// 1～100までループ
		$i = 1;
		while( $i <= 100 ):
			// 3の倍数かつ4の倍数の時
			if( $i % 3 == 0 && $i % 4 == 0 ):
				print("<p>Fizz Buzz</p>");
			// 3の倍数の時
			elseif( $i % 3 == 0 ):
				print("<p>Fizz</p>");
			// 4の倍数の時
			elseif( $i % 4 == 0 ):
				print("<p>Buzz</p>");
			else: // 数値の時
				print("<p>".$i."</p>");
			endif;

			$i++;
		endwhile;

		//----------------------------------------
		// 課題２
		//----------------------------------------
		print("<p>課題②--------</p>");
		
		// iを1～9までループ
		$i = 1;
		while( $i <= 9 ):
			// jを1～9までループ
			$j = 1;
			while( $j <= 9 ):
				print("<p>".$i."*".$j."=".( $i * $j )."</p>");
				$j++;
			endwhile;
			$i++;
		endwhile;

		//----------------------------------------
		// 課題３
		//----------------------------------------
		print("課題③--------</p>");
		
		$i = 1;
		while( $i <= 10 ):
			$strAsterisk = "";
			print("!"."</p>");

			$j = 1;
			while( $j <= $i ):
				$strAsterisk .= "*";
				$j++;
			endwhile;
			
			print( $strAsterisk."</p>" );
			$i++;
		endwhile;
	?>
</body>
</html>
