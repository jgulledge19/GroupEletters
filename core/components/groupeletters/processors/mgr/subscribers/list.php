<?php
/**
 * Get a list of subscribers
 *
 *
 * @package groupeletters
 * @subpackage processors.subscribers.list
 */

/* setup default properties */
$isLimit    = !empty($_REQUEST['limit']);
$start      = $modx->getOption('start',$_REQUEST,0);
$limit      = $modx->getOption('limit',$_REQUEST,9999999);
$sort       = $modx->getOption('sort',$_REQUEST,'EletterSubscribers.id');
$dir        = $modx->getOption('dir',$_REQUEST,'ASC');
$query      = $modx->getOption('query',$_REQUEST,'');
$groupfilter = $modx->getOption('groupfilter',$_REQUEST,'');

/* query for subscribers */
$c = $modx->newQuery('EletterSubscribers');

if(!empty($groupfilter)) {
    $c->leftJoin('EletterGroupSubscribers', 'Groups');
    $c->where( array('Groups.group' => (int)$groupfilter));
} else if (!empty($query)) {
    $c->where(array('EletterSubscribers.email:LIKE' => '%'.$query.'%'));
    $c->orCondition(array('EletterSubscribers.firstname:LIKE' => '%'.$query.'%'));
    $c->orCondition(array('EletterSubscribers.lastname:LIKE' => '%'.$query.'%'));
    $c->orCondition(array('EletterSubscribers.company:LIKE' => '%'.$query.'%'));
}

$count = $modx->getCount('EletterSubscribers',$c);

$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$subscribers = $modx->getCollection('EletterSubscribers',$c);

/* iterate through subscribers */
$list = array();
foreach ($subscribers as $subscriber) {
        $subscriber = $subscriber->toArray();
        $list[] = $subscriber;
}
return $this->outputArray($list,$count);