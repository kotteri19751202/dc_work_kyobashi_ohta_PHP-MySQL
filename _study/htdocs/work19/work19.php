<?php
	define('WRITE_DATA_FILE_NAME','./data.txt'); // 書きこみデータファイル名
	
	// 書きこみデータファイルがなかったら
	if( false == file_exists( WRITE_DATA_FILE_NAME ) )
	{
		// ファイル作成
		touch( WRITE_DATA_FILE_NAME );
	}

	// POSTで呼ばれた時
	if( isset( $_POST["title"] ) && isset( $_POST["text"] ) )
	{
		$strTitle = "";
		// タイトルが入力されているとき
		if( $_POST["title"] != "" )
		{
			$strTitle = htmlspecialchars( $_POST["title"], ENT_QUOTES, "UTF-8" );
		}
		$strText = "";
		// テキストが入力されているとき
		if( $_POST["text"] != "" )
		{
			$strText = htmlspecialchars( $_POST["text"], ENT_QUOTES, "UTF-8" );
		}
	
		// 入力情報が不足していたら
		if( $strTitle == "" || $strText == "" )
		{
			echo "<div>入力情報が不足しています！。</div>";
		}
		else // 情報が足りていたら
		{
			// ファイル開く
			$fp = fopen( WRITE_DATA_FILE_NAME, 'c+');
	
			// ファイルロック
			flock( $fp, LOCK_EX );
			
			// 追加文字列作成
			$strWriteData = sprintf( "%s：%s\n", $strTitle, $strText );
			// 先頭に連結
			$strWriteData .= stream_get_contents( $fp );
			// ファイルポインタを先頭に移動
			rewind( $fp );
	
			// 書きこみ
			$result = fwrite( $fp, $strWriteData );
			// エラーチェック
			if( $result === false )
			{
				echo "<div>書き込みに失敗しました。</div>";
			}
			// フラッシュ
			fflush( $fp );
	
			// ファイルロック解除
			flock( $fp, LOCK_UN );
			
			// ファイル閉じる
			fclose( $fp );
		}
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORK19</title>
</head>
<body>
	<div>公序良俗の範囲内で、ご自由に書き込みを行ってください。</div>
	<form method="post">
		タイトル<br>
		<input type="text" name="title" ><br>
		書き込み内容<br>
		<input type="text" name="text" ><br><br>
		<input type="submit" value="送信">
	</form>
	<?php
		echo "<ul>";
		
		// ファイル読み込み
		$strReadData = file_get_contents( WRITE_DATA_FILE_NAME );
		// 各種改行で\nに置換
		$strReadData = str_replace( array( "\r\n", "\r", "\n" ), "\n", $strReadData );
		// 改行で分割
		$arrReadData = explode( "\n", $strReadData );

		// 行数ループ
		foreach( $arrReadData as $value )
		{
			// 空行の時は戻る
			if( $value == "" ) continue;
			// 行を表示
			echo "<li>" . $value . "</li>";
		}

		echo "</ul>";
	?>
</body>
</html>
