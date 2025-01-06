<?php

// デバッグ表示
define( "DEBUG", false );
//define( "DEBUG", true );

// DB設定関連
define( "DSN", "mysql:host=localhost;dbname=xb513874_wa8fy;charset=utf8mb4" ); 
define( "DB_USER_NAME", "xb513874_t7dq0" ); 
define( "DB_PASS_WORD", "7op8tds1dz" );
// テーブル名
define( "TABLE_NAME_USER",	"tbl_ec_user" );	// ユーザーテーブル
define( "TABLE_NAME_ITEM",	"tbl_ec_item" );	// アイテムテーブル
define( "TABLE_NAME_CART",	"tbl_ec_cart" );	// カートテーブル


// 時間関連
define( "ONE_MINUTES_SECONDS", 60 );
define( "ONE_HOUR_MINUTES", 60 );
define( "ONE_DAY_HOUR", 24 );

// Cookieの保存期間（秒数）（30日）
define( "COOKIE_EXPIRATION_SECONDS", 30 * ONE_DAY_HOUR * ONE_HOUR_MINUTES * ONE_MINUTES_SECONDS );


// ユーザー名の形式（半角英数とアンダースコア（5文字以上））
define( "PREG_PATTERN_USER_NAME_FORM",	"\w{5,}$"	);							// HTML用
define( "PREG_PATTERN_USER_NAME",	"/". PREG_PATTERN_USER_NAME_FORM . "/"	);	// php用
// パスワードの形式（半角英数とアンダースコア（8文字以上））
define( "PREG_PATTERN_PASSWORD_FORM",	"\w{8,}$"	);							// HTML用
define( "PREG_PATTERN_PASSWORD",	"/". PREG_PATTERN_PASSWORD_FORM . "/"	);	// php用


// サイト名
define( "SITE_NAME", "フルーツショップ" );
// ページ名
define( "PAGE_NAME_INDEX", 					"ログインページ"	);
define( "PAGE_NAME_REGIST_USER", 			"ユーザー登録"		);
define( "PAGE_NAME_ITEM_LIST", 				"商品リスト"		);
define( "PAGE_NAME_MANAGE_ITEM", 			"商品管理"			);
define( "PAGE_NAME_CART",					"カート"			);
define( "PAGE_NAME_PURCHASE_RESULT",		"購入結果"			);
// ページ説明
define( "PAGE_DISCRIPTION_INDEX",			"ログインページです"	);
define( "PAGE_DISCRIPTION_REGIST_USER",		"ユーザー登録ページです");
define( "PAGE_DISCRIPTION_ITEM_LIST",		"商品一覧ページです"	);
define( "PAGE_DISCRIPTION_MANAGE_ITEM",		"商品管理ページです" 	);
define( "PAGE_DISCRIPTION_CART",			"カートページです"		);
define( "PAGE_DISCRIPTION_PURCHASE_RESULT",	"購入結果ページです"	);

// 各種メッセージ
define( "MSG_INDEX_LOGIN_ERR",				"ログインに失敗しました"		);

define( "MSG_REGIST_USER_USER_NAME_ERR",	"ユーザー名の形式が違います");
define( "MSG_REGIST_USER_PASSWORD_ERR",		"パスワードの形式が違います");
define( "MSG_REGIST_USER_SUCCESS",			"ユーザー登録完了"				);
define( "MSG_REGIST_USER_ERR",				"そのユーザー名は使用されています");

define( "MSG_REGIST_ITEM_SUCCESS",			"商品の登録が完了しました"		);
define( "MSG_REGIST_ITEM_ERR",				"正しい値を入力してください"	);

define( "MSG_UPDATE_ITEM_STOCK_NUM_SUCCESS",	"商品個数を変更しました"	);
define( "MSG_UPDATE_ITEM_STOCK_NUM_ERR",		"商品個数の変更に失敗しました");

define( "MSG_CHANGE_ITEM_PUBLIC_FLG_SUCCESS",	"商品の公開状態を変更しました"	);
define( "MSG_CHANGE_ITEM_PUBLIC_FLG_ERR",		"商品の公開状態の変更に失敗しました");

define( "MSG_DELETE_ITEM_SUCCESS",			"商品の削除が完了しました"	);
define( "MSG_DELETE_ITEM_ERR",				"商品の削除に失敗しました"	);

define( "MSG_ADD_CART_SUCCESS",				"カートへの追加が完了しました"	);
define( "MSG_ADD_CART_ERR",					"カートへの追加に失敗しました"	);

define( "MSG_CART_EMPTY",					"現在カート内に商品がありません"	);

define( "MSG_UPDATE_CART_ITEM_NUM_SUCCESS",	"カートの商品個数を変更しました"	);
define( "MSG_UPDATE_CART_ITEM_NUM_ERR",		"カートの商品個数の変更に失敗しました");

define( "MSG_DELETE_CART_ITEM_SUCCESS",		"カート商品の削除が完了しました"	);
define( "MSG_DELETE_CART_ITEM_ERR",			"カート商品の削除に失敗しました"	);

define( "MSG_BUY_CART_ITEM_SUCCESS",			"商品の購入が完了しました"	);
define( "MSG_BUY_CART_ITEM_ERR",				"商品の購入に失敗しました"	);
define( "MSG_BUY_CART_ITEM_ERR_STOCK_EMPTY",	"「%s」の在庫がありませんでした（残り%d個）");

define( "MSG_HEADER_LOGIN_KIND_ADMIN",		"管理者ログイン中"			);
define( "MSG_HEADER_LOGIN_KIND_NORMAL",		"ログイン中"				);
