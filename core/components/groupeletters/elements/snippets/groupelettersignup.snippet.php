<?php
/**
 * Signup hook for FormIt
 * This is a post hook 
 * 
 */
if (!isset($modx->groupEletters)) {
    $modx->addPackage('groupeletters', $modx->getOption('core_path').'components/groupeletters/model/');
    $modx->groupEletters = $modx->getService('groupeletter', 'GroupEletters', $modx->getOption('core_path').'components/groupeletters/model/groupeletters/');
}
$groupEletters =& $modx->groupEletters;

$confimPageID = $modx->getOption('confirmPage', $scriptProperties, $modx->getOption('confirmPageID') );
// FormIt options:
$options = array(
        'emailTpl' => $modx->getOption('emailTpl', $scriptProperties, 'GroupElettersSignupMail' ),
        'emailSubject' => $modx->getOption('emailSubject', $scriptProperties, $modx->lexicon('groupeletters.subscribers.confirm.subject') ),
        'emailFrom' => $modx->getOption('emailFrom', $scriptProperties, $modx->getOption('emailsender') ),
        'emailFromName' => $modx->getOption('emailFromName', $scriptProperties, $modx->getOption('site_name') ),
        'emailReplyTo' => $modx->getOption('emailReplyTo', $scriptProperties, $modx->getOption('emailsender') ),
    ); 

// $hook->setValue('datestamp_submitted', $datestamp);
// 

if( $groupEletters->signup($hook->getValues(), $confirmPageID, $options) ) {
    return true;
} else {
    //$scriptProperties['hook']->errors['signup'] = $groupEletters->errormsg;
    
    $hook->addError('signup', $groupEletters->errormsg );
    return false;
}