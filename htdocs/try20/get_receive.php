<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY20</title>
</head>
<body>
	<div>入力内容の取得</div>
	<?php
		// テキストが入力されているとき
		if( isset( $_GET["display_text"] ) && $_GET["display_text"] != "" )
		{
			echo "入力した内容：" . htmlspecialchars( $_GET["display_text"], ENT_QUOTES, "UTF-8" );
		}
		else // 入力されてない時
		{
			echo "入力されていません";
		}
	?>
</body>
</html>
