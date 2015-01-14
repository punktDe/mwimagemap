<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');



if (TYPO3_MODE=='BE')	{
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule('file', 'txmwimagemapM1', '', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) ."mod1/");
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_mwimagemap_pi1_wizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'pi1/class.tx_mwimagemap_pi1_wizicon.php';
}

require_once( \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('mwimagemap').'config_inc.php' );
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

?>
