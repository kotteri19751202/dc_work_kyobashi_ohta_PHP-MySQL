<?php
//========================================================================
//------------------------------------------------------------------------
// カート model
//------------------------------------------------------------------------
//========================================================================

//-----------------------------------------------
// 共通 model の読み込み
//-----------------------------------------------
require_once( "../../include/ec_site/model/common_model.php" );

//===============================================
// カートデータの取得
//===============================================
function getCartData( $db, &$arrCartData, &$iTotalPrice, &$strCartMsg )
{
	// デバッグ表示
	dprint( $_SESSION["user_id"] );

	// 情報が不足してる時
	if( !isset( $_SESSION["user_id"] ) )
	{
		dprint( "カートへデータ取得の情報が不足しています。" );
		// エラーメッセージ
		$strCartMsg = MSG_ADD_CART_ERR;
		return false;
	}

	// ユーザーID -------------------
	// ユーザーIDが数値じゃない時
	if( !is_numeric( $_SESSION["user_id"] ) )
	{
		dprint( "ユーザーIDが数値じゃない" );
		$strCartMsg = MSG_ADD_CART_ERR;
		return false;
	}
	// ユーザーIDが0以下の時
	if( 0 >= $_SESSION["user_id"] )
	{
		dprint( "ユーザーIDが異常です" );
		$strCartMsg = MSG_ADD_CART_ERR;
		return false;
	}
	$iUserID = $_SESSION["user_id"];

	try
	{
		// SELECT文の実行
		$strSelectQuery = "SELECT "
							. TABLE_NAME_CART . ".ItemID AS ItemID"
							. ", " . TABLE_NAME_CART . ".ItemNum AS ItemNum"
							. ", " . TABLE_NAME_ITEM . ".ItemName AS ItemName"
							. ", " . TABLE_NAME_ITEM . ".ImageData AS ImageData"
							. ", " . TABLE_NAME_ITEM . ".ImageContentType AS ImageContentType"
							. ", " . TABLE_NAME_ITEM . ".Price AS Price"
							. " FROM " . TABLE_NAME_CART
								. " JOIN " . TABLE_NAME_ITEM . " USING( ItemID ) "
							. " WHERE UserID = :userID";

		// クエリの実行準備をする
		$stmt = $db->prepare( $strSelectQuery );
		// 値をバインドする
		$stmt->bindValue( ":userID", $iUserID );

		// クエリ実行
		$stmt->execute();
		// 件数取得
		$iRow = $stmt->rowCount();
		// 登録件数表示
		dprint( $iRow . "件、取得しました。" );

		// 0件の時
		if( 0 >= $iRow )
		{
			// カートが空です
			$strCartMsg = MSG_CART_EMPTY;
		}
		
		// カートデータ
		$arrCartData = $stmt->fetchAll();

		// 合計金額の計算
		$iTotalPrice = 0;
		// カートデータループ
		foreach( $arrCartData as $arrRow )
		{
			$iTotalPrice += $arrRow["Price"] * $arrRow["ItemNum"];
		}
		
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

		return false;
	}
}

