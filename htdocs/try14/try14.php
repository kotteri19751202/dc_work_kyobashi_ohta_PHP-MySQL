<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TRY14</title>
</head>
<body>
	<?php
		$iRandom = rand( 0, 4 );	// 0～4までのランダムな数値を取得
	?>
	
	<p>iRandom: <?php echo $iRandom ?></p>

	<?php switch( $iRandom ):
			case 1: ?>
				<p>変数iRandomの値は1です。</p>
		<?php
			break;
			case 2:
		?>
			<p>変数iRandomの値は2です。</p>
		<?php	
			break;
			default:
		?>
			<p>変数iRandomの値は1,2ではありません。</p>
	<?php endswitch; ?>

</body>
</html>
