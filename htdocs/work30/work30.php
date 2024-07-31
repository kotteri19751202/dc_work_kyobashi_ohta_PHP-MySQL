<?php
/* イメージテーブル
DROP TABLE IF EXISTS tbl_work30_image;
CREATE TABLE tbl_work30_image (
	ImageID INT(11) NOT NULL AUTO_INCREMENT,
	ImageName VARCHAR(128) CHARACTER SET utf8 DEFAULT NULL,
	ImageFileName VARCHAR(128) CHARACTER SET utf8 DEFAULT NULL,
	PublicFlg BOOLEAN NOT NULL,
	CreateTime DATETIME NOT NULL,
	UpdateTime DATETIME NOT NULL,
	PRIMARY KEY( ImageID )
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

*/
	// デバッグ表示
	define( "DEBUG", false );
	//define( "DEBUG", true );
	function dprint( $strMsg )
	{
		if( DEBUG ) echo $strMsg  . "<br>\n";
		return;
	}
	// 情報表示
	function iprint( $strMsg )
	{
		echo $strMsg  . "<br>\n";
		return;
	}

	// DB関連
	define( "HOST_NAME", 		"localhost" 		); 
	define( "USER_NAME", 		"xb513874_t7dq0" 	); 
	define( "PASS_WORD", 		"7op8tds1dz" 		);   
	define( "DATA_BASE_NAME", 	"xb513874_wa8fy" 	);
	define( "TABLE_NAME",		"tbl_work30_image" 	);

	define( "IMAGE_DIR", "img/" ); // イメージディレクトリ名

	// ページタイプ列挙型
	define( "E_PAGE_TYPE_IMAGE_LIST", 		"0"		); // 画像一覧
	define( "E_PAGE_TYPE_IMAGE_UPLOAD", 	"1"		); // 画像投稿

	//===============================================
	// 画像の投稿 
	//===============================================
	function uploadImage()
	{
		$arrDbErrMg = [];
		
		// 情報がない時
		if( false == isset( $_POST["image_name"] ) || false == isset( $_FILES["image_file_name"] ) )
		{
			iprint( "正しい値を入れていください" );
			return 0;
		}

		$strImageName = "";
		// 画像名が入力されているとき
		if( $_POST["image_name"] != "" )
		{
			// 画像名取得
			$strImageName = htmlspecialchars( $_POST["image_name"], ENT_QUOTES, "UTF-8" );
		}

		$strImageFileName = "";
		// 画像ファイル名が入力されているとき
		if( $_FILES["image_file_name"]["name"] != "" )
		{
			// 画像ファイル名
			$strImageFileName = basename( $_FILES["image_file_name"]["name"] );
		}

		// 入力情報が不足していたら
		if( $strImageName == "" || $strImageFileName == "" )
		{
			iprint( "<div>入力情報が不足しています！" );
			return -1;
		}

		// コンテントタイプを取得
		$strContentType = mime_content_type( $_FILES["image_file_name"]["tmp_name"] );
		//echo $strContentType ."<br>";
		// ファイル形式が違ったら
		if( $strContentType != "image/jpeg" && $strContentType != "image/png" )
		{
			iprint( "<div>JPGかPNG形式の画像のみ投稿できます！" );
			return -1;
		}

		// ファイルを保存先ディレクトリに移動させる
		if( false == move_uploaded_file( $_FILES["image_file_name"]["tmp_name"], IMAGE_DIR . $strImageFileName ) )
		{
			iprint( "画像ファイルのアップロードに失敗しました。" );
			return -1;
		}
		
		// DB書き込み ---------------
		// データベースへ接続
		$db = new mysqli( HOST_NAME, USER_NAME, PASS_WORD, DATA_BASE_NAME );
		if( $db->connect_error )
		{
			echo $db->connect_error;
			exit();
		}
		else
		{
			dprint( "データベースの接続に成功しました" );
			// 文字コードをUTF8に設定
			$db->set_charset("utf8"); 
		}

		// Insertクエリ作成
		$strInsertQuery = "INSERT INTO " . TABLE_NAME . " VALUES( NULL, '{$strImageName}', '{$strImageFileName}', 1, now(), now() )";
		// トランザクション開始
		$db->begin_transaction();

		// クエリ実行
		if( $result = $db->query( $strInsertQuery ) )
		{
			// 更新行数の取得
			$iRow = $db->affected_rows;
		}
		else // エラーの時
		{
			$arrDbErrMg[] = "INSERT実行エラー[実行SQL]" . $strInsertQuery;
		}

		// エラーがなかったら
		if( count( $arrDbErrMg ) == 0 )
		{
			dprint( $iRow . "件更新しました。" );
			// コミット
			$db->commit();
		}
		else // エラーの時
		{
			iprint( "更新が失敗しました。" );
			iprint( $db->error . "<br>" ); // 直近のエラーを表示
			// エラーメッセージ表示
			var_dump( $arrDbErrMg );
			echo "<br>";
			// ロールバック
			$db->rollback();
		}
		$db->close();
	}

	//===============================================
	// 表示の切り替え 
	//===============================================
	function changePuclicFlg()
	{
		$arrDbErrMg = [];
		
		// データベースへ接続
		$db = new mysqli( HOST_NAME, USER_NAME, PASS_WORD, DATA_BASE_NAME );
		if( $db->connect_error )
		{
			echo $db->connect_error;
			exit();
		}
		else
		{
			dprint( "データベースの接続に成功しました" );
			// 文字コードをUTF8に設定
			$db->set_charset("utf8"); 
		}

		// Insertクエリ作成
		$strUpdateQuery = "UPDATE " . TABLE_NAME . 
							" SET PublicFlg = " . $_POST["change_public_flg"] . 
							", UpdateTime = now() " .
							" WHERE ImageID = " . $_POST["image_id"];
		// トランザクション開始
		$db->begin_transaction();

		// クエリ実行
		if( $result = $db->query( $strUpdateQuery ) )
		{
			// 更新行数の取得
			$iRow = $db->affected_rows;
		}
		else // エラーの時
		{
			$arrDbErrMg[] = "UPDATE実行エラー[実行SQL]" . $strUpdateQuery;
		}

		// エラーがなかったら
		if( count( $arrDbErrMg ) == 0 )
		{
			dprint( $iRow . "件更新しました。" );
			// コミット
			$db->commit();
		}
		else // エラーの時
		{
			iprint( "更新が失敗しました。" );
			iprint( $db->error . "<br>" ); // 直近のエラーを表示
			// エラーメッセージ表示
			var_dump( $arrDbErrMg );
			echo "<br>";
			// ロールバック
			$db->rollback();
		}
		$db->close();
	}

	//===============================================
	// POSTチェック 
	//===============================================
	function checkPost()
	{
		// リクエストメソッドがPOSTじゃない時
		if( $_SERVER["REQUEST_METHOD"] != "POST" )
		{
			//dprint( "POSTじゃない");
			return 0;
		}
		
		// 表示の切替の時
		if( false != isset( $_POST["change_public"] ) )
		{
			changePuclicFlg();
			return 0;
		}
		
		// 画像投稿の時
		if( false != isset( $_POST["upload_image"] ) )
		{
			uploadImage();
			return 0;
		}
	}
	

	// ページタイプ
	$ePageType = E_PAGE_TYPE_IMAGE_LIST;	// 初期は画像一覧

	// ページタイプが設定されてたら
	if( false != isset( $_GET["page_type"] ) )
	{
		$ePageType = $_GET["page_type"];
	}
	
	// 画像投稿ページの時
	if( $ePageType == E_PAGE_TYPE_IMAGE_UPLOAD )
	{
		// POSTチェック 
		checkPost();
	}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORK30</title>
