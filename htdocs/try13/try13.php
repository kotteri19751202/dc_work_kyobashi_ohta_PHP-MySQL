<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY13</title>
</head>
<body>
<?php
	$iRandom = rand( 0, 4 );	// 0～4までのランダムな数値を取得
	
	print "<p>iRandom: ".$iRandom."</p>";

	switch( $iRandom )
	{
		case 1:
			print "<p>変数iRandomの値は1です。</p>";
			break;

		case 2:
			print "<p>変数iRandomの値は2です。</p>";
			break;
		
		default:
			print "<p>変数iRandomの値は1,2ではありません。</p>";
	}
?>

</body>
</html>
