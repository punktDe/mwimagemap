<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');



if (TYPO3_MODE=='BE')	{
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule('file', 'txmwimagemapM1', '','',  ['routeTarget' =>\tx_mwimagemap_module1::class, 'name' => 'file_txmwimagemapM1', 'icon' => 'EXT:' . $_EXTKEY . '/mod1/moduleicon.gif']);
    $TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_mwimagemap_pi1_wizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'pi1/class.tx_mwimagemap_pi1_wizicon.php';
    $GLOBALS['TBE_MODULES']['_configuration']['file_txmwimagemapM1']['labels'] = 'LLL:EXT:mwimagemap/locallang_db.php:tt_content.list_type_pi1';
}

require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('mwimagemap').'config_inc.php');
require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('mwimagemap').'class.tx_mwimagemap_ufunc.php');
require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('mwimagemap').'class.tx_mwimagemap.php');

// --------------------------------------------
// Flexform for directly inserting the plugin.
// --------------------------------------------
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['mwimagemap_pi1']='pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('mwimagemap_pi1', '
<T3DataStructure>
	<ROOT>
		<type>array</type>
		<el>
		<imagemap>
			<TCEforms>
			<label>LLL:EXT:mwimagemap/locallang_db.php:tt_content.tx_select_imagemap</label>
			<config>
				<type>select</type>
					<items type="array">
						'.mwimagemap_getitems().'
					</items>
				<maxitems>1</maxitems>
				<size>1</size>
				<disableNoMatchingValueElement>1</disableNoMatchingValueElement>
			</config>
			</TCEforms>
		</imagemap>
		</el>
	</ROOT>
</T3DataStructure>');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(Array('LLL:EXT:mwimagemap/locallang_db.php:tt_content.list_type_pi1', 'mwimagemap_pi1'), 'list_type');


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
