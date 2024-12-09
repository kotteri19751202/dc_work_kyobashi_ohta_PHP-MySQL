<?php

//========================================================================
//------------------------------------------------------------------------
// アイテム管理ページ Controller
//------------------------------------------------------------------------
//========================================================================

//------------------------------------------------------------------------
// Model
//------------------------------------------------------------------------
require_once( "../../include/ec_site/model/item_model.php" );

//------------------------------------------------------------------------
// Controller
//------------------------------------------------------------------------

//===============================================
// POSTチェック 
//===============================================
function checkPost( $db, &$strRegistItemMsg, &$strItemMsg )
{
	// リクエストメソッドがPOSTじゃない時
	if( $_SERVER["REQUEST_METHOD"] != "POST" )
	{
		dprint( "POSTじゃない");
		return 0;
	}

	// アイテム登録の時
	if( isset( $_POST["regist_item"] ) )
	{
		dprint( "アイテム登録");
		registItem( $db, $strRegistItemMsg );
		return 0;
	}

	// アイテム個数の変更の時
	if( isset( $_POST["update_item_stock_num"] ) )
	{
		dprint( "アイテム個数の変更");
		updateItemStockNum( $db, $strItemMsg );
		return 0;
	}

	// アイテム公開フラグの切り替えの時
	if( isset( $_POST["change_item_public_flg"] ) )
	{
		dprint( "アイテム公開フラグの切り替え");
		changeItemPublicFlg( $db, $strItemMsg );
		return 0;
	}
	
	// アイテム削除の時
	if( isset( $_POST["delete_item"] ) )
	{
		dprint( "アイテム削除");
		deleteItem( $db, $strItemMsg );
		return 0;
	}
}

// セッション開始
session_start();

// 管理者権限じゃない時
if( !$_SESSION["is_admin"] )
{
	// index.phpにリダイレクト（転送）する
	header('Location: index.php');
	exit();
}

// 先ずDBに接続する
$db = connectDB();

$strRegistItemMsg = ""; // アイテム登録メッセージ
$strItemMsg = ""; // アイテムメッセージ

// POSTチェック 
checkPost( $db, $strRegistItemMsg, $strItemMsg );

// アイテムデータの取得
$arrItemData = getItemData( $db );

//------------------------------------------------------------------------
// View
//------------------------------------------------------------------------
include_once( "../../include/ec_site/view/manage_item_view.php" );
