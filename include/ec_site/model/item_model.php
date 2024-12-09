<?php
//========================================================================
//------------------------------------------------------------------------
// アイテム model
//------------------------------------------------------------------------
//========================================================================

//-----------------------------------------------
// 共通 model の読み込み
//-----------------------------------------------
require_once( "../../include/ec_site/model/common_model.php" );

//===============================================
// アイテムの公開フラグのチェック 
//===============================================
function checkItemPublicFlg( &$bItemPublicFlg )
{
	// アイテム公開状態 ---------------------
	$bItemPublicFlg = "";
	// アイテム公開状態で分岐
	switch( $_POST["item_public_flg"] )
	{
		case "false":
			$bItemPublicFlg = false;
			dprint( "公開状態：false" );
			break;
		case "true": 
			$bItemPublicFlg = true;
			dprint( "公開状態：true" );
			break;
		default: 
			dprint( "アイテム公開状態が異常です。" );
			return false;
	}

	return true;
}

//===============================================
// アイテムデータの取得
//===============================================
function getItemData( $db )
{
	// SELECT文の実行
	$strSelectQuery = "SELECT * FROM " . TABLE_NAME_ITEM;
	// SELECTの結果を取得 
	return getSelectResult( $db, $strSelectQuery );
}

//===============================================
// アイテムの登録
//===============================================
function registItem( $db, &$strRegistItemMsg )
{
	// デバッグ表示
	dprint( $_POST["item_name"] );
	dprint( $_POST["item_price"] );
	dprint( $_POST["item_num"] );
	dprint( $_FILES["item_image_file_name"]["tmp_name"] );
	dprint( $_POST["item_public_flg"] );

	// 情報が不足してる時
	if( !isset( $_POST["item_name"] ) 
		|| !isset( $_POST["item_price"] )
		|| !isset( $_POST["item_num"] )
		|| !isset( $_FILES["item_image_file_name"] )
		|| !isset( $_POST["item_public_flg"] )
	)
	{
		dprint( "アイテム登録情報が不足しています。" );
		// エラーメッセージ
		$strRegistItemMsg = MSG_REGIST_ITEM_ERR;
		return false;
	}

	// アイテム名 ---------------------
	// アイテム名が入力されてない時
	if( empty( $_POST["item_name"] ) )
	{
		dprint( "アイテム名が空です。" );
		$strRegistItemMsg = MSG_REGIST_ITEM_ERR;
		return false;
	}
	$strItemName = htmlspecialchars( $_POST["item_name"], ENT_QUOTES, "UTF-8" );

	// アイテム価格 -------------------
	// アイテム価格が数値じゃない時
	if( !is_numeric( $_POST["item_price"] ) )
	{
		dprint( "アイテム価格が数値じゃない" );
		$strRegistItemMsg = MSG_REGIST_ITEM_ERR;
		return false;
	}
	// アイテム価格が0以下の時
	if( 0 >= $_POST["item_price"] )
	{
		dprint( "アイテム価格が異常です" );
		$strRegistItemMsg = MSG_REGIST_ITEM_ERR;
		return false;
	}
	$iItemPrice = $_POST["item_price"];

	// アイテム数 --------------------
	// アイテム数が数値じゃない時
	if( !is_numeric( $_POST["item_num"] ) )
	{
		dprint( "アイテム数が数値じゃない" );
		$strRegistItemMsg = MSG_REGIST_ITEM_ERR;
		return false;
	}
	// アイテム数が0以下の時
	if( 0 >= $_POST["item_num"] )
	{
		dprint( "アイテム数が異常です" );
		$strRegistItemMsg = MSG_REGIST_ITEM_ERR;
		return false;
	}
	$iItemNum = $_POST["item_num"];

	// アイテム画像 -----------
	// アイテム画像ファイル名が入力されてない時
	if( empty( $_FILES["item_image_file_name"]["tmp_name"] ) )
	{
		dprint( "アイテム画像ファイル名が異常です" );
		$strRegistItemMsg = MSG_REGIST_ITEM_ERR;
		return false;
	}
	// コンテントタイプを取得
	$strItemImageContentType = mime_content_type( $_FILES["item_image_file_name"]["tmp_name"] );
	// ファイル形式が違ったら
	if( $strItemImageContentType != "image/jpeg" 
		&& $strItemImageContentType != "image/png" )
	{
		dprint( "アイテム画像のファイル形式が違います。" );
		$strRegistItemMsg = MSG_REGIST_ITEM_ERR;
		return false;
	}
	// 画像のバイナリデータ取得
	$binItemImageData = file_get_contents( $_FILES["item_image_file_name"]["tmp_name"] );

	// アイテム公開状態 ---------------------
	$bItemPublicFlg = "";
	// アイテムの公開フラグのチェック 
	if( false === checkItemPublicFlg( $bItemPublicFlg ) )
	{
		$strRegistItemMsg = MSG_REGIST_ITEM_ERR;
		return false;
	}

	try
	{
		// トランザクション開始
		//$db->beginTransaction();

		// 挿入クエリ作成
		$strInsertQuery = "INSERT INTO " . TABLE_NAME_ITEM 
							. " VALUES( NULL, :itemName, :imageData,"
								. " :imageContentType, :price, :stockNum, :publicFlg,"
								. " now(), now()"
							. " )";
							
		// クエリの実行準備をする
		$stmt = $db->prepare( $strInsertQuery );
		// 値をバインドする
		$stmt->bindValue( ":itemName", $strItemName );
		$stmt->bindValue( ":imageData", $binItemImageData );
		$stmt->bindValue( ":imageContentType", $strItemImageContentType );
		$stmt->bindValue( ":price", $iItemPrice );
		$stmt->bindValue( ":stockNum", $iItemNum );
		$stmt->bindValue( ":publicFlg", $bItemPublicFlg );

		// クエリ実行
		$stmt->execute();
		// 件数取得
		$iRow = $stmt->rowCount();

		// 登録件数表示
		dprint( $iRow . "件、追加しました。" );
		
		// 登録完了
		$strRegistItemMsg = MSG_REGIST_ITEM_SUCCESS;

		// コミット
		//$db->commit();

		return true;
	}
	catch( PDOException $e )
	{
		// クエリ文字列表示
		dprint( $stmt->queryString );
		// エラー発生
		dprint( "クエリエラーです。" );
		// エラーメッセージ表示
		dprint( $e->getMessage() );
		// ロールバック
		//$db->rollBack();
		// 登録失敗
		$strRegistItemMsg = MSG_REGIST_ITEM_ERR;

		return false;
	}
}

