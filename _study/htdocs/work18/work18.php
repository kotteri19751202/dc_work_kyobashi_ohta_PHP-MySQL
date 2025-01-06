<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORK18</title>
</head>
<body>
<style>
	table,tr,td,th{
		border: solid 1px black; border-collapse: collapse;
	}
	td,th{
		min-width: 32px;
	}
	th{
		background: silver;
	}
</style>
<?php
	define('ONE_PAGE_MAX','3'); // 1ページの表示数
	
	// 顧客データの配列
	$arrCustomersData = 
				array(
					array('name' => '佐藤', 'age' => '10'),
					array('name' => '鈴木', 'age' => '15'),
					array('name' => '高橋', 'age' => '20'),
					array('name' => '田中', 'age' => '25'),
					array('name' => '伊藤', 'age' => '30'),
					array('name' => '渡辺', 'age' => '35'),
					array('name' => '山本', 'age' => '40'),
				);
				
	// 顧客データ数
	$iCustomersDataNum = count( $arrCustomersData );
	// ページ数
	$iMaxPage = ceil( $iCustomersDataNum / ONE_PAGE_MAX );

	// ページ番号初期化
	$iPageNo = 1;
	// ページ番号があるとき
	if( isset( $_GET["page_no"] ) && $_GET["page_no"] != "" )
	{
		// ページ番号設定
		$iPageNo = htmlspecialchars( $_GET["page_no"], ENT_QUOTES, "UTF-8" );
		// ページ番号リミットチェック
		if( $iPageNo < 1 || $iPageNo > $iMaxPage ) $iPageNo = 1;
	}

	// データの表示
	// 開始データ番号計算
	$iStartDataNo = ( $iPageNo - 1 ) * ONE_PAGE_MAX;
	
	// テーブル
	echo "<table>";
	echo "<tr><th>名前</th><th>年齢</th></tr>";

	// ページ内ループ
	for( $i = 0 ; $i < ONE_PAGE_MAX ; $i++ )
	{
		// データ番号
		$iDataNo = $iStartDataNo + $i;
		// リミットチェック
		if( $iDataNo >= $iCustomersDataNum ) break;

		echo "<tr>";
		echo "<td>" . $arrCustomersData[ $iDataNo ]["name"] . "</td>";
		echo "<td>" . $arrCustomersData[ $iDataNo ]["age"] . "</td>";
		echo "</tr>";
	}

	echo "</table>";

	// ページネーション表示 ----------------------------

	// ページ内ループ
	for( $i = 1 ; $i < $iMaxPage + 1 ; $i++ )
	{
		// 現在ページの時（リンクなし）
		if( $i == $iPageNo )
		{
			echo $i . " ";
		}
		else // 現在ページじゃない時（リンクあり）
		{
			echo "<a href='./work18.php?page_no=" . $i . "'>" . $i . "</a> ";
		}
	}

?>
</body>
</html>
