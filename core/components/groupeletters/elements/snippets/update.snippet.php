<?php
/**
 * This snippet will just update the DB tables from to 1.0 beta3+
 */
if (!isset($modx->groupEletters)) {
    $modx->addPackage('groupeletters', $modx->getOption('core_path').'components/groupeletters/model/');
    $modx->groupEletters = $modx->getService('groupeletters', 'GroupEletters', $modx->getOption('core_path').'components/groupeletters/model/groupeletters/');
}
$groupEletters =& $modx->groupEletters;

$manager = $modx->getManager();
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);

$modx->exec("ALTER TABLE {$modx->getTableName('EletterSubscribers')} 
    ADD COLUMN `city` VARCHAR(64) NULL AFTER `address`
    ");