<?php


/* ページ構成
htdocs/ec_site/
		index.php
		regist_user.php
		item_list.php
		manage_item.php
		cart.php
		purchase_result.php

include/ec_site/
	model/	// モデル
		common_model.php
		index_model.php
		regist_user_model.php
		item_list_model.php
		manage_item_model.php
		cart_model.php
		purchase_result_model.php
	view/	// ビュー
		index_view.php
		regist_user_view.php
		item_list_view.php
		manage_item_view.php
		cart_veiw.php
		purchase_result_view.php

		common/		// 共通テンプレート
			head_view.php
			header_view.php
			footer_view.php
*/

/* 共通テンプレート文献
https://www.webdesignleaves.com/pr/php/php_create_template.php


/* 書類リスト						

/* DBテーブル */
/* ユーザテーブル
DROP TABLE IF EXISTS tbl_ec_user;
CREATE TABLE tbl_ec_user (
	UserID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	UserName VARCHAR(128) CHARACTER SET utf8 NOT NULL,
	Password VARCHAR(128) CHARACTER SET utf8 NOT NULL,
	IsAdmin  BOOLEAN NOT NULL DEFAULT 0,
	CreateTime DATETIME NOT NULL,
	UpdateTime DATETIME NOT NULL,
	PRIMARY KEY( UserID ),
	UNIQUE( UserName )
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO tbl_ec_user VALUES( 0, "ec_admin", "ec_admin", true, now(), now() );
INSERT INTO tbl_ec_user VALUES( 0, "kotteri", "kotterikotteri", false, now(), now() );

/* アイテムテーブル
DROP TABLE IF EXISTS tbl_ec_item;
CREATE TABLE tbl_ec_item (
	ItemID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	ItemName VARCHAR(128) CHARACTER SET utf8 NOT NULL,
	ImageData MEDIUMBLOB DEFAULT NULL,
	ImageContentType VARCHAR(10) CHARACTER SET utf8 DEFAULT NULL,
	Price INT(11) UNSIGNED NOT NULL DEFAULT 0,
	StockNum INT(11) UNSIGNED NOT NULL DEFAULT 1,
	PublicFlg  BOOLEAN NOT NULL DEFAULT FALSE,
	CreateTime DATETIME NOT NULL,
	UpdateTime DATETIME NOT NULL,
	PRIMARY KEY( ItemID )
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO tbl_ec_item VALUES( 0, 'りんご', '', '', 120, 10, true, now(), now() );
INSERT INTO tbl_ec_item VALUES( 0, 'いちご', '', '', 770, 100, true, now(), now() );
INSERT INTO tbl_ec_item VALUES( 0, 'パイナップル', '', '', 880, 23, true, now(), now() );
INSERT INTO tbl_ec_item VALUES( 0, 'すいか', '', '', 1200, 4, true, now(), now() );
INSERT INTO tbl_ec_item VALUES( 0, 'シャインマスカット', '', '', 890, 16, true, now(), now() );
INSERT INTO tbl_ec_item VALUES( 0, 'もも', '', '', 550, 55, true, now(), now() );
INSERT INTO tbl_ec_item VALUES( 0, 'オレンジ', '', '', 80, 420, true, now(), now() );
*/

/* カートテーブル
DROP TABLE IF EXISTS tbl_ec_cart;
CREATE TABLE tbl_ec_cart (
	UserID INT(11) UNSIGNED NOT NULL,
	ItemID INT(11) UNSIGNED NOT NULL,
	ItemNum INT(11) UNSIGNED NOT NULL DEFAULT 1,
	CreateTime DATETIME NOT NULL,
	UpdateTime DATETIME NOT NULL,
	PRIMARY KEY( UserID, ItemID ),
	INDEX( UserID ),
	FOREIGN KEY ( UserID ) REFERENCES tbl_ec_user ( UserID ),
	FOREIGN KEY ( ItemID ) REFERENCES tbl_ec_item ( ItemID )
)ENGINE=InnoDB DEFAULT CHARSET=latin1;
*/


//========================================================================
//------------------------------------------------------------------------
// ログインページ Controller
//------------------------------------------------------------------------
//========================================================================

