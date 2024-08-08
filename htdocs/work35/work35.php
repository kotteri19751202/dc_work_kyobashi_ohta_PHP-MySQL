<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORK35</title>
</head>
<body>
	<?php
	// 関数
	function calcNum( $iNum )
	{
		$iResult;

		// 偶数の時
		if( $iNum %2 == 0 )
		{
			// 10倍
			$iResult = $iNum * 10;
		}
		else // 奇数の時
		{
			// 100倍
			$iResult = $iNum * 100;
		}

		return $iResult;
	}

	// ランダム値取得
	$iRandNum = rand( 1, 10 );
	// 関数呼び出し
	echo calcNum( $iRandNum ) . "<br>";


	?>
</body>
</html>