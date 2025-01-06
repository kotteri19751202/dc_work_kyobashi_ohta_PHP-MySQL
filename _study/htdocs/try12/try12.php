<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY12</title>
</head>
<body>
	<?php
		$iScore = rand( 0, 100 );	// 0～100までのランダムな数値を取得
	?>
	<p>$iScore: <?php echo $iScore ?></p>
	<p>$iScore == 100 : <?php var_dump($iScore == 100 ); ?></p>

	<p>$iScore >= 60 : <?php var_dump($iScore >= 60 ); ?></p>

	<?php if( $iScore == 100 ): ?>
		<p>満点です。</p>
	<?php elseif( $iScore >= 60 ): ?>
		<p>合格です。</p>
	<?php else: ?>
		<p>不合格です。</p>
	<?php endif; ?>

</body>
</html>
