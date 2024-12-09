<?php

//========================================================================
//------------------------------------------------------------------------
// 購入結果ページ Controller
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
function checkPost( $db, &$arrCartData, &$iTotalPrice, &$strCartMsg )
{
	// リクエストメソッドがPOSTじゃない時
	if( $_SERVER["REQUEST_METHOD"] != "POST" )
	{
		dprint( "POSTじゃない");

		// このページはPOSTじゃない時はカートページを表示する
		header('Location: cart.php');
		exit();
		
		return 0;
	}

	// カートアイテム購入の時
	if( isset( $_POST["buy_cart_item"] ) )
	{
		dprint( "カートアイテム購入");
		if( false == buyCartItem( $db, $arrCartData, $iTotalPrice, $strCartMsg ) )
		{
			// 購入に失敗したとき
			header('Location: cart.php');
			exit();
		}
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
checkPost( $db, $arrCartData, $iTotalPrice, $strCartMsg );

// カートデータの取得
//getCartData( $db, $arrCartData, $iTotalPrice, $strCartMsg );

dprint( $iTotalPrice );



//------------------------------------------------------------------------
// View
//------------------------------------------------------------------------
include_once( "../../include/ec_site/view/purchase_result_view.php" );
