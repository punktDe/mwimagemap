<?php


include_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('mwimagemap').'class.tx_mwimagemap_ufunc.php');
include_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('mwimagemap').'class.tx_mwimagemap.php');

$tx_mwimagemap_extconf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mwimagemap']);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('mwimagemap', 'static/pi1/', 'MW Imagemap');

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['mwimagemap'.'_pi1']='layout,select_key,pages,recursive';

// -------------------------------------------------------------------
// Use an image map with the Content-type "image", "image with Text" 
// -------------------------------------------------------------------
if($tx_mwimagemap_extconf['disable_IMAGE'] == 0) {
	$tempColumns = Array (
		'tx_mwimagemap' => Array (
			'label' => 'LLL:EXT:mwimagemap/locallang_db.php:tt_content.tx_mwimagemap',
			'exclude' => 1,											// CR by Stefan Galinski
			'config' => Array (
				'type' => 'select',
				'size' => '1',
				'itemsProcFunc' => 'tx_mwimagemap->main',
				'wizards' => array(
					'uproc' => array(
						'type' => 'userFunc',
						'userFunc' => 'tx_mwimagemap_ufunc->user_TCAform_procWizard',
						'params' => array(
							'tempid' => '###THIS_UID###'
						),
					),
				),
			),
		),
	);

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumns, 1);

	$GLOBALS['TCA']['tt_content']['palettes'][] = array( 'showitem' => 'tx_mwimagemap', 'canNotCollapse' => 1 );
	end($GLOBALS['TCA']['tt_content']['palettes']);
	$p_key = key($GLOBALS['TCA']['tt_content']['palettes']);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--palette--;LLL:EXT:mwimagemap/locallang_db.php:tx_mwimagemap;'.$p_key, 'textpic,image');
}



