<?php
$group = $modx->getObject('EletterGroups', $scriptProperties['id']);

if ($group == null) {
	return $modx->error->failure($modx->lexicon('groupeletters.groups.err.nf'));
}

// Remove group
$group->remove();

return $modx->error->success('');