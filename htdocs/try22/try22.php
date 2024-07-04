<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY22</title>
</head>
<body>
	<form method="post">
		<?php
			// ファイルを開く
			$fp = fopen( "file_read.txt", "r" );
			// ファイルを一行ずつ取得する
			while( $line = fgets($fp) )
			{
				echo $line . "<br>";
			}
			fclose( $fp);
		?>
</body>
</html>