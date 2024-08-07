<?php 
	define( "DSN", "mysql:host=localhost;dbname=xb513874_wa8fy" ); 
	define( "DB_USER_NAME", "xb513874_t7dq0" ); 
	define( "DB_PASS_WORD", "7op8tds1dz" );   

 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY48</title>
</head>
<body>
	<?php
		try
		{
			// データベースへ接続
			$db = new PDO( DSN, DB_USER_NAME, DB_PASS_WORD );
			//PDOのエラー時にPEOExceptionが発生するように設定
			$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

			// トランザクション開始
			$db->beginTransaction();

			// UPDATEクエリ作成
			$sql = "UPDATE product Set price = ? WHERE product_id = ?";

			// prepareメソッドによるクエリの実行準備をする
			$stmt = $db->prepare( $sql );
			// 値をバインドする
			$stmt->bindValue( 1, 170 );
			$stmt->bindValue( 2, 1 );

			// クエリ実行
			$stmt->execute();
			// 件数取得
			$iRow = $stmt->rowCount();
			// 更新件数表示
			echo $iRow . "件更新しました。<br>";
			// コミット
			$db->commit();
		}
		catch( PDOException $e )
		{
			// エラー発生
			echo $iRow . "エラーです。<br>";
			// エラーメッセージ表示
			echo $e->getMessage() . "<br>";
			// ロールバック
			$db->rollBack();
		}

		// SELECTクエリ
		$sql = "SELECT product_id, product_name, price FROM product";
		// クエリ実行
		if( $result = $db->query( $sql ))
		{
			// 結果が存在したら
			// 連想配列を取得
			foreach( $result as $arrRow )
			{
				echo $arrRow["product_id"] . "：" . $arrRow["product_name"] . "：" . $arrRow["price"] . "<br>";
			}

		}
	?>
</body>
</html>