<?php

defined('TYPO3_MODE') or die();

$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['organizer_simple']['config']['type'] = 'passthrough';
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['location_simple']['config']['type'] = 'passthrough';
