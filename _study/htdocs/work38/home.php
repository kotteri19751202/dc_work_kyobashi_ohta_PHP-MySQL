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

	//セッション開始
	session_start();        
	// Cookieの保存期間
	define( "EXPIRATION_PERIOD", 30 );

	//===============================================
	// Postのチェック
	//===============================================
	function checkPost()
	{
		// ポストじゃない時
		if( $_SERVER["REQUEST_METHOD"] != "POST" )
		{
			dprint( "Postじゃない" );
			header('Location: work38.php');
			exit();
			return false;
		}
		return true;
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
		// ログインIDの値がセットされてなかったら戻る
		if( !isset( $_POST["user_id"]) )
		{
			dprint( "user_id が空です" );
			return FALSE;
		}

		// ユーザーIDの形式が違っていたら戻る（半角英数記号）
		if( false == preg_match( "/^[ -~]+$/", $_POST["user_id"] ) )
		{
			dprint( "user_id の形式が違います". $_POST["user_id"] );
			return FALSE;
		}

		try
		{
			// Selectクエリ作成
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

	//===============================================
	// Cookieのチェック
	//===============================================
	function checkCookie()
	{
		$iCookieExpiration = time() + EXPIRATION_PERIOD * 60 * 24 * 365;
		$strCookieConfirmation = ''; // ここで変数を初期化します
		
		// 省略するかどうかのチェックボックス 
		if( isset( $_POST["cookie_confirmation"]) === TRUE )
		{
			$strCookieConfirmation = $_POST["cookie_confirmation"];
		}
		else
		{
			$strCookieConfirmation = "";
		}
		
		// ログインIDの値がある時
		if( isset( $_POST["user_id"]) === TRUE )
		{
			$strUserID = $_POST["user_id"];
			dprint( "ログインIDの値がある" );
		}
		else
		{
			$strUserID = "";
			dprint( "ログインIDの値がない" );
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

	
	//========================================================


	// Postののチェック
	checkPost();

	// 先ずDBに接続する
	$db = connectDB();

	// ログイン処理
	if( FALSE != login( $db ) )
	{
		// ログイン成功状態を保存
		$_SESSION["user_id"] = $_POST["user_id"];
		dprint( "ログイン成功" );
	}
	else // ログインに失敗したら
	{
		$_SESSION["err_flg"] = TRUE;
		dprint( "ログイン失敗" );
	}

	// Cookieのチェック
	checkCookie();

	// ログイン中じゃない時
	if( !isset( $_SESSION["user_id"] ) )
	{
		// ログイン中ではない場合は、work38.phpにリダイレクト（転送）する
		header('Location: work38.php');
		exit();
		dprint( "ログイン中じゃない" );
	}
	else // ログイン中の時
	{
		echo "<p>" . $_SESSION['user_id'] . "さん：ログイン中です。</p>";
	}
	?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORDK38</title>
</head>
<body>
	<form action="work38.php" method="post">
		<input type="hidden" name="logout" value="logout">
		<input type="submit" value="ログアウト">
	</form>
</body>
</html>
