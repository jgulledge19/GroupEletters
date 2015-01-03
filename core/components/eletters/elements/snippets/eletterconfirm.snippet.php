<?php
/**
 * This snippet will confirm a subscriber
 */
if (!isset($modx->eletters)) {
    $modx->addPackage('eletters', $modx->getOption('core_path').'components/eletters/model/');
    $modx->eletters = $modx->getService('eletters', 'Eletters', $modx->getOption('core_path').'components/eletters/model/eletters/');
}
$eletters =& $modx->eletters;

if( $eletters->confirmSignup() ) {
    return $modx->lexicon('eletters.subscribers.confirm.success');
} else {
    return $modx->lexicon('eletters.subscribers.confirm.err');
}