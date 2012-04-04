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
$c = $modx->newQuery('EletterNewsletters');
$count = $modx->getCount('EletterNewsletters',$c);

$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$newsletters = $modx->getCollection('EletterNewsletters',$c);

/* iterate through newsletters */
$list = array();
foreach ($newsletters as $newsletter) {
    $total = $modx->getCount('EletterQueue',array('newsletter' => $newsletter->get('id')));
    $sent = $modx->getCount('EletterQueue',array('newsletter' => $newsletter->get('id'), 'sent' => 1));
    $newsletter = $newsletter->toArray();
    $newsletter['total'] = (int)$total;// tot_cnt
    $newsletter['sent'] = (int)$sent;// sent_cnt
    $list[] = $newsletter;
}
return $this->outputArray($list,$count);