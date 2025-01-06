<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY54</title>
</head>
<body>
<?php
	var_dump( $_SESSION );
	echo "<br>";

	$_SESSION["id"] = 1;
	$_SESSION["username"] = "login_user";
	$_SESSION["year"] = date( "Y");
	var_dump( $_SESSION );
	echo "<br>";

	unset( $_SESSION["username"]);
	var_dump( $_SESSION );
	echo "<br>";

	unset( $_SESSION["id"]);
	unset( $_SESSION["year"]);
?>
</body>
</html>
