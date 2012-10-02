<?php
class EletterNewsletters extends xPDOSimpleObject {
    /**
     * @param (boolean) debug 
     */
    protected $debug = false;
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
        global $modx;
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
            $group = $modx->newObject('EletterNewsletterGroups');
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
        global $modx;
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
            if ( $subscriber = $modx->getObject('EletterSubscribers', array('email' => $email) ) ) {
                
            } else {
                $subscriber = $modx->newObject('EletterSubscribers');
                $defaultData['email'] = $email;
                $subscriber->fromArray($defaultData);
            }
            // send test
            $this->sendOne($subscriber, false);
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
        global $modx;
        
        $numSent = 0;
        // get the list that has already received their eletter 
        $c = $modx->newQuery('EletterQueue');
        $c->where( array(
            'sent' => 1,
            'newsletter' => $this->get('id'),
            ));
        $queue = $modx->getCollection('EletterQueue', $c);
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
        
        //$modx->log(modX::LOG_LEVEL_ERROR,'EletterNewsletter->sendList() - For newsletter: '.$this->get('id') );
        //$groups = $this->get('groups');// 1 to 1 or comma separted list 1,2,3 - bad design
        if ( count($myGroups) > 0 ) {
            $startDate = date('Y-m-d H:i:s');
            
            $c = $modx->newQuery('EletterSubscribers');
            $c->leftJoin('EletterGroupSubscribers', 'Groups');
            $c->where(array('Groups.group:IN' => $myGroups ));// OLD: explode(',',$groups)));
            // 
            //$c->leftJoin('EletterNewsletterGroups', 'NewsGroups');
            //$c->where(array('NewsGroups.newsletter' => $this->get('id') ) );
            
            $c->andCondition(array('EletterSubscribers.active' => 1));
            if ( count($sendList)) {
                $c->andCondition(array('EletterSubscribers.id:NOT IN' => $sendList));
            }
            
            $c->limit($limit, 0);
            $subscribers = $modx->getCollection('EletterSubscribers' , $c);
            if ( $this->debug ) {
                $process_id = time();
                $modx->log(modX::LOG_LEVEL_ERROR,'EletterNewsletter->sendList() - Start send loop for '.$modx->getCount('EletterSubscribers' , $c).' subscribers, processID: '.$process_id );
            }
            foreach($subscribers as $subscriber) {
                if ( in_array($subscriber->get('id'), $sendList) ) {
                    // a user may be in several different groups but only should get one email
                    continue;
                }
                if ( $this->debug ) {
                    $modx->log(modX::LOG_LEVEL_ERROR,'EletterNewsletter->sendList() - Sendone subscribers: '.$subscriber->get('id').' '.$subscriber->get('email').', processID: '.$process_id );
                }
                $this->sendOne($subscriber);
                $numSent++;
                $queueItem = $modx->newObject('EletterQueue');
                $queueItem->fromArray(
                    array(
                        'newsletter' => $this->get('id'),
                        'subscriber' => $subscriber->get('id'),
                        'sent' => 1
                    )
                );
                $queueItem->save();
                $sendList[] = $subscriber->get('id');
                sleep($delay);
            }
        }
        $current_status = $this->get('status');
        // add in the number sent for this round:
        $sent_cnt = $this->get('sent_cnt');
        if ( $numSent > 0 && $sent_cnt == 0 ) {
            $this->set('start_date', $startDate );
            // $this->set('status', 'sent');
            //$this->save();
        }
        
        if ( $limit > $numSent && $current_status == 'approved' ) {
            $this->set('finish_date', date('Y-m-d H:i:s'));
            $this->set('status', 'complete');
        }
        $sent_cnt += $numSent;
        $this->set('sent_cnt', $sent_cnt);
        $this->set('tot_cnt', $sent_cnt);
        
