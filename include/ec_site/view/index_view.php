<!--
//============================================
//	ログインページ view
//============================================
-->

<?php
// ページ名
$strPageName = PAGE_NAME_INDEX;
// ページタイトル
$strPageTitle = SITE_NAME . " | " . $strPageName;
// ページ説明
$strPageDiscription = PAGE_DISCRIPTION_INDEX;

// ヘッドの読み込み
include( "common/head_view.php" );
?>
</head>

<body>
	<!-- ヘッダーの読み込み -->
	<?php include( "common/header_view.php" ); ?>

	<!-- メインビジュアル -->
	<div class="mv-wrapper mv-orange min-width">
	</div>

	<!-- メインコンテナ -->
	<div class="main-container">
		<!-- ページ名 -->
		<h1><?= $strPageName ?></h1>
		<!-- エラーメッセージ -->
		<h4><?= $strErrMsg ?></h4>
		
		<!-- ログインフォーム -->
		<form class="account-form" method="post">
			<label for="user-name">ユーザー名</label>
			<input type="text" id="user-name" name="user_name" value="<?= $strUserName; ?>" placeholder="UserName" required><br>
			<label for="password">パスワード</label>
			<input type="text" id="password" name="password" value="<?= $strPassword; ?>" placeholder="PassWord" required><br>
			<input type="checkbox" name="cookie_confirmation" value="checked" <?= $strCookieConfirmation;?>>次回からログイン情報の入力を省略する<br>
			<br>
			<input type="submit" name="login" value="ログイン"><br>
			<br>
			<a href="regist_user.php">【新規ユーザー登録】</a>
		</form>
	</div> 

	<!-- フッターの読み込み -->
	<?php include( "common/footer_view.php" ); ?>
</body>
</html>
