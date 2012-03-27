<?php
/**
 * Get a list of subscribers
 *
 *
 * @package ditsnews
 * @subpackage processors.subscribers.list
 */

/* setup default properties */
$isLimit    = !empty($_REQUEST['limit']);
$start      = $modx->getOption('start',$_REQUEST,0);
$limit      = $modx->getOption('limit',$_REQUEST,9999999);
$sort       = $modx->getOption('sort',$_REQUEST,'dnSubscriber.id');
$dir        = $modx->getOption('dir',$_REQUEST,'ASC');
$query      = $modx->getOption('query',$_REQUEST,'');
$groupfilter = $modx->getOption('groupfilter',$_REQUEST,'');

/* query for subscribers */
$c = $modx->newQuery('dnSubscriber');

if(!empty($groupfilter)) {
    $c->leftJoin('dnGroupSubscribers', 'Groups');
    $c->where( array('Groups.group' => (int)$groupfilter));
}
elseif(!empty($query)) {
    $c->where(array('dnSubscriber.email:LIKE' => '%'.$query.'%'));
    $c->orCondition(array('dnSubscriber.firstname:LIKE' => '%'.$query.'%'));
    $c->orCondition(array('dnSubscriber.lastname:LIKE' => '%'.$query.'%'));
    $c->orCondition(array('dnSubscriber.company:LIKE' => '%'.$query.'%'));
}

$count = $modx->getCount('dnSubscriber',$c);

$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$subscribers = $modx->getCollection('dnSubscriber',$c);

/* iterate through subscribers */
$list = array();
foreach ($subscribers as $subscriber) {
        $subscriber = $subscriber->toArray();
        $list[] = $subscriber;
}
return $this->outputArray($list,$count);