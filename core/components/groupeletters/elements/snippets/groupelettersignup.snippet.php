<?php
/**
 * Signup hook for FormIt
 * @TODO review this snippet
 */
require_once MODX_CORE_PATH.'/components/groupeletters/model/groupeletters/groupeletters.class.php';
$groupEletters = new GroupEletters($modx);

if( $groupEletters->signup($scriptProperties['fields'], $scriptProperties['confirmPage']) ) {
    return true;
} else {
    $scriptProperties['hook']->errors['signup'] = $groupEletters->errormsg;
    return false;
}