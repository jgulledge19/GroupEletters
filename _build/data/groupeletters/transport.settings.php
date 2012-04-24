<?php
/** Array of system settings for Mycomponent package
 * @package mycomponent
 * @subpackage build
 */


/* This section is ONLY for new System Settings to be added to
 * The System Settings grid. If you include existing settings,
 * they will be removed on uninstall. Existing setting can be
 * set in a script resolver (see install.script.php).
 */
$settings = array();
// batch size, delay
/* The first three are new settings */
$settings['groupeletters.batchSize']= $modx->newObject('modSystemSetting');
$settings['groupeletters.batchSize']->fromArray(array (
    'key' => 'groupeletter.batchSize',
    'value' => '20',
    'xtype' => 'textfield',
    'namespace' => 'groupeletters',
    'area' => 'Batch Settings',
), '', true, true);

$settings['groupeletters.delay']= $modx->newObject('modSystemSetting');
$settings['groupeletters.delay']->fromArray(array (
    'key' => 'groupeletter.delay',
    'value' => '10',
    'xtype' => 'textfield',
    'namespace' => 'groupeletters',
    'area' => 'Batch Settings',
), '', true, true);

$settings['groupeletters.confirmPageID']= $modx->newObject('modSystemSetting');
$settings['groupeletters.confirmPageID']->fromArray(array (
    'key' => 'groupeletter.confirmPageID',
    'value' => '0',
    'xtype' => 'textfield',
    'namespace' => 'groupeletters',
    'area' => 'Subscriber Settings',
), '', true, true);

$settings['groupeletters.unsubscribePageID']= $modx->newObject('modSystemSetting');
$settings['groupeletters.unsubscribePageID']->fromArray(array (
    'key' => 'groupeletter.unsubscribePageID',
    'value' => '0',
    'xtype' => 'textfield',
    'namespace' => 'groupeletters',
    'area' => 'Subscriber Settings',
), '', true, true);
// Email
$settings['groupeletters.replyEmail']= $modx->newObject('modSystemSetting');
$settings['groupeletters.replyEmail']->fromArray(array (
    'key' => 'groupeletter.replyEmail',
    'value' => '0',
    'xtype' => 'textfield',
    'namespace' => 'groupeletters',
    'area' => 'Email',
), '', true, true);
$settings['groupeletters.fromEmail']= $modx->newObject('modSystemSetting');
$settings['groupeletters.fromEmail']->fromArray(array (
    'key' => 'groupeletter.fromEmail',
    'value' => '0',
    'xtype' => 'textfield',
    'namespace' => 'groupeletters',
    'area' => 'Email',
), '', true, true);

$settings['groupeletters.fromName']= $modx->newObject('modSystemSetting');
$settings['groupeletters.fromName']->fromArray(array (
    'key' => 'groupeletter.fromName',
    'value' => '0',
    'xtype' => 'textfield',
    'namespace' => 'groupeletters',
    'area' => 'Email',
), '', true, true);


return $settings;