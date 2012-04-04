<?php
$group = $modx->getObject('EletterGroups', array('id' => $scriptProperties['id']));
if (empty($group)) return $modx->error->failure($modx->lexicon('groupeletters.groups.err.nf'));

//set fields
$group->fromArray(
    array(
        'name' => $scriptProperties['name'],
        'public' => (int)$scriptProperties['public']
    )
);

// Return values
if ($group->save()) {
    return $modx->error->success('', $group);
} else {
    return $modx->error->failure($modx->lexicon('groupeletters.groups.err.save'));
}

