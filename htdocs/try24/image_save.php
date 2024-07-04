<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY24</title>
</head>
<body>
	<?php
	// ファイルが送信されてない場合はエラー
	if( !isset( $_FILES["upload_image"] ) )
	{
		echo 'ファイルが送信されていません。';
		exit;
	}

	// 保存パス作成
	$save = "img/" . basename($_FILES["upload_image"]["name"]);

	// ファイルを保存先ディレクトリに移動させる
	if( move_uploaded_file( $_FILES["upload_image"]["tmp_name"], $save ) )
	{
		echo "アップロード成功しました。";
	}
	else
	{
		echo "アップロード失敗しました。";
	}
	?>
</body>
</html>