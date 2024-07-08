<?php
	$strInput1 = "";
	if( isset( $_POST["input_1"] ) )
	{
		$strInput1 = htmlspecialchars($_POST['input_1'], ENT_QUOTES, 'UTF-8');
	}
	$strInput2 = "";
	if( isset( $_POST["input_2"] ) )
	{
		$strInput2 = htmlspecialchars($_POST['input_2'], ENT_QUOTES, 'UTF-8');
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORK21</title>
</head>
<body>
	<form method="post">
		<div>input①半角英字で入力を行ってください。</div>
		<input type="text" name="input_1" value=<?php echo $strInput1 ?>>
		
		<div>input①半角英字で入力を行ってください。</div>
		<input type="text" name="input_2" value=<?php echo $strInput2 ?>>
		<br>
		<input type="submit" value="送信">
	</form>
	<?php
		// 
		echo "<div>input①の結果 ----------</div>";
		// 半角英字じゃない時
		if( !preg_match("/^[a-zA-Z]+$/", $strInput1 ) && $strInput1 !== "" )
		{
			echo "<div>半角英字以外が入力されています。</div>";
		}
		else // 半角英字の時
		{
			// dcが含まれるとき
			if( preg_match("/dc/", $strInput1 ) )
			{
				echo "<div>ディーキャリアが含まれています。</div>";
			}
			// 最後がendで終わているとき
			if( preg_match("/end$/", $strInput1 ) )
			{
				echo "<div>終了です。</div>";
			}
		}
		
		echo "<div>input②の結果 ----------</div>";
		// 携帯電話番号の形式のとき
		if( !preg_match("/^0[7-9]0-[0-9]{4}-[0-9]{4}$/", $strInput2 ) && $strInput2 !== "" )
		{
			echo "<div>携帯電話番号の形式ではありません。</div>";
		}
	?>
</body>
</html>