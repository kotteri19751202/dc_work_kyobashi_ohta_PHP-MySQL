//===============================================
//-----------------------------------------------
//  ハンバーガーメニュー（JavaScript）
//-----------------------------------------------
//===============================================

// HTMLの読み込み完了後に実行する
$(function()
{
	// オプション設定
	const options =
	{
		slide: 'right', 	/* スライド方向（none, top, bottom, left, right） */
		duration: 300, 		/* 表示アニメーション速度（ms） */
		weight: 'regular', 	/* アイコン太さ（regular, light, solid） */
		dark: true, 		/* 画面の暗転（true, false） */
	};

	// ハンバーガーアイコン設定
	const icons =
	{
		barsRegular: '<svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="bars" class="svg-inline--fa fa-bars fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M436 124H12c-6.627 0-12-5.373-12-12V80c0-6.627 5.373-12 12-12h424c6.627 0 12 5.373 12 12v32c0 6.627-5.373 12-12 12zm0 160H12c-6.627 0-12-5.373-12-12v-32c0-6.627 5.373-12 12-12h424c6.627 0 12 5.373 12 12v32c0 6.627-5.373 12-12 12zm0 160H12c-6.627 0-12-5.373-12-12v-32c0-6.627 5.373-12 12-12h424c6.627 0 12 5.373 12 12v32c0 6.627-5.373 12-12 12z"></path></svg>',
		barsLight: '<svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="bars" class="svg-inline--fa fa-bars fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M442 114H6a6 6 0 0 1-6-6V84a6 6 0 0 1 6-6h436a6 6 0 0 1 6 6v24a6 6 0 0 1-6 6zm0 160H6a6 6 0 0 1-6-6v-24a6 6 0 0 1 6-6h436a6 6 0 0 1 6 6v24a6 6 0 0 1-6 6zm0 160H6a6 6 0 0 1-6-6v-24a6 6 0 0 1 6-6h436a6 6 0 0 1 6 6v24a6 6 0 0 1-6 6z"></path></svg>',
		barsSolid: '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars" class="svg-inline--fa fa-bars fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"></path></svg>',
		timesRegular: '<svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="times" class="svg-inline--fa fa-times fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M207.6 256l107.72-107.72c6.23-6.23 6.23-16.34 0-22.58l-25.03-25.03c-6.23-6.23-16.34-6.23-22.58 0L160 208.4 52.28 100.68c-6.23-6.23-16.34-6.23-22.58 0L4.68 125.7c-6.23 6.23-6.23 16.34 0 22.58L112.4 256 4.68 363.72c-6.23 6.23-6.23 16.34 0 22.58l25.03 25.03c6.23 6.23 16.34 6.23 22.58 0L160 303.6l107.72 107.72c6.23 6.23 16.34 6.23 22.58 0l25.03-25.03c6.23-6.23 6.23-16.34 0-22.58L207.6 256z"></path></svg>',
		timesLight: '<svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="times" class="svg-inline--fa fa-times fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M193.94 256L296.5 153.44l21.15-21.15c3.12-3.12 3.12-8.19 0-11.31l-22.63-22.63c-3.12-3.12-8.19-3.12-11.31 0L160 222.06 36.29 98.34c-3.12-3.12-8.19-3.12-11.31 0L2.34 120.97c-3.12 3.12-3.12 8.19 0 11.31L126.06 256 2.34 379.71c-3.12 3.12-3.12 8.19 0 11.31l22.63 22.63c3.12 3.12 8.19 3.12 11.31 0L160 289.94 262.56 392.5l21.15 21.15c3.12 3.12 8.19 3.12 11.31 0l22.63-22.63c3.12-3.12 3.12-8.19 0-11.31L193.94 256z"></path></svg>',
		timesSolid: '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" class="svg-inline--fa fa-times fa-w-11" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg>',
	};

	const weight = options.weight[0].toUpperCase() + options.weight.substring(1);
	const barsIcon = icons['bars' + weight];
	const timesIcon = icons['times' + options.weight[0].toUpperCase() + options.weight.substring(1)];

	
	// セレクタ
	const $button = $('.hamburger-button');
	const $nav = $('.hamburger-nav');
	const $overlay = $('#hamburger-overlay');


	// overlayの設定（z-index対策）
	$nav.parent().append('<div id="hamburger-overlay"></div>');
	// overlayの移行感覚設定
	$overlay.css('transition-duration', (options.duration / 1000) + 's');
	// 暗転設定の時
	if( !options.dark )
	{
		// 透過する
		$overlay.css('background-color', 'transparent');
	}
	
	// navメニューのサイズ取得
	let navHeight = $nav.outerHeight();
	let navWidth = $nav.outerWidth();
	
	// オープン状態
	let isOpen = false;

	// navメニューの遷移間隔設定
	$nav.css('transition-duration', (options.duration / 1000) + 's');
	
	// navメニューのクローズ
	closeNavMenu();

	//============================================
	// navメニューのクローズ
	//============================================
	function closeNavMenu()
	{
		// スライド無しの時
		if (options.slide === 'none')
		{
			$nav.css('opacity', 0);
		}
		else // スライドありの時
		{
			// 上下の時
			if (options.slide === 'top' || options.slide === 'bottom')
			{
				$nav.css('left', 0);
				$nav.css(options.slide, - navHeight);
			}
			else // 左右の時
			{
				$nav.css('top', 0);
				$nav.css(options.slide, - navWidth);
			}
		}
		$button.html(barsIcon);
		$button.removeClass('close');
		$overlay.css('opacity', 0);
		
		// クロース状態にする			
		isOpen = false;
	}

	//============================================
	// オープン状態変更
	//============================================
	function changeOpenState()
	{
		// オープン状態の時
		if( isOpen )
		{
			// navメニューのクローズ
			closeNavMenu();
		}
		else // クローズ状態の時
		{
			// 可視化する
			$nav.css( 'visibility', 'visible' );

			// スライド無しの時
			if( options.slide === 'none' )
			{
				$nav.css('opacity', 1);
				$nav.css('top', 0);
			}
			else // スライドありの時
			{
				$nav.css(options.slide, 0);
			}
	
			$button.html(timesIcon);
			$button.addClass('close');
			$overlay.css('opacity', 1);
			
			// オープン状態にする
			isOpen = true;
		}
	}

	//============================================
	// クリックイベント
	//============================================
	$button.on('click', function()
	{
		// オープン状態変更
		changeOpenState();
	} );

	//============================================
	// リサイズイベント
	//============================================
	$(window).on('resize', function()
	{
		$nav.css('display', 'none'); // visibilityのhiddenでは、なぜか移動中は隠せないので一時的に消す
		$nav.css('visibility', 'hidden'); 
		navHeight = $nav.outerHeight(); /* responsive対応 */
		navWidth = $nav.outerWidth(); /* responsive対応 */
		
		// navメニューのクローズ
		closeNavMenu();
		
		$nav.css('display', 'block'); // 移動完了直ぐ復活させる
	} );

} );


