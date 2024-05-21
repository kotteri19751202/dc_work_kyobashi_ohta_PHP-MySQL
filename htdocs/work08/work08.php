<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORK08</title>
</head>
<body>
<?php
	$strResult = ""; // 結果文字列

	//----------------------------------------
	// 課題１
	//----------------------------------------
	print("<p>課題①--------</p>");

	// 1～100までの範囲の乱数を生成し、定数constに格納する
	$iRandom = rand( 1, 100 );
	print("<p>ランダム値：".$iRandom."</p>");

	// 3の倍数の時
	switch( $iRandom % 3 )
	{
		case 0:
			// 6の倍数かどうかで分岐
			switch( $iRandom % 6 )
			{
				case 0:		// 6の倍数の時
					$strResult = "3と6の倍数です";
					break;

				default:	// 6の倍数じゃない時
					$strResult = "3の倍数で、6の倍数ではありません";
			}
			break;

		default:	// 3の倍数じゃない時
			$strResult = "倍数ではありません";
	}

	print("<p>".$strResult."</p>");

	//----------------------------------------
	// 課題２
	//----------------------------------------
	print("<p>課題②--------</p>");

	// 値表示 ------------------------
	// 1～10までの範囲の乱数を生成し、定数constに格納する
	$iRandom01 = rand( 1, 10 );
	$iRandom02 = rand( 1, 10 );

	$strResult = "";
	$strResult = "ランダム値01 = ".$iRandom01."、ランダム値02 = ".$iRandom02." です。";

	// 大きさ判定 ---------------------
	// 同じ時
	if( $iRandom01 == $iRandom02 )
	{
		$strResult .= "同じ値です。";
	}
	else // 同じじゃない時
	{
		// ランダム値01の方が大きいとき
		if( $iRandom01 > $iRandom02 )
		{
			$strResult .= "ランダム値01の方が大きいです。";
		}
		else // ランダム値02の方が大きいとき
		{
			$strResult .= "ランダム値02の方が大きいです。";
		}
	}

	// 3の倍数の判定 -------------------
	$iCount = 0; // ３の倍数カウント

	// ランダム値01が3の倍数の時
	if( $iRandom01 % 3 == 0 )
	{
		// カウントプラス
		$iCount++;
	}
	// ランダム値02が3の倍数の時
	if( $iRandom02 % 3 == 0 )
	{
		// カウントプラス
		$iCount++;
	}

	$strResult .= "2つの数字のうち、";

	// 3の倍数の数で分岐
	switch( $iCount )
	{
		case 0:
			$strResult .= "3の倍数となる数はありません。";
			break;
		case 1:
			$strResult .= "3の倍数となる数は1つです。";
			break;
		case 2:
			$strResult .= "3の倍数となる数は2つです。";
			break;
		default:
			print( "エラーです。");
	}
	
	print("<p>".$strResult."</p>");
?>
</body>
</html>
