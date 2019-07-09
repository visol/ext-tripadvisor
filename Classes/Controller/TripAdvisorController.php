<?php
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with TYPO3 source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Sinso\Tripadvisor\Controller;

/**
 * TripAdvisor controller.
 *
 * @category    Controller
 * @package     TYPO3
 * @subpackage  tx_tripadvisor
 * @author      Daniel Huf <daniel.huf@swisscom.com>
 * @license     http://www.gnu.org/copyleft/gpl.html
 */
class TripAdvisorController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * Overrides $this->settings with a list of fields coming from the parent (default language)
	 * record if needed.
	 *
	 * @param array $fields
	 * @return void
	 */
	protected function inheritFlexFormSettingsIfNeeded() {
		/** @var $flexFormService \TYPO3\CMS\Extbase\Service\FlexFormService */
		$flexFormService = $this->objectManager->get(\TYPO3\CMS\Extbase\Service\FlexFormService::class);
		$contentObject = $this->configurationManager->getContentObject();

		if ($contentObject->data['sys_language_uid'] > 0) {
			$parentUid = intval($contentObject->data['l18n_parent']);
			if ($parentUid) {
				$parentData = $this->getDatabaseConnection()->exec_SELECTgetSingleRow(
					'pi_flexform',
					'tt_content',
					'uid=' . $parentUid
				);
				if ($parentData['pi_flexform']) {
					$flexFormConfiguration = $flexFormService->convertFlexFormContentToArray($parentData['pi_flexform']);
					$parentSettings = isset($flexFormConfiguration['settings']) ? $flexFormConfiguration['settings'] : [];
					foreach($parentSettings as $parentSettingKey => $parentSettingValue){
						if($this->settings[$parentSettingKey]){
							// keep the data
						}else{
							$this->settings[$parentSettingKey] = $parentSettingValue;
						}
					}
					$this->view->assign('settings', $this->settings);
				}
			}
		}
	}

	/**
	 * Show action.
	 *
	 * @return void
	 */
	public function showAction() {
		$this->contentObj = $this->configurationManager->getContentObject();
		$this->view->assign('contentUid', $this->contentObj->data['uid']);
		$this->view->assign('language', $GLOBALS['TSFE']->config['config']['language']);
		$this->inheritFlexFormSettingsIfNeeded();
	}

	/**
	 * @return \TYPO3\CMS\Core\Database\DatabaseConnection
	 */
	protected static function getDatabaseConnection() {
		return $GLOBALS['TYPO3_DB'];
	}
}

?>