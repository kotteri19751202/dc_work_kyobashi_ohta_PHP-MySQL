<?php
	// デバッグ表示
	define( "DEBUG", false );
	//define( "DEBUG", true );
	function dprint( $strMsg )
	{
		if( DEBUG ) echo $strMsg  . "<br>\n";
		return;
	}
	// 情報表示
	function iprint( $strMsg )
	{
		echo $strMsg  . "<br>\n";
		return;
	}
	// DB関連
	define( "DSN", "mysql:host=localhost;dbname=xb513874_wa8fy;charset=utf8mb4" ); 
	define( "DB_USER_ID", "xb513874_t7dq0" ); 
	define( "DB_PASS_WORD", "7op8tds1dz" );
	define( "TABLE_NAME",	"tbl_work37_user" );

	/**
	* DB接続を行いPDOインスタンスを返す
	* 
	* @return object $pdo 
	*/
	function get_connection()
	{
		try{
			// PDOインスタンスの生成
			$pdo = new PDO( DSN, DB_USER_ID, DB_PASS_WORD );
		}
		catch( PDOException $e )
		{
			echo $e->getMessage();
			exit();
		}
	
		return $pdo;
	}
	 
	/**
	* SQL文を実行・結果を配列で取得する
	*
	* @param object $pdo
	* @param string $sql 実行されるSQL文章
	* @return array 結果セットの配列
	*/
	function get_sql_result( $pdo, $sql )
	{
		$data = [];
		if ( $result = $pdo->query( $sql ) )
		{
			if ( $result->rowCount() > 0 )
			{
				while ( $row = $result->fetch() )
				{
					$data[] = $row;
				}
			}
		}
		return $data;
	}
	 
	/**
	 * 全商品の商品名データ取得
	 * 
	 *  @param object 
	 * @return array
	*/
	function get_product_list( $pdo )
	{
		$sql = 'SELECT product_name, price FROM product';
		return get_sql_result( $pdo, $sql );
	}
	
	/**
	* htmlspecialchars（特殊文字の変換）のラッパー関数
	* @param string 
	* @return string 
	*/
	function h( $str )
	{
		return htmlspecialchars( $str, ENT_QUOTES, 'UTF-8' );
	}
	 
	/**
	* 特殊文字の変換（二次元配列対応）
	* @param array
	* @return array 
	*/
	function h_array( $array )
	{
		//二次元配列をforeachでループさせる
		foreach ( $array as $keys => $values )
		{
			foreach( $values as $key => $value )
			{
				//ここの値にh関数を使用して置き換える
				$array[ $keys ][ $key ] = h( $value );
			}
		}
		return $array;
	}