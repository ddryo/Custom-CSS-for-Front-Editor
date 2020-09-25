<?php
namespace FECSS_Editor;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 管理画面にメニューを追加
 */
add_action( 'admin_menu', function () {

	// 「SWELL設定」を追加
	add_menu_page(
		__( 'CSS Editor', 'fecss-editor' ), // ページタイトルタグ
		__( 'CSS Editor', 'fecss-editor' ), // メニュータイトル
		'manage_options', // 必要な権限
		'fecss-editor', // このメニューを参照するスラッグ名
		'\FECSS_Editor\display_edit_page', // 表示内容
		'', // アイコン
		30 // 管理画面での表示位置
	);
} );


/**
 * 設定ページの内容
 */
function display_edit_page() {
	require_once FECSS_PATH . 'lib/menu/edit_page.php';
}


/**
 * 編集内容の保存処理
 */
add_action( 'admin_init', function() {

	// fecssの保存処理が必要かどうか
	if ( ! isset( $_POST['fecss_nonce_save'] ) ) return;

	// nonceチェック
	if ( ! wp_verify_nonce( $_POST['fecss_nonce_save'], 'fecss_action_save' ) ) return;

	$new_text  = '';
	$file_path = '';
	if ( isset( $_POST['front_css'] ) ) {
		$new_text  = $_POST['front_css'];
		$file_path = FECSS_PATH . 'css/front.css';
	} elseif ( isset( $_POST['editor_css'] ) ) {
		$new_text  = $_POST['editor_css'];
		$file_path = FECSS_PATH . 'css/editor.css';

	} elseif ( isset( $_POST['common_css'] ) ) {
		$new_text  = $_POST['common_css'];
		$file_path = FECSS_PATH . 'css/common.css';
	}

	if ( ! $new_text || ! $file_path ) return;

	$new_text = str_replace( "\r\n", "\n", $new_text );
	$new_text = \FECSS_Editor\Filesystem::convert_utf( $new_text );
	$new_text = stripslashes_deep( $new_text );

	$saved = \FECSS_Editor\Filesystem::save( $file_path, $new_text );

	if ( $saved ) {
		$_POST['fecss_saved'] = '1';
	} else {
		$_POST['fecss_error'] = '1';
	}

});
