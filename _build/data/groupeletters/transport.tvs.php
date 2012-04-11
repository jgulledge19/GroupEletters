<?php
/**
* Template variable objects for the MyComponents package
* @author Your Name <you@yourdomain.com>
* 1/1/11
*
* @package mycomponents
* @subpackage build
*/

/* Common 'type' options:
 * textfield (text line)
 * textbox
 * richtext
 * textarea
 * textareamini
 * email
 * html
 * image
 * date
 * option (radio buttons)
 * listbox
 * listbox-multiple
 * number
 * checkbox
 * tag
 * hidden
 */
/**
 * eletterToGroups
 * 
 */
$templateVariables = array();
$x=0;
$templateVariables[++$x]= $modx->newObject('modTemplateVar');
$templateVariables[$x]->fromArray(array(
    'id' => $x,
    'type' => 'checkbox',
    'name' => 'eletterSendTest',
    'caption' => 'Send a test email',
    'description' => 'Select the check box to send a test email',
    'display' => 'default',
    'elements' => 'Yes==Yes',  /* input option values */
    'locked' => 0,
    'rank' => 0,
    'display_params' => '',
    'default_text' => 'No',
    'properties' => array(),
),'',true,true);

$templateVariables[++$x]= $modx->newObject('modTemplateVar');
$templateVariables[$x]->fromArray(array(
    'id' => $x,
    'type' => 'listbox',
    'name' => 'eletterMakeELetter',
    'caption' => 'Send as an e-letter',
    'description' => 'Send as an e-letter on the publish date',
    'display' => 'default',
    'elements' => 'Yes||No',  /* input option values */
    'locked' => 0,
    'rank' => 0,
    'display_params' => '',
    'default_text' => 'No',
    'source' => '1',
    'properties' => array(),
),'',true,true);

$templateVariables[++$x]= $modx->newObject('modTemplateVar');
$templateVariables[$x]->fromArray(array(
    'id' => $x,
    'type' => 'text',
    'name' => 'eletterSubject',
    'caption' => 'Email Subject',
    'description' => 'Email Subject max of 128 characters',
    'display' => 'default',
    'elements' => '',  /* input option values */
    'locked' => 0,
    'rank' => 0,
    'display_params' => '',
    'default_text' => '',
    'properties' => array(),
),'',true,true);

$templateVariables[++$x]= $modx->newObject('modTemplateVar');
$templateVariables[$x]->fromArray(array(
    'id' => $x,
    'type' => 'text',
    'name' => 'eletterFromEmail',
    'caption' => 'From Email',
    'description' => 'This is the email address the eletter is from, max of 128 characters',
    'display' => 'default',
    'elements' => '',  /* input option values */
    'locked' => 0,
    'rank' => 0,
    'display_params' => '',
    'default_text' => '',
    'properties' => array(),
),'',true,true);
$templateVariables[++$x]= $modx->newObject('modTemplateVar');
$templateVariables[$x]->fromArray(array(
    'id' => $x,
    'type' => 'text',
    'name' => 'eletterFromName',
    'caption' => 'From Name',
    'description' => 'This is the name which the eletter is from, max of 128 characters',
    'display' => 'default',
    'elements' => '',  /* input option values */
    'locked' => 0,
    'rank' => 0,
    'display_params' => '',
    'default_text' => '',
    'properties' => array(),
),'',true,true);
$templateVariables[++$x]= $modx->newObject('modTemplateVar');
$templateVariables[$x]->fromArray(array(
    'id' => $x,
    'type' => 'text',
    'name' => 'eletterReplyEmail',
    'caption' => 'Reply to Email Address',
    'description' => 'This is the email address that you would like reply\'s and bounces to go to.',
    'display' => 'default',
    'elements' => '',  /* input option values */
    'locked' => 0,
    'rank' => 0,
    'display_params' => '',
    'default_text' => '',
    'properties' => array(),
),'',true,true);
$templateVariables[++$x]= $modx->newObject('modTemplateVar');
$templateVariables[$x]->fromArray(array(
    'id' => $x,
    'type' => 'autotag',
    'name' => 'eletterTestTo',
    'caption' => 'Send test to the following emails',
    'description' => 'Comma separated list of email addresses',
    'display' => 'default',
    'elements' => '',  /* input option values */
    'locked' => 0,
    'rank' => 0,
    'display_params' => '',
    'default_text' => '',
    'source' => '1',
    'properties' => array(),
),'',true,true);

$templateVariables[++$x]= $modx->newObject('modTemplateVar');
$templateVariables[$x]->fromArray(array(
    'id' => $x,
    'type' => 'listbox-multiple',
    'name' => 'eletterToGroups',
    'caption' => 'Groups',
    'description' => 'Choose the group(s) that this eletter will go to',
    'display' => 'delim',
    'elements' => '@EVAL return $modx->runSnippet(\'listELetterGroups\', array());',  /* input option values */
    'locked' => 0,
    'rank' => 0,
    'display_params' => '',
    'default_text' => '',
    'source' => '1',
    'properties' => array(),
),'',true,true);


return $templateVariables;