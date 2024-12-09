<?php
//========================================================================
//------------------------------------------------------------------------
// 共通 model
//------------------------------------------------------------------------
//========================================================================


//-----------------------------------------------
// 定数設定の読み込み
//-----------------------------------------------
require_once "../../include/ec_site/config/const.php";

//===============================================
// デバッグ表示
//===============================================
function dprint( $strMsg )
{
	if( DEBUG ) echo "[D]" . $strMsg . "<br>\n";
	return;
}

//===============================================
// 情報表示
//===============================================
function iprint( $strMsg )
{
	echo $strMsg . "<br>\n";
	return;
}

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
		dprint( "DB接続エラーです。" );
		// エラーメッセージ表示
		dprint( "$e->getMessage()" );
		// 終了
		exit();
	}
}

//===============================================
// SELECTの結果を取得 
//===============================================
function getSelectResult( $db, $strSelectSql )
{
	// クエリの実行準備をする
	$stmt = $db->prepare( $strSelectSql );
	// クエリ実行
	$stmt->execute();
	// 件数取得
	$iRow = $stmt->rowCount();
	// 更新件数表示
	dprint( $iRow . "件、取得しました。" );
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
