<!--
//============================================
//	カートページ view
//============================================
-->

<?php
	// ページ名
	$strPageName = PAGE_NAME_CART;
	// ページタイトル
	$strPageTitle = SITE_NAME . " | " . $strPageName;
	// ページ説明
	$strPageDiscription = PAGE_DISCRIPTION_CART;

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
		<!-- カートメッセージ -->
		<h3><?= $strCartMsg ?></h3>

		<!-- カートアイテム一覧 -->
		<div class='flex-item-box'>
<?php
		// カートデータループ
		foreach( $arrCartData as $arrRow )
		{
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
				<!-- 個数 -->
				<form method='post' enctype='multipart/form-data'>
					<input type='hidden' name='item_id' value='<?= $arrRow['ItemID'] ?>'>
					<input type='number' class="item-stock-num" name='item_num' value='<?= $arrRow['ItemNum'] ?>' min="1" required>個
					<input type='submit' class="update-item-stock-num" name='update_cart_item_num' value='個数変更'><br>
				</form>
				<!-- 削除 -->
				<form method='post'>
					<input type='hidden' name='item_id' value='<?= $arrRow['ItemID'] ?>'>
					<input type='submit' class="delete-item" name='delete_cart_item' value='削除する'>
				</form>
			</div>
<?php		
		}
?>
		</div>
<?php
		// 購入ボタン状態文字列
		$strBuyCartItemStatus = "";
		// 合計金額が0の時、購入ボタン押せない
		if( $iTotalPrice == 0 ) $strBuyCartItemStatus = "disabled"; 
?>
		<!-- 合計、購入 -->
		<div class="cart-total-price-box">
			<!-- 合計金額 -->
			<div class="cart-total-price"><span>合計金額：</span><?= $iTotalPrice ?><span>円(税込)</span></div>
			<!-- 購入 -->
			<form action="purchase_result.php" method='post'>
<?php
				// 購入時の整合性チェックのため、現在のアイテム配列データを埋め込む
				// カートデータループ
				foreach( $arrCartData as $iKey => $arrRow )
				{
?>	
					<input type='hidden' name='item[<?= $iKey ?>][item_id]' value='<?= $arrRow['ItemID'] ?>'>
					<input type='hidden' name='item[<?= $iKey ?>][item_num]' value='<?= $arrRow['ItemNum'] ?>'>
<?php				
				}
?>
				<input type='hidden' name='cart_total_price' value='<?= $iTotalPrice ?>'>
				<input type='submit' class="cart-buy-item" name='buy_cart_item' value='　購入する　'<?= $strBuyCartItemStatus ?>>
			</form>
		</div>
	</div>
	<!-- フッターの読み込み -->
	<?php include( "common/footer_view.php" ); ?>
</body>
</html>
