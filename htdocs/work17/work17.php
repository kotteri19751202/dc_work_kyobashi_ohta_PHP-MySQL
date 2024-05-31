<?php
	$strName = "";
	// テキストが入力されているとき
	if( isset( $_POST["name"] ) && $_POST["name"] != "" )
	{
		$strName = htmlspecialchars( $_POST["name"], ENT_QUOTES, "UTF-8" );
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORK16</title>
</head>
<body>
	<div>名前</div>
	<form method="post">
		<input type="text" name="name" value = <?php echo $strName;?> ><br>
		<input type="checkbox" name="check_01" <?php if( isset( $_POST["check_01"] ) ) echo "checked" ?>>選択肢01
		<input type="checkbox" name="check_02" <?php if( isset( $_POST["check_02"] ) ) echo "checked" ?>>選択肢02
		<input type="checkbox" name="check_03" <?php if( isset( $_POST["check_03"] ) ) echo "checked" ?>>選択肢03
		<input type="submit" value="送信">
	</form>
	<?php
		// チェックボックス01の値
		if( isset( $_POST["check_01"] ) ) echo "選択肢01：" . $_POST["check_01"] . "<br>"; 
		// チェックボックス02の値
		if( isset( $_POST["check_02"] ) ) echo "選択肢02：" . $_POST["check_02"] . "<br>"; 
		// チェックボックス02の値
		if( isset( $_POST["check_03"] ) ) echo "選択肢03：" . $_POST["check_03"] . "<br>"; 
	?>
	</body>
</html>
