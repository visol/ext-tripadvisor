<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY));
$pluginName = strtolower('pi1');
$pluginSignature = $extensionName.'_'.$pluginName;

// Register an Extbase plugin into backend's list of plugins
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Sinso.' . $_EXTKEY,
	$pluginName,
	'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang_db.xlf:plugin.extension_name',
	NULL // icon
);
// Remove default plugin configs
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages,recursive';
// FlexForm configuration
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
	$pluginSignature,
	'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/FlexForm.xml'
);