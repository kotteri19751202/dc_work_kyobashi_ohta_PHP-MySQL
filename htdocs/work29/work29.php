<?php 
	define( "HOST_NAME", "localhost" ); 
	define( "USER_NAME", "xb513874_t7dq0" ); 
	define( "PASS_WORD", "7op8tds1dz" );   
	define( "DATA_BASE_NAME", "xb513874_wa8fy" );

	$arrErrorMsg = [];
	
	$strProductName;
	$iPrice;
	$iPriceVal;
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORK29</title>
</head>
<body>
	<?php
		// データベースへ接続
		$db = new mysqli( HOST_NAME, USER_NAME, PASS_WORD, DATA_BASE_NAME );
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

		$strQuery = ""; // クエリ文字列

		// リクエストメソッドがPOSTの時
		if( $_SERVER["REQUEST_METHOD"] == "POST")
		{
			// Insertがセットされていたら
			if( isset( $_POST["insert"] ) )
			{
				// Insertクエリ作成
				$strQuery = "INSERT INTO product VALUES( 21, 1021, 'エンシャロット', 200, 1 )";
			}
			else // deleteがセットされていたら
			if( isset( $_POST["delete"] ) )
			{
				// Insertクエリ作成
				$strQuery = "DELETE FROM product WHERE product_id = 21";
			}
			// トランザクション開始
			$db->begin_transaction();

			// クエリ実行
			if( $result = $db->query( $strQuery ) )
			{
				// 更新行数の取得
				$iRow = $db->affected_rows;
			}
			else // エラーの時
			{
				$arrErrorMsg[] = "UPDATE実行エラー[実行SQL]" . $strQuery;
			}

			// エラーがなかったら
			if( count( $arrErrorMsg ) == 0 )
			{
				echo $iRow . "件更新しました。<br>";
				// コミット
				$db->commit();
			}
			else // エラーの時
			{
				echo "更新が失敗しました。<br>";
				echo $db->error . "<br>";
				// エラーメッセージ表示
				var_dump( $arrErrorMsg );
				echo "<br>";
				// ロールバック
				$db->rollback();
			}
		}
		
		// SELECT文の実行
		$strSelectSql = "SELECT * FROM product";
		if( $result = $db->query( $strSelectSql ) )
		{
			// 結果の連想配列を取得
			while( $arrRow = $result->fetch_assoc() )
			{
				echo $arrRow["product_id"] . "：" . $arrRow["product_name"] . "<br>";
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

	<form method="post">
	<input type="submit" name="insert" value="挿入">
	<input type="submit" name="delete" value="削除">
	</form>	
</body>
</html>