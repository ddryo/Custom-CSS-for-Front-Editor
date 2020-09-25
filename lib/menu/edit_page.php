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
		<p>※ プラグイン内のファイルを直接編集します。データベースに値を保存するわけではないのでご注意ください。</p>
		<form method="post" action="">
			<?php
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				// echo '<div>' . $now_tab . '</div>';

				// タブコンテンツの読み込み
				$content_path = FECSS_PATH . 'lib/menu/page/' . $now_tab . '.php';
				if ( file_exists( $content_path ) ) {
				include_once $content_path;
				}

				// Nonce
				wp_nonce_field( 'fecss_action_save', 'fecss_nonce_save' );

				// 保存ボタン
				submit_button( '', 'primary', 'save', true );
			?>
		</form>
	</div>
</div>

<!-- <script>
	$(function(){
		$("textarea").change(function() {
			$(window).on('beforeunload', function() {
				return '投稿が完了していません。このまま移動しますか？';
			});
		});
		$("input[type=submit]").click(function() {
			$(window).off('beforeunload');
		});
	});
	</script>
</script> -->
