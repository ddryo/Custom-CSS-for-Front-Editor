#!/bin/bash

version=$1
version=${version//-/.}

# style.css のバージョン書き換え
# sed -i '' -e "s/Version: .*/Version: ${version}/g" style.css;

# readme.txt のバージョン書き換え
# sed -i '' -e "s/Stable tag: .*/Stable tag: ${version}/g" readme.txt;

#上の階層へ
cd ../

# 不要なファイルを除いてzip化
zip -r custom_css_for_fe.zip custom-css-for-fe -x "*/.*" "*/__*" "*bin*" "*node_modules*" "*vendor*" "*package.json" "*package-lock.json" "*composer.json" "*composer.lock" "*gulpfile.js" "*webpack.config.js" "*phpcs.xml"

# zipから不要なファイルを削除#設定ファイル系削除
# zip --delete arkhe.zip  "arkhe/.*" "arkhe/README.md" "arkhe/phpcs.xml"

mv custom_css_for_fe.zip _versions/custom_css_for_fe-${1}.zip