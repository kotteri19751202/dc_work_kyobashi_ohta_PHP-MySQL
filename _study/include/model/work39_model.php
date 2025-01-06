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
define( "DSN", "mysql:host=localhost;dbname=xb513874_wa8fy;charset=utf8mb4" ); 
define( "DB_USER_NAME", "xb513874_t7dq0" ); 
define( "DB_PASS_WORD", "7op8tds1dz" );
define( "TABLE_NAME",	"tbl_work30_image" );

define( "IMAGE_DIR", "img/" ); // イメージディレクトリ名

// ページタイプ列挙型
define( "E_PAGE_TYPE_IMAGE_LIST", 		"0"		); // 画像一覧
define( "E_PAGE_TYPE_IMAGE_UPLOAD", 	"1"		); // 画像投稿

define("URL_IMAGE_LIST", "./work39.php?page_type=0" 	); // 画像一覧ページURL
define("URL_IMAGE_UPLOAD", "./work39.php?page_type=1"	); // 画像投稿ページURL


//===============================================
// DB接続 
//===============================================
function connectDB()
{
	try
	{
		// データベースへ接続
		$pdo = new PDO( DSN, DB_USER_NAME, DB_PASS_WORD, 
						array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ) );

		return $pdo;
	}
	catch( PDOException $e )
	{
		// エラー発生
		echo $iRow . "DB接続エラーです。<br>";
		// エラーメッセージ表示
		echo $e->getMessage() . "<br>";
		// 終了
		exit();
	}
}

//===============================================
// SELECTの結果を取得 
//===============================================
function getSelectResult( $pdo, $strSelectSql )
{
	// prepareメソッドによるクエリの実行準備をする
	$stmt = $pdo->prepare( $strSelectSql );
	// クエリ実行
	$stmt->execute();
	// 件数取得
	$iRow = $stmt->rowCount();
	// 更新件数表示
	//echo $iRow . "件取得しました。<br>";
	// 結果を取ってくる
	return $stmt->fetchAll();
}
	
//===============================================
// 特殊文字の変換
//===============================================
function setHtmlSpecialChars( $strString )
{
	return htmlspecialchars( $strString, ENT_QUOTES, 'UTF-8' );
}
	
//===============================================
// 特殊文字の変換（二次元配列対応）
//===============================================
function setHtmlSpecialCharsAarray( $arrArray )
{
	// 二次元配列をforeachでループさせる
	foreach ( $arrArray as $strKeys => $values )
	{
		foreach( $values as $strKey => $value )
		{
			// 特殊文字の変換
			$arrArray[ $strKkeys ][ $strKey ] = setHtmlSpecialChars( $value );
		}
	}
	return $ArrArray;
}	

//===============================================
// 画像の投稿 
//===============================================
function uploadImage( &$pdo )
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
	
	try
	{
		// トランザクション開始
		$pdo->beginTransaction();

		// Insertクエリ作成
		$strInsertQuery = "INSERT INTO " . TABLE_NAME . " VALUES( NULL, :imageName, :imageFileName, 1, now(), now() )";
		// prepareメソッドによるクエリの実行準備をする
		$stmt = $pdo->prepare( $strInsertQuery );
		// 値をバインドする
		$stmt->bindValue( ":imageName", $strImageName );
		$stmt->bindValue( ":imageFileName", $strImageFileName );
		//$stmt->bindValue( ":imageName", $strImageName, PDO::PARAM_STR );
		//$stmt->bindValue( ":imageFileName", $strImageFileName, PDO::PARAM_STR );

		// クエリ実行
		$stmt->execute();
		// 件数取得
		$iRow = $stmt->rowCount();
		// 更新件数表示
		echo $iRow . "件更新しました。<br>";
		// コミット
		$pdo->commit();
	}
	catch( PDOException $e )
	{
		echo $stmt->queryString;
		// エラー発生
		echo $iRow . "エラーです。<br>";
		// エラーメッセージ表示
		echo $e->getMessage() . "<br>";
		// ロールバック
		$pdo->rollBack();
	}
}

//===============================================
// 表示の切り替え 
//===============================================
function changePuclicFlg( &$pdo )
{
	try
	{
		// Updateクエリ作成
		$strUpdateQuery = "UPDATE " . TABLE_NAME . 
							" SET PublicFlg = :changePublicFlg" .
							", UpdateTime = now() " .
							" WHERE ImageID = :imageID";
		// トランザクション開始
		$pdo->beginTransaction();

		// prepareメソッドによるクエリの実行準備をする
		$stmt = $pdo->prepare( $strUpdateQuery );
		// 値をバインドする
		$stmt->bindValue( ":changePublicFlg", $_POST["change_public_flg"] );
		$stmt->bindValue( ":imageID", $_POST["image_id"] );

		// クエリ実行
		$stmt->execute();
		// 件数取得
		$iRow = $stmt->rowCount();
		// 更新件数表示
		echo $iRow . "件更新しました。<br>";
		// コミット
		$pdo->commit();
	}
	catch( PDOException $e )
	{
		// エラー発生
		echo $iRow . "エラーです。<br>";
		// エラーメッセージ表示
		echo $e->getMessage() . "<br>";
		// ロールバック
		$pdo->rollBack();
	}
}

//===============================================
// POSTチェック 
//===============================================
function checkPost( &$pdo )
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
		changePuclicFlg( $pdo );
		return 0;
	}
	
	// 画像投稿の時
	if( false != isset( $_POST["upload_image"] ) )
	{
		uploadImage( $pdo );
		return 0;
	}
}

//===============================================
// 表示データの取得
//===============================================
function getViewData( &$pdo )
{
	// SELECT文の実行
	$strSelectSql = "SELECT * FROM " . TABLE_NAME;
	// SELECTの結果を取得 
	return getSelectResult( $pdo, $strSelectSql );
}