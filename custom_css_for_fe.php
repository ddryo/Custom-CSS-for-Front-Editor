<?php
/**
 * Plugin Name: Custom CSS for Front & Editor
 * Plugin URI: https://github.com/ddryo/Custom-CSS-for-Front-Editor
 * Description: ブロックエディター用とフロント用のCSSを追加し、管理画面からも編集できるようになります。
 * Version: 1.2.0
 * Author: 了
 * Author URI: https://twitter.com/ddryo_loos
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * 定数宣言
 */
define( 'FECSS_URL', plugins_url( '/', __FILE__ ) );
define( 'FECSS_PATH', plugin_dir_path( __FILE__ ) );
define( 'FECSS_VERSION', ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? gmdate( 'mdGis' ) : '1.2.0' );


/**
 * plugins_loaded
 */
add_action( 'plugins_loaded', function() {
	if ( is_admin() ) {
		// require_once FECSS_PATH . 'lib/filesystem.php';
		require_once FECSS_PATH . 'lib/menu.php';
	}
	require_once FECSS_PATH . 'lib/utility.php';
	require_once FECSS_PATH . 'lib/enqueues.php';
	require_once FECSS_PATH . 'lib/output.php';
}, 11 );


/**
 * アップデートチェック
 */
add_action('after_setup_theme', function() {
	if ( ! is_admin() ) return;

	if ( ! class_exists( '\Puc_v4_Factory' ) ) {
		require_once FECSS_PATH . 'lib/update/plugin-update-checker.php';
	}

	if ( class_exists( '\Puc_v4_Factory' ) ) {
		try {
			\Puc_v4_Factory::buildUpdateChecker(
				'https://looscdn.com/cdn/fecss/__update.json',
				__FILE__,
				'custom-css-for-fe'
			);
		} catch ( \Throwable $e ) {
			// echo 'Update Error: ' . esc_html( $e->getMessage() ) . PHP_EOL;
		}
	}
}, 20);
