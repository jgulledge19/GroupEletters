<?php
/**
 * Ditsnews Connector
 *
 * @package ditsnews
 */
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

$corePath = $modx->getOption('ditsnews.core_path',null,$modx->getOption('core_path').'components/ditsnews/');
require_once $corePath.'model/ditsnews/ditsnews.class.php';
$modx->ditsnews = new Ditsnews($modx);

$modx->lexicon->load('ditsnews:default');

/* handle request */
$path = $modx->getOption('processorsPath',$modx->ditsnews->config,$corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));