</head>
<body>
	<!---------------------------------------------------->
	<!-- css --------------------------------------------->
	<!---------------------------------------------------->
	<style>
	/* CSS変数宣言 */
	:root{
		/* フォントサイズ */
		--fs-xx-large: 	32px;
		--fs-x-large: 	24px;
		--fs-large: 	20px;
		--fs-medium: 	16px;
		--fs-small: 	14px;
		--fs-x-small: 	12px;

		/* フォント色 */
		--main-font-color:	#FFFFFF;
		--sub-font-color:	#000000;

		/* その他の色 */
		--back-ground-color-white:	white;			/* 背景色（白） */
		--back-ground-color-gray:	gray;			/* 背景色（灰色） */
	}
	/* リセット設定 */
	*{
		margin: 0;
		padding: 0;
		box-sizing: border-box;
		/*user-select: none;		/* 選択不可 */
		font-weight: bold;
	}
	/*img{
		margin-left:10px;
		max-height:100px;
		max-width: 100px;
	}*/
	/* 背景色（白） */
	.background-color-white{
		background-color:var(--back-ground-color-white);
	}
	/* 背景色（灰色） */
	.background-color-gray{
		background-color:var(--back-ground-color-gray);
	}
	/* タイトル */
	.caption{
		font-size: var(--fs-xx-large);
		text-align: left;
		color: var(--sub-font-color);
		margin-bottom: 20px;
	}

	/* フレックスボックス */
	.flex_item_box{
		display: flex;
		flex-direction: row;
		justifiy-content: flex-start;
		flex-wrap : wrap;
		margin-bottom: 30px;
	}
	/* 画像ボックス */
	.image_box{
		width: 150px;
		height: 150px;
		/*margin:0 auto;*/
		font-size: var(--fs-medium);
		/*background-color:var(--back-ground-color-gray);*/
		color:var(--sub-font-color);
		text-align: center;
		border:solid;
		border-radius: 5px;
		opacity: 1;
	}
	/* 画像 */
	.image{
		width: 60%;
		height: 60%;
		margin-bottom: 0px;
	}
	</style>
	
	<!---------------------------------------------------->
	<!-- html -------------------------------------------->
	<!---------------------------------------------------->
	<?php
		// 画像一覧ページの時
		if( $ePageType == E_PAGE_TYPE_IMAGE_LIST )
		{
			echo "<p class='caption'>画像一覧</p>\n";
		}
		else
		// 画像投稿ページの時
		if( $ePageType == E_PAGE_TYPE_IMAGE_UPLOAD )
		{
			echo "<p class='caption'>画像投稿</p>\n";
			echo "	<a href='./work30.php?page_type=0'>画像一覧ページへ</a>\n";
			echo "<br>\n";
			echo "<form method='post' enctype='multipart/form-data'>\n";
			echo "	画像名<br>\n";
			echo "	<input type='text' name='image_name' ><br>\n";
			echo "	画像ファイル<br>\n";
			echo "	<input type='file' name='image_file_name' accept='.jpg,.jpeg,.JPG,.JPEG,.png,.PNG'><br>\n";
			echo "	<br>\n";
			echo "	<input type='submit' name='upload_image' value='画像投稿'>\n";
			echo "</form>\n";
			echo "<br>\n";
		}

		// データベースへ接続
		$db = new mysqli( HOST_NAME, USER_NAME, PASS_WORD, DATA_BASE_NAME );
		if( $db->connect_error )
		{
			echo $db->connect_error;
			exit();
		}
		else
		{
			if( DEBUG ) echo "データベースの接続に成功しました。<br>\n";
			// 文字コードをUTF8に設定
			$db->set_charset("utf8"); 
		}
		
		echo "<div class='flex_item_box'>\n";
		
		// SELECT文の実行
		$strSelectSql = "SELECT * FROM " . TABLE_NAME;
		if( $result = $db->query( $strSelectSql ) )
		{
			// 結果の連想配列を取得
			while( $arrRow = $result->fetch_assoc() )
			{
				// 画像一覧ページの時
				if( $ePageType == E_PAGE_TYPE_IMAGE_LIST )
				{
					// 公開フラグがOFFの時
					if( $arrRow['PublicFlg'] == 0 ) continue;
				}
				else
				// 画像投稿ページの時
				if( $ePageType == E_PAGE_TYPE_IMAGE_UPLOAD )
				{
					$strPublicMsg = "非表示にする";
					$strBackGroundColorClass = "background-color-white";
					$bPublicFlg = 0;
					// 公開フラグがOFFの時
					if( $arrRow['PublicFlg'] == 0 )
					{
						$strPublicMsg = "表示する";
						$strBackGroundColorClass = "background-color-gray";
						$bPublicFlg = 1;
					}
				}

				echo "	<div class='image_box {$strBackGroundColorClass}'>\n";
				echo "		{$arrRow['ImageName']}<br>\n";
				echo "		<img class='image' src='". IMAGE_DIR . "{$arrRow['ImageFileName']}' alt='{$arrRow['ImageFileName']}'/>\n";
				
				// 画像投稿ページの時
				if( $ePageType == E_PAGE_TYPE_IMAGE_UPLOAD )
				{
					echo "		<form method='post'>\n";
					echo "			<input type='hidden' name='image_id' value='{$arrRow['ImageID']}'>\n";
					echo "			<input type='hidden' name='change_public_flg' value='{$bPublicFlg}'>\n";
					echo "			<input type='submit' name='change_public' value='{$strPublicMsg}'>\n";
					echo "		</form>\n";
				}
				
				echo "	</div>\n";
			}
			// 結果セットを閉じる
			$result->close();
		}
		else
		{
			dprint( "SELECTに失敗しました。" );
			echo $db->error;
		}
		$db->close();

		echo "</div>\n";

		// 画像一覧ページの時
		if( $ePageType == E_PAGE_TYPE_IMAGE_LIST )
		{
			echo "<a href='./work30.php?page_type=1'>画像投稿ページへ</a>\n";
		}
	?>

</body>
</html>
