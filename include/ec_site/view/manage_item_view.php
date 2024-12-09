<!--
//============================================
//	アイテム管理ページ view
//============================================
-->

<?php
// ページ名
$strPageName = PAGE_NAME_MANAGE_ITEM;
// ページタイトル
$strPageTitle = SITE_NAME . " | " . $strPageName;
// ページ説明
$strPageDiscription = PAGE_DISCRIPTION_MANAGE_ITEM;

// ヘッドの読み込み
include( "common/head_view.php" );
?>
</head>

<body>
	<!-- ヘッダーの読み込み -->
	<?php include( "common/header_view.php" ); ?>

	<!-- メインビジュアル -->
	<div class="mv-wrapper mv-apple min-width">
	</div>

	<!-- メインコンテナ -->
	<div class="main-container min-width">
		<!-- ページ名 -->
		<h1><?= $strPageName ?></h1>
		
		<h2>商品登録</h2>
		<!-- アイテム登録メッセージ -->
		<h4><?= $strRegistItemMsg ?></h4>
		<!-- アイテム登録フォーム -->
		<form class="regist-item-form" method='post' enctype='multipart/form-data'>
			<label>商品名　　：
				<input type="text" name='item_name' placeholder="りんご" required>
			</label><br>
			<label>価格　　　：
				<input type="number" name="item_price" value="0" min="0" required>
			</label><br>
			<label>個数　　　：
				<input type="number" name="item_num" value="0" min="0" required>
			</label><br>
			<label>商品画像　：
				<input type="file" name="item_image_file_name" accept=".jpg,.jpeg,.JPG,.JPEG,.png,.PNG" required>
			</label><br>
			<label>ステータス：
				<select id="item-public-flg" name="item_public_flg">
					<option value="false">非公開</option>
					<option value="true">公開</option>
				</select>
			</label><br><br>
			　　　　　　　
			<input type="submit" class="regist-item-btn" name="regist_item" value="登録する">
			
		</form>
		
		<h2>商品リスト</h2>
		<!-- アイテムメッセージ -->
		<h3><?= $strItemMsg ?></h3>

		<!-- アイテム一覧 -->
		<div class="flex-item-box">
<?php
		// アイテムデータループ
		foreach( $arrItemData as $arrRow )
		{
			// 公開フラグ
			$strItemPublicMsg = "非公開にする";
			$strBackGroundColorClass = "item-box-background-color-white";
			$strItemPublicFlg = "false";
			
			// 公開フラグがOFFの時
			if( $arrRow['PublicFlg'] == 0 )
			{
				$strItemPublicMsg = "公開する";
				$strBackGroundColorClass = "item-box-background-color-gray";
				$strItemPublicFlg = "true";
			}
?>
			<!-- アイテムボックス -->
			<div class='item-box <?= $strBackGroundColorClass ?>'>
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
				<div class="item-name"><?= $arrRow['ItemID'] . "：" . $arrRow['ItemName'] ?> </div>
				<!-- 価格 -->
				<div class="item-price"><?= $arrRow['Price'] ?><span>円(税込)</span></div>
				<!-- 個数 -->
				<form method='post' enctype='multipart/form-data'>
					<input type='hidden' name='item_id' value='<?= $arrRow['ItemID'] ?>'>
					<input type='number' class="item-stock-num" name='item_stock_num' value='<?= $arrRow['StockNum'] ?>' min="0" required>個
					<input type='submit' class="update-item-stock-num" name='update_item_stock_num' value='個数変更'><br>
				</form>
				<!-- 公開フラグ -->
				<form method='post'>
					<input type='hidden' name='item_id' value='<?= $arrRow['ItemID'] ?>'>
					<input type='hidden' name='item_public_flg' value='<?= $strItemPublicFlg ?>'>
					<input type='submit' class="change-item-public-flg" name='change_item_public_flg' value='<?= $strItemPublicMsg ?>'>
				</form>
				<!-- 削除 -->
				<form method='post'>
					<input type='hidden' name='item_id' value='<?= $arrRow['ItemID'] ?>'>
					<input type='submit' class="delete-item" name='delete_item' value='削除する'>
				</form>

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
