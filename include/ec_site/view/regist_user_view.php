<!--
//============================================
//	ユーザー登録ページ view
//============================================
-->

<?php
// ページ名
$strPageName = PAGE_NAME_REGIST_USER;
// ページタイトル
$strPageTitle = SITE_NAME . " | " . $strPageName;
// ページ説明
$strPageDiscription = PAGE_DISCRIPTION_REGIST_USER;

// ヘッドの読み込み
include( "common/head_view.php" );
?>
</head>

<body>
<!-- <?php phpinfo(); ?> -->

	<!-- ヘッダーの読み込み -->
	<?php include( "common/header_view.php" ); ?>

	<!-- メインビジュアル -->
	<div class="mv-wrapper mv-orange min-width">
	</div>

	<!-- メインコンテナ -->
	<div class="main-container">
		<!-- ページ名 -->
		<h1><?= $strPageName ?></h1>
		<!-- メッセージ -->
		<h4><?= $strMsg ?></h4>

		<!-- ユーザー登録フォーム -->
		<form class="account-form" action="regist_user.php" method="post">
			<label for="user_name">ユーザー名</label>
			<input type="text" id="user_name" name="user_name" value="<?php echo $strUserName; ?>" pattern="<?= PREG_PATTERN_USER_NAME_FORM ?>" placeholder="UserName" required><br>
			<div class="account-form-description">※半角英数字とアンダースコアのみ、5文字以上</div>
			<label for="password">パスワード</label>
			<input type="text" id="password" name="password" value="<?php echo $strPassword; ?>" pattern="<?= PREG_PATTERN_PASSWORD_FORM ?>" placeholder="PassWord" required><br>
			<div class="account-form-description">※半角英数字とアンダースコアのみ、8文字以上</div>
			<br>
			<input type="submit" value="ユーザー登録"><br>
			<br>
			<a href="index.php">【ログインページ】</a>
		</form>
	</div> 

	<!-- フッターの読み込み -->
	<?php include( "common/footer_view.php" ); ?>
</body>
</html>
