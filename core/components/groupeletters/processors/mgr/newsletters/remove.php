<?php
$newsletter = $modx->getObject('dnNewsletter',  $scriptProperties['id']);

if ($newsletter == null) {
	return $modx->error->failure($modx->lexicon('ditsnews.newsletters.err.nf'));
}

// Remove newsletter
if($newsletter->remove()) {
    return $modx->error->success('');
}
else {
    return $modx->error->failure($modx->lexicon('ditsnews.newsletters.err.remove'));
}