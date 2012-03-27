<?php
/**
 * This snippet will fill the placeholders for an email
 * @TODO review this snippet
 */
if (!isset($modx->groupEletters)) {
    $modx->addPackage('groupeletters', $modx->getOption('core_path').'components/groupeletters/model/');
    $modx->groupEletters = $modx->getService('groupeletters', 'GroupEletters', $modx->getOption('core_path').'components/groupeletters/model/groupeletters/');
}
 
$dn =& $modx->groupEletters;
return $dn->setPlaceholders($scriptProperties);