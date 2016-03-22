<?php
$subscriber = $modx->getObject('EletterSubscribers', array('id' => $scriptProperties['id']));
if(empty($subscriber)) {
    return $modx->error->failure($modx->lexicon('eletters.subscribers.err.nf'));
}

//check for unique email address
$emailcount = $modx->getCount('EletterSubscribers', array('id != '.$subscriber->get('id'), 'email' => $scriptProperties['email']));
if($emailcount > 0) {
    return $modx->error->failure($modx->lexicon('eletters.subscribers.err.ae'));
}

$subscriber->fromArray($scriptProperties);

if ($subscriber->save()) {
    //add new groups
    $groups = $modx->getCollection('EletterGroups');
    foreach($groups as $group) {
        $id = $group->get('id');
        //$myGroup = $subscriber->getOne('Groups', array('group' => $id) );
        $myGroup = $modx->getObject('EletterGroupSubscribers', array('group'=>$id,'subscriber'=>$subscriber->get('id')));
        
        if( isset($scriptProperties['groups_'.$id]) ) {
            // add or keep
            if ( $myGroup ) {
                // this already exists
                $myGroup->get('id');
                //$modx->log(modX::LOG_LEVEL_ERROR,'[ELetters/Process/Update] Subscriber('.$subscriber->get('id') .') Exists for group: '.$id.' ID: '.$myGroup->get('id'));
                if ( $myGroup->get('recieve_email') == 'N') {
                    $myGroup->set('recieve_email', 'Y');
                    $myGroup->set('date_updated', date('Y-m-d H:i:s'));
                    $myGroup->save();
                }
            } else {
                //$modx->log(modX::LOG_LEVEL_ERROR,'[ELetters/Process/Update] ADD Subscriber('.$subscriber->get('id') .') to group: '.$id);
                // add subsciber to group
                $GroupSubscribers = $modx->newObject('EletterGroupSubscribers');
                $GroupSubscribers->set('group', $id);
                $GroupSubscribers->set('subscriber', $subscriber->get('id'));
                $GroupSubscribers->set('date_created', date('Y-m-d h:i:s'));
                $GroupSubscribers->save();
            }
        } else {
            // remove if exists:
            if ( is_object($myGroup) ) {
                $myGroup->remove();
            }
        }
        unset($myGroup);
        // $this->modx->log(modX::LOG_LEVEL_ERROR,'[ELetters->signup()] GroupID: '.$groupID);
    }

	return $modx->error->success('', $subscriber);
} else {
	return $modx->error->failure($modx->lexicon('eletters.subscribers.err.save'));
}