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
// Cookieの保存期間
define( "EXPIRATION_PERIOD", 30 );
$iCookieExpiration = time() + EXPIRATION_PERIOD * 60 * 24 * 365;
$strCookieConfirmation = ''; // ここで変数を初期化します

// ポストされたフォームの値を変数に格納する
if( $_SERVER["REQUEST_METHOD"] == "POST" )
{
	// チェックボックスの値があれば
	if( isset( $_POST["cookie_confirmation"]) )
	{
		$strCookieConfirmation = $_POST["cookie_confirmation"];
	}
	else
	{
		$strCookieConfirmation = "";
	}
	// ログインIDの値があるかつ、書式にマッチしていたら
	if( isset( $_POST["login_id"]) && preg_match( "/^[a-zA-Z0-9]+$/", $_POST["login_id"] ) )
	{
		$strLoginID = $_POST["login_id"];
		$_SESSION["login_id"] = $strLoginID;
	}
	else
	{
		$strLoginID = "";
		$_SESSION["err_flg"] = TRUE;
	}
}

// ログインIDの入力省略にチェックがされている場合はCookieを保存
if( $strCookieConfirmation === "checked" )
{
	setcookie("cookie_confirmation", $strCookieConfirmation, $iCookieExpiration );
	setcookie("login_id", $strLoginID, $iCookieExpiration );
}
else // チェックされてない場合はCookieを削除する
{
	setcookie( "cookie_confirmation", "", time() - 30 );
	setcookie( "login_id", "", time() - 30 );
}

// ログイン中じゃない時
if( !isset( $_SESSION["login_id"] ) )
{
	// ログイン中ではない場合は、try55.phpにリダイレクト（転送）する
	header('Location: try55.php');
	exit();
}
else // ログイン中の時
{
	echo "<p>" . $_SESSION['login_id'] . "さん：ログイン中です。</p>";
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY55</title>
</head>
<body>
	<form action="try55.php" method="post">
		<input type="hidden" name="logout" value="logout">
		<input type="submit" value="ログアウト">
	</form>
</body>
</html>
