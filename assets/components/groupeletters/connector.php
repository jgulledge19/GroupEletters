<?php
/**
 * Ditsnews Connector
 *
 * @package ditsnews
 */
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

$corePath = $modx->getOption('groupeletters.core_path',null,$modx->getOption('core_path').'components/groupeletters/');
// require_once $corePath.'model/groupeletters/groupeletters.class.php';
$modx->addPackage('groupeletters', $corePath.'components/groupeletters/model/');
$modx->groupEletters = $modx->getService('groupeletters', 'GroupEletters', $modx->getOption('core_path').'components/groupeletters/model/groupeletters/');

$modx->lexicon->load('groupeletters:default');

/* handle request */
$path = $modx->getOption('processorsPath',$modx->groupEletters->config,$corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));