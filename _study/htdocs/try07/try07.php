<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY07</title>
</head>
<body>
<?php
	$iNum = 10;
	$strNum = "10";

	print var_dump( $iNum == $strNum );		// true;
	print var_dump( $iNum === $strNum ); 	// false;
?>
</body>
</html>
