<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>WORK15</title>
</head>
<body>
	<?php
		// この課題の意図、連想配列の持ち方はこれであってる？
		// ②名前をキーにしてやってみる。（このやり方があってる気がする）
		$arrClass01 = [ "tokugawa" => 0, "oda" => 0,	"toyotomi" => 0,	"takeda" => 0	];
		$arrClass02 = [ "minamoto" => 0, "taira" => 0,	"sugawara" => 0,	"fujiwara" => 0	];

		// arrClass01の連想配列に点数を入れる
		foreach( $arrClass01 as $key => $iValue)
		{
			$arrClass01[ $key ] = rand( 1, 100 );
			echo $key.":".$arrClass01[ $key ]."<br>";
		}
		echo( "<br>" );

		// arrClass02の連想配列に点数を入れる
		foreach( $arrClass02 as $key => $iValue )
		{
			$arrClass02[ $key ] = rand( 1, 100 );
			echo $key.":".$arrClass02[ $key ]."<br>";
		}
		echo( "<br>");
		
		// oda
		$strKeyOda = "oda";
		echo $strKeyOda.":".$arrClass01[ $strKeyOda ]."<br>";
		// sugawara
		$strKeySugawara = "sugawara";
		echo $strKeySugawara.":".$arrClass02[ $strKeySugawara ]."<br>";

		$iOdaScore = $arrClass02[ $strKeyOda ];
		$iSugawaraScore = $arrClass02[ $strKeySugawara ];
		
		// 同じスコアの時
		if( $iOdaScore == $iSugawaraScore )
		{
			echo( "同点です。<br>" );
		}
		else
		// odaの方がが大きい時
		if( $iOdaScore > $iSugawaraScore )
		{
			echo( "odaの方が高いです。<br>" );
		}
		else // sugawaraの方が高いとき。
		{
			echo( "sugawaraの方が高いです。<br>" );
		}

	?>
</body>
</html>