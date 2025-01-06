<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY37</title>
</head>
<body>
	<?php
		// データベースへ接続
		$db = new mysqli( "localhost", "xb513874_t7dq0", "7op8tds1dz", "xb513874_wa8fy" );
		if( $db->connect_error )
		{
			echo $db->connect_error;
			exit();
		}
		else
		{
			echo "データベースの接続に成功しました。";
		}
		// 接続を閉じる
		$db->close();
	?>
</body>
</html>