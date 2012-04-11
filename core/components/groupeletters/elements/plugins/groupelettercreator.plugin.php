<?php
/*
 *
 * Written by: Joshua Gulledge
 * License: GNU GENERAL PUBLIC LICENSE Version 2, June 1991
 *
 * */

 
// set OnHandleRequest 
$eventName = $modx->event->name;
switch($eventName) {
    case 'OnDocFormSave':
        /* do something */
        if (!isset($modx->groupEletters)) {
            $modx->addPackage('groupeletters', $modx->getOption('core_path').'components/groupeletters/model/');
            $modx->groupEletters = $modx->getService('groupeletters', 'GroupEletters', $modx->getOption('core_path').'components/groupeletters/model/groupEletters/');
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
        if ( !empty($makeELetter) ) {
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
                $pubDateFuture = $resource->get('pub_date'); // the pub date in the future
                if ( !empty($pubOnDate) ) {
                    $data['start_date'] = $pubOnDate;//date('Y-m-d H:i:s', $pubOnDate);
                } else if ( !empty($pubDateFuture) ) {// 
                    $data['start_date'] = $pubDateFuture;//date('Y-m-d H:i:s', $pubDateFuture);
                } 
                //$modx->log(modX::LOG_LEVEL_ERROR,'Pub Date: '.$pubOnDate.' - Future: '.$pubDateFuture);
            } else {
                $data['status'] = 'draft';
            }
                    
            $newsletter->fromArray($data);
        } else {
            // $newsletter->remove();
        }
        
        if ( $makeELetter == 'Yes' ) {
            // just save data
            $newsletter->save();
            // $resource->get('template');
            $sendTest = $resource->getTVValue('eletterSendTest');
            if ( $sendTest == 'Yes' ) {
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