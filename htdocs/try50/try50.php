<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY50</title>
</head>
<body>
	<?php
	// グローバル変数
	$g_strString = "グローバル変数";

	function setLocalString()
	{
		$strString = "ローカル変数";
		echo "<p>関数内のローカル変数：" . $strString . "</p>";
		echo "<p>関数内のグローバル変数：" . $g_strString . "</p>";
	}

	echo setLocalString();
	echo "<p>関数内のグローバル変数：" . $g_strString . "</p>";
	echo "<p>関数内のローカル変数：" . $strString . "</p>";
	?>
</body>
</html>