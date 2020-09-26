<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// メッセージ
$green_message = '';
if ( isset( $_POST['fecss_saved'] ) ) {
	echo '<div class="notice updated is-dismissible"><p>保存しました。</p></div>';
} elseif ( isset( $_POST['fecss_error'] ) ) {
	echo '<div class="notice is-dismissible"><p>保存に失敗しました。</p></div>';
}

// タブリスト
$setting_tabs = [
	'editor'  => 'ブロックエディター',
	'front'   => 'フロント',
	'common'  => '共通',
];

// 現在のタブ
$now_tab = $_GET['tab'] ?? 'editor';

?>
<div id="fecss_setting" class="fecss-setting wrap">
	<h1 class="fecss-setting__title">
		<?=esc_html__( 'CSS編集', 'fecss-editor' )  ?>
	</h1>
	<div class="fecss-setting__tabs">
		<div class="nav-tab-wrapper">
			<?php
				// タブ出力
				foreach ( $setting_tabs as $key => $val ) :

				$setting_url = admin_url( 'admin.php?page=fecss-editor' );
				$tab_url     = $setting_url . '&tab=' . $key;
				$nav_class   = ( $now_tab === $key ) ? 'nav-tab nav-tab-active' : 'nav-tab';

				echo '<a href="' . esc_url( $tab_url ) . '" class="' . esc_attr( $nav_class ) . '">' . esc_html( $val ) . '</a>';
				endforeach
			?>
		</div>
	</div>
	<div class="fecss-setting__body">
		<?php
			$message = '';
			switch ( $now_tab ) {
				case 'editor':
					$message = 'ブロックエディターにのみ読み込ませるCSS';
					break;
				case 'front':
					$message = 'フロント（サイト表示側）にのみ読み込ませるCSS';
					break;
				default:
					$message = 'フロント & エディターの両方に読み込ませるCSS';
					break;
			}
		?>
		<p><?=esc_html( $message )?></p>
		<form method="post" action="">
			<?php
				// ファイル直接変種時
				// $content = '';
				// $file    = FECSS_PATH . 'css/' . $now_tab . '.css';
				// if ( is_file( $file ) && file_exists( $file ) ) {
				// 	$content = \FECSS_Editor\Filesystem::get_contents( $file );
				// 	$content = \FECSS_Editor\convert_utf( $content );
				// }

				// DBから取得
				$content = get_option( 'fecss_' . $now_tab ) ?: '';
				$content = \FECSS_Editor\convert_utf( $content );

				// name, id
				$name = $now_tab . '_css';

				// #template にするとコードが自動で広くなる
				?>
				<div id="template">
					<?php // textarea の中はそのまま出ちゃうので無闇にインデント揃えたりしないように注意 ?>
					<textarea cols="60" rows="30" name="<?=esc_attr( $name )?>" id="<?=esc_attr( $name )?>" class="fecss-edit-area" ><?php echo esc_textarea( $content ); ?></textarea>
				</div>
			<?php
				// Nonce
				wp_nonce_field( 'fecss_action_save', 'fecss_nonce_save' );

				// 保存ボタン
				submit_button( '', 'primary', 'save', true );
			?>
		</form>
	</div>
</div>
