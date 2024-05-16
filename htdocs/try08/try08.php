<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY08</title>
</head>
<body>
<?php
	$strFruit01 = "りんご";
	$strFruit02 = "バナナ";

	if( $strFruit01 == "りんご" && $strFruit02 == "バナナ" )
	{
		echo "<p>fruit01はリンゴで、かつ、frute02はバナナです!</p>";
	}
	
	if( $strFruit01 == "りんご" || $strFruit02 == "りんご" )
	{
		echo "<p>fruit01がりんご、あるいは、frute02がりんごのどちらかです!</p>";
	}
	
	if( !( $strFruit01 == "バナナ" ) )
	{
		echo "<p>fruit01はバナナではありません。</p>";
	}

?>
</body>
</html>
