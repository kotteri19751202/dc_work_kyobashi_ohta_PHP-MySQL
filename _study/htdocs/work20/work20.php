<?php
	define('WRITE_DATA_FILE_NAME','./data.txt'); // 書きこみデータファイル名
	
	// 書きこみデータファイルがなかったら
	if( false == file_exists( WRITE_DATA_FILE_NAME ) )
	{
		// ファイル作成
		touch( WRITE_DATA_FILE_NAME );
	}

	// POSTで呼ばれた時
	if( isset( $_POST["title"] ) && isset( $_POST["text"] ) 
		&& isset( $_FILES["upload_image"] ) )
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

		$strSaveFileName = "";
		// ファイル名が入力されているとき
		if( $_FILES["upload_image"]["name"] != "" )
		{
			// 保存パス作成
			$strSaveFileName = "img/" . basename($_FILES["upload_image"]["name"]);
		}

		// 入力情報が不足していたら
		if( $strTitle == "" || $strText == "" || $strSaveFileName == "" )
		{
			echo "<div>入力情報が不足しています！。</div>";
		}
		else // 情報が足りていたら
		{
			// ファイルを保存先ディレクトリに移動させる(ちょっとネスト深くなった)
			if( move_uploaded_file( $_FILES["upload_image"]["tmp_name"], $strSaveFileName ) )
			{
				//echo "アップロード成功しました。";
			
				// デーファイルに書き込み ---------------
				// ファイル開く
				$fp = fopen( WRITE_DATA_FILE_NAME, 'c+');
		
				// ファイルロック
				flock( $fp, LOCK_EX );
				
				// 追加文字列作成
				$strWriteData = sprintf( "%s|%s|%s|\n", $strTitle, $strText, $strSaveFileName );
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
			else
			{
				echo "アップロード失敗しました。";
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORK20</title>
</head>
<body>
	<!-- css --------------------------------------------->
	<style>
	img{
		margin-left:10px;
		max-height:100px;
		max-width: 100px;
	}
	</style>

	<div>公序良俗の範囲内で、ご自由に書き込みを行ってください。</div>
	<form method="post" enctype="multipart/form-data">
		タイトル<br>
		<input type="text" name="title" ><br>
		書き込み内容<br>
		<input type="text" name="text" ><br>
		画像ファイル<br>
		<input type="file" name="upload_image"><br>
		<br>
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

			// パース文字列で分割
			$arrValue = explode( "|", $value );

			// 行を表示
			echo "<li>" . $arrValue[ 0 ] . "：" . $arrValue[ 1 ] . 
				"<img src='" . $arrValue[ 2 ] . "'>" . "</li>\n";
		}

		echo "</ul>";
	?>
</body>
</html>
