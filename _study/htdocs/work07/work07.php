<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORK07</title>
</head>
<body>
	<?php
		$strResult = ""; // 結果文字列
	?>
	<!-- ---------------------------------------->
	<!-- 課題１								   -->
	<!-- ---------------------------------------->
	<p>課題①--------</p>
	<?php
		// 1～100までの範囲の乱数を生成し、定数constに格納する
		$iRandom = rand( 1, 100 );
	?>
	<p>ランダム値：<?php echo $iRandom; ?></p>

	<?php
	// 3の倍数の時
	if( $iRandom % 3 == 0 ):
		// 6の倍数の時
		if( $iRandom % 6 == 0 ):
			$strResult = "3と6の倍数です";
		else: // 6の倍数じゃない時
			$strResult = "3の倍数で、6の倍数ではありません";
		endif;
	else: // 3の倍数じゃない時
		$strResult = "倍数ではありません";
	endif;
	?>
	<p><?php $strResult ?></p>
	<?php
	//----------------------------------------
	// 課題２
	//----------------------------------------
	?>
	<p>課題②--------</p>
	<?php
	// 値表示 ------------------------
	// 1～10までの範囲の乱数を生成し、定数constに格納する
	$iRandom01 = rand( 1, 10 );
	$iRandom02 = rand( 1, 10 );

	$strResult = "";
	$strResult = "ランダム値01 = ".$iRandom01."、ランダム値02 = ".$iRandom02." です。";

	// 大きさ判定 ---------------------
	// 同じ時
	if( $iRandom01 == $iRandom02 ):
		$strResult .= "同じ値です。";
	else: // 同じじゃない時
		// ランダム値01の方が大きいとき
		if( $iRandom01 > $iRandom02 ):
			$strResult .= "ランダム値01の方が大きいです。";
		else: // ランダム値02の方が大きいとき
			$strResult .= "ランダム値02の方が大きいです。";
		endif;
	endif;
	// 3の倍数の判定 -------------------
	$iCount = 0; // ３の倍数カウント

	// ランダム値01が3の倍数の時
	if( $iRandom01 % 3 == 0 ):
		// カウントプラス
		$iCount++;
	endif;
	// ランダム値02が3の倍数の時
	if( $iRandom02 % 3 == 0 ):
		// カウントプラス
		$iCount++;
	endif;

	$strResult .= "2つの数字のうち、";

	// 3の倍数がない時
	if( $iCount == 0 ):
		$strResult .= "3の倍数となる数はありません。";
	else: // 3の倍数がある時
		$strResult .= "3の倍数となる数は".$iCount."つです。";
	endif;
	?>
	<p><?php echo $strResult; ?></p>

</body>
</html>
