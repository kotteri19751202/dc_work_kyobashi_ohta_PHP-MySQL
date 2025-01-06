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
	// ログイン種類メッセージ
	$strLoginKindMsg = "";

	// ログイン中の時
	if( isset( $_SESSION["user_name"] ) )
	{
		// 管理者権限の時
		if( $_SESSION["is_admin"] )
		{
			$strLoginKindMsg = MSG_HEADER_LOGIN_KIND_ADMIN;
			$strManageItemLink = '<a href="manage_item.php">【' . PAGE_NAME_MANAGE_ITEM . '】</a>' . "\n";
		}
		else // 管理者権限じゃない時
		{
			$strLoginKindMsg = MSG_HEADER_LOGIN_KIND_NORMAL;
		}
?>
		<!-- ヘッダー右側 -->
		<div class="header-right">
			<!-- ログイン状態 -->
			<?= $_SESSION["user_name"] . "：" . $strLoginKindMsg ?>
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

		<!-- ハンバーガーメニュー -->
		<button class="hamburger-button"></button>
		<nav class="hamburger-nav">
			<!-- ログイン状態 -->
			<?= $_SESSION["user_name"] ?><br>
			<?= $strLoginKindMsg ?>
			<!-- ログアウトフォーム -->
			<form action="index.php" method="post">
				<input type="hidden" name="logout" value="logout">
				<input type="submit" value="ログアウト">
			</form>
			<br>
			<!-- ページリンク -->
			<a href="item_list.php">【<?= PAGE_NAME_ITEM_LIST ?>】</a><br>
			<a href="cart.php">【<?= PAGE_NAME_CART ?>】</a><br>
			<?= $strManageItemLink ?>
		</nav>
<?php
	}
?>
</header>

