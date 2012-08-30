<?php
/**
 * This snippet will process and send out the eletters
 */
if (!isset($modx->groupEletters)) {
    $modx->addPackage('groupeletters', $modx->getOption('core_path').'components/groupeletters/model/');
    $modx->groupEletters = $modx->getService('groupeletter', 'GroupEletters', $modx->getOption('core_path').'components/groupeletters/model/groupeletters/');
}
$groupEletters =& $modx->groupEletters;

if( $groupEletters->processQueue() ) {
    return $modx->lexicon('groupeletters.queue.ran');
} else {
    return $modx->lexicon('groupeletters.queue.ran.err');
}