<?php
//check for unique email address
$emailcount = $modx->getCount('EletterSubscribers', array('email' => $scriptProperties['email']));
if($emailcount > 0) {
    return $modx->error->failure($modx->lexicon('groupeletters.subscribers.err.ae'));
}
$subscriber = $modx->newObject('EletterSubscribers');
$subscriber->fromArray($scriptProperties);
$subscriber->set('code', md5( time().$scriptProperties['email'] ));
//$subscriber->set('active', 0);
$subscriber->set('date_created', date('Y-m-d H:i:s'));

if ($subscriber->save()) {
    
    //add new groups
    $groups = $modx->getCollection('EletterGroups');
    foreach($groups as $group) {
        $id = $group->get('id');
        // $myGroup = $subscriber->getOne('Groups', array('group' => $id) );
        $myGroup = $modx->getObject('EletterGroupSubscribers', array('group'=>$id,'subscriber'=>$subscriber->get('id')));
        
        if( isset($scriptProperties['groups_'.$id]) ) {
            // add or keep
            if ( is_object($myGroup) ) {
                // this already exists
                $modx->log(modX::LOG_LEVEL_ERROR,'[Group ELetters/Process/create()] Subscriber Exists for group ('.$subscriber->get('id') .') to GroupID: '.$id);
                if ( $myGroup->get('recieve_email') == 'N') {
                    $myGroup->set('recieve_email', 'Y');
                    $myGroup->set('date_updated', date('Y-m-d H:i:s'));
                    $myGroup->save();
                }
            } else {
                // add subsciber to group
                $modx->log(modX::LOG_LEVEL_ERROR,'[Group ELetters/Process/create()] add Subscriber for group ('.$subscriber->get('id') .') to GroupID: '.$id);
                $GroupSubscribers = $modx->newObject('EletterGroupSubscribers');
                $GroupSubscribers->set('group', $id);
                $GroupSubscribers->set('subscriber', $subscriber->get('id'));
                $GroupSubscribers->set('date_created', date('Y-m-d h:i:s'));
                $GroupSubscribers->save();
            }
        } else {
            // remove if exists:
            if ( is_object($myGroup) ) {
                $myGroup->set('receive_email', 'N');
                $myGroup->set('receive_sms', 'N');
                $myGroup->set('date_updated', date('Y-m-d H:i:s'));
                $myGroup->save();
            }
        }
        unset($myGroup);
        // $this->modx->log(modX::LOG_LEVEL_ERROR,'[Group ELetters->signup()] GroupID: '.$groupID);
    }
    
    /* OLD:
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
    }*/

	return $modx->error->success('', $subscriber);
}
return $modx->error->failure('');