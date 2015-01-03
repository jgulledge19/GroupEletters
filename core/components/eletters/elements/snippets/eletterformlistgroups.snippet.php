<?php
/**
 * Create a list of Groups for the subscribe/manage
 */

$checkBoxes = $modx->getOption('checkBoxes', $scriptProperties, 'EletterGroupCheckbox' );

if (!isset($modx->eletters)) {
    $modx->addPackage('eletters', $modx->getOption('core_path').'components/eletters/model/');
    $modx->eletters = $modx->getService('eletters', 'Eletters', $modx->getOption('core_path').'components/eletters/model/eletters/');
}
$eletters =& $modx->eletters;
 
$groups = $modx->getCollection('EletterGroups', array('allow_signup' => 'Y' ) );

$sendToGroups = array();
$output = '';
foreach($groups as $group) {
    $properties = $group->toArray();
    
    // $properties['input_name'] = 'loc_arr[]';
    $properties['is_checked'] = 0;//$eletters->isChecked((in_array($properties['id'],array()) ? 1 : 0), 1);
    // this make a check box for the group item
    $output .= $modx->getChunk($checkBoxes, $properties);
}
return $output;