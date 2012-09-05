<?php
/**
 *
 * Written by: Joshua Gulledge
 * License: GNU GENERAL PUBLIC LICENSE Version 2, June 1991
 *
 */

 
// set OnHandleRequest 
$eventName = $modx->event->name;
switch($eventName) {
    case 'OnDocFormSave':
        /* do something */
        // $modx->log(modX::LOG_LEVEL_ERROR,'[GroupEletters] Do Something!');
        if (!isset($modx->groupEletters)) {
            $modx->addPackage('groupeletters', $modx->getOption('core_path').'components/groupeletters/model/');
            $modx->groupEletters = $modx->getService('groupeletters', 'GroupEletters', $modx->getOption('core_path').'components/groupeletters/model/groupeletters/');
        }
        $groupEletters =& $modx->groupEletters;

        $new = false;
        if( !$newsletter = $modx->getObject('EletterNewsletters', array('resource' => $resource->get('id') )) ) {
            // create a new newsletter:
            $newsletter = $modx->newObject('EletterNewsletters', array(
                'date' => time(),
                'resource' => $resource->get('id')
            ));
            $new = true;
        } 
        
        $makeELetter = $resource->getTVValue('eletterMakeELetter');
        if ( !empty($makeELetter) && $makeELetter == 'Yes' ) {
            $data = array(
                    'title' => $resource->getTVValue('eletterSubject'),
                    'subject' => $resource->getTVValue('eletterSubject'),
                    'from' => $resource->getTVValue('eletterFromEmail'),
                    'from_name' => $resource->getTVValue('eletterFromName'),
                    'reply_to' => $resource->getTVValue('eletterReplyEmail'),
                    'groups' => $resource->getTVValue('eletterToGroups'),
                    'status' => 'approved', //draft, submitted, approved $resource->getTVValue('eletterAllowComments'),
                    'allow_comments' => 'N',// Y/N $resource->getTVValue('eletter'),
                    'user' => $resource->get('publishedby'),
                );
            // published
            if ( $resource->get('published') ) {
                $pubOnDate = $resource->get('publishedon');
                if ( !empty($pubOnDate) ) {
                    $data['add_date'] = $pubOnDate;//date('Y-m-d H:i:s', $pubOnDate);
                }  
                //$modx->log(modX::LOG_LEVEL_ERROR,'Pub Date: '.$pubOnDate.' - Future: '.$pubDateFuture);
            } else {
                $pubDateFuture = $resource->get('pub_date'); // the pub date in the future
                if ( !empty($pubDateFuture) ) {// 
                    $data['add_date'] = $pubDateFuture;//date('Y-m-d H:i:s', $pubDateFuture);
                    //$data['status'] = 'draft';
                } else {
                    $data['status'] = 'draft';
                }
                
                
            }
            $newsletter->fromArray($data);
            $newsletter->save();
            $newsletter->assignGroups(explode(',', $resource->getTVValue('eletterToGroups') ) );
            
        } else {
            if ( !$new ){
                $newsletter->remove();
                // set to void?
            }
        }
        
        if ( $makeELetter == 'Yes' ) {
            // just save data
            $newsletter->save();
            // $resource->get('template');
            $sendTest = $resource->getTVValue('eletterSendTest');
            if ( $sendTest == 'Yes' ) {
                // set test back to No - this way quick updates don't send tests or every save does not send tests
                $resource->setTVValue('eletterSendTest', 'No');
                $resource->save();
                
                $testTo = $resource->getTVValue('eletterTestTo');
                if( !empty($testTo) ) {
                    $newsletter->sendTest($testTo);
                }
                //$newsletter->sendList(50);
                //$newsletter->proc
                //$groupEletters->processQueue();
            }
            
            /*  
                eletterMakeELetter
             * 
                eletterSendTest
                eletterTestTo
             * 
                eletterFromEmail
                eletterFromName
                eletterReplyEmail
                eletterSubject
             * 
                eletterToGroups
                eletterAllowComments
            */
        
        } else {
            // delete eletter
        }
        break;
    case 'OnWebPagePrerender':
        /* do something else */
        break;
}
return;