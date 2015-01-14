<?php

if(!TYPO3_MODE) { die('This script cannot be called directly.'); }

function mwimagemap_getitems() {
	if (TYPO3_MODE == 'BE') {
		$filemounts = array();
		$localBeUser = $GLOBALS['BE_USER'];
		$GLOBALS['BE_USER'] = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Backend\FrontendBackendUserAuthentication'); /** @var $BE_USER  \TYPO3\CMS\Backend\FrontendBackendUserAuthentication */
		$GLOBALS['BE_USER']->start();
		$GLOBALS['BE_USER']->unpack_uc('');


		if ($GLOBALS['BE_USER']->user['uid']) {
			$GLOBALS['BE_USER']->fetchGroupData();

			$resourceStorages = $GLOBALS['BE_USER']->getFileStorages();

			foreach ($resourceStorages as $resourceStorage) { /** @var $resourceStorage  \TYPO3\CMS\Core\Resource\ResourceStorage */

				$filemounts = array_merge($filemounts, $resourceStorage->getFileMounts());

			}
		}

		$i = 0;
		$opt = '';

		$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('id, name, folder', 'tx_mwimagemap_map', '1=1', $groupBy = '', $orderBy = 'name asc');
		if (is_array($rows)) {
			foreach ($rows as $row) {
				$show = FALSE;
				if ($GLOBALS['BE_USER']->user['admin'] == 1) {
					$show = TRUE;
				}
				foreach ($filemounts as $filemount) {

					$folder = $filemount['folder']; /** @var $folder \TYPO3\CMS\Core\Resource\Folder */
					$filemountDir = $folder->getPublicUrl();

					if (!empty($filemountDir) && preg_match('/^' . preg_quote($filemountDir, '/') . '/', $row['folder'])) {
						$show = TRUE;
						break;
					}
				}

				if ($show) {
					$opt .= '<numIndex index="' . $i++ . '" type="array">' . "\n";
					$opt .= '<numIndex index="0"><![CDATA[ ' . $row['name'] . ' ]]></numIndex>' . "\n";
					$opt .= '<numIndex index="1">' . $row['id'] . '</numIndex>' . "\n";
					$opt .= '</numIndex>' . "\n";
				}
			}
		}
		$GLOBALS['BE_USER'] = $localBeUser;
		return $opt;
	}
}
?>