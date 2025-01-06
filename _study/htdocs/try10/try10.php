<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY10</title>
</head>
<body>
<?php
	$iScore = rand( 0, 100 );	// 0～100までのランダムな数値を取得

	print "<p>iScore: ".$iScore."</p>";
	print "<p>$iScore == 100 : ";
	var_dump($iScore == 100 );
	print " </p>";

	print "<p>$iScore >= 60 : ";
	var_dump($iScore >= 60 );
	print " </p>";

	if( $iScore == 100 )
	{
		print "<p>満点です。</p>";
	}
	else
	if( $iScore >= 60 )
	{
		print "<p>合格です。</p>";
	}
	else
	{
		print "<p>不合格です。</p>";
	}
?>
</body>
</html>
