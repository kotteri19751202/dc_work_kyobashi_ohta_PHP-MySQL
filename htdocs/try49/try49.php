<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY49</title>
</head>
<body>
	<?php
	// 引数：なし、戻り値：なしの関数を実行
	outputFunction();

	// 引数：あり、戻り値：なしの関数を実行
	outputFunctionNum( 10 );

	// 引数：あり、戻り値：ありの関数を実行
	$strString = makeFunctionNum( 10 );
	echo $strString;


	// 引数：なし、戻り値：なしの関数
	function outputFunction()
	{
		echo "<p>引数：なし、戻り値：なしの関数</p>";
	}

	// 引数：あり、戻り値：なしの関数
	function outputFunctionNum( $iNum )
	{
		echo "<p>引数：" . $iNum . "、戻り値：なしの関数</p>";
	}

	// 引数：あり、戻り値：ありの関数
	function makeFunctionNum( $iNum )
	{
		$strString = "<p>引数：" . $iNum . "、戻り値：ありの関数</p>";

		return $strString;
	}


	?>
</body>
</html>