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
	<title>TRY23</title>
</head>
<body>
	<form method="post">
		<?php
			// ファイルを開く
			$fp = fopen( "file_write.txt", "w" );
			// ファイルへ書き込む
			fwrite($fp, "ファイルへ書き込む");
			fclose($fp);
		?>
</body>
</html>