<?php
	// デバッグ表示
	define( "DEBUG", false );
	//define( "DEBUG", true );
	function dprint( $strMsg )
	{
		if( DEBUG ) echo $strMsg  . "<br>\n";
		return;
	}
	// 情報表示
	function iprint( $strMsg )
	{
		echo $strMsg  . "<br>\n";
		return;
	}
	// DB関連
	define( "DSN", "mysql:host=localhost;dbname=xb513874_wa8fy;charset=utf8mb4" ); 
	define( "DB_USER_ID", "xb513874_t7dq0" ); 
	define( "DB_PASS_WORD", "7op8tds1dz" );
	define( "TABLE_NAME",	"tbl_work37_user" );

	// Cookieの保存期間
	define( "EXPIRATION_PERIOD", 30 );
	$iCookieExpiration = time() + EXPIRATION_PERIOD * 60 * 24 * 365;

	//===============================================
	// Cookieのチェック
	//===============================================
	function checkCookie()
	{
		// 省略するかどうかのチェックボックス 
		if( isset( $_POST["cookie_confirmation"]) === TRUE )
		{
			$strCookieConfirmation = $_POST["cookie_confirmation"];
		}
		else
		{
			$strCookieConfirmation = "";
		}

		// ユーザーID
		if( isset( $_POST["user_id"]) === TRUE )
		{
			$strUserID = $_POST["user_id"];
		}
		else
		{
			$strUserID = "";
		}

		// パスワード
		if( isset( $_POST["password"]) === TRUE )
		{
			$strPassword = $_POST["password"];
		}
		else
		{
			$strPassword = "";
		}

		// ログイン出来て、チェックがある場合は、Cookieに保存
		if( $strCookieConfirmation === "checked" )
		{
			setcookie("cookie_confirmation", $strCookieConfirmation, $iCookieExpiration );
			setcookie("user_id", $strUserID, $iCookieExpiration );
			setcookie("password", $strPassword, $iCookieExpiration );
		}
		else // チェックされてない場合はCookieを削除する
		{
			setcookie( "cookie_confirmation", "", time() - 30 );
			setcookie( "user_id", "", time() - 30 );
			setcookie( "password", "", time() - 30 );
		}
	}
	
	//===============================================
	// DB接続 
	//===============================================
	function connectDB()
	{
		try
		{
			// データベースへ接続
			$db = new PDO( DSN, DB_USER_ID, DB_PASS_WORD, 
							array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ) );

			return $db;
		}
		catch( PDOException $e )
		{
			// エラー発生
			iprint( "DB接続エラーです。");
			// エラーメッセージ表示
			iprint( $e->getMessage() );
			// 終了
			exit();
		}
	}

	//===============================================
	// ログイン 
	//===============================================
	function login( &$db )
	{
		try
		{
			// Updateクエリ作成
			$strQuery = "SELECT * FROM " . TABLE_NAME . 
						" WHERE UserID = :UserID" . 
						" AND Password = :Password";

			// prepareメソッドによるクエリの実行準備をする
			$stmt = $db->prepare( $strQuery );
			// 値をバインドする
			$stmt->bindValue( ":UserID", $_POST["user_id"] );
			$stmt->bindValue( ":Password", $_POST["password"] );

			// クエリ実行
			$stmt->execute();
			// 件数取得
			$iRow = $stmt->rowCount();
			// 件数が1件だったら
			if( $iRow == 1 )
			{
				// 結果を取ってくる
				if( $result = $stmt->fetchAll() )
				{
					iprint( $result[0]["UserName"] . "さん、ようこそ！" );
					// 結果が存在したら
					// 連想配列を取得
					//foreach( $result as $arrRow )
					//{
					//	iprint( $arrRow["UserName"] . "さん、ようこそ！" );
					//}
				}
				return true;
			}
			
			return false;
		}
		catch( PDOException $e )
		{
			// エラー発生
			iprint( "ログインエラーです。");
			// エラーメッセージ表示
			iprint( $e->getMessage() );
			// クエリ文字列
			dprint( $strQuery );

			return false;
		}
	}

	// Cookieのチェック
	checkCookie();
	// 先ずDBに接続する
	$db = connectDB();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORDK37</title>
</head>
<body>
	<?php
	if( login( $db ) ) echo "<p>ログイン（疑似的）が完了しました</p>";
	else echo "<p>ログインに失敗しました。</p>";
	?>
</body>
</html>
