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
	<title>TRY40</title>
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

		// リクエストメソッドがPOSTの時
		if( $_SERVER["REQUEST_METHOD"] == "POST")
		{
			// 値がセットされていたら
			if( isset( $_POST["price"] ) )
			{
				// 値取り出し
				$iPrice = $_POST["price"];
			}
			// トランザクション開始
			$db->begin_transaction();

			// UPDATE文の作成
			$strUpdateSql = "UPDATE product SET price =" . $iPrice . " WHERE product_id = 1";
			// クエリ実行
			if( $result = $db->query( $strUpdateSql ) )
			{
				// 更新行数の取得
				$iRow = $db->affected_rows;
			}
			else // エラーの時
			{
				$arrErrorMsg[] = "UPDATE実行エラー[実行SQL]" . $strUpdateSql;
			}

			// エラーがなかったら
			if( count( $arrErrorMsg ) == 0 )
			{
				echo $iRow . "件更新しました。<br>";
				// コミット
				$db->commit();
			}
			else
			{
				echo "更新が失敗しました。<br>";
				echo $db->error . "<br>";
				// エラーメッセージ表示
				var_dump( $arrErrorMsg );
				// ロールバック
				$db->rollback();
			}
		}
		
		// SELECT文の実行
		$strSelectSql = "SELECT product_name, price FROM product WHERE product_id = 1";
		if( $result = $db->query( $strSelectSql ) )
		{
			// 結果の連想配列を取得
			while( $arrRow = $result->fetch_assoc() )
			{
				$strProductName = $arrRow["product_name"];
				$iPrice = $arrRow["price"];
			}
			// 結果セットを閉じる
			$result->close();
		}
		else
		{
			echo "SELECTに失敗しました。<br>";
			echo $db->error;
		}

		if( $iPrice == 150 )
		{
			$iPriceVal = 130;
		}
		else
		{
			$iPriceVal = 150;
		}

		$db->close();
	?>

	<form method="post">
		<?php echo $strProductName ?>の現在の価格は<?php echo $iPrice ?>円です。<br>
		<input type="radio" name="price" value="<?php echo $iPriceVal ?>" checked> <?php echo $iPriceVal?>円に変更する
		<input type="submit" value="送信">
	</form>	
</body>
</html>