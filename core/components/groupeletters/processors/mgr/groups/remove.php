<?php
$group = $modx->getObject('dnGroup', $scriptProperties['id']);

if ($group == null) {
	return $modx->error->failure($modx->lexicon('ditsnews.groups.err.nf'));
}

// Remove group
$group->remove();

return $modx->error->success('');