<!--
//============================================
//	アイテム一覧ページ view
//============================================
-->

<?php
	// ページ名
	$strPageName = PAGE_NAME_ITEM_LIST;
	// ページタイトル
	$strPageTitle = SITE_NAME . " | " . $strPageName;
	// ページ説明
	$strPageDiscription = PAGE_DISCRIPTION_ITEM_LIST;

	// ヘッドの読み込み
	include( "common/head_view.php" );
?>
</head>

<body>
	<!-- ヘッダーの読み込み -->
	<?php include( "common/header_view.php" ); ?>

	<!-- メインビジュアル -->
	<div class="mv-wrapper mv-fruit min-width">
	</div>

	<!-- メインコンテナ -->
	<div class="main-container min-width">
		<!-- ページ名 -->
		<h1><?= $strPageName ?></h1>
		<!-- アイテムメッセージ -->
		<h3><?= $strItemMsg ?></h3>

		<!-- アイテム一覧 -->
		<div class='flex-item-box'>
<?php
		// アイテムデータループ
		foreach( $arrItemData as $arrRow )
		{
			// 公開フラグがOFFの時
			if( $arrRow['PublicFlg'] == 0 ) continue;
?>
			<!-- アイテムボックス -->
			<div class='item-box'>
<?php
			$srcData = "";
			// 画像データが存在したら
			if( !empty( $arrRow['ImageContentType'] ) )
			{
				$srcData = "data:" . $arrRow['ImageContentType'] . ";base64," . base64_encode( $arrRow['ImageData'] );
			}
?>
				<!-- アイテム画像 -->
				<img class='item-image' src= "<?= $srcData ?>" alt='<?= $arrRow['ItemName']?>' /><br>
				<!-- アイテム名 -->	
				<div class="item-name"><?= $arrRow['ItemName'] ?></div>
				<!-- 価格 -->
				<div class="item-price"><?= $arrRow['Price'] ?><span>円(税込)</span></div>
<?php
			// 個数が0以下の時
			if( $arrRow['StockNum'] <= 0 )
			{
?>
				<!-- 売り切れ -->
				<div class="item-sold-out">売り切れ</div>
<?php
			}
			else // 個数が残ってる時
			{
?>
				<!-- カートへの追加 -->
				<form method='post'>
					<input type='hidden' name='item_id' value='<?= $arrRow['ItemID'] ?>'>
					<input type='hidden' name='item_num' value=1>
					<input type='submit' class="item-add-cart" name='add_cart' value='カートに追加'>
				</form>
<?php
			}
?>
			</div>
<?php		
		}
?>
		</div>
	</div>
	<!-- フッターの読み込み -->
	<?php include( "common/footer_view.php" ); ?>
</body>
</html>
