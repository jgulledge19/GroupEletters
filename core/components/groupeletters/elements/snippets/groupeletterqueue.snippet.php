<?php
/**
 * This snippet will process and send out the eletters
 */
if (!isset($modx->groupEletters)) {
    $modx->addPackage('groupeletters', $modx->getOption('core_path').'components/groupeletters/model/');
    $modx->groupEletters = $modx->getService('groupeletter', 'GroupEletters', $modx->getOption('core_path').'components/groupeletters/model/groupeletters/');
}
$groupEletters =& $modx->groupEletters;

$groupEletters->processQueue();

if( $groupEletters->confirmSignup() ) {
    return $modx->lexicon('groupeletters.subscribers.confirm.success');
} else {
    return $modx->lexicon('groupeletters.subscribers.confirm.err');
}