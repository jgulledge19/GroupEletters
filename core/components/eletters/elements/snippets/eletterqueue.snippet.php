<?php
/**
 * This snippet will process and send out the eletters
 */
if (!isset($modx->eletters)) {
    $modx->addPackage('eletters', $modx->getOption('core_path').'components/eletters/model/');
    $modx->eletters = $modx->getService('eletter', 'Eletters', $modx->getOption('core_path').'components/eletters/model/eletters/');
}
$eletters =& $modx->eletters;

if( $eletters->processQueue() ) {
    return $modx->lexicon('eletters.queue.ran');
} else {
    return $modx->lexicon('eletters.queue.ran.err');
}