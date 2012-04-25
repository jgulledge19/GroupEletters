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

$confirmPageID = $modx->getOption('confirmPage', $scriptProperties, $modx->getOption('confirmPageID') );
// FormIt options:
//'emailFromName' => $modx->getOption('emailFromName', (isset($scriptProperties['emailFromName']) && !empty($scriptProperties['emailFromName']) ? $scriptProperties : NULL ), $modx->getOption('groupeletters.fromName') ),
$options = array(
        'emailTpl' => $modx->getOption('emailTpl', $scriptProperties, 'GroupElettersSignupMail' ),
        'emailSubject' => $modx->getOption('emailSubject', $scriptProperties, $modx->lexicon('groupeletters.subscribers.confirm.subject') ),
        'emailFrom' => $modx->getOption('groupeletters.fromEmail'), //$modx->getOption('emailFrom', $scriptProperties, $modx->getOption('groupeletters.fromEmail') ),
        'emailFromName' => $modx->getOption('emailFromName', $scriptProperties, $modx->getOption('groupeletters.fromName') ),
        'emailReplyTo' => $modx->getOption('emailReplyTo', $scriptProperties, $modx->getOption('groupeletters.replyEmail') ),
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