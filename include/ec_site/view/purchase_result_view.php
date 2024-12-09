<!--
//============================================
//	カートページ view
//============================================
-->

<?php
// ページ名
$strPageName = PAGE_NAME_PURCHASE_RESULT;
// ページタイトル
$strPageTitle = SITE_NAME . " | " . $strPageName;
// ページ説明
$strPageDiscription = PAGE_DISCRIPTION_PURCHASE_RESULT;

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
	<div class="main-container">
		<!-- ページ名 -->
		<h1><?= $strPageName ?></h1>
		<!-- カートメッセージ -->
		<h3><?= $strCartMsg ?></h3>

		<!-- 購入アイテム一覧 -->
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
				<div class="item-name"><?= $arrRow['ItemName'] ?> </div>
				<!-- 価格 -->
				<div class="item-price"><?= $arrRow['Price'] ?><span>円(税込)</span></div>
				<!-- 個数 -->
				<div class="item-stock-num-result"><?= $arrRow['ItemNum'] ?><span>個</span></div>
			</div>
<?php		
		}
?>
		</div>
		<!-- 合計、購入 -->
		<div class="cart-total-price-box">
			<!-- 合計金額 -->
			<div class="cart-total-price"><span>合計金額：</span><?= $iTotalPrice ?><span>円(税込)</span></div>
		</div>
	</div>
	<!-- フッターの読み込み -->
	<?php include( "common/footer_view.php" ); ?>
</body>
</html>