//===============================================
// アイテム個数の変更 
//===============================================
function updateItemStockNum( $db, &$strItemMsg )
{
	// デバッグ表示
	dprint( $_POST["item_id"] );
	dprint( $_POST["item_stock_num"] );

	// 情報が不足してる時
	if( !isset( $_POST["item_id"] )
		|| !isset( $_POST["item_stock_num"] )
	)
	{
		dprint( "アイテム個数の変更の情報が不足しています。" );
		// エラーメッセージ
		$strItemMsg = MSG_UPDATE_ITEM_STOCK_NUM_ERR;
		return false;
	}

	// アイテムID -------------------
	// アイテムIDが数値じゃない時
	if( !is_numeric( $_POST["item_id"] ) )
	{
		dprint( "アイテムIDが数値じゃない" );
		$strItemMsg = MSG_UPDATE_ITEM_STOCK_NUM_ERR;
		return false;
	}
	// アイテムIDが0以下の時
	if( 0 >= $_POST["item_id"] )
	{
		dprint( "アイテムIDが異常です" );
		$strItemMsg = MSG_UPDATE_ITEM_STOCK_NUM_ERR;
		return false;
	}
	$iItemID = $_POST["item_id"];

	// アイテム個数 -------------------
	// アイテム個数が数値じゃない時
	if( !is_numeric( $_POST["item_stock_num"] ) )
	{
		dprint( "アイテム個数が数値じゃない" );
		$strItemMsg = MSG_UPDATE_ITEM_STOCK_NUM_ERR;
		return false;
	}
	// アイテム個数が-1以下の時
	if( -1 >= $_POST["item_stock_num"] )
	{
		dprint( "アイテム個数が異常です" );
		$strItemMsg = MSG_UPDATE_ITEM_STOCK_NUM_ERR;
		return false;
	}
	$iItemStockNum = $_POST["item_stock_num"];

	
	try
	{
		// Updateクエリ作成
		$strUpdateQuery = "UPDATE " . TABLE_NAME_ITEM . 
							" SET StockNum = :stockNum" .
							", UpdateTime = now() " .
							" WHERE ItemID = :itemID";
		
		// トランザクション開始
		//$db->beginTransaction();

		// クエリの実行準備をする
		$stmt = $db->prepare( $strUpdateQuery );
		// 値をバインドする
		$stmt->bindValue( ":itemID", $iItemID );
		$stmt->bindValue( ":stockNum", $iItemStockNum );

		// クエリ実行
		$stmt->execute();
		// 件数取得
		$iRow = $stmt->rowCount();
		
		// 件数が1件じゃない時
		if( $iRow != 1 )
		{
			dprint( $iRow . "件、アイテム個数の更新件数が異常です" );
			// 更新失敗？
			$strItemMsg = MSG_UPDATE_ITEM_STOCK_NUM_ERR;

			return false;
		}
		
		// コミット
		//$db->commit();
		
		dprint( "アイテム個数を更新しました。" );
		// 更新完了
		$strItemMsg = MSG_UPDATE_ITEM_STOCK_NUM_SUCCESS;

		return true;
	}
	catch( PDOException $e )
	{
		// クエリ文字列表示
		dprint( $stmt->queryString );
		// エラー発生
		dprint( "クエリエラーです。" );
		// エラーメッセージ表示
		dprint( $e->getMessage() );
		// ロールバック
		//$db->rollBack();
		// アイテムの個数変更失敗
		$strItemMsg = MSG_UPDATE_ITEM_STOCK_NUM_ERR;

		return false;
	}
}

