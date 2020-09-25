<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * フロント用のファイルを読み込む
 */
add_action( 'wp_enqueue_scripts', function() {

	/* フロント & エディター共通のスタイル */
	wp_enqueue_style(
		'fecss-common',
		FECSS_URL . 'css/common.css',
		[],
		FECSS_VERSION
	);

	/* フロント用のスタイル */
	wp_enqueue_style(
		'fecss-front',
		FECSS_URL . 'css/front.css',
		[],
		FECSS_VERSION
	);

}, 20 );


/**
 * エディター用のファイルを読み込む
 */
add_action( 'enqueue_block_editor_assets', function() {

	/* フロント & エディター共通のスタイル */
	wp_enqueue_style(
		'fecss-common',
		FECSS_URL . 'css/common.css',
		[],
		FECSS_VERSION
	);

	/* ブロックエディター用のスタイル */
	wp_enqueue_style(
		'fecss-editor',
		FECSS_URL . 'css/editor.css',
		[],
		FECSS_VERSION
	);

}, 20 );


/**
 * プラグイン設定画面用のファイルを読み込む
 */
add_action( 'admin_enqueue_scripts', function ( $hook_suffix ) {

	$is_fecss_page = false !== strpos( $hook_suffix, 'fecss' );

	// 設定ページにだけ読み込むファイル
	if ( $is_fecss_page ) {
		wp_enqueue_style( 'fecss-admin', FECSS_URL . 'lib/css/admin.css', [], FECSS_VERSION );

		/**
		 * code mirror
		 */
		// see: https://codemirror.net/doc/manual.html#config
		$codemirror = [
			'tabSize'           => 4,
			'indentUnit'        => 4,
			'indentWithTabs'    => true,
			'inputStyle'        => 'contenteditable',
			'lineNumbers'       => true,
			'smartIndent'       => true,
			'lineWrapping'      => true, // 横長のコードを折り返すかどうか
			'autoCloseBrackets' => true,
			'styleActiveLine'   => true,
			'continueComments'  => true,
			// 'extraKeys'         => [],

		];

		$settings = wp_enqueue_code_editor( [
			'type'       => 'text/css',
			'codemirror' => $codemirror,
		] );

		wp_localize_script( 'wp-theme-plugin-editor', 'codeEditorSettings', $settings );
		wp_enqueue_script( 'wp-theme-plugin-editor' );
		wp_add_inline_script(
			'wp-theme-plugin-editor',
			'jQuery(document).ready(function($) {
				wp.codeEditor.initialize($(".fecss-edit-area"), codeEditorSettings );
			})'
		);

		// こっちはサジェストとか動かなかった
		// wp_add_inline_script(
		// 	'wp-theme-plugin-editor',
		// 	'jQuery(document).ready(function($) {
		// 		console.log(codeEditorSettings);
		// 		var textarea = document.querySelector(".fecss-edit-area");
		// 		wp.CodeMirror.fromTextArea(textarea, codeEditorSettings.codemirror );
		// 	});'
		// );

		wp_enqueue_style( 'wp-codemirror' );

	}
} );
