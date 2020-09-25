<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$content = '';
$file    = FECSS_PATH . 'css/front.css';

if ( is_file( $file ) && file_exists( $file ) ) {
	$content = \FECSS_Editor\Filesystem::get_contents( $file );
	$content = \FECSS_Editor\Filesystem::convert_utf( $content );
}

// #template にするとコードが自動で広くなる
?>
<div id="template">
	<?php // textarea の中はそのまま出ちゃうので無闇にインデント揃えたりしないように注意 ?>
	<textarea cols="60" rows="30" name="front_css" id="front_css" class="fecss-edit-area" ><?php echo esc_textarea( $content ); ?></textarea>
</div>
