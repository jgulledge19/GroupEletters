<?php
$subscriberId = (int) $_REQUEST['subscriberId'];

$subscriber = $modx->getObject('EletterSubscribers', $subscriberId);

if ($subscriber == null) {
	return $modx->error->failure('Subscriber not found');
}

// Remove subscriber
$subscriber->remove();

return $modx->error->success('');