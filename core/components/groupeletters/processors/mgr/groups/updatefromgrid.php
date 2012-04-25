<?php
/* parse JSON */
if (empty($scriptProperties['data'])) return $modx->error->failure('Invalid data.');
$_DATA = $modx->fromJSON($scriptProperties['data']);
if (!is_array($_DATA)) return $modx->error->failure('Invalid data.');

/* get obj */
if (empty($_DATA['id'])) return $modx->error->failure($modx->lexicon('groupeletters.groups.err.nf'));
$group = $modx->getObject('EletterGroups',$_DATA['id']);
if (empty($group)) return $modx->error->failure($modx->lexicon('groupeletters.groups.err.nf'));

/* set fields */
$group->fromArray($_DATA);
if ( isset($_DATA['active']) ){
    if ( $_DATA['active'] === 1 || $_DATA['active'] == $modx->lexicon('yes') ) {
        $group->set('active', 'Y');
    } else {
        $group->set('active', 'N');
    }
}
if ( isset($_DATA['allow_signup']) ){
    if ( $_DATA['allow_signup'] === 1 || $_DATA['allow_signup'] == $modx->lexicon('yes') ) {
        $group->set('allow_signup', 'Y');
    } else {
        $group->set('allow_signup', 'N');
    }
}
/* save */
if ($group->save() == false) {
    return $modx->error->failure($modx->lexicon('groupeletters.groups.err.save'));
}


return $modx->error->success('',$group);