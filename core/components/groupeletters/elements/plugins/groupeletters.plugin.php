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
            // send to array then JSON - need to get the path from the TV?
            //$attachments = array($resource->getTVValue('eletterAttachment'));
            
            $tv = $modx->getObject('modTemplateVar', array('name'=>'eletterAttachment'));
            $attachments = array($tv->renderOutput($resource->get('id')));// default to the current resource
            
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
                    'attachments' => json_encode($attachments),
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
            }
        }
        break;
     case 'OnLoadWebDocument': 
        /* tracking */
        if (is_object($modx->resource) && count($_GET) >= 1 ) {
            // get the current page ID and compare to the system settings ID for 
            
            if (!isset($modx->groupEletters)) {
                $modx->addPackage('groupeletters', $modx->getOption('core_path').'components/groupeletters/model/');
                $modx->groupEletters = $modx->getService('groupeletters', 'GroupEletters', $modx->getOption('core_path').'components/groupeletters/model/groupeletters/');
            }
            $groupEletters =& $modx->groupEletters;
            
            $page_id = $modx->resource->get('id');
            $tracking_id = $modx->getOption('groupeletters.trackingPageID');
            
            if ( $page_id == $tracking_id ) {
                // process the url and redirect if needed:
                // now load the tracking stuff:
                $etracker = $groupEletters->loadTracker();
                $etracker->debug = (boolean)$this->modx->getOption('groupeletters.debug',NULL, 0);
                $etracker->logAction('click');
            }
        }
        break;
        
    case 'OnWebPagePrerender':
        
        break;
}
return;