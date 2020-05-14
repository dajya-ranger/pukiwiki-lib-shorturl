<?php

/**
 * shorturl.php
 *
 * URL短縮ライブラリ shorturl.php
 *
 * @author		オヤジ戦隊ダジャレンジャー <red@dajya-ranger.com>
 * @copyright	Copyright © 2019-2020, dajya-ranger.com
 * @link		https://dajya-ranger.com/pukiwiki/embed-url-shortener/
 * @example		@linkの内容を参照
 * @license		Apache License 2.0
 * @version		0.2.0
 * @since 		0.2.0 2020/05/14 PukiWiki1.5.3正式対応
 * @since 		0.1.3 2019/07/13 get_short_url_from_pagenameの引数にデフォルト値を追加し、長いページ名から短いページ名のみの取得に対応
 * @since 		0.1.2 2019/07/02 get_short_url_from_pagenameでページ名が有効かデフォルトページかを先に評価する（戻り値に'?'を追加する仕様に戻した）
 * @since 		0.1.1 2019/06/20 get_short_url_from_pagenameの戻り値から'?'を削除
 * @since 		0.1.0 2019/06/02 暫定初公開
 *
 */

// url name map directory
define('SHORT_URL_DIR', 'shortener');

// url name counter map directory
define('SHORT_URL_COUNTER_DIR', 'shortener_counter');

// url string length
define('SHORT_URL_PAGEID_LENGTH', 10);

// page name minimum length   
define('SHORT_URL_PAGENAME_MININUM_LENGTH', 12);

function get_pagename_from_short_url($url) {
	$filename = SHORT_URL_DIR . '/' . $url . '.txt';

	if (file_exists($filename)) {
		// 短縮URLファイルが存在する場合はページ名を取得する
		$fp = fopen($filename, 'r');
		$pagename = trim(fgets($fp));
		fclose($fp);

		// 短縮URLファイルのカウンタをインクリメント
		$cfilename = SHORT_URL_COUNTER_DIR . '/' . $url . '.count';
		$fpc = fopen($cfilename, file_exists($cfilename) ? 'r+' : 'w+') or die_message('Cannot open: ' . $cfilename);
		set_file_buffer($fpc, 0);
		flock($fpc, LOCK_EX);
		$shorter_count = trim(fgets($fpc));
		$shorter_count = intval($shorter_count) + 1;
		rewind($fpc);
		fputs($fpc, $shorter_count);
		flock($fpc, LOCK_UN);
		fclose($fpc);
	
		if (!defined('PKWK_UTF8_ENABLE')) {
			$pagename = mb_convert_encoding(mb_convert_encoding($pagename, 'SJIS-win', 'UTF-8'), 'EUC-JP', 'SJIS-win');
		}
		return $pagename;
	}
	return $url;
}

function get_short_url_from_pagename($page, $url=TRUE) {
	global $defaultpage;

	// 2019/07/13 長いページ名から短いページ名のみの取得に対応
	$symbol = $url ? '?' : '';

	// 2019/07/02 ページ名が有効かデフォルトページかを先に評価する
	if ($page == '' || $page == $defaultpage) {
		return '';
	} else {
		if (SHORT_URL_PAGENAME_MININUM_LENGTH < strlen(rawurlencode($page))) {
			$utf8page = $page; 
			if (!defined('PKWK_UTF8_ENABLE')) {
				$utf8page = mb_convert_encoding(mb_convert_encoding($page, 'SJIS-win', 'EUC-JP'), 'UTF-8', 'SJIS-win');
			}
			$encoded = encode($utf8page);
			$md5 = md5($encoded);
			$shortid = substr($md5, 0, SHORT_URL_PAGEID_LENGTH);
			$shorturl = $symbol . $shortid;
			$filename = SHORT_URL_DIR . '/' . $shortid . '.txt';
			if (!file_exists($filename)) {
				$fp = fopen($filename, 'w') or die('fopen() failed: ' . $filename);
				set_file_buffer($fp, 0);
				flock($fp, LOCK_EX);
				rewind($fp);
				fputs($fp, $utf8page);
				flock($fp, LOCK_UN);
				fclose($fp);
			}
			return $shorturl;
		} else {
			return $symbol . $page;
		}
	}
}

?>
