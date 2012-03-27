<?php
/**
 * Get a list of newsletters
 *
 *
 * @package ditsnews
 * @subpackage processors.newsletters.list
 */


/* setup default properties */
$isLimit    = !empty($_REQUEST['limit']);
$start      = $modx->getOption('start',$_REQUEST,0);
$limit      = $modx->getOption('limit',$_REQUEST,10);
$sort       = $modx->getOption('sort',$_REQUEST,'id');
$dir        = $modx->getOption('dir',$_REQUEST,'DESC');

/* query for newsletters */
$c = $modx->newQuery('dnNewsletter');
$count = $modx->getCount('dnNewsletter',$c);

$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$newsletters = $modx->getCollection('dnNewsletter',$c);

/* iterate through newsletters */
$list = array();
foreach ($newsletters as $newsletter) {
        $total = $modx->getCount('dnQueue',array('newsletter' => $newsletter->get('id')));
        $sent = $modx->getCount('dnQueue',array('newsletter' => $newsletter->get('id'), 'sent' => 1));
        $newsletter = $newsletter->toArray();
        $newsletter['total'] = (int)$total;
        $newsletter['sent'] = (int)$sent;
        $list[] = $newsletter;
}
return $this->outputArray($list,$count);