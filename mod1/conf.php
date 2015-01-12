<?php
define('TYPO3_MODE', 'BE');

$confdir = (preg_match('/win/i', PHP_OS) && !preg_match('/darwin/i', PHP_OS)) ? 'ext\mwimagemap\mod1\conf.php' : 'ext/mwimagemap/mod1/conf.php';
$confdir = (strlen($confdir) == 0) ? 'ext/mwimagemap/mod1/conf.php' : $confdir;


define('TYPO3_MOD_PATH', '../typo3conf/ext/mwimagemap/mod1/');
$BACK_PATH='../../../../typo3/';
 
$MCONF['navFrameScriptParam'] = '&folderOnly=1';

$MCONF['name'] = 'file_txmwimagemapM1';

$MCONF['access'] = 'user,group';
$MCONF['script'] = 'index.php';

$MLANG['default']['tabs_images']['tab'] = 'moduleicon.gif';
$MLANG['default']['ll_ref'] = 'LLL:EXT:mwimagemap/mod1/locallang_mod.xml';

?>