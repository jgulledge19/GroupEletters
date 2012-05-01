<?php
/**
 * Create a list of Groups for the subscribe/manage
 */

$checkBoxes = $modx->getOption('checkBoxes', $scriptProperties, 'GroupEletterGroupCheckbox' );

if (!isset($modx->groupEletters)) {
    $modx->addPackage('groupeletters', $modx->getOption('core_path').'components/groupeletters/model/');
    $modx->groupEletters = $modx->getService('groupeletters', 'GroupEletters', $modx->getOption('core_path').'components/groupeletters/model/groupeletters/');
}
$groupEletters =& $modx->groupEletters;
 
$groups = $modx->getCollection('EletterGroups', array('allow_signup' => 'Y' ) );

$sendToGroups = array();
$output = '';
foreach($groups as $group) {
    $properties = $group->toArray();
    
    // $properties['input_name'] = 'loc_arr[]';
    $properties['is_checked'] = 0;//$groupEletters->isChecked((in_array($properties['id'],array()) ? 1 : 0), 1);
    // this make a check box for the group item
    $output .= $modx->getChunk($checkBoxes, $properties);
}
return $output;