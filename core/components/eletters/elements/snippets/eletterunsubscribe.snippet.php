<?php
/**
 * Unsubscribe
 * @TODO rewrite this snippet to make it manage subscribtions
 */
require_once MODX_CORE_PATH.'/components/eletters/model/eletters/eletters.class.php';
$eletters = new Eletters($modx);

if( $eletters->unsubscribe() ) {
    return $modx->lexicon('eletters.subscribers.unsubscribe.success');
} else {
    return $modx->lexicon('eletters.subscribers.unsubscribe.err');
}