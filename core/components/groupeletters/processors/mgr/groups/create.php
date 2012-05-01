<?php


$group = $modx->newObject('EletterGroups');

$group->fromArray($scriptProperties);
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
	return $modx->error->failure('');
}