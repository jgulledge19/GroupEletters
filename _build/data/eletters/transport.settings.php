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
$settings['eletters.batchSize']= $modx->newObject('modSystemSetting');
$settings['eletters.batchSize']->fromArray(array (
    'key' => 'eletters.batchSize',
    'value' => '20',
    'xtype' => 'textfield',
    'namespace' => 'eletters',
    'area' => 'Batch Settings',
), '', true, true);

$settings['eletters.delay']= $modx->newObject('modSystemSetting');
$settings['eletters.delay']->fromArray(array (
    'key' => 'eletters.delay',
    'value' => '10',
    'xtype' => 'textfield',
    'namespace' => 'eletters',
    'area' => 'Batch Settings',
), '', true, true);

$settings['eletters.confirmPageID']= $modx->newObject('modSystemSetting');
$settings['eletters.confirmPageID']->fromArray(array (
    'key' => 'eletters.confirmPageID',
    'value' => '0',
    'xtype' => 'textfield',
    'namespace' => 'eletters',
    'area' => 'Subscriber Settings',
), '', true, true);

$settings['eletters.manageSubscriptionsPageID']= $modx->newObject('modSystemSetting');
$settings['eletters.manageSubscriptionsPageID']->fromArray(array (
    'key' => 'eletters.manageSubscriptionsPageID',
    'value' => '0',
    'xtype' => 'textfield',
    'namespace' => 'eletters',
    'area' => 'Subscriber Settings',
), '', true, true);

$settings['eletters.unsubscribePageID']= $modx->newObject('modSystemSetting');
$settings['eletters.unsubscribePageID']->fromArray(array (
    'key' => 'eletters.unsubscribePageID',
    'value' => '0',
    'xtype' => 'textfield',
    'namespace' => 'eletters',
    'area' => 'Subscriber Settings',
), '', true, true);
// Email
$settings['eletters.replyEmail']= $modx->newObject('modSystemSetting');
$settings['eletters.replyEmail']->fromArray(array (
    'key' => 'eletters.replyEmail',
    'value' => '0',
    'xtype' => 'textfield',
    'namespace' => 'eletters',
    'area' => 'Email',
), '', true, true);
$settings['eletters.fromEmail']= $modx->newObject('modSystemSetting');
$settings['eletters.fromEmail']->fromArray(array (
    'key' => 'eletters.fromEmail',
    'value' => '0',
    'xtype' => 'textfield',
    'namespace' => 'eletters',
    'area' => 'Email',
), '', true, true);

$settings['eletters.fromName']= $modx->newObject('modSystemSetting');
$settings['eletters.fromName']->fromArray(array (
    'key' => 'eletters.fromName',
    'value' => '0',
    'xtype' => 'textfield',
    'namespace' => 'eletters',
    'area' => 'Email',
), '', true, true);

$settings['eletters.testPrefix']= $modx->newObject('modSystemSetting');
$settings['eletters.testPrefix']->fromArray(array (
    'key' => 'eletters.testPrefix',
    'value' => 'TEST - ',
    'xtype' => 'textfield',
    'namespace' => 'eletters',
    'area' => 'Email',
), '', true, true);

$settings['eletters.debug']= $modx->newObject('modSystemSetting');
$settings['eletters.debug']->fromArray(array (
    'key' => 'eletters.debug',
    'value' => '0',
    'xtype' => 'combo-boolean',
    'namespace' => 'eletters',
    'area' => 'Batch',
), '', true, true);

$settings['eletters.useUrlTracking']= $modx->newObject('modSystemSetting');
$settings['eletters.useUrlTracking']->fromArray(array (
    'key' => 'eletters.useUrlTracking',
    'value' => '0',
    'xtype' => 'combo-boolean',
    'namespace' => 'eletters',
    'area' => 'Tracking',
), '', true, true);

$settings['eletters.trackingPageID']= $modx->newObject('modSystemSetting');
$settings['eletters.trackingPageID']->fromArray(array (
    'key' => 'eletters.trackingPageID',
    'value' => '1',
    'xtype' => 'textfield',
    'namespace' => 'eletters',
    'area' => 'Tracking',
), '', true, true);
// deined page - New Setting: eletters.deniedPageID - this if you set the page to private and a user goes to the URL without unique code send them to this page.

$settings['eletters.deniedPageID']= $modx->newObject('modSystemSetting');
$settings['eletters.deniedPageID']->fromArray(array (
    'key' => 'eletters.deniedPageID',
    'value' => '0',
    'xtype' => 'textfield',
    'namespace' => 'eletters',
    'area' => 'Subscriber Settings',
), '', true, true);

return $settings;