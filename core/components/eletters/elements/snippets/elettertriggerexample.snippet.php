<?php
/**
 * Eletter Trigger/Response code example snippet
 * @return (String) $html
 *
 *
 * This example will just email the MODX User on page load
 *
 */

if (!isset($modx->eletters)) {
    $modx->addPackage('eletters', $modx->getOption('core_path').'components/eletters/model/');
    $modx->eletters = $modx->getService('eletters', 'Eletters', $modx->getOption('core_path').'components/eletters/model/eletters/');
}
$eletters =& $modx->eletters;

$profile = $modx->user->getOne('Profile');
$to = $to_name = '';
if ( is_object($profile) ) {
    $to = $profile->get('email');
    $to_name = $profile->get('fullname');
} else {
    return 'Cannot find MODX user';
}

$options = array(
    'to_address' => $to,
    'to_name' => $to_name,
    'NewsletterID' => 16,
);

$placeholders = $profile->toArray();

/**
 *
 * @param (Array) $options  - name=>value ex: for auto response form_address=Fname Lname
 *              'from_address' => '',
                'from_name' => '',
                'to_address' => '',
                'to_name' => '',
                'cc_address' => '',
                'cc_name' => '',
                'bcc_address' => '',
                'bcc_name' => '',
                'reply_to_address' => '',
                'reply_to_name' => '',
                'ishtml' => TRUE,
                'NewsletterID' => '',
                'EResourceID' => '',
                'uploads' => TRUE,
                'files' => TRUE,
 * @param (Array) $placeholders - MODX placehoders -name=>value
 * @param (Boolean) $log - TRUE will save completed email to DB
 * @param (Array) $attachments - add addtional attachments
 */

$sent = $eletters->sendResponse($options, $placeholders, $log=TRUE);

$output = '';
if ( $sent ) {
    $output = 'An email was sent to '.$to_name.' at '.$to.' email address.';
} else  {
    $output = 'An email could not be sent to '.$to_name.' at '.$to.' email address.';
}

return $output;