//===============================================
// カートへの追加
//===============================================
function addCart( $db, &$strCartMsg )
{
	// デバッグ表示
	dprint( $_SESSION["user_id"] );
	dprint( $_POST["item_id"] );
	dprint( $_POST["item_num"] );

	// 情報が不足してる時
	if( !isset( $_SESSION["user_id"] ) 
		|| !isset( $_POST["item_id"] )
		|| !isset( $_POST["item_num"] )
	)
	{
		dprint( "カートへの追加情報が不足しています。" );
		// エラーメッセージ
		$strCartMsg = MSG_ADD_CART_ERR;
		return false;
	}

	// ユーザーID -------------------
	// ユーザーIDが数値じゃない時
	if( !is_numeric( $_SESSION["user_id"] ) )
	{
		dprint( "ユーザーIDが数値じゃない" );
		$strCartMsg = MSG_ADD_CART_ERR;
		return false;
	}
	// ユーザーIDが0以下の時
	if( 0 >= $_SESSION["user_id"] )
	{
		dprint( "ユーザーIDが異常です" );
		$strCartMsg = MSG_ADD_CART_ERR;
		return false;
	}
	$iUserID = $_SESSION["user_id"];

	// アイテムID -------------------
	// アイテムIDが数値じゃない時
	if( !is_numeric( $_POST["item_id"] ) )
	{
		dprint( "アイテムIDが数値じゃない" );
		$strCartMsg = MSG_ADD_CART_ERR;
		return false;
	}
	// アイテムIDが0以下の時
	if( 0 >= $_POST["item_id"] )
	{
		dprint( "アイテムIDが異常です" );
		$strCartMsg = MSG_ADD_CART_ERR;
		return false;
	}
	$iItemID = $_POST["item_id"];

	// アイテム数 --------------------
	// アイテム数が数値じゃない時
	if( !is_numeric( $_POST["item_num"] ) )
	{
		dprint( "アイテム数が数値じゃない" );
		$strCartMsg = MSG_ADD_CART_ERR;
		return false;
	}
	// アイテム数が0以下の時
	if( 0 >= $_POST["item_num"] )
	{
		dprint( "アイテム数が異常です" );
		$strCartMsg = MSG_ADD_CART_ERR;
		return false;
	}
	$iItemNum = $_POST["item_num"];

	try
	{
		// 挿入クエリ作成
		$strInsertQuery = "INSERT INTO " . TABLE_NAME_CART 
							. " VALUES("
								. " :userID, :itemID, :itemNum, now(), now()"
							. " )"
							. " ON DUPLICATE KEY UPDATE ItemNum = ItemNum + :itemNum, UpdateTime = now()";

		// クエリの実行準備をする
		$stmt = $db->prepare( $strInsertQuery );
		// 値をバインドする
		$stmt->bindValue( ":userID", $iUserID );
		$stmt->bindValue( ":itemID", $iItemID );
		$stmt->bindValue( ":itemNum", $iItemNum );

		// クエリ実行
		$stmt->execute();
		// 件数取得
		$iRow = $stmt->rowCount();
		// 登録件数表示
		dprint( $iRow . "件、追加しました。" );

		// 登録完了
		$strCartMsg = MSG_ADD_CART_SUCCESS;

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
		// 登録失敗
		$strCartMsg = MSG_ADD_CART_ERR;

		return false;
	}
}

