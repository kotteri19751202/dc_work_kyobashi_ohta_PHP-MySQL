//===============================================
//-----------------------------------------------
//  JavaScript
//-----------------------------------------------
//===============================================

//===============================================
// 商品リストの最後の列の左寄せ処理
//===============================================
const alignItemBoxLeft = () =>
{
	let arrEmptyCells = [];
	
	// 今回は最大4列なので3つ空要素を追加する
	arrEmptyCells.push( $('<div>', { class: 'item-box item-box-empty' } ) );
	arrEmptyCells.push( $('<div>', { class: 'item-box item-box-empty' } ) );
	arrEmptyCells.push( $('<div>', { class: 'item-box item-box-empty' } ) );
	
	// 空要素配列をアイテムボックスに追加
	$( '.flex-item-box' ).append( arrEmptyCells );
}

//===============================================
// パスワード可視性の切り替え処理初期化
//===============================================
const initPasswordToggleVisibility = () =>
{
	// オブジェクト取得
	let passwordInput = document.getElementById( "password" );
	let passwordEye = document.getElementById( "password-eye" );

	// クリック時の処理
	passwordEye.addEventListener( "click", () =>
	{
		// 伏字の時
		if( passwordInput.type === "password")
		{
			// 表示する
			passwordInput.type = "text";
		}
		else // 表示されてる時
		{
			// 伏字にする
			passwordInput.type = "password";
		}

		// アイコンの変更
		passwordEye.classList.toggle( "fa-eye-slash" );
		passwordEye.classList.toggle( "fa-eye" );
	} );
}




//===============================================
// 処理実行
//===============================================

// 商品リストの最後の列の左寄せ処理
alignItemBoxLeft();

// パスワード可視性の切り替え処理初期化
initPasswordViewToggle();
