<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY53</title>
</head>
<body>
	<?php
	// cookieに値がある場合、変数に格納する
	if( isset( $_COOKIE[ "cookie_confirmation"]) === TRUE )
	{
		$strCookieConfirmation = "checked";
	}
	else
	{
		$strCookieConfirmation = "";
	}

	if( isset( $COOKIE["login_id"]) === TRUE )
	{
		$strLoginId = $_COOKIE["login_id"];
	}
	else
	{
		$strLoginId = "";
	}
	?>

	<form action="home.php" method="post">
		<label for="login_id">ログインID</label>
		<input type="text" id="login_id" name="login_id" value="<?php echo $strLoginID; ?>"><br>
		<input type="checkbox" name="cookie_confirmation" value="checked" <?php print $strCookieConfirmation;?>>次回からログインIDの入力を省略する<br>
		<input type="submit" value="ログイン">
	</form>

</body>
</html>