//===============================================
// カートアイテム個数の変更 
//===============================================
function updateCartItemNum( $db, &$strCartMsg )
{
	// デバッグ表示
	dprint( $_SESSION["user_id"] );
	dprint( $_POST["item_id"] );
	dprint( $_POST["item_num"] );

	// 情報が不足してる時
	if( !isset( $_SESSION["user_id"] ) 
		|| !isset( $_POST["item_id"] )
		|| !isset( $_POST["item_num"] )
	)
	{
		dprint( "カートアイテム個数の変更の情報が不足しています。" );
		// エラーメッセージ
		$strCartMsg = MSG_UPDATE_CART_ITEM_NUM_ERR;
		return false;
	}

	// ユーザーID -------------------
	// ユーザーIDが数値じゃない時
	if( !is_numeric( $_SESSION["user_id"] ) )
	{
		dprint( "ユーザーIDが数値じゃない" );
		$strCartMsg = MSG_UPDATE_CART_ITEM_NUM_ERR;
		return false;
	}
	// ユーザーIDが0以下の時
	if( 0 >= $_SESSION["user_id"] )
	{
		dprint( "ユーザーIDが異常です" );
		$strCartMsg = MSG_UPDATE_CART_ITEM_NUM_ERR;
		return false;
	}
	$iUserID = $_SESSION["user_id"];

	// アイテムID -------------------
	// アイテムIDが数値じゃない時
	if( !is_numeric( $_POST["item_id"] ) )
	{
		dprint( "アイテムIDが数値じゃない" );
		$strCartMsg = MSG_UPDATE_CART_ITEM_NUM_ERR;
		return false;
	}
	// アイテムIDが0以下の時
	if( 0 >= $_POST["item_id"] )
	{
		dprint( "アイテムIDが異常です" );
		$strCartMsg = MSG_UPDATE_CART_ITEM_NUM_ERR;
		return false;
	}
	$iItemID = $_POST["item_id"];

	// カートアイテム個数 -------------------
	// カートアイテム個数が数値じゃない時
	if( !is_numeric( $_POST["item_num"] ) )
	{
		dprint( "カートアイテム個数が数値じゃない" );
		$strCartMsg = MSG_UPDATE_CART_ITEM_NUM_ERR;
		return false;
	}
	// カートアイテム個数が0以下の時
	if( 0 >= $_POST["item_num"] )
	{
		dprint( "カートアイテム個数が異常です" );
		$strCartMsg = MSG_UPDATE_CART_ITEM_NUM_ERR;
		return false;
	}
	$iItemNum = $_POST["item_num"];

	
	try
	{
		// Updateクエリ作成
		$strUpdateQuery = "UPDATE " . TABLE_NAME_CART . 
							" SET ItemNum = :itemNum" .
							", UpdateTime = now() " .
							" WHERE UserID = :userID AND ItemID = :itemID";
		
		// クエリの実行準備をする
		$stmt = $db->prepare( $strUpdateQuery );
		// 値をバインドする
		$stmt->bindValue( ":userID", $iUserID );
		$stmt->bindValue( ":itemID", $iItemID );
		$stmt->bindValue( ":itemNum", $iItemNum );

		// クエリ実行
		$stmt->execute();
		// 件数取得
		$iRow = $stmt->rowCount();

		// 件数が1件じゃない時
		if( $iRow != 1 )
		{
			dprint( $iRow . "件、カートアイテム個数の更新件数が異常です" );
			// 更新失敗？
			$strCartMsg = MSG_UPDATE_CART_ITEM_NUM_ERR;

			return false;
		}

		dprint( "カートアイテム個数を更新しました。" );
		// 更新完了
		$strCartMsg = MSG_UPDATE_CART_ITEM_NUM_SUCCESS;

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
		// カートアイテムの個数変更失敗
		$strCartMsg = MSG_UPDATE_CART_ITEM_NUM_ERR;

		return false;
	}
}

//===============================================
// カートアイテムの削除
//===============================================
function deleteCartItem( $db, &$strCartMsg )
{
	// デバッグ表示
	dprint( $_SESSION["user_id"] );
	dprint( $_POST["item_id"] );

	// 情報が不足してる時
	if( !isset( $_SESSION["user_id"] ) 
		|| !isset( $_POST["item_id"] ) 
	)
	{
		dprint( "カートアイテム削除の情報が不足しています。" );
		// エラーメッセージ
		$strCartMsg = MSG_DELETE_CART_ITEM_ERR;
		return false;
	}

	// ユーザーID -------------------
	// ユーザーIDが数値じゃない時
	if( !is_numeric( $_SESSION["user_id"] ) )
	{
		dprint( "ユーザーIDが数値じゃない" );
		$strCartMsg = MSG_DELETE_CART_ITEM_ERR;
		return false;
	}
	// ユーザーIDが0以下の時
	if( 0 >= $_SESSION["user_id"] )
	{
		dprint( "ユーザーIDが異常です" );
		$strCartMsg = MSG_DELETE_CART_ITEM_ERR;
		return false;
	}
	$iUserID = $_SESSION["user_id"];

	// アイテムID -------------------
	// アイテムIDが数値じゃない時
	if( !is_numeric( $_POST["item_id"] ) )
	{
		dprint( "アイテムIDが数値じゃない" );
		$strCartMsg = MSG_DELETE_CART_ITEM_ERR;
		return false;
	}
	// アイテムIDが0以下の時
	if( 0 >= $_POST["item_id"] )
	{
		dprint( "アイテムIDが異常です" );
		$strCartMsg = MSG_DELETE_CART_ITEM_ERR;
		return false;
	}
	$iItemID = $_POST["item_id"];

	try
	{
		// 削除クエリ作成
		$strDeletetQuery = "DELETE FROM " . TABLE_NAME_CART . " WHERE UserID = :userID AND ItemID = :itemID";
		// クエリの実行準備をする
		$stmt = $db->prepare( $strDeletetQuery );
		// 値をバインドする
		$stmt->bindValue( ":userID", $iUserID );
		$stmt->bindValue( ":itemID", $iItemID );
	
		// クエリ実行
		$stmt->execute();
		// 件数取得
		$iRow = $stmt->rowCount();

		// 件数が1件じゃない時
		if( $iRow != 1 )
		{
			dprint( $iRow . "件、カートアイテム削除の件数が異常です" );
			// 削除失敗
			$strCartMsg = MSG_DELETE_CART_ITEM_ERR;

			return false;
		}

		dprint( "削除しました" );
		// 削除完了
		$strCartMsg = MSG_DELETE_CART_ITEM_SUCCESS;
		
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
		$strCartMsg = MSG_DELETE_CART_ITEM_ERR;

		return false;
	}
}

