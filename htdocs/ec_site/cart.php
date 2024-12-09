<?php

//========================================================================
//------------------------------------------------------------------------
// カートページ Controller
//------------------------------------------------------------------------
//========================================================================

//------------------------------------------------------------------------
// Model
//------------------------------------------------------------------------
require_once( "../../include/ec_site/model/cart_model.php" );

//------------------------------------------------------------------------
// Controller
//------------------------------------------------------------------------

//===============================================
// POSTチェック 
//===============================================
function checkPost( $db, &$strCartMsg )
{
	// リクエストメソッドがPOSTじゃない時
	if( $_SERVER["REQUEST_METHOD"] != "POST" )
	{
		dprint( "POSTじゃない");
		return 0;
	}

	// カートアイテム個数の変更の時
	if( isset( $_POST["update_cart_item_num"] ) )
	{
		dprint( "カートアイテム個数の変更");
		updateCartItemNum( $db, $strCartMsg );
		return 0;
	}

	// カートアイテム削除の時
	if( isset( $_POST["delete_cart_item"] ) )
	{
		dprint( "カートアイテム削除");
		deleteCartItem( $db, $strCartMsg );
		return 0;
	}
}

// セッション開始
session_start();

// ログイン中じゃない時
if( false == isset( $_SESSION["user_name"] ) )
{
	// ログイン中ではない場合は、index.phpにリダイレクト（転送）する
	header('Location: index.php');
	exit();
}

// 先ずDBに接続する
$db = connectDB();

$strCartMsg = ""; 		// カートメッセージ
$arrCartData = [[]];	// カートデータ配列
$iTotalPrice = 0;		// 合計金額の取得

// POSTチェック 
checkPost( $db, $strCartMsg );

// カートデータの取得
getCartData( $db, $arrCartData, $iTotalPrice, $strCartMsg );

dprint( $iTotalPrice );

dprint("在庫なかった：" . $_SESSION["buy_cart_item_result_stock_empty_flg"] );

// 購入で在庫がなかったフラグに値が入っていたら
if( isset( $_SESSION["buy_cart_item_result_stock_empty_flg"] ) )
{
	// 購入で在庫がなかったフラグがONの時
	if( $_SESSION["buy_cart_item_result_stock_empty_flg"] )
	{
		$strCartMsg = MSG_BUY_CART_ITEM_ERR_STOCK_EMPTY;
		// 購入で在庫がなかったフラグ初期化
		$_SESSION["buy_cart_item_result_stock_empty_flg"] = false;
	}	
}


//------------------------------------------------------------------------
// View
//------------------------------------------------------------------------
include_once( "../../include/ec_site/view/cart_view.php" );
