<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORK39</title>
</head>
<body>
	<!---------------------------------------------------->
	<!-- css --------------------------------------------->
	<!---------------------------------------------------->
	<style>
	/* CSS変数宣言 */
	:root{
		/* フォントサイズ */
		--fs-xx-large: 	32px;
		--fs-x-large: 	24px;
		--fs-large: 	20px;
		--fs-medium: 	16px;
		--fs-small: 	14px;
		--fs-x-small: 	12px;

		/* フォント色 */
		--main-font-color:	#FFFFFF;
		--sub-font-color:	#000000;

		/* その他の色 */
		--back-ground-color-white:	white;			/* 背景色（白） */
		--back-ground-color-gray:	gray;			/* 背景色（灰色） */
	}
	/* リセット設定 */
	*{
		margin: 0;
		padding: 0;
		box-sizing: border-box;
		/*user-select: none;		/* 選択不可 */
		font-weight: bold;
	}
	/*img{
		margin-left:10px;
		max-height:100px;
		max-width: 100px;
	}*/
	/* 背景色（白） */
	.background-color-white{
		background-color:var(--back-ground-color-white);
	}
	/* 背景色（灰色） */
	.background-color-gray{
		background-color:var(--back-ground-color-gray);
	}
	/* タイトル */
	.caption{
		font-size: var(--fs-xx-large);
		text-align: left;
		color: var(--sub-font-color);
		margin-bottom: 20px;
	}

	/* フレックスボックス */
	.flex_item_box{
		display: flex;
		flex-direction: row;
		justifiy-content: flex-start;
		flex-wrap : wrap;
		margin-bottom: 30px;
	}
	/* 画像ボックス */
	.image_box{
		width: 150px;
		height: 150px;
		/*margin:0 auto;*/
		font-size: var(--fs-medium);
		/*background-color:var(--back-ground-color-gray);*/
		color:var(--sub-font-color);
		text-align: center;
		border:solid;
		border-radius: 5px;
		opacity: 1;
	}
	/* 画像 */
	.image{
		width: 60%;
		height: 60%;
		margin-bottom: 0px;
	}
	</style>
	
	<!---------------------------------------------------->
	<!-- html -------------------------------------------->
	<!---------------------------------------------------->
<?php
	// 画像一覧ページの時
	if( $ePageType == E_PAGE_TYPE_IMAGE_LIST )
	{
?>
		<p class='caption'>画像一覧</p>
<?php
	}
	else
	// 画像投稿ページの時
	if( $ePageType == E_PAGE_TYPE_IMAGE_UPLOAD )
	{
?>
		<p class='caption'>画像投稿</p>
		<a href='<?= URL_IMAGE_LIST ?>'>画像一覧ページへ</a>
		<br>
		<form method='post' enctype='multipart/form-data'>
			画像名<br>
			<input type='text' name='image_name' ><br>
			画像ファイル<br>
			<input type='file' name='image_file_name' accept='.jpg,.jpeg,.JPG,.JPEG,.png,.PNG'><br>
			<br>
			<input type='submit' name='upload_image' value='画像投稿'>
		</form>
		<br>
<?php
	}
?>
		<div class='flex_item_box'>
<?php
	// 結果が存在したら
	// 連想配列を取得
	foreach( $arrViewData as $arrRow )
	{
		// 画像一覧ページの時
		if( $ePageType == E_PAGE_TYPE_IMAGE_LIST )
		{
			// 公開フラグがOFFの時
			if( $arrRow['PublicFlg'] == 0 ) continue;
		}
		else
		// 画像投稿ページの時
		if( $ePageType == E_PAGE_TYPE_IMAGE_UPLOAD )
		{
			$strPublicMsg = "非表示にする";
			$strBackGroundColorClass = "background-color-white";
			$bPublicFlg = 0;
			
			// 公開フラグがOFFの時
			if( $arrRow['PublicFlg'] == 0 )
			{
				$strPublicMsg = "表示する";
				$strBackGroundColorClass = "background-color-gray";
				$bPublicFlg = 1;
			}
		}
?>
			<div class='image_box <?= $strBackGroundColorClass ?>'>
				<?= $arrRow['ImageName'] ?><br>
				<img class='image' src=' <?= IMAGE_DIR . $arrRow['ImageFileName'] ?>' alt='<?= $arrRow['ImageFileName'] ?>'/>
<?php		
		// 画像投稿ページの時
		if( $ePageType == E_PAGE_TYPE_IMAGE_UPLOAD )
		{
?>
				<form method='post'>
					<input type='hidden' name='image_id' value='<?= $arrRow['ImageID'] ?>'>
					<input type='hidden' name='change_public_flg' value=' <?= $bPublicFlg ?>'>
					<input type='submit' name='change_public' value='<?= $strPublicMsg ?>'>
				</form>
<?php		
		}
?>
			</div>
<?php		
	}
?>
		</div>
<?php
	// 画像一覧ページの時
	if( $ePageType == E_PAGE_TYPE_IMAGE_LIST )
	{
?>
		<a href=' <?php echo URL_IMAGE_UPLOAD ?>'>画像投稿ページへ</a>
<?php
	}
?>

</body>
</html>
