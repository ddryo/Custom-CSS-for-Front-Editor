ブロックエディター用とフロント用にそれぞれCSSファイルを追加し、管理画面からも編集できるプラグイン。

ブロックエディターをベースにしたサイト制作に是非ご利用ください。


# Overview

- ブロックエディターで読み込むCSS
- フロント（サイト表示側）でのみ読み込むCSS
- フロント & エディターの両方で読み込むCSS

をそれぞれ管理画面で編集できるようになるプラグインです。

CSSの内容はDBに保存され、`<style>`タグで吐き出されます。

# Dwonload
プラグイン本体のダウンロードは以下のリリースページからどうぞ。

https://github.com/ddryo/Custom-CSS-for-Front-Editor/releases

最新版の `custom_css_for_fe-{version}.zip`をダウンロードしてご利用ください。



# Development

```
composer install
composer set-wpcs
```