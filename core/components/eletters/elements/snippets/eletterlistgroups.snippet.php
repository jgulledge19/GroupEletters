<?php
/**
 * Create a list of Groups for the eletterToGroups TV (template variable)
 */
if (!isset($modx->eletters)) {
    $modx->addPackage('eletters', $modx->getOption('core_path').'components/eletters/model/');
    $modx->eletters = $modx->getService('eletters', 'Eletters', $modx->getOption('core_path').'components/eletters/model/eletters/');
}
$eletters =& $modx->eletters;
 
$groups = $modx->getCollection('EletterGroups');
$sendToGroups = array();
//if( is_array($groups) ) {
    foreach($groups as $group) {
        $id = $group->get('id');
        $sendToGroups[] = $group->get('name') . '==' . $group->get('id');
    }
//}
$out = implode("||",$sendToGroups);
return $out;