        $this->save();
       return $numSent;
    }
    /**
     * Send an eletter to a subscriber
     * @param (Array) $subscriber
     * @param (Boolean) $save
     * @return (Boolean)
     */
    public function sendOne($subscriber, $save=true) {
        global $modx;
        $success = true;
        
        // has the newsletter been created?  if not create it
        $body = $this->get('message');
        if (empty($body)) {
            $this->_createELetter($save);
        }
        
        // set place 
        $placeholders = $subscriber->toArray();
        $placeholders['newsletterID'] = $this->get('id');
        $placeholders['subscriberID'] = $placeholders['id'];
        unset($placeholders['id']);
        $placeholders['fullname'] = $placeholders['first_name'].' '.$placeholders['last_name'];
        // the URLs: 
        $urlData = array(
                's' => $subscriber->get('id'),
                'c' => $subscriber->get('code'),
                'nwl' => $this->get('id'), 
            );
        $placeholders['manageSubscriptionsID'] = $modx->getOption('groupeletters.manageSubscriptionsPageID', '', 1);
        // http://rtfm.modx.com/display/revolution20/modX.makeUrl
        $placeholders['manageSubscriptionsUrl'] = $modx->makeUrl($placeholders['manageSubscriptionsID'], '', $urlData, 'full');
        
        // newsletterID]]&amp;s=[[+subscriberID]]&amp;c=[[+code
        $placeholders['unsubscribeID'] = $modx->getOption('groupeletters.unsubscribePageID', '', 1);
        $placeholders['unsubscribeUrl'] = $modx->makeUrl($placeholders['unsubscribeID'], '', $urlData, 'full');
        
        $modx->getService('mail', 'mail.modPHPMailer');
        
        $modx->mail->set(modMail::MAIL_BODY,      $this->getELetter($placeholders));
        $modx->mail->set(modMail::MAIL_FROM,      $this->get('from') );
        $modx->mail->set(modMail::MAIL_FROM_NAME, $this->get('from_name') );
        $modx->mail->set(modMail::MAIL_SENDER,    $this->get('from'));
        $modx->mail->set(modMail::MAIL_SUBJECT,   $this->get('title'));
        $modx->mail->address('to',                $subscriber->get('email'));
        $modx->mail->address('reply-to', $this->get('reply_to'));
        $modx->mail->setHTML(true);
        if (!$modx->mail->send()) {
            $modx->log(modX::LOG_LEVEL_ERROR,'[Group ELetters->newsletter->sendOne()] An error occurred while trying to send newsletter to: '.$subscriber->get('email').' E: '.$modx->mail->mailer->ErrorInfo);
            $success = false;
        }
        $modx->mail->reset();
        return $success;
    }
    /**
     * get the complete e-letter for a given subscriber
     * @param (Array) $placeholders
     * @return (String) $html
     */
    public function getELetter($placeholders) {
        global $modx;
        // set placeholders
        // process
        //get message including parsed placeholders
        $chunk = $modx->newObject('modChunk');
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
        global $modx;
        // process the eletter but leave the placeholders as
        $doc = $modx->getObject('modResource', array('id'=>$this->get('resource')));
        
        //$modx->log(modX::LOG_LEVEL_ERROR,'EletterNewsletter->_createEletter() - Resource: '.$this->get('resource') );
        
        $docUrl = preg_replace('/&amp;/', '&', $modx->makeUrl($this->get('resource'), '', '&sending=1', 'full') );
        
        //$modx->log(modX::LOG_LEVEL_ERROR,'EletterNewsletter->_createEletter() - Resource URL: '.$docUrl );
        
        $context = $modx->getObject('modContext', array('key' => $doc->get('context_key')));
        $contextUrl = $context->getOption('site_url', $modx->getOption('site_url'));
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
        $tempCss = $modx->getChunk('cssEmbed_'.str_replace(' ', '', $this->get('title')));// cssFile_templateName, cssEmbed_templateName, cssResouce_templateName
        if (!empty($tempCss)) {
            // apply styles
            $cssStyles .= $tempCss;
        }
        // File CSS Chunk - comma separated list:
        $tempCss = $modx->getChunk('cssFile_'.str_replace(' ', '', $this->get('title')));// cssFile_templateName, cssEmbed_templateName, cssResouce_templateName
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
        global $modx;
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
            $baseUrl = $modx->getOption('site_url');
            $html = str_replace('[[++site_url]]', $baseUrl, $html);
        }
        
        //return $html;//
        return $this->fullUrls($baseUrl, $html);
        
        // @TODO Make trackable URLs:
        /* 
        //convert local link URLs to full URLs
        $links = $dom->getElementsByTagName('a');
        foreach($links as $link) {
            if( $href = $link->getAttribute('href') ) {
                if(substr($href, 0, 7) != 'http://' && substr(trim($href), 0, 7) != 'mailto:') {
                    $newhref = $site_url.$href;
                    //add tracking vars
                    $newhref .= ( strpos($newhref, '?') ? '&amp;' : '?' );
                    $newhref .= 'nwl=[[+newsletterID]]&amp;s=[[+subscriberID]]&amp;c=[[+code]]';
                    $link->setAttribute('href',$newhref);
                }
            }
        }*/
        
        // Make tracking URLs:
        
        // 1. Convert all links to /tiny/Link id(base 64)/Person ID(base 64?) -> email_links
        $temp_links = explode("<a ",$message);
        $shortened_email = NULL;
        
        foreach ($temp_links as $link_str ) {
            // get the first occurance of href
            $position = strpos($link_str, 'href="');
            if ( $position === false ) {
                // no link:
                $shortened_email .= $link_str;
                continue;
            }
            $before = substr($link_str, 0, $position );
            $link = substr($link_str, ($position+6) );
            $quote_position = strpos($link, '"');
            $after = substr($link, ($quote_position+1) );
            $link = substr($link, 0, $quote_position );
            
            if ( strpos($link, 'mailto:') === false  && strpos($link, '[[') === false ) {
            
            } else {
                // mailto link:
                $shortened_email .= '<a '.$link_str;
                continue;
            }
            // now reconstruct the link_str:
            $shortened_email .= '<a '.$before.' href="'.$this->tinyURL($link).'|CODE"'.$after;
        }
        $this->content = $shortened_email;
        return true;
    }
    /**
     * 
     * /
    public function tinyURL($current_url){
        if ( empty($this->created_urls[$current_url]) ){
            //echo '<br>Create URL ';
            $sql = "SELECT * FROM email_links 
            WHERE
                email_rec_id = ".$this->email_id." AND
                url = '".addslashes($current_url)."'
                ";
            $data = $this->rs->query($sql, true, true);
            
            //echo '<br>SQL: '.mysql_error();
            //echo '<br>'.$sql;
            //print_r($data);
            
            if ( isset($data['email_link_id']) ) {
                $this->created_urls[$current_url] = $data['email_link_id'];
            } else {
                // save the link:
                $save_data = array(
                        'email_rec_id' => $this->email_id,
                        'url' => $current_url,
                        'type' => 'link' );
                if ( $this->rs->add_record($save_data, 'email_links', 'email_link_id') ) {
                    $this->created_urls[$current_url] = mysql_insert_id();
                }
            }
        }
        return $this->base_link.base_convert($this->created_urls[$current_url],10,36);
    }*/
    /**
     * Apply CSS rules:
     * @param (String) $html
     * @param (String) $css_rules
     * 
     * @return (String) $html
     */
    public function applyCss($html, $css_rules){
        require_once MODX_CORE_PATH.'components/groupeletters/model/csstoinline/css_to_inline_styles.php';
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
    
    
    
    
    // 
    
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