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

/* save */
if ($group->save() == false) {
    return $modx->error->failure($modx->lexicon('groupeletters.groups.err.save'));
}


return $modx->error->success('',$group);