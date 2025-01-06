<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY39</title>
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
			echo "データベースの接続に成功しました。<br>";
			// 文字コードをUTF8に設定
			$db->set_charset("utf8"); 
		}
		// SELECT文の実行
		$sql = "SELECT product_name, price FROM product WHERE price <= 100";
		if( $result = $db->query( $sql ) )
		{
			/*// 結果の連想配列を取得
			while( $row = $result->fetch_assoc() )
			{
				echo $row["product_name"] . $row["price"] . "<br>";
			}
			*/
			// 結果の連想配列を取得
			foreach( $result as $row )
			{
				echo $row["product_name"] . $row["price"] . "<br>";
			}
			// 結果セットを閉じる
			$result->close();
		}
		else
		{
			echo "SELECTに失敗しました。<br>";
			echo $db->error;
		}

		$db->close();
	?>
</body>
</html>