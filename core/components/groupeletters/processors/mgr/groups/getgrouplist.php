<?php
$outputArray = array();

//get groups of subscriber
$subscriberGroupsArray = array();
if( $_REQUEST['subscriberId'] ) {
    $subscriberGroups = $modx->getCollection('EletterGroupSubscribers', array('subscriber' => (int)$_REQUEST['subscriberId']));
    foreach($subscriberGroups as $subscriberGroup) {
        $subscriberGroupsArray[] = $subscriberGroup->get('group');
    }
}
unset($subscriberGroups);

//get all groups including checked/unchecked for current subscriber
$groups = $modx->getCollection('EletterGroup');
foreach( $groups as $group ) {

    if($_REQUEST['memberCount']) {
        $c = $modx->newQuery('EletterGroupSubscribers');
        $c->where( array('group' => $group->get('id')) );
        $members = $modx->getCount('EletterGroupSubscribers', $c);
    } else {
        $members = -1;
    }

    $outputArray[] = array(
        'id' => $group->get('id'),
        'name' => $group->get('name'),
        'checked' => (int)in_array($group->get('id'), $subscriberGroupsArray),
        'members' => $members
    );
}

return $modx->error->success('', $outputArray);