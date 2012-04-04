<?php
$newsletter = $modx->getObject('EletterNewsletters',  $scriptProperties['id']);

if ($newsletter == null) {
	return $modx->error->failure($modx->lexicon('groupeletters.newsletters.err.nf'));
}

// Remove newsletter
if($newsletter->remove()) {
    return $modx->error->success('');
}
else {
    return $modx->error->failure($modx->lexicon('groupeletters.newsletters.err.remove'));
}