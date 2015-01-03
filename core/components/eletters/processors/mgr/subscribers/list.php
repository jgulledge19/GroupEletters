<?php
/**
 * Get a list of subscribers
 *
 *
 * @package eletters
 * @subpackage processors.subscribers.list
 */

/* setup default properties */
$isLimit    = !empty($_REQUEST['limit']);
$start      = $modx->getOption('start',$_REQUEST,0);
$limit      = $modx->getOption('limit',$_REQUEST,9999999);
$sort       = $modx->getOption('sort',$_REQUEST,'EletterSubscribers.last_name');
$dir        = $modx->getOption('dir',$_REQUEST,'ASC');
$query      = $modx->getOption('query',$_REQUEST,'');
$groupfilter = $modx->getOption('groupfilter',$_REQUEST,'');

/* query for subscribers */
$c = $modx->newQuery('EletterSubscribers');
$sub = FALSE;
if(!empty($groupfilter)) {
    $c->leftJoin('EletterGroupSubscribers', 'Groups');
    $c->where( array('Groups.group' => (int)$groupfilter));
} 
if (!empty($query)) {
    $conditions = 
        array(
            'EletterSubscribers.email:LIKE' => '%'.$query.'%',
            'OR:EletterSubscribers.first_name:LIKE' => '%'.$query.'%',
            'OR:EletterSubscribers.last_name:LIKE' => '%'.$query.'%',
            'OR:EletterSubscribers.company:LIKE' => '%'.$query.'%'
        );
    $c->where($conditions, xPDOQuery::SQL_AND);
}

$count = $modx->getCount('EletterSubscribers',$c);

$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$subscribers = $modx->getCollection('EletterSubscribers',$c);

// $modx->log(modX::LOG_LEVEL_ERROR,'Eletters->Processors/subscribers/list SQL: '.$c->toSql() );

/* iterate through subscribers */
$list = array();
foreach ($subscribers as $subscriber) {
        $subscriber = $subscriber->toArray();
        $list[] = $subscriber;
}
return $this->outputArray($list,$count);