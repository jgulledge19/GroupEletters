<?php
/**
 * load modx:
 */
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'model/modx/modx.class.php';
$modx = new modX();
$modx->initialize('web');

// Load groupEletters
if (!isset($modx->groupEletters)) {
    $modx->addPackage('eletters', $modx->getOption('core_path').'components/eletters/model/');
    $modx->groupEletters = $modx->getService('eletters', 'Eletters', $modx->getOption('core_path').'components/eletters/model/eletters/');
}
$groupEletters =& $modx->groupEletters;
// now load the tracking stuff:
$etracker = $groupEletters->loadTracker();

$etracker->logAction('image');

?>