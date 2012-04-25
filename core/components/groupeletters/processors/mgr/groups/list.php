<?php
/**
 * Get a list of groups
 *
 *
 * @package groupEletters
 * @subpackage processors.groups.list
 */


/* setup default properties */
$isLimit    = !empty($_REQUEST['limit']);
$start      = $modx->getOption('start',$_REQUEST,0);
$limit      = $modx->getOption('limit',$_REQUEST,9999999);
$sort       = $modx->getOption('sort',$_REQUEST,'id');
$dir        = $modx->getOption('dir',$_REQUEST,'ASC');

/* query for groups */
$c = $modx->newQuery('EletterGroups');
$count = $modx->getCount('EletterGroups',$c);

$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$groups = $modx->getCollection('EletterGroups',$c);

/* iterate through groups */
$list = array();
foreach ($groups as $group) {

    $c = $modx->newQuery('EletterGroupSubscribers');
    $c->where( array('group' => $group->get('id')) );
    $members = $modx->getCount('EletterGroupSubscribers', $c);
    $group = $group->toArray();
    $group['members'] = (int)$members;
    
    $group['active'] = ($group['active'] == 'Y' ? 1 : 0 );
    $group['allow_signup'] = ($group['allow_signup'] == 'Y' ? 1 : 0 );
    
    $list[] = $group;
}
if(isset($_REQUEST['includeAll']) && !empty($_REQUEST['includeAll']) ) {
    array_unshift($list, array('id' => 0, 'name' => '--- '.$modx->lexicon('groupeletters.groups').' ---'));
}
return $this->outputArray($list,$count);