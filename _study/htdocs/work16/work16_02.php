<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORK16</title>
</head>
<body>
	<div>入力内容の取得</div>
	<?php
		// テキストが入力されているとき
		if( isset( $_GET["name"] ) && $_GET["name"] != "" )
		{
			echo "入力した内容：" . htmlspecialchars( $_GET["name"], ENT_QUOTES, "UTF-8" ) . "<br>";
		}
		else // 入力されてない時
		{
			echo "入力されていません<br>";
		}
		// チェックボックス01の値
		if( isset( $_GET["check_01"] ) ) echo "選択肢01：" . $_GET["check_01"] . "<br>"; 
		// チェックボックス02の値
		if( isset( $_GET["check_02"] ) ) echo "選択肢02：" . $_GET["check_02"] . "<br>"; 
		// チェックボックス02の値
		if( isset( $_GET["check_03"] ) ) echo "選択肢03：" . $_GET["check_03"] . "<br>"; 
	?>
</body>
</html>