//===============================================
// 合計金額の取得
//===============================================
function getCartTotalPrice( $db )
{
	// デバッグ表示
	dprint( $_SESSION["user_id"] );

	// 情報が不足してる時
	if( !isset( $_SESSION["user_id"] ) )
	{
		dprint( "合計金額の取得の情報が不足しています。" );
		return 0;
	}

	// ユーザーID -------------------
	// ユーザーIDが数値じゃない時
	if( !is_numeric( $_SESSION["user_id"] ) )
	{
		dprint( "ユーザーIDが数値じゃない" );
		$strCartMsg = MSG_ADD_CART_ERR;
		return false;
	}
	// ユーザーIDが0以下の時
	if( 0 >= $_SESSION["user_id"] )
	{
		dprint( "ユーザーIDが異常です" );
		$strCartMsg = MSG_ADD_CART_ERR;
		return false;
	}
	$iUserID = $_SESSION["user_id"];

	try
	{
		// SELECT文
		$strSelectQuery = "SELECT "
							. " SUM( " 
								. TABLE_NAME_CART . ".ItemNum "
								. " * ".  TABLE_NAME_ITEM . ".Price "
							. " ) AS TotalPrice "
							. " FROM " . TABLE_NAME_CART
								. " JOIN " . TABLE_NAME_ITEM . " USING( ItemID ) "
							. " WHERE UserID = :userID";

		// クエリの実行準備をする
		$stmt = $db->prepare( $strSelectQuery );
		// 値をバインドする
		$stmt->bindValue( ":userID", $iUserID );

		// クエリ実行
		$stmt->execute();
		// 件数取得
		$iRow = $stmt->rowCount();
		// 登録件数表示
		dprint( $iRow . "件、取得しました。" );

		// 0件の時
		if( 0 >= $iRow ) 
		{
			// エラー発生
			dprint( "カートが空です。" );
			return 0;
		}
		
		// 結果を取ってくる
		$result = $stmt->fetchAll();
		// 合計金額を返す
		return $result[0]["TotalPrice"];
	}
	catch( PDOException $e )
	{
		// クエリ文字列表示
		dprint( $stmt->queryString );
		// エラー発生
		dprint( "クエリエラーです。" );
		// エラーメッセージ表示
		dprint( $e->getMessage() );
	}
}


