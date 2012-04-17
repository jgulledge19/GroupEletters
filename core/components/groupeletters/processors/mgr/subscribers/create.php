<?php
//check for unique email address
$emailcount = $modx->getCount('EletterSubscribers', array('email' => $scriptProperties['email']));
if($emailcount > 0) {
    return $modx->error->failure($modx->lexicon('groupeletters.subscribers.err.ae'));
}

$details = array(
		'firstname' => $scriptProperties['firstname'],
        'lastname'  => $scriptProperties['lastname'],
        'company'   => $scriptProperties['company'],
        'email'     => $scriptProperties['email'],
        'active'    => (int)$scriptProperties['active'],
        'code'      => md5( time().$scriptProperties['firstname'].$scriptProperties['lastname']),
        'signupdate' => time()
);


$subscriber = $modx->newObject('EletterSubscribers', $details);

if ($subscriber->save()) {
    //remove current groups
    $curGroups = $subscriber->getMany('Groups');
    foreach($curGroups as $curGroup){
        $curGroup->remove();
    }
    
    //add new groups
    $groups = $modx->getCollection('EletterGroups');
    if( is_array($groups) ) {
        foreach($groups as $group) {
            $id = $group->get('id');
            if( isset($scriptProperties['groups_'.$id]) ) {
                $newGroup = $modx->newObject('EletterGroupSubscribers', array('group' => $id, 'subscriber' => $subscriber->get('id'))  );
                $newGroup->save();
            }
        }
    }

	return $modx->error->success('', $subscriber);
} else {
	return $modx->error->failure('');
}