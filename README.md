ブロックエディター用とフロント用にそれぞれCSSファイルを追加し、管理画面からも編集できるプラグイン。

ブロックエディターをベースにしたサイト制作に是非ご利用ください。


# Overview
`/css/` の中にある３つのCSSを読み込みます。それぞれ、管理画面から編集できるようになっています。

- `editor.css` : ブロックエディターで読み込む
- `front.css` : フロントでのみ読み込む
- `common.css` : フロント & エディターで読み込む

**管理画面内でのファイル操作は、プラグイン内のファイルを直接編集します。データベースに値を保存するわけではないのでご注意ください。**


# Dwonload
プラグイン本体のダウンロードは以下のリリースページからどうぞ。

https://github.com/ddryo/Custom-CSS-for-Front-Editor/releases

最新版の `custom_css_for_fe-{version}.zip`をダウンロードしてご利用ください。



# Development

```
composer install
composer set-wpcs
```