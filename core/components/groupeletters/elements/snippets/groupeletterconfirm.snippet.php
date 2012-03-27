<?php
/**
 * This snippet will confirm a subscriber
 */
require_once MODX_CORE_PATH.'/components/groupeletters/model/groupeletters/groupeletters.class.php';
$groupEletters = new GroupEletters($modx);

if( $groupEletters->confirmSignup() ) {
    return $modx->lexicon('groupeletters.subscribers.confirm.success');
} else {
    return $modx->lexicon('groupeletters.subscribers.confirm.err');
}