//------------------------------------------------------------------------
// Model
//------------------------------------------------------------------------
require_once( "../../include/ec_site/model/user_model.php" );

//------------------------------------------------------------------------
// Controller
//------------------------------------------------------------------------

//===============================================
// Cookieの更新
//===============================================
function updateCookie()
{
	// Cokkieの有効時間
	$iCookieExpiration = time() + COOKIE_EXPIRATION_SECONDS;

	// チェックがある場合は、Cookieに保存
	if( $_POST["cookie_confirmation"] == "checked" )
	{
		setcookie("cookie_confirmation", $_POST["cookie_confirmation"], $iCookieExpiration );
		setcookie("user_name", $_POST["user_name"], $iCookieExpiration );
		setcookie("password", $_POST["password"], $iCookieExpiration );
		dprint( "Cookie保存");
	}
	else // チェックされてない場合はCookieを削除する
	{
		setcookie( "cookie_confirmation", "", time() - 30 );
		setcookie( "user_name", "", time() - 30 );
		setcookie( "password", "", time() - 30 );
		dprint( "Cookie削除");
	}
}

//===============================================
// POSTチェック 
//===============================================
function checkPost()
{
	// リクエストメソッドがPOSTじゃない時
	if( $_SERVER["REQUEST_METHOD"] != "POST" )
	{
		dprint( "POSTじゃない");
		return 0;
	}

	// ログアウト処理がされた場合
	if( isset( $_POST["logout"]) )
	{
		// セッション名を取得する
		$strSession = session_name();
		// セッション変数を削除
		$_SESSION = [];

		// セッションID（ユーザー側のCookieに保存されている）を削除
		if( isset( $_COOKIE[ $strSession ] ) )
		{
			// sessionに関する設定を取得
			$params = session_get_cookie_params();

			// cookie削除
			setcookie( $strSession, "", time() - 30, "/");
		}
		return 0;
	}

	// ログインの時
	if( isset( $_POST["login"] ) )
	{
		// Cookieの更新
		updateCookie();
		
		// 先ずDBに接続する
		$db = connectDB();

		// ログイン成功の時
		if( false != login( $db ) )
		{
			dprint( "ログイン成功" );
			
			// 管理者権限の時
			if( $_SESSION["is_admin"] )
			{
				// アイテム管理ページへ
				header( "Location:" . "manage_item.php" );
				exit();
			}
		}
		else // ログインに失敗したら
		{
			dprint( "ログイン失敗" );
			
			// セッションに情報保存
			$_SESSION["err_flg"] = true;
			
			// Cokkie反映のためもう一回呼び出す
			header( "Location:" . $_SERVER['PHP_SELF'] );
			exit();
		}
	}
}


//========================================================

//セッション開始
session_start();

// POSTチェック 
checkPost();

// ログイン中のユーザーであるかを確認する
if( isset( $_SESSION["user_name"] ) )
{
	// ログイン中である場合は、item_list.phpにリダイレクト（転送）する
	header( "Location: item_list.php");
	exit();
}

// エラーフラグに値が入ってたら
if( isset( $_SESSION["err_flg"]) )
{
	// エラーフラグがONの時
	if( $_SESSION["err_flg"] )
	{
		$strErrMsg =  MSG_INDEX_LOGIN_ERR;
		// エラーフラグ初期化
		$_SESSION["err_flg"] = false;
	}
}

// cookieの適用 -----------------------

// 省略するかどうかのチェックボックス 
$strCookieConfirmation = "";
if( isset( $_COOKIE["cookie_confirmation"] ) === true )
{
	$strCookieConfirmation = "checked"; dprint( "checked ON");
}
// ユーザー名
$strUserName = "";
if( isset( $_COOKIE["user_name"] ) === true )
{
	$strUserName = $_COOKIE["user_name"]; dprint( "cookie user_name ON" );
}
// パスワード
$strPassword = "";
if( isset( $_COOKIE["password"] ) === true )
{
	$strPassword = $_COOKIE["password"]; dprint( "cookie password ON");
}

//------------------------------------------------------------------------
// View
//------------------------------------------------------------------------
include_once( "../../include/ec_site/view/index_view.php" );
