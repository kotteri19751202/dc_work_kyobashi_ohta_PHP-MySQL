<!--
//============================================
//	フッター view
//============================================
-->

<footer>
	<div class="footer-copyright min-width">Copyright © 2025 <?= $strHeaderTitle ?> All Rights Reserved.</div>
</footer>
<script>
	// 商品リストの最後の列の左寄せ用の処理 --------
	var arrEmptyCells = [];
	
	// 今回は最大4列なので3つ空要素を追加する
	arrEmptyCells.push( $('<div>', { class: 'item-box item-box-empty' } ) );
	arrEmptyCells.push( $('<div>', { class: 'item-box item-box-empty' } ) );
	arrEmptyCells.push( $('<div>', { class: 'item-box item-box-empty' } ) );
	
	// 空要素配列をアイテムボックスに追加
	$( '.flex-item-box' ).append( arrEmptyCells );
</script>
