# pukiwiki-lib-shorturl

PukiWiki用URL短縮ライブラリ

- 暫定公開版です（[PukiWiki1.5.3](https://pukiwiki.osdn.jp/?PukiWiki/Download/1.5.3)で動作確認済）
- 設置と設定に関しては自サイトの記事「[PukiWikiのクソ長いURLをURL短縮ライブラリを組み込んで解決する！](https://dajya-ranger.com/pukiwiki/embed-url-shortener/)」を参照して下さい（過去に執筆した記事なので、ライブラリの設置と基本的な設定のみ参考にして下さい）
- shorturl.phpを「lib」フォルダにFTPし、PukiWikiのドキュメントルートに「shortener」と「shortener_counter」フォルダを作成する必要があります
- Ver0.2.1からの変更点は次の通り
	- エイリアスが画像の場合の処理を追加（[[&ref(./画像ファイル名);>ページ名]] 及び [[&ref(./画像ファイル名);>>ページ名]] の記述を可能にし、エイリアスが画像の場合であっても、明示的にリンクを自窓または別窓で開く記述が出来るように修正）
	- すでに本ライブラリのVer0.2.1を導入している場合は、lib\make_link.php のみを差し替えれば最新の状態になります
- [PukiWiki1.5.2](https://pukiwiki.osdn.jp/?PukiWiki/Download/1.5.2)の場合は[Ver0.1.5](https://dajya-ranger.com/sdm_downloads/short-url-library-pkwk152/)をご利用下さい
