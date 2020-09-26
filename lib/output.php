<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * フロントスタイル
 */
add_action( 'wp_head', function() {
	$front_css  = '';
	$front_css .= \FECSS_Editor\minify_css( get_option( 'fecss_common' ) );
	$front_css .= \FECSS_Editor\minify_css( get_option( 'fecss_front' ) );

	if ( $front_css ) {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '<style id="fecss-front-style">' . $front_css . '</style>' . PHP_EOL;
	}
});


/**
 * エディタースタイル
 */
add_action( 'admin_head', function() {
	global $hook_suffix;
	$is_editor = 'post.php' === $hook_suffix || 'post-new.php' === $hook_suffix;

	if ( ! $is_editor) return;

	$editor_css  = '';
	$editor_css .= \FECSS_Editor\minify_css( get_option( 'fecss_common' ) );
	$editor_css .= \FECSS_Editor\minify_css( get_option( 'fecss_editor' ) );

	if ( $editor_css ) {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '<style id="fecss-editor-style">' . $editor_css . '</style>' . PHP_EOL;
	}
});
