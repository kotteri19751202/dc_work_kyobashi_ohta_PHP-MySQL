<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY51</title>
</head>
<body>
	<?php
	// 定数の定義
	define( "TAX_RATE", 0.1 );
	define( "COMPANY_NAME", "ディーキャリア株式会社" );


	function echoConst( $iPrice )
	{
		echo "<p>税込み価格は" . ($iPrice + $iPrice * TAX_RATE ). "円です</p>";
		echo "<p>会社名：" . COMPANY_NAME. "</p>";
	}

	echoConst( 100 );
	?>
</body>
</html>
