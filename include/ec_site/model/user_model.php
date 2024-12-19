<?php
//========================================================================
//------------------------------------------------------------------------
// ユーザー model
//------------------------------------------------------------------------
//========================================================================

//-----------------------------------------------
// 共通 model の読み込み
//-----------------------------------------------
require_once( "../../include/ec_site/model/common_model.php" );

//===============================================
// ログイン 
//===============================================
function login( $db )
{
	// ユーザー名の形式が違っていたら戻る
	if( false == preg_match( PREG_PATTERN_USER_NAME, $_POST["user_name"] ) )
	{
		return false;
	}
	
	// パスワードの形式が違っていたら戻る
	if( false == preg_match( PREG_PATTERN_PASSWORD, $_POST["password"] ) )
	{
		return false;
	}

	try
	{
		// Selectクエリ作成
		$strQuery = "SELECT * FROM " . TABLE_NAME_USER 
					. " WHERE UserName = :UserName";

		// クエリの実行準備をする
		$stmt = $db->prepare( $strQuery );
		// 値をバインドする
		$stmt->bindValue( ":UserName", $_POST["user_name"] );
	
		// クエリ実行
		$stmt->execute();
		// 件数取得
		$iRow = $stmt->rowCount();
		// 件数が1件じゃなかったら失敗
		if( $iRow != 1 )
		{
			dprint( "ログイン結果が1件じゃない" );
			return false;
		}

		// 結果を取ってくる
		$result = $stmt->fetchAll();
		
		// パスワードが一致しなかったら
		if( !password_verify( $_POST["password"], $result[0]["Password"] ) )
		{
			dprint( "パスワードが一致しない" );
			dprint( "POST:" . $_POST["password"] );
			dprint( "HASH:" . $result[0]["Password"] );
			
			return false;
		}

		dprint( "ユーザーID：" . $result[0]["UserID"] );
		// セッションに情報保存
		$_SESSION["user_id"] 	= $result[0]["UserID"];
		$_SESSION["user_name"] 	= $result[0]["UserName"];
		$_SESSION["is_admin"] 	= $result[0]["IsAdmin"];
				
		// ログイン成功
		return true;
	}
	catch( PDOException $e )
	{
		// クエリ文字列
		dprint( $strQuery );
		// エラー発生
		dprint( "クエリエラーです。");
		// エラーメッセージ表示
		dprint( $e->getMessage() );
	
		return false;
	}
}

//===============================================
// ユーザー登録
//===============================================
function registUser( $db, &$strMsg )
{
	// ユーザーIDの形式が違っていたら戻る
	if( false == preg_match( PREG_PATTERN_USER_NAME, $_POST["user_name"] ) )
	{
		$strMsg = MSG_REGIST_USER_USER_NAME_ERR;
		return false;
	}
	
	// パスワードの形式が違っていたら戻る
	if( false == preg_match( PREG_PATTERN_PASSWORD, $_POST["password"] ) )
	{
		$strMsg = MSG_REGIST_USER_PASSWORD_ERR;
		return false;
	}

	// パスワードのハッシュ化
	$strHashPassword = password_hash( $_POST["password"], PASSWORD_DEFAULT );

	// レコードの挿入
	try
	{
		// Insertクエリ作成
		$strQuery = " INSERT INTO " . TABLE_NAME_USER
					. " VALUES("
						. " 0, :UserName, :Password, " . "false,"
						. " now(), now()"
					. " )";

		// クエリの実行準備をする
		$stmt = $db->prepare( $strQuery );
		// 値をバインドする
		$stmt->bindValue( ":UserName", $_POST["user_name"] );
		$stmt->bindValue( ":Password", $strHashPassword );

		// クエリ実行
		$stmt->execute();
		// 件数取得
		$iRow = $stmt->rowCount();
		// 件数が1件じゃなかったら失敗
		if( $iRow != 1 )
		{
			dprint( "ユーザー登録が1件じゃない");
			$strMsg = MSG_REGIST_USER_ERR;
			return false;
		}
		
		// ユーザー登録完了
		$strMsg = MSG_REGIST_USER_SUCCESS;
		return true;
	}
	catch( PDOException $e )
	{
		// クエリ文字列
		dprint( $strQuery );
		// エラー発生
		dprint( "クエリエラーです。");
		// エラーメッセージ表示
		dprint( $e->getMessage() );

		// ユーザー登録失敗
		$strMsg = MSG_REGIST_USER_ERR;
		return false;
	}
}
