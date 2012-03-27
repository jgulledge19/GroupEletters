<?php
/**
 * Create a list of Groups for the eletterToGroups TV (template variable)
 */
if (!isset($modx->groupEletters)) {
    $modx->addPackage('groupeletters', $modx->getOption('core_path').'components/groupeletters/model/');
    $modx->groupEletters = $modx->getService('groupeletters', 'GroupEletters', $modx->getOption('core_path').'components/groupeletters/model/groupeletters/');
}
$groupEletters =& $modx->groupEletters;
 
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