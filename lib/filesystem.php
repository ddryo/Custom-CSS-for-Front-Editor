<?php
namespace FECSS_Editor;

class Filesystem {

	public static function init( $url = '' ) {

		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		// direct accsessで。
		$access_type = get_filesystem_method();

		if ( 'direct' !== $access_type ) {

			add_filter( 'filesystem_method', function( $a ) {
				return 'direct';
			});

			if ( ! defined( 'FS_CHMOD_DIR' ) ) {
				define( 'FS_CHMOD_DIR', 0777 );
			}
			if ( ! defined( 'FS_CHMOD_FILE' ) ) {
				define( 'FS_CHMOD_FILE', 0666 );
			}
		}

		// url
		if ( ! $url ) {
			// $url = wp_nonce_url( 'customize.php?return=' . rawurlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
			$url = wp_nonce_url( 'admin.php?page=fecss-editor' );
		}

		$creds = request_filesystem_credentials( $url, '', false, false, null );

		// Writable or Check
		if ( ! $creds ) {
			return false;
		}

		// WP_Filesystem_Base init
		if ( ! WP_Filesystem( $creds ) ) {
			request_filesystem_credentials( $url, '', true, false, null ); // 第三引数をtrueに
			return false;
		}

		global $wp_filesystem;
		return $wp_filesystem;
	}

	// ファイルの保存
	public static function save( $file = '', $txt = '' ) {

		// request_filesystem_credentialsを強制的に true に？
		// add_filter( 'request_filesystem_credentials', '__return_true' );

		$wp_filesystem = self::init();

		if ( ! $wp_filesystem ) return false;

		if ( ! $wp_filesystem->put_contents( $file, $txt, FS_CHMOD_FILE ) ) {
			// エラーの場合
			$result = new WP_Error( 'error saving file', __( 'Error saving file.', 'fecss-editor' ), $file );

			echo '<div style="margin:1em">' .
			'<p>' . esc_html( $result->get_error_message() ) . '</p>' .
			'<p>' . esc_html( $result->get_error_data() ) . '</p>' .
			'</div>';

			return false;
		}
		return true;
	}

	/**
	 * ファイルのコンテンツを取得
	 */
	public static function get_contents( $file = '' ) {

		// request_filesystem_credentialsを強制的に true に？
		// add_filter( 'request_filesystem_credentials', '__return_true' );

		$wp_filesystem = self::init();

		if ( ! $wp_filesystem ) return false;

		$file_content = $wp_filesystem->get_contents( $file );
		if ( ! $file_content ) {
			return false;
		}
		return $file_content;
	}

	/**
	 * UTF-8にエンコード
	 */
	public static function convert_utf( $text = '' ) {

		if ( empty( $text ) ) return '';

		// ヌル文字があれば
		if ( stripos( $text, chr( 0x00 ) ) !== false ) return '';

		// 日本語にセット
		// get_locale() === 'ja'
		// mb_language( 'Japanese' );

		// UTF-8 かどうか
		// $is_utf8  = mb_detect_encoding( $text, 'UTF-8', true );

		// UTF-8 以外ならエンコードして返す
		// $charcode = mb_detect_encoding( $text );
		$charcode = mb_detect_encoding( $text, 'ASCII, JIS, ISO-2022-JP, UTF-8, CP51932, SJIS-win', true );
		if ( 'UTF-8' !== $charcode ) {
			return mb_convert_encoding( $text, 'UTF-8', $charcode );
		}

		return $text;
	}

}
