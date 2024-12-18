<!--
//============================================
//	ヘッダー view
//============================================
-->
<?php
	// ヘッダータイトル
	$strHeaderTitle = SITE_NAME;
?>

<header class="min-width">
	<!-- タイトル -->
	<div class="header-left"><?= $strHeaderTitle ?></div>
<?php
	// ログイン状態文字列
	$strLoginStatus="";

	// ログイン中の時
	if( isset( $_SESSION["user_name"] ) )
	{
		// 管理者権限の時
		if( $_SESSION["is_admin"] )
		{
			$strLoginStatus = $_SESSION["user_name"] . MSG_HEADER_LOGIN_KIND_ADMIN;
			$strManageItemLink = '<a href="manage_item.php">【' . PAGE_NAME_MANAGE_ITEM . '】</a>' . "\n";
		}
		else // 管理者権限じゃない時
		{
			$strLoginStatus = $_SESSION["user_name"] . MSG_HEADER_LOGIN_KIND_NORMAL;
		}
?>
		<div class="header-right">
			<!-- ログイン状態 -->
			<?= $strLoginStatus ?>
			<!-- ログアウトフォーム -->
			<form class="inline-block" action="index.php" method="post">
				<input type="hidden" name="logout" value="logout">
				<input type="submit" value="ログアウト">
			</form>
			<br>
			<!-- ページリンク -->
			<a href="item_list.php">【<?= PAGE_NAME_ITEM_LIST ?>】</a>
			<a href="cart.php">【<?= PAGE_NAME_CART ?>】</a>
			<?= $strManageItemLink ?>
		</div>
<?php
	}
?>
</header>

