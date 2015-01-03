<?php
/**
 *
 * Written by: Joshua Gulledge
 * License: GNU GENERAL PUBLIC LICENSE Version 2, June 1991
 *
 */

 
// set OnHandleRequest 
$eventName = $modx->event->name;
//$modx->log(modX::LOG_LEVEL_ERROR,'[Eletters->Plugin] Event: '.$eventName);
switch($eventName) {
    case 'OnDocFormSave':
        /* do something */
        // $modx->log(modX::LOG_LEVEL_ERROR,'[Eletters] Do Something!');
        if (!isset($modx->eletters)) {
            $modx->addPackage('eletters', $modx->getOption('core_path').'components/eletters/model/');
            $modx->eletters = $modx->getService('eletters', 'Eletters', $modx->getOption('core_path').'components/eletters/model/eletters/');
        }
        $eletters =& $modx->eletters;

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
            $tvValue = $tv->getValue($resource->get('id'));
            $source = $tv->getSource();
            $source->initialize();
            $path = $source->getBasePath();
            $attachments = array(str_replace(MODX_BASE_PATH, '', $path).'/'.ltrim($tvValue,'/'));
            
            $procesTVs = array(
                'eletterFromEmail' => '',
                'eletterFromName' => '',
                'eletterReplyEmail' => '',
            );
            foreach ($procesTVs as $t => $v ) {
                $chunk = $modx->newObject('modChunk');
                $chunk->setContent($resource->getTVValue($t));
                $procesTVs[$t] = $chunk->process(array());
            }
            
            $data = array(
                    'title' => $resource->getTVValue('eletterSubject'),
                    'subject' => $resource->getTVValue('eletterSubject'),
                    'from' => $procesTVs['eletterFromEmail'],
                    'from_name' => $procesTVs['eletterFromName'],
                    'reply_to' => $procesTVs['eletterReplyEmail'],
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
            
            if (!isset($modx->eletters)) {
                $modx->addPackage('eletters', $modx->getOption('core_path').'components/eletters/model/');
                $modx->eletters = $modx->getService('eletters', 'Eletters', $modx->getOption('core_path').'components/eletters/model/eletters/');
            }
            $eletters =& $modx->eletters;
            if ( $modx->getOption('eletters.debug', NULL, 0) ) {
                $eletters->setDebug();
            }
            $page_id = $modx->resource->get('id');
            $tracking_id = $modx->getOption('eletters.trackingPageID');
            
            if ( $page_id == $tracking_id ) {
                // process the url and redirect if needed:
                // now load the tracking stuff:
                $etracker = $eletters->loadTracker();
                $etracker->debug = (boolean)$modx->getOption('eletters.debug',NULL, 0);
                $etracker->logAction('click');
                 
            }
            
            // @TODO Varify Access - Private/Public 
            $makeELetter = $modx->resource->getTVValue('eletterMakeELetter');
            $send = FALSE;
            if ( !empty($makeELetter) && $makeELetter == 'Yes' ) {
                 //$modx->log(modX::LOG_LEVEL_ERROR, 'Make Eletter ');
                // use the tv values: 
                $access = $modx->resource->getTVValue('eletterAccess');
                if ( $access == 'Private' ) {
                    // Elog:
                    $send = TRUE;
                    //$modx->log(modX::LOG_LEVEL_ERROR, 'Make Eletter Private ');
                }
                if ( isset($_GET['ecode']) && isset($_GET['lid']) ) {
                    $send = FALSE;
                    // get log
                    $output = $eletters->getLogEmail($_GET['lid'], $_GET['ecode']);
                    $modx->log(modX::LOG_LEVEL_ERROR, 'Get Elog');
                    if (empty($output) || $output === FALSE) {
                        if ( $access == 'Private' ){
                            $send = TRUE;
                        } 
                    } else {
                        $modx->log(modX::LOG_LEVEL_ERROR, 'Set Elog Content');
                        $modx->resource->_content = $modx->resource->output = $output;
                        $modx->resource->set('content', $output);
                        $modx->resource->setProcessed(true);
                    }
                    
                } else if ( isset($_GET['c']) && isset($_GET['s']) && isset($_GET['nwl']) ) {
                    // get  nwl=[[+newsletterID]]&s=[[+subscriberID]]&c=[[+code]]&fname=([[+first_name]])
                    
                    //$modx->log(modX::LOG_LEVEL_ERROR, 'Find eletter campaign nwl: '.$_GET['nwl'].' s: '.$_GET['s'].' c: '.$_GET['c']);
                    // @TODO Load Placeholders for subscriber
                    $newsletter = $modx->getObject('EletterNewsletters', array('id' => $_GET['nwl'] ));
                    if ( is_object($newsletter) ) {
                        //$modx->log(modX::LOG_LEVEL_ERROR, 'Found eletter campaign: '.$_GET['nwl']);
                        $subscriber = $modx->getObject('EletterSubscribers', array('id' => $_GET['s'], 'code' => $_GET['c'] ));
                        if ( is_object($subscriber) ) {
                            //$modx->log(modX::LOG_LEVEL_ERROR, 'Find Subscriber: '.$_GET['s']);
                            $modx->setPlaceholders($newsletter->setPlaceholders($subscriber) );
                            $send = FALSE;
                        }
                    }
                    
                } 
                
                if ( $send ) {
                    //$modx->log(modX::LOG_LEVEL_ERROR, 'Did not find eletter so redirect: '.$modx->getOption('error_page'));
                    // redirect to error page
                    $modx->sendRedirect($modx->makeUrl($modx->getOption('eletters.deniedPageID'), null, $modx->getOption('error_page') ));
                }
                
            }
            
        }
        break;
        
    case 'OnWebPagePrerender':
        
        break;
}
return;