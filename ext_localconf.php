<?php
defined('TYPO3_MODE') || die();

/***************
 * Add default RTE configuration
 */
$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['suedbahnhotel_website'] = 'EXT:suedbahnhotel_website/Configuration/RTE/Default.yaml';

/***************
 * PageTS
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:suedbahnhotel_website/Configuration/TsConfig/Page/All.tsconfig">');

/***************
 * Extending News
 */
/* $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\GeorgRinger\News\Domain\Model\News::class] = [
    'className' => \Hebotek\ḰickstartProjectWebsite\Domain\Model\News::class
]; */

/**
 * Form - Register template paths for custom email templates and layouts
 *
 * @link https://docs.typo3.org/m/typo3/reference-coreapi/master/en-us/ApiOverview/Mail/Index.html
 */
//$GLOBALS['TYPO3_CONF_VARS']['MAIL']['templateRootPaths'][100] = 'EXT:suedbahnhotel_website/Resources/Private/Templates/Email';
//$GLOBALS['TYPO3_CONF_VARS']['MAIL']['layoutRootPaths'][100] = 'EXT:suedbahnhotel_website/Resources/Private/Layouts/Email';


// Override allowed file extensions for mediafiles
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext'] = 'jpg,jpeg,png,youtube';

// Custom Content Elements
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Imaging\IconRegistry::class
 );

 $iconRegistry->registerIcon(
    'icon-thumbnail-menu', // Icon-Identifier, e.g. tx-myext-action-preview
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:suedbahnhotel_website/Resources/Public/Icons/icon-thumbnail-menu.svg']
 );

 // Register view helper namespaces
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['hb'] = [
    'HeBoTek\suedbahnhotelWebsite\ViewHelpers',
];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:news/Resources/Private/Language/locallang_db.xlf'][] = 'EXT:suedbahnhotel_website/Resources/Private/Language/locallang_db.xlf';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['de']['EXT:news/Resources/Private/Language/locallang_db.xlf'][] = 'EXT:suedbahnhotel_website/Resources/Private/Language/de.locallang_db.xlf';