//===============================================
// カートアイテムの購入
//===============================================
function buyCartItem( $db, &$arrCartData, &$iTotalPrice, &$strCartMsg )
{
	// デバッグ表示
	dprint( $_SESSION["user_id"] );
	// デバッグ表示
	dprint( $_POST["item"] );
	// デバッグ表示
	dprint( $_POST["cart_total_price"] );

	// 情報が不足してる時
	if( !isset( $_SESSION["user_id"] ) 
		|| !isset( $_POST["item"] ) 
		|| !isset( $_POST["cart_total_price"] ) 
	)
	{
		dprint( "カートアイテム購入情報が不足しています。" );
		// エラーメッセージ
		$strCartMsg = MSG_BUY_CART_ITEM_ERR;
		return false;
	}

	// デバッグ表示
	// カートデータループ
	foreach( $_POST["item"] as $iKey => $arrRow )
	{
		dprint( "[" . $iKey . "]" ." :item_id: " . $arrRow["item_id"] );
		dprint( "[" . $iKey . "]" ." :item_num: " . $arrRow["item_num"] );
	}
	
	// ユーザーID -------------------
	// ユーザーIDが数値じゃない時
	if( !is_numeric( $_SESSION["user_id"] ) )
	{
		dprint( "ユーザーIDが数値じゃない" );
		$strCartMsg = MSG_BUY_CART_ITEM_ERR;
		return false;
	}
	// ユーザーIDが0以下の時
	if( 0 >= $_SESSION["user_id"] )
	{
		dprint( "ユーザーIDが異常です" );
		$strCartMsg = MSG_BUY_CART_ITEM_ERR;
		return false;
	}
	$iUserID = $_SESSION["user_id"];

	// カートアイテム情報 -------------------
	// カートアイテムループ
	foreach( $_POST["item"] as $iKey => $arrRow )
	{
		// アイテムID -------------------
		// アイテムIDが数値じゃない時
		if( !is_numeric( $arrRow["item_id"] ) )
		{
			dprint( $arrRow["item_id"] .":アイテムIDが数値じゃない" );
			$strCartMsg = MSG_BUY_CART_ITEM_ERR;
			return false;
		}
		// アイテムIDが0以下の時
		if( 0 >= $arrRow["item_id"] )
		{
			dprint( $arrRow["item_id"] .":アイテムIDが異常です" );
			$strCartMsg = MSG_BUY_CART_ITEM_ERR;
			return false;
		}

		// カートアイテム個数 -------------------
		// カートアイテム個数が数値じゃない時
		if( !is_numeric( $arrRow["item_num"] ) )
		{
			dprint( $arrRow["item_num"] .":カートアイテム個数が数値じゃない" );
			$strCartMsg = MSG_BUY_CART_ITEM_ERR;
			return false;
		}
		// カートアイテム個数が0以下の時
		if( 0 >= $arrRow["item_num"] )
		{
			dprint( $arrRow["item_num"] .":カートアイテム個数が異常です" );
			$strCartMsg = MSG_BUY_CART_ITEM_ERR;
			return false;
		}
	}

	// カート合計金額 -------------------
	// カート合計金額が数値じゃない時
	if( !is_numeric( $_POST["cart_total_price"] ) )
	{
		dprint( "カート合計金額が数値じゃない" );
		$strCartMsg = MSG_BUY_CART_ITEM_ERR;
		return false;
	}
	// カート合計金額が0以下の時
	if( 0 >= $_POST["cart_total_price"] )
	{
		dprint( "カート合計金額が異常です" );
		$strCartMsg = MSG_BUY_CART_ITEM_ERR;
		return false;
	}

	try
	{
		// トランザクション開始
		$db->beginTransaction();

		// カート画面のアイテム数がカートテーブルと一致するかチェック -----------
		// クエリ作成（行ロックかける）
		$strQuery = "SELECT COUNT( * ) AS ItemCount FROM " . TABLE_NAME_CART
					 . " WHERE UserID = :userID FOR UPDATE";
		// クエリの実行準備をする
		$stmt = $db->prepare( $strQuery );
		// 値をバインドする
		$stmt->bindValue( ":userID", $iUserID );

		// クエリ実行
		$stmt->execute();
		// 結果を取ってくる
		$result = $stmt->fetchAll();

		dprint( count( $_POST["item"] ) . "件、現在" . 
						$result[0]["ItemCount"] . "件" );

		// 件数が一致しなかったら
		if( count( $_POST["item"] ) != $result[0]["ItemCount"] )
		{
			dprint( count( $_POST["item"] ) . "件、現在" . 
					$result[0]["ItemCount"] . "件、カートアイテム数が一致しない" );
			// 購入失敗
			$strCartMsg = MSG_BUY_CART_ITEM_ERR;

			// ロールバック
			$db->rollBack();

			return false;
		}

		// カート画面のアイテム内容がカートテーブルと一致するかチェック ----------------
		// クエリ作成
		$strQuery = "SELECT COUNT( * ) AS ItemCount FROM " . TABLE_NAME_CART
					. " WHERE UserID = :userID "
					. " AND ( ItemID, ItemNum ) IN "
					. "( ";
		
		// IN句作成
		$strQueryIn = "";
		// カート画面のアイテムループ
		foreach( $_POST["item"] as $iKey => $arrRow )
		{
			if( $iKey != 0 ) $strQueryIn .= ", ";
			$strQueryIn .= "( :item_id" . $iKey . ", :item_num" . $iKey . " )";
		}
		// 閉じカッコ追加
		$strQueryIn .= " ) ";
		// IN句連結
		$strQuery .= $strQueryIn;

		// クエリ文字列表示
		dprint( $strQuery );

		// クエリの実行準備をする
		$stmt = $db->prepare( $strQuery );
		// 値をバインドする
		$stmt->bindValue( ":userID", $iUserID );
		// カート画面のアイテムループ
		foreach( $_POST["item"] as $iKey => $arrRow )
		{
			// 値をバインドする
			$stmt->bindValue( ":item_id" . $iKey, 	$arrRow["item_id"] );
			$stmt->bindValue( ":item_num" . $iKey, 	$arrRow["item_num"] );
		}

		// クエリ実行
		$stmt->execute();
		// 結果を取ってくる
		$result = $stmt->fetchAll();

		// デバッグ表示
		dprint( count( $_POST["item"] ) . "件、現在" . 
						$result[0]["ItemCount"] . "件" );

		// 件数が一致しなかったら
		if( count( $_POST["item"] ) != $result[0]["ItemCount"] )
		{
			dprint( count( $_POST["item"] ) . "件、現在" . 
					$result[0]["ItemCount"] . "件、カートアイテム内容が一致しない" );
			// 購入失敗
			$strCartMsg = MSG_BUY_CART_ITEM_ERR;

			// ロールバック
			$db->rollBack();

			return false;
		}

		// アイテムテーブルの情報を取得する ----------------
		// クエリ作成（行ロックかける）
		$strQuery = "SELECT ItemID, StockNum FROM " . TABLE_NAME_ITEM
					. " WHERE ItemID IN ( ";
		
		// IN句作成
		$strQueryIn = "";
		// カート画面のアイテムループ
		foreach( $_POST["item"] as $iKey => $arrRow )
		{
			if( $iKey != 0 ) $strQueryIn .= ", ";
			$strQueryIn .= ":item_id" . $iKey;
		}
		// 閉じカッコ追加
		$strQueryIn .= " ) FOR UPDATE";
		// IN句連結
		$strQuery .= $strQueryIn;

		// クエリ文字列表示
		dprint( $strQuery );

		// クエリの実行準備をする
		$stmt = $db->prepare( $strQuery );
		// 値をバインドする
		// カート画面のアイテムループ
		foreach( $_POST["item"] as $iKey => $arrRow )
		{
			// 値をバインドする
			$stmt->bindValue( ":item_id" . $iKey, 	$arrRow["item_id"] );
		}

		// クエリ実行
		$stmt->execute();
		// 結果を取ってくる
		$arrDbResult = $stmt->fetchAll();

		// デバッグ表示
		dprint( count( $_POST["item"] ) . "件、現在" . count( $arrDbResult ) . "件" );

		// 件数が一致しなかったら
		if( count( $_POST["item"] ) != count( $arrDbResult ) )
		{
			dprint( count( $_POST["item"] ) . "件、現在" . 
					count( $arrDbResult ) . "件、カート画面のアイテムがアイテムテーブルに存在しない" );
			// 購入失敗
			$strCartMsg = MSG_BUY_CART_ITEM_ERR;

			// ロールバック
			$db->rollBack();

			return false;
		}

		// カートデータの取得（更新前に取得しておく）
		if( false == getCartData( $db, $arrCartData, $iTotalPrice, $strCartMsg ) )
		{
			dprint( "カートDBデータの取得に失敗" );
			// 購入失敗
			$strCartMsg = MSG_BUY_CART_ITEM_ERR;

			// ロールバック
			$db->rollBack();

			return false;
		}

		// カート画面の合計金額とカートDBの合計金額が一致しなかったら
		if( $_POST["cart_total_price"] != $iTotalPrice )
		{
			dprint( "画面:" . $_POST["cart_total_price"] . "円、"
					. "DB:" . $iTotalPrice . "円、合計金額が一致しない。" );
			// 購入失敗
			$strCartMsg = MSG_BUY_CART_ITEM_ERR;

			// ロールバック
			$db->rollBack();

			return false;
		}		

		// アイテムの在庫の更新 ----------------
		// カート画面のアイテムループ
		foreach( $_POST["item"] as $iCartKey => $arrCartRow )
		{
			// DBのアイテムIDカラムを取得
			$arrDbItemID = array_column( $arrDbResult, "ItemID" );
			// DBのアイテムIDが一致するキーを取得
			$iDbItemKey = array_search( $arrCartRow["item_id"], $arrDbItemID );

			// DBのアイテム配列を取得　
			$arrDbItem = $arrDbResult[ $iDbItemKey ];

			// 残りの在庫数を計算
			$iResultStockNum = $arrDbItem["StockNum"] - $arrCartRow["item_num"];

			// DBの在庫数が-1以下の時
			if( -1 >= $iResultStockNum )
			{
				dprint( $arrDbItem["ItemID"] .":" . $arrDbItem["StockNum"]
						 . ":" . $arrCartRow["item_num"] . "在庫が不足しています。" );

				 $strCartMsg = MSG_BUY_CART_ITEM_ERR;

				 // 購入で在庫がなかったフラグON
				 $_SESSION["buy_cart_item_result_stock_empty_flg"] = true;

				 // ロールバック
				$db->rollBack();

				return false;
			}

			// アイテムテーブルを更新する
			// クエリ作成
			$strQuery = "UPDATE " . TABLE_NAME_ITEM
						. " SET StockNum = :stockNum, UpdateTime = now() "
						. " WHERE ItemID = :itemID ";

			// クエリ文字列表示
			dprint( $strQuery );

			// クエリの実行準備をする
			$stmt = $db->prepare( $strQuery );
			// 値をバインドする
			$stmt->bindValue( ":stockNum", $iResultStockNum );
			$stmt->bindValue( ":itemID", $arrDbItem["ItemID"] );

			// クエリ実行
			$stmt->execute();
			// 件数取得
			$iRow = $stmt->rowCount();

			// 件数が1件じゃない時
			if( $iRow != 1 )
			{
				dprint( $iRow . "件、アイテム在庫の更新件数が異常です。" );
				// 更新失敗
				$strCartMsg = MSG_BUY_CART_ITEM_ERR;

				// ロールバック
				$db->rollBack();

				return false;
			}
			// デバッグ表示
			dprint( $arrDbItem["ItemID"] .":" . $arrDbItem["StockNum"] ."->" . $iResultStockNum
					 . ":アイテムの在庫を更新しました。" );

		}

		// カートを空にする ---------------
		
		// 削除クエリ作成
		$strQuery = "DELETE FROM " . TABLE_NAME_CART . " WHERE UserID = :userID";
		// クエリの実行準備をする
		$stmt = $db->prepare( $strQuery );
		// 値をバインドする
		$stmt->bindValue( ":userID", $iUserID );
	
		// クエリ実行
		$stmt->execute();
		// 件数取得
		$iRow = $stmt->rowCount();

		// 件数が1件じゃない時
		if( $iRow != count( $_POST["item"] ) )
		{
			dprint( "画面:" . count( $_POST["item"] ) . "件、"
					. "削除:" . $iRow . "件、カートを空にする件数が異常です" );
			// 削除失敗
			$strCartMsg = MSG_BUY_CART_ITEM_ERR;

			return false;
		}

		dprint( "カートを空にしました。" );
		// 削除完了
		$strCartMsg = MSG_BUY_CART_ITEM_SUCCESS;
	
		// コミット
		$db->commit();

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
		// 購入失敗
		$strCartMsg = MSG_BUY_CART_ITEM_ERR;
		
		// ロールバック
		$db->rollBack();

		return false;
	}

	return true;

}