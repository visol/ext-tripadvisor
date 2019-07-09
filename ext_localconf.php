<?php
defined('TYPO3_MODE') || die();

$boot = function ($_EXTKEY) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Sinso.' . $_EXTKEY,
        'pi1',
        [
            'TripAdvisor' => 'show',
        ],
        [
            'TripAdvisor' => '',
        ]
    );
};

$boot($_EXTKEY);
unset($boot);
?>