//===============================================
// アイテムの公開フラグの切り替え 
//===============================================
function changeItemPublicFlg( $db, &$strItemMsg )
{
	// デバッグ表示
	dprint( $_POST["item_id"] );
	dprint( $_POST["item_public_flg"] );

	// 情報が不足してる時
	if( !isset( $_POST["item_id"] )
		|| !isset( $_POST["item_public_flg"] )
	)
	{
		dprint( "アイテム公開フラグ切り替えの情報が不足しています。" );
		// エラーメッセージ
		$strItemMsg = MSG_CHANGE_ITEM_PUBLIC_FLG_ERR;
		return false;
	}

	// アイテムID -------------------
	// アイテムIDが数値じゃない時
	if( !is_numeric( $_POST["item_id"] ) )
	{
		dprint( "アイテムIDが数値じゃない" );
		$strItemMsg = MSG_CHANGE_ITEM_PUBLIC_FLG_ERR;
		return false;
	}
	// アイテムIDが0以下の時
	if( 0 >= $_POST["item_id"] )
	{
		dprint( "アイテムIDが異常です" );
		$strItemMsg = MSG_CHANGE_ITEM_PUBLIC_FLG_ERR;
		return false;
	}
	$iItemID = $_POST["item_id"];

	// アイテム公開状態 ---------------------
	$bItemPublicFlg = "";
	// アイテムの公開フラグのチェック 
	if( false === checkItemPublicFlg( $bItemPublicFlg ) )
	{
		dprint( "アイテム公開フラグが異常です" );
		$strItemMsg = MSG_CHANGE_ITEM_PUBLIC_FLG_ERR;
		return false;
	}	

	try
	{
		// Updateクエリ作成
		$strUpdateQuery = "UPDATE " . TABLE_NAME_ITEM . 
							" SET PublicFlg = :publicFlg" .
							", UpdateTime = now() " .
							" WHERE ItemID = :itemID";
		
		// トランザクション開始
		//$db->beginTransaction();

		// クエリの実行準備をする
		$stmt = $db->prepare( $strUpdateQuery );
		// 値をバインドする
		$stmt->bindValue( ":itemID", $iItemID );
		$stmt->bindValue( ":publicFlg", $bItemPublicFlg );

		// クエリ実行
		$stmt->execute();
		// 件数取得
		$iRow = $stmt->rowCount();

		// コミット
		//$db->commit();
		
		// 件数が1件じゃない時
		if( $iRow != 1 )
		{
			dprint( $iRow . "件、アイテム公開フラグの更新件数が異常です" );
			// 更新失敗？
			$strItemMsg = MSG_CHANGE_ITEM_PUBLIC_FLG_ERR;

			return false;
		}
		
		dprint( "アイテム公開フラグを更新しました。" );
		// 更新完了
		$strItemMsg = MSG_CHANGE_ITEM_PUBLIC_FLG_SUCCESS;

		return true;
	}
	catch( PDOException $e )
	{
		// クエリ文字列表示
		dprint( $stmt->queryString );
		// エラー発生
		dprint( "クエリエラーです。" );
		// エラーメッセージ表示
		dprint( $e->getMessage() );
		// ロールバック
		//$db->rollBack();
		// 削除失敗
		$strItemMsg = MSG_CHANGE_ITEM_PUBLIC_FLG_ERR;

		return false;
	}
}

