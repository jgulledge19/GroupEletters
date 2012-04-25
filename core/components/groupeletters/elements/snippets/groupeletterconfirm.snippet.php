<?php
/**
 * This snippet will confirm a subscriber
 */
if (!isset($modx->groupEletters)) {
    $modx->addPackage('groupeletters', $modx->getOption('core_path').'components/groupeletters/model/');
    $modx->groupEletters = $modx->getService('groupeletters', 'GroupEletters', $modx->getOption('core_path').'components/groupeletters/model/groupeletters/');
}
$groupEletters =& $modx->groupEletters;

if( $groupEletters->confirmSignup() ) {
    return $modx->lexicon('groupeletters.subscribers.confirm.success');
} else {
    return $modx->lexicon('groupeletters.subscribers.confirm.err');
}