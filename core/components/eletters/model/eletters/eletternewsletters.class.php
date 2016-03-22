<?php
class EletterNewsletters extends xPDOSimpleObject {
    /**
     * @param (string) sendOneError
     */
    protected $sendOneError = '';
    /**
     * @param (boolean) debug 
     */
    protected $debug = false;
    /**
     * @param (Array) created_urls
     */
    protected $created_urls = array();
    /**
     * MODX
     */
    public $modx = NULL;
    
    /**
     * Set the debug value
     * @param (Boolean) $debug
     */
    public function setDebug($debug=TRUE) {
        $this->debug = (boolean) $debug;
    }
    
    /**
     * Assign Groups to Newsletter
     * @param (Array) $groups - just the IDs of the groups
     * 
     */
    public function assignGroups($groups) {
        $this->setMODX();
        $currentGroups = $this->getMany('Groups');
        foreach ( $currentGroups as $group ) {
            if ( in_array($group->get('id'), $groups) ) {
                // already exists now remove from list
                unset($groups[$group->get('id')]);
            } else {
                // remove as it is no longer used:
                $group->remove();
            }
        }
        // now create new records
        foreach( $groups as $gID) {
            $group = $this->modx->newObject('EletterNewsletterGroups');
            $group->set('group',$gID);
            $group->set('newsletter', $this->get('id'));
            // http://rtfm.modx.com/display/XPDO10/addOne
            // $this->addOne($group, 'Groups'); -- why does this not work???
            $group->save();
        }
        
        $this->save();
    }
    /**
     * send a test email
     * @param (String) $emails - comma separated list
     * @return (Boolean)
     */
    public function sendTest($emails) {
        $this->setMODX();
        $testers = explode(',', $emails);
        $testerData = array();
        
        // create the email for testing but don't save it
        $this->_createELetter(false);
        
        $defaultData = array(
            'first_name' => 'Firstname',
            'last_name' => 'Lastname',
            'fullname' => 'Full Name',
            'code' => 'CODE', 
            );
        
        foreach ($testers as $email ) {
            // check to see if email/user(s) are in subsriber table
            if ( $subscriber = $this->modx->getObject('EletterSubscribers', array('email' => $email) ) ) {
                
            } else {
                $subscriber = $this->modx->newObject('EletterSubscribers');
                $defaultData['email'] = $email;
                $subscriber->fromArray($defaultData);
            }
            // send test
            $subjectPrefix = $this->modx->getOption('eletters.testPrefix', '', NULL);
            $this->sendOne($subscriber, false, $subjectPrefix);
        }
        return true;
    }
    /**
     * Send to a list of subscribers
     * @param (Int) $limit - the limit to send for this instance
     * @param (Int) $delay - the time in seconds to delay between emails
     * @return (Int) $numSent - the number sent 
     */
    public function sendList($limit,$delay=10) {
        $this->setMODX();
        $numSent = 0;
        // get the list that has already received their eletter 
        $c = $this->modx->newQuery('EletterQueue');
        $c->where( array(
            'sent' => 1,
            'newsletter' => $this->get('id'),
            ));
        $queue = $this->modx->getCollection('EletterQueue', $c);
        $sendList = array();
        foreach($queue as $qitem) {
            $sendList[] = $qitem->get('subscriber');
        }
        
        // get list to send to:
        $groups = $this->getMany('Groups');// (EletterNewsletterGroups) 1 to many
        $myGroups = array();
        foreach ( $groups as $g ) {
            $myGroups[] = $g->get('group');
        }
        $delivered = 0;
        //$this->modx->log(modX::LOG_LEVEL_ERROR,'EletterNewsletter->sendList() - For newsletter: '.$this->get('id') );
        //$groups = $this->get('groups');// 1 to 1 or comma separted list 1,2,3 - bad design
        if ( count($myGroups) > 0 ) {
            $startDate = date('Y-m-d H:i:s');
            
            $c = $this->modx->newQuery('EletterSubscribers');
            $c->leftJoin('EletterGroupSubscribers', 'Groups');
            $c->where(array('Groups.group:IN' => $myGroups ));// OLD: explode(',',$groups)));
            // 
            //$c->leftJoin('EletterNewsletterGroups', 'NewsGroups');
            //$c->where(array('NewsGroups.newsletter' => $this->get('id') ) );
            
            $c->andCondition(array('EletterSubscribers.active' => 1));
            if ( count($sendList)) {
                $c->andCondition(array('EletterSubscribers.id:NOT IN' => $sendList));
            }
            
            $c->groupby('EletterSubscribers.email');
            $c->limit($limit, 0);
            $subscribers = $this->modx->getCollection('EletterSubscribers' , $c);
            if ( $this->debug ) {
                $process_id = time();
                $this->modx->log(modX::LOG_LEVEL_ERROR,'EletterNewsletter->sendList() - Start send loop for '.$this->modx->getCount('EletterSubscribers' , $c).' subscribers, processID: '.$process_id );
            }
            foreach($subscribers as $subscriber) {
                if ( in_array($subscriber->get('id'), $sendList) ) {
                    // a user may be in several different groups but only should get one email
                    continue;
                }
                if ( $this->debug ) {
                    $this->modx->log(modX::LOG_LEVEL_ERROR,'EletterNewsletter->sendList() - Sendone subscribers: '.$subscriber->get('id').' '.$subscriber->get('email').', processID: '.$process_id );
                }
                $delivered = $this->sendOne($subscriber);
                $numSent++;
                $queueItem = $this->modx->newObject('EletterQueue');
                $queueItem->fromArray(
                    array(
                        'newsletter' => $this->get('id'),
                        'subscriber' => $subscriber->get('id'),
                        'sent' => 1,
                        // added in RC1
                        'sent_time' => date('Y-m-d H:i:a'),
                        'delivered' => $delivered,
                        'error' => $this->sendOneError,
                    )
                );
                $queueItem->save();
                $sendList[] = $subscriber->get('id');
                sleep($delay);
            }
        }
        $current_status = $this->get('status');
        // add in the number sent for this round:
        $sent = $this->get('sent');
        $been_delivered = $this->get('delivered');
        if ( $delivered ) {
            $been_delivered += 1;
        }
        if ( $numSent > 0 && $sent == 0 ) {
            $this->set('start_date', $startDate );
            // $this->set('status', 'sent');
            //$this->save();
        }
        
        if ( $limit > $numSent && $current_status == 'approved' ) {
            $this->set('finish_date', date('Y-m-d H:i:s'));
            $this->set('status', 'complete');
        }
        $sent += $numSent;
        $this->set('sent', $sent);// total number sent
        $this->set('delivered', $been_delivered);// total sent with out errors
        
        $this->save();
       return $numSent;
    }
    /**
     * Send an eletter to a subscriber
     * @param (Array) $subscriber
     * @param (Boolean) $save
     * @param (String) $subjectPrefix
     * @return (Boolean)
     */
    public function sendOne($subscriber, $save=true, $subjectPrefix=NULL) {
        $this->setMODX();
        
        // has the newsletter been created?  if not create it
        $body = $this->get('message');
        if (empty($body)) {
            $this->_createELetter($save);
        }
        
        // set placeholders
        $placeholders = $this->setPlaceholders($subscriber);
        
        
        // process subject:
        $chunk = $this->modx->newObject('modChunk');
        $chunk->setContent($subjectPrefix.$this->get('title'));
        $subject = $chunk->process($placeholders);
        /**
                return $this->mail($placeholders, $subjectPrefix);
            }
            
            /**
             * mail a newsletter/response/trigger
             * @param (Array) $placeholders
             * @param (String) $subjectPrefix
             * @param (Boolean) $log - true log email to eletters_log
             * @return (Boolean)
             * /
             protected function mail($placeholders=array(), $subjectPrefix=NULL) {
        */
        $success = true;
        $this->modx->getService('mail', 'mail.modPHPMailer');
        
        $this->modx->mail->set(modMail::MAIL_BODY,      $body=$this->getELetter($placeholders));
        // ->AltBody
        $this->modx->mail->set(modMail::MAIL_BODY_TEXT, strip_tags($body));
        $this->modx->mail->set(modMail::MAIL_FROM,      $this->get('from') );
        $this->modx->mail->set(modMail::MAIL_FROM_NAME, $this->get('from_name') );
        $this->modx->mail->set(modMail::MAIL_SENDER,    $this->get('from'));
        $this->modx->mail->set(modMail::MAIL_SUBJECT,   $subject);
        $this->modx->mail->address('to',                $subscriber->get('email'));
        $this->modx->mail->address('reply-to', $this->get('reply_to'));
        $this->modx->mail->setHTML(true);
        // attachments:
        $attachments = json_decode($this->get('attachments'));
        foreach ( $attachments as $attachment ) {
            if ( !file_exists(MODX_BASE_PATH.DIRECTORY_SEPARATOR.$attachment) ) {
                continue;
            }
            $this->modx->mail->attach(MODX_BASE_PATH.DIRECTORY_SEPARATOR.$attachment);
        }
        $this->sendOneError = '';
        if (!$this->modx->mail->send()) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[ELetters->newsletter->sendOne()] An error occurred while trying to send newsletter to: '.$subscriber->get('email').' E: '.$this->modx->mail->mailer->ErrorInfo);
            $this->sendOneError = $this->modx->mail->mailer->ErrorInfo;
            $success = false;
        }
        $this->modx->mail->reset();
        return $success;
     }
    
    /**
     * Set the placeholders for a single newsletter
     * 
     */
    public function setPlaceholders(&$subscriber) {
        $this->setMODX();
        // set place 
        $placeholders = $subscriber->toArray();
        $placeholders['newsletterID'] = $this->get('id');
        $placeholders['subscriberID'] = $placeholders['id'];
        unset($placeholders['id']);
        $placeholders['fullname'] = $placeholders['first_name'].' '.$placeholders['last_name'];
        $placeholders['firstname'] = $placeholders['first_name'];
        $placeholders['lastname'] = $placeholders['last_name'];
        // the URLs: 
        $urlData = array(
                's' => $subscriber->get('id'),
                'c' => $subscriber->get('code'),
                'nwl' => $this->get('id'), 
            );
        $placeholders['manageSubscriptionsID'] = $this->modx->getOption('eletters.manageSubscriptionsPageID', '', 1);
        $placeholders['trackingPageID'] = $this->modx->getOption('eletters.trackingPageID', '', 1);
        // http://rtfm.modx.com/display/revolution20/modX.makeUrl
        $placeholders['manageSubscriptionsUrl'] = $this->modx->makeUrl($placeholders['manageSubscriptionsID'], '', $urlData, 'full');
        
        // newsletterID]]&amp;s=[[+subscriberID]]&amp;c=[[+code
        $placeholders['unsubscribeID'] = $this->modx->getOption('eletters.unsubscribePageID', '', 1);
        $placeholders['unsubscribeUrl'] = $this->modx->makeUrl($placeholders['unsubscribeID'], '', $urlData, 'full');
        if ( (boolean) $this->modx->getOption('eletters.useUrlTracking', '', FALSE) ) {
            require_once 'elettertracking.class.php';
            $tracking = new EletterTracking($this->modx);
            $placeholders['trackingImage'] = $tracking->makeUrl('trackingImage', $this->get('id'), 'image');
        } else {
            $placeholders['trackingImage'] = '';
        }
        $placeholders['current_year'] = date('Y');
        return $placeholders;
    }
    
    /**
     * get the complete e-letter for a given subscriber
     * @param (Array) $placeholders
     * @return (String) $html
     */
    public function getELetter($placeholders) {
        $this->setMODX();
        // set placeholders
        // process
        //get message including parsed placeholders
        $chunk = $this->modx->newObject('modChunk');
        $chunk->setContent($this->get('message'));
        $html = $chunk->process($placeholders);
        unset($chunk);
        // return HTML string
        
        return $html;
    }
    
    /**
     * create and parse the eletter
     * @return (Boolean)
     * @param (Boolean) $save
     * @TODO review this method
     */
    private function _createELetter($save=true) { 
        $this->setMODX();
        // process the eletter but leave the placeholders as
        $doc = $this->modx->getObject('modResource', array('id'=>$this->get('resource')));
        
        //$this->modx->log(modX::LOG_LEVEL_ERROR,'EletterNewsletter->_createEletter() - Resource: '.$this->get('resource') );
        
        $docUrl = preg_replace('/&amp;/', '&', $this->modx->makeUrl($this->get('resource'), '', '&sending=1', 'full') );
        
        //$this->modx->log(modX::LOG_LEVEL_ERROR,'EletterNewsletter->_createEletter() - Resource URL: '.$docUrl );
        
        $context = $this->modx->getObject('modContext', array('key' => $doc->get('context_key')));
        $contextUrl = $context->getOption('site_url', $this->modx->getOption('site_url'));
        unset($context);
        
        $message = $doc->process();//NULL,$doc->getContent());
        //$message = $doc->getContent();
        
        // _output;
        //$message = file_get_contents($docUrl);
        //$message = str_replace('&#91;&#91;', '[[', $message); //convert entities back to normal placeholders
        //$message = str_replace('&#93;&#93;', ']]', $message); //convert entities back to normal placeholders
        
        // fix links/srcs:
        $message = $this->makeUrls($message);
        // sets floating properties to html attributes
        $message = $this->imgAttributes($message);
        // Apply CSS:
        
        // RESOURCE
        // CHUNK
        // File {assets_path}
        $cssBasePath = MODX_BASE_PATH . 'assets/';
        
        $cssStyles = "\n";
        // Embedded CSS Chunk 
        $tempCss = $this->modx->getChunk('cssEmbed_'.str_replace(' ', '', $this->get('title')));// cssFile_templateName, cssEmbed_templateName, cssResouce_templateName
        if (!empty($tempCss)) {
            // apply styles
            $cssStyles .= $tempCss;
        }
        // File CSS Chunk - comma separated list:
        $tempCss = $this->modx->getChunk('cssFile_'.str_replace(' ', '', $this->get('title')));// cssFile_templateName, cssEmbed_templateName, cssResouce_templateName
        if (!empty($tempCss)) {
            $files = explode(',', $tempCss);
            foreach ($files as $file) {
                $file = str_replace('{assets_path}', $cssBasePath, $file);
                $tempCss = file_get_contents($cssFile);
                if ( !empty($tempCss) ) {
                    $cssStyles .= $tempCss;
                }
            }
        }
        // Resouce CSS Chunk - is this really needed?
        
        $message = $this->applyCss($message, $cssStyles);
        //CSS inline
        
        // Hack:  Parse and/or applyCSS seems to turn all empty [[+]] that are in href="[[+placeholder]]" into HTML safe symboles? 
        $message = str_replace(array('%5B%5B%2B','%5B%5B&#43;', '%5B%5B', '%5D%5D'), array('[[+', '[[+', '[[', ']]'), $message); 
        
        $this->set('message', $message);
        // if ( $save ) { // always save until I get the process() figured out!
            $this->save();
        //}
        return true;
        
    }
    
    /** 
     *  Make the tracking links:
     * @param (Sring) $html
     * @param (Boolean) $tracking - true will make tracking URLs
     * @return (String) $html
     */
    public function makeUrls($html, $tracking=false){ // bool
        $this->setMODX();
        // Make full URLs:
        $baseUrl = ''; 
        $dom = new DOMDocument('1.0', 'utf-8');
        $dom->loadHTML($html);
        if ( is_object($dom) ) {
            //$site_url = $dom->getElementsByTagName('base')->item(0)->getAttribute('href');
            //get site_url from base tag or default MODX setting
            $base = $dom->getElementsByTagName('base');
            if (is_object($base)){
                $baseItem = $base->item(0);
            }
            if (is_object($baseItem)){
                $baseUrl = $baseItem->getAttribute('href');
            }
        }
        if( empty($baseUrl) || $baseUrl == '[[++site_url]]') {
            $baseUrl = $this->modx->getOption('site_url');
            $html = str_replace('[[++site_url]]', $baseUrl, $html);
        }
        
        $html = $this->fullUrls($baseUrl, $html);
        //return $html;
        // add in the tracking URLs:
        if ( (boolean) $this->modx->getOption('eletters.useUrlTracking', '', FALSE) ) {
            require_once 'elettertracking.class.php';
            $tracking = new EletterTracking($this->modx);
            $html = $tracking->makeTrackingUrls($html, $this);
        }
        return $html;
    }
    /**
     * Set modx 
     */
    public function setMODX() {
        if (!is_object($this->modx) ) {
            global $modx;
            $this->modx = &$modx;
        }
    }
    
    /**
     * Apply CSS rules:
     * @param (String) $html
     * @param (String) $css_rules
     * 
     * @return (String) $html
     */
    public function applyCss($html, $css_rules){
        require_once MODX_CORE_PATH.'components/eletters/model/csstoinline/css_to_inline_styles.php';
        // embedded CSS:
        preg_match_all('|<style(.*)>(.*)</style>|isU', $html, $css);
        if( !empty($css[2]) ) {
            foreach( $css[2] as $cssblock ) {
                $css_rules .= $cssblock;
            }
        }
        $cssToInlineStyles = new CSSToInlineStyles($html, $css_rules);
        
        // the processed HTML
        $html = $cssToInlineStyles->convert();
        // remove tags: http://www.php.net/manual/en/domdocument.savehtml.php#85165
        //$html = preg_replace('/^<!DOCTYPE.+? >/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $html) );
        return $html;
    }
    
    /**
     * Make full URLs of HTML body function From emailresource: http://modx.com/extras/package/emailresource
     * @param (String) $baseUrl
     * @param (String) $html
     * @return (String) $html
     */
    public function fullUrls($baseUrl, $html) {
        // THIS method seems to act funny for https and any placeholders: [[+firstname]]
        $baseUrl = str_replace('https://', 'http://', $baseUrl);// @TODO Revise this to make option
        /* extract domain name from $baseUrl (http://example.com/) */
        $splitBase = explode('//', $baseUrl);
        $domain = $splitBase[1];// example.com/
        $domain = rtrim($domain,'/ ');// example.com

        /* remove space around = sign */
        //$html = preg_replace('@(href|src)\s*=\s*@', '\1=', $html);
        $html = preg_replace('@(?<=href|src)\s*=\s*@', '=', $html);

        /* fix google link weirdness - what is this for? */
        //$html = str_ireplace('google.com/undefined', 'google.com',$html);

        /* add http to naked domain links so they'll be ignored later */
        if ( !empty($domain) ) {
            $html = str_ireplace('a href="' . $domain, 'a href="http://'. $domain, $html);
        }
        /* standardize orthography of domain name */
        $html = str_ireplace($domain, $domain, $html);

        /* Correct base URL, if necessary ?? */
        $server = preg_replace('@^([^\:]*)://([^/*]*)(/|$).*@', '\1://\2/', $baseUrl);

        /* handle root-relative URLs */
        $html = preg_replace('@\<([^>]*) (href|src)="/([^"]*)"@i', '<\1 \2="' . $server . '\3"', $html);

        /* handle base-relative URLs */
        $html = preg_replace('@\<([^>]*) (href|src)="(?!http|mailto|sip|tel|callto|sms|ftp|sftp|gtalk|skype|\[\[)(([^\:"])*|([^"]*:[^/"].*))"@i', '<\1 \2="' . $baseUrl . '\3"', $html);

        return $html;
    }
    /**
     * Fix inline CSS images to be useable in email
     * @param (String) $html
     * @return (String) $html
     */
    public function imgAttributes($html) {
        $replace = array (
            '<img style="vertical-align: baseline;' =>'<img align="bottom" hspace="4" vspace="4" style="vertical-align: baseline;',
            '<img style="vertical-align: middle;' => '<img align="middle" hspace="4" vspace="4" style="vertical-align: middle;',
            '<img style="vertical-align: top;' => '<img align="top" hspace="4" vspace="4" style="vertical-align: top;',
            '<img style="vertical-align: bottom;' => '<img align="bottom" hspace="4" vspace="4" style="vertical-align: bottom;',
            '<img style="vertical-align: text-top;' =>'<img align="top" hspace="4" vspace="4" style="vertical-align: text-top;',
            '<img style="vertical-align: text-bottom;' => '<img align="bottom" hspace="4" vspace="4" style="vertical-align: text-bottom;',
            '<img style="float: left;' => '<img align="left" hspace="4" vspace="4" style="float: left;',
            '<img style="float: right;' => '<img align="right" hspace="4" vspace="4" style="float: right;',
        );
        $html = $this->strReplaceAssoc($replace, $html);
        return $html;
    }
    /**
     * Utility function
     * @param (Array) $replace
     * @param (String) $subject
     * @return (String) $string
     */
    protected function strReplaceAssoc(array $replace, $subject) {
        return str_replace(array_keys($replace), array_values($replace), $subject);
    }
}