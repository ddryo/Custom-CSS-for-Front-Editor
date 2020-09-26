<?php
namespace FECSS_Editor;

if ( ! defined( 'ABSPATH' ) ) exit;

function minify_css( $css ) {
	if ( empty( $css ) ) return '';

	$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css ); // コメント削除
	$css = str_replace( [ "\r\n", "\r", "\n" ], '', $css ); // 開業削除
	$css = str_replace( "\t", ' ', $css ); // タブを単一スペースに

	// 2つ以上続くスペースを１つに
	$cnt = 1;
	while ( 0 !== $cnt ) {
		$css = str_replace( '  ', ' ', $css, $cnt );
	}

	// {} の前後のスペースを削除 & 最後の ; を削除
	$css = str_replace( '{ ', '{', str_replace( ' {', '{', str_replace( '} ', '}', str_replace( ' }', '}', str_replace( '; ', ';', str_replace( ';}', '}', $css ) ) ) ) ) );

	return $css;
}


/**
 * UTF-8にコンバート
 */
function convert_utf( $text = '' ) {

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
