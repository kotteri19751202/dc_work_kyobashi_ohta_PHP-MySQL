<?php

//========================================================================
//------------------------------------------------------------------------
// ユーザー登録ページ Controller
//------------------------------------------------------------------------
//========================================================================

//------------------------------------------------------------------------
// Model
//------------------------------------------------------------------------
require_once( "../../include/ec_site/model/user_model.php" );

//------------------------------------------------------------------------
// Controller
//------------------------------------------------------------------------

//セッション開始
session_start();

// ログイン中のユーザーであるかを確認する
if( isset( $_SESSION["user_name"] ) )
{
	// ログイン中である場合は、item_list.phpにリダイレクト（転送）する
	header( "Location: item_list.php");
	exit();
}

// ポストの時
if( $_SERVER["REQUEST_METHOD"] == "POST" )
{
	// 先ずDBに接続する
	$db = connectDB();
	$strMsg = ""; // メッセージ

	// ユーザー登録
	registUser( $db, $strMsg );
}

//------------------------------------------------------------------------
// View
//------------------------------------------------------------------------
include_once( "../../include/ec_site/view/regist_user_view.php" );