//===============================================
// アイテムの削除
//===============================================
function deleteItem( $db, &$strItemMsg )
{
	// デバッグ表示
	dprint( $_POST["item_id"] );

	// 情報が不足してる時
	if( !isset( $_POST["item_id"] ) 
	)
	{
		dprint( "アイテム削除の情報が不足しています。" );
		// エラーメッセージ
		$strItemMsg = MSG_DELETE_ITEM_ERR;
		return false;
	}

	// アイテムID -------------------
	// アイテムIDが数値じゃない時
	if( !is_numeric( $_POST["item_id"] ) )
	{
		dprint( "アイテムIDが数値じゃない" );
		$strItemMsg = MSG_DELETE_ITEM_ERR;
		return false;
	}
	// アイテムIDが0以下の時
	if( 0 >= $_POST["item_id"] )
	{
		dprint( "アイテムIDが異常です" );
		$strItemMsg = MSG_DELETE_ITEM_ERR;
		return false;
	}
	$iItemID = $_POST["item_id"];

	try
	{
		// 削除クエリ作成
		$strDeletetQuery = "DELETE FROM " . TABLE_NAME_ITEM . " WHERE ItemID = :itemID";
		// クエリの実行準備をする
		$stmt = $db->prepare( $strDeletetQuery );
		// 値をバインドする
		$stmt->bindValue( ":itemID", $iItemID );
	
		// クエリ実行
		$stmt->execute();
		// 件数取得
		$iRow = $stmt->rowCount();

		// 件数が1件じゃない時
		if( $iRow != 1 )
		{
			dprint( $iRow . "件、アイテム削除の件数が異常です" );
			// 削除失敗
			$strItemMsg = MSG_DELETE_ITEM_ERR;

			return false;
		}

		dprint( "削除しました" );
		// 削除完了
		$strItemMsg = MSG_DELETE_ITEM_SUCCESS;

		return true;

	}
	catch( PDOException $e )
	{
		// クエリ文字列表示
		dprint( $stmt->queryString );
		// エラー発生
		dprint( "クエリエラーです。" );
		// エラーメッセージ表示
		dprint( $e->getMessage() );
		// 削除失敗
		$strItemMsg = MSG_DELETE_ITEM_ERR;

		return false;
	}
}
