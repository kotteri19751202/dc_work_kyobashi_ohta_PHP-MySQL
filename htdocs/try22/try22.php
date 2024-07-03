<?php
	$food_genre = '';
	if (isset($_POST['food_genre'])) {
		$food_genre = htmlspecialchars($_POST['food_genre'], ENT_QUOTES, 'UTF-8');
	}
?>
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