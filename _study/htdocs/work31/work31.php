<?php 
	define( "DSN", "mysql:host=localhost;dbname=xb513874_wa8fy" ); 
	define( "DB_USER_NAME", "xb513874_t7dq0" ); 
	define( "DB_PASS_WORD", "7op8tds1dz" );   

 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORK31</title>
</head>
<body>
	<?php
		try
		{
			// データベースへ接続
			$db = new PDO( DSN, DB_USER_NAME, DB_PASS_WORD );
		}
		catch( PDOException $e )
		{
			echo $e->getMessage();
			exit();
		}

		// SELECTクエリ
		$sql = "SELECT product_name, category_name FROM product JOIN category USING( category_id ) WHERE category_id = 1";
		// クエリ実行
		if( $result = $db->query( $sql ))
		{
			// 結果が存在したら
			// 連想配列を取得
			foreach( $result as $arrRow )
			{
				echo $arrRow["product_name"] . "：" . $arrRow["category_name"] . "<br>";
			}

		}
	?>
</body>
</html>