<?php
/**
 * Unsubscribe
 * @TODO rewrite this snippet to make it manage subscribtions
 */
require_once MODX_CORE_PATH.'/components/groupeletters/model/groupeletters/groupeletters.class.php';
$groupEletters = new GroupEletters($modx);

if( $groupEletters->unsubscribe() ) {
    return $modx->lexicon('groupeletters.subscribers.unsubscribe.success');
} else {
    return $modx->lexicon('groupeletters.subscribers.unsubscribe.err');
}