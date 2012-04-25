<?php
$group = $modx->getObject('EletterGroups', array('id' => $scriptProperties['id']));
if (empty($group)) return $modx->error->failure($modx->lexicon('groupeletters.groups.err.nf'));


$group->fromArray($scriptProperties);
//print_r($scriptProperties);
if ( $scriptProperties['active'] === 1 || $scriptProperties['active'] == $modx->lexicon('yes') ) {
    $group->set('active', 'Y');
} else {
    $group->set('active', 'N');
}
if ( $scriptProperties['allow_signup'] === 1 || $scriptProperties['allow_signup'] == $modx->lexicon('yes') ) {
    $group->set('allow_signup', 'Y');
} else {
    $group->set('allow_signup', 'N');
}
// Return values
if ($group->save()) {
    return $modx->error->success('', $group);
} else {
    return $modx->error->failure($modx->lexicon('groupeletters.groups.err.save'));
}

