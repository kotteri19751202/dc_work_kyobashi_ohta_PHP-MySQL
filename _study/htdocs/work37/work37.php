<?php
/* イメージテーブル
DROP TABLE IF EXISTS tbl_work37_user;
CREATE TABLE tbl_work37_user (
	UserID VARCHAR(128) CHARACTER SET utf8 DEFAULT NULL,
	UserName VARCHAR(128) CHARACTER SET utf8 DEFAULT NULL,
	Password VARCHAR(128) CHARACTER SET utf8 DEFAULT NULL,
	CreateTime DATETIME NOT NULL,
	UpdateTime DATETIME NOT NULL,
	PRIMARY KEY( UserID )
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO tbl_work37_user VALUES( 'xb513874_t7dq0', 'こってり', '7op8tds1dz', now(), now() );

*/
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

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORK37</title>
</head>
<body>
	<?php
	// cookieに値がある場合、変数に格納する
	
	// 省略するかどうかのチェックボックス 
	if( isset( $_COOKIE["cookie_confirmation"] ) === TRUE )
	{
		$strCookieConfirmation = "checked";
		dprint( "checked ON");
	}
	else
	{
		$strCookieConfirmation = "";
		dprint( "checked OFF");
	}

	// ユーザーID
	if( isset( $_COOKIE["user_id"] ) === TRUE )
	{
		$strUserID = $_COOKIE["user_id"];
		dprint( "cookie user_id ON" );
	}
	else
	{
		$strUserID = "";
		dprint( "cookie user_id OFF");
	}

	// パスワード
	if( isset( $_COOKIE["password"] ) === TRUE )
	{
		$strPassword = $_COOKIE["password"];
		dprint( "cookie password ON");
	}
	else
	{
		$strPassword = "";
		dprint( "cookie password OFF");
	}
	?>

	<form action="home.php" method="post">
		<label for="user_id">ユーザーID</label>
		<input type="text" id="user_id" name="user_id" value="<?php echo $strUserID; ?>"><br>
		<label for="password">パスワード</label>
		<input type="text" id="password" name="password" value="<?php echo $strPassword; ?>"><br>
		<input type="checkbox" name="cookie_confirmation" value="checked" <?php echo $strCookieConfirmation;?>>次回からログイン情報の入力を省略する<br>
		<input type="submit" value="ログイン">
	</form>

</body>
</html>
