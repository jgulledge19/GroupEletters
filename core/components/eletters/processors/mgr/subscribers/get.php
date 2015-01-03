<?php
$subscriberId = (int) $_REQUEST['id'];

$subscriber = $modx->getObject('EletterSubscribers', $subscriberId);

if ($subscriber == null) {
	return $modx->error->failure('Subscriber not found');
}

$subscriberArray = $subscriber->toArray();

return $modx->error->success('', $subscriberArray);