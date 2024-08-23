<?php
	// デバッグ表示
	//define( "DEBUG", false );
	define( "DEBUG", true );
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

    //セッション開始
	session_start();
	// エラーフラグに値が入ってたら
	if( isset( $_SESSION["err_flg"]) )
	{
		// エラーフラグがONの時
		if( $_SESSION["err_flg"] )
		{
			echo "<p>ログインが失敗しました：正しいログインID（半角英数字）を入力してください。</p>";
		}
	}

	$_SESSION["err_flg"] = FALSE;

	// ログアウト処理がされた場合
	if( isset( $_POST["logout"]) )
	{
		// セッション名を取得する
		$strSession = session_name();
		// セッション変数を削除
		$_SESSION = [];

		// セッションID（ユーザー側のCookieに保存されている）を削除
		if( isset( $_COOKIE[ $strSession ] ) )
		{
			// sessionに関する設定を取得
			$params = session_get_cookie_params();

			// cookie削除
			setcookie( $strSession, "", time() - 30, "/");
			$strMessage =  "<p>ログアウトされました。</p>";
		}
	}
	else // ログアウト処理がされてない時
	{
		// ログイン中のユーザーであるかを確認する
		if( isset( $_SESSION["login_id"] ) )
		{
			// ログイン中である場合は、top.phpにリダイレクト（転送）する
			header( "Location: top.php");
			exit();
		}
	}

	// cookieに値がある場合、変数に格納する
	if( isset( $_COOKIE[ "cookie_confirmation"]) === TRUE )
	{
		$strCookieConfirmation = "checked";
	}
	else
	{
		$strCookieConfirmation = "";
	}

	if( isset( $_COOKIE["login_id"]) === TRUE )
	{
		$strLoginID = $_COOKIE["login_id"];
	}
	else
	{
		$strLoginID = "";
	}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY55</title>
</head>

<body>
	<?php
	if( isset( $strMessage ) )
	{
		echo $strMessage;
	}
	?>
	<form action="top.php" method="post">
		<label for="login_id">ログインID</label>
		<input type="text" id="login_id" name="login_id" value="<?php echo $strLoginID; ?>"><br>
		<input type="checkbox" name="cookie_confirmation" value="checked" <?php print $strCookieConfirmation;?>>次回からログインIDの入力を省略する<br>
		<input type="submit" value="ログイン">
	</form>
</body>
</html>
