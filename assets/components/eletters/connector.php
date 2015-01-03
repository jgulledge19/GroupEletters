<?php
/**
 * Eletters Connector
 *
 * @package eletters
 */
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

$corePath = $modx->getOption('eletters.core_path',null,$modx->getOption('core_path').'components/eletters/');
// require_once $corePath.'model/eletters/eletters.class.php';
$modx->addPackage('eletters', $corePath.'model/');
$modx->eletters = $modx->getService('eletters', 'Eletters', $modx->getOption('core_path').'components/eletters/model/eletters/');

$modx->lexicon->load('eletters:default');

/* handle request */
$path = $modx->getOption('processorsPath',$modx->eletters->getConfig(), $corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));