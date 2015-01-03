<?php
/**
 * Signup hook for FormIt
 * This is a post hook 
 * 
 */
if (!isset($modx->eletters)) {
    $modx->addPackage('eletters', $modx->getOption('core_path').'components/eletters/model/');
    $modx->eletters = $modx->getService('eletter', 'Eletters', $modx->getOption('core_path').'components/eletters/model/eletters/');
}
$eletters =& $modx->eletters;

$confirmPageID = $modx->getOption('confirmPage', $scriptProperties, $modx->getOption('confirmPageID') );
// FormIt options:
//'emailFromName' => $modx->getOption('emailFromName', (isset($scriptProperties['emailFromName']) && !empty($scriptProperties['emailFromName']) ? $scriptProperties : NULL ), $modx->getOption('eletters.fromName') ),
$options = array(
        'emailTpl' => $modx->getOption('emailTpl', $scriptProperties, 'eletterSignupMail' ),
        'emailSubject' => $modx->getOption('emailSubject', $scriptProperties, $modx->lexicon('eletters.subscribers.confirm.subject') ),
        'emailFrom' => $modx->getOption('eletters.fromEmail'), //$modx->getOption('emailFrom', $scriptProperties, $modx->getOption('eletters.fromEmail') ),
        'emailFromName' => $modx->getOption('emailFromName', $scriptProperties, $modx->getOption('eletters.fromName') ),
        'emailReplyTo' => $modx->getOption('emailReplyTo', $scriptProperties, $modx->getOption('eletters.replyEmail') ),
    ); 
// $hook->setValue('datestamp_submitted', $datestamp);
// 

if( $eletters->signup($hook->getValues(), $confirmPageID, $options) ) {
    return true;
} else {
    //$scriptProperties['hook']->errors['signup'] = $eletters->errormsg;
    
    $hook->addError('signup', $eletters->errormsg );
    return false;
}