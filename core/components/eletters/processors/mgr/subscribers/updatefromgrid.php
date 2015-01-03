<?php
/* parse JSON */
if (empty($scriptProperties['data'])) return $modx->error->failure('Invalid data.');
$_DATA = $modx->fromJSON($scriptProperties['data']);
if (!is_array($_DATA)) return $modx->error->failure('Invalid data.');

/* get obj */
if (empty($_DATA['id'])) return $modx->error->failure($modx->lexicon('eletters.subscribers.err.nf'));
$subscriber = $modx->getObject('EletterSubscribers',$_DATA['id']);
if (empty($subscriber)) return $modx->error->failure($modx->lexicon('eletters.subscribers.err.nf'));

/* set fields */
unset($_DATA['post_date']);
$subscriber->fromArray($_DATA);

/* save */
if ($subscriber->save() == false) {
    return $modx->error->failure($modx->lexicon('eletters.subscribers.err.save'));
}


return $modx->error->success('',$subscriber);