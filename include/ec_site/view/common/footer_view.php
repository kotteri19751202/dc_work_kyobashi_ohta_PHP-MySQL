<!--
//============================================
//	フッター view
//============================================
-->

<footer>
	<div class="footer-copyright min-width">Copyright © 2025 <?= $strHeaderTitle ?> All Rights Reserved.</div>
</footer>
<script>
		// 商品リストの最後の列の左寄せ用
		var $grid = $('.flex-item-box');
		var	emptyCells = [];
		//var	i;
		// boxの数だけ空要素を追加する
		//for ( i = 0; i < $grid.find('.item-box').length - 2 ; i++ )
		//{
		//	emptyCells.push($('<div>', { class: 'item-box item-box-empty' }));
		//}
		
		// 今回は4列最大なので3つ空要素を追加する
		emptyCells.push($('<div>', { class: 'item-box item-box-empty' }));
		emptyCells.push($('<div>', { class: 'item-box item-box-empty' }));
		emptyCells.push($('<div>', { class: 'item-box item-box-empty' }));
		$grid.append(emptyCells);
</script>
