<?php
// Cookieの保存期間
define( "EXPIRATION_PERIOD", 30 );
$iCookieExpiration = time() + EXPIRATION_PERIOD * 60 * 24 * 365;

// ポストされたフォームの値を変数に格納する
if( isset( $_POST["cookie_confirmation"]) === TRUE )
{
	$strCookieConfirmation = $_POST["cookie_confirmation"];
}
else
{
	$strCookieConfirmation = "";
}

if( isset( $_POST["login_id"]) === TRUE )
{
	$strLoginID = $_POST["login_id"];
}
else
{
	$strLoginID = "";
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
	setcookie( "login_id", "", time() -30 );
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY53</title>
</head>
<body>
	<p>ログイン（疑似的）が完了しました</p>
</body>
</html>
