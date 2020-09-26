
(function($) {

	// 変化前のコードを保持する変数
	let oldCode = null;

	// beforeunloadに登録する処理
	function beforeunloadFunc(e) {
		const newCode = $('.CodeMirror-code').text();
		if(newCode !== oldCode){
			e.returnValue = '';
		} else {
			return false;
		}
	}

	window.addEventListener('load', function () {

		oldCode = $('.CodeMirror-code').text();

		window.addEventListener('beforeunload', beforeunloadFunc);

		// 保存ボタン時は beforeunload 解除
		$("#save").click(function() {
			window.removeEventListener('beforeunload', beforeunloadFunc);
		});
	});

})(window.jQuery);
