<?php
/**
 * @package Eletters
 */
class Eletters {
    
    /**
     * A reference to the modX instance
     * @var modX $modx
     */
    public $modx;
    
    /**
     * @var (Array) $config
     */
    protected $config = array();
    /**
     * Constructs the Eletters object
     *
     * @param modX &$modx A reference to the modX object
     * @param array $config An array of configuration options
     */
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;

        $basePath = $this->modx->getOption('eletters.core_path',$config,$this->modx->getOption('core_path').'components/eletters/');
        $assetsUrl = $this->modx->getOption('eletters.assets_url',$config,$this->modx->getOption('assets_url').'components/eletters/');

        $this->config = array_merge(array(
            'basePath' => $basePath,
            'corePath' => $basePath,
            'modelPath' => $basePath.'model/',
            'processorsPath' => $basePath.'processors/',
            'templatesPath' => $basePath.'templates/',
            'chunksPath' => $basePath.'elements/chunks/',
            'jsUrl' => $assetsUrl.'js/',
            'cssUrl' => $assetsUrl.'css/',
            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $assetsUrl.'connector.php',
            'debug' => (boolean) $this->modx->getOption('eletters.debug', NULL, 0)
        ),$config);
        $this->modx->addPackage('eletters',$this->config['modelPath']);

        $this->modx->lexicon->load('eletters:default');
    }

    /**
     * Initializes the class into the proper context
     *
     * @access public
     * @param string $ctx
     */
    public function initialize($ctx = 'web') {
        switch ($ctx) {
            case 'mgr':
                //                           eletterscontrollerrequest.class.php
                //require_once $this->config['modelPath'].'eletters/request/eletterscontrollerrequest.class.php';
                if (!$this->modx->loadClass('ElettersControllerRequest',$this->config['modelPath'].'eletters/request/',true,true)) {
                    return 'Could not load controller request handler: '.__FILE__;
                    // ElettersControllerRequest
                }
                $this->request = new ElettersControllerRequest($this);
                return $this->request->handleRequest();
            break;
        }
        return true;
    }
    /**
     * @param (String) NULL or String(Key)- Null returns array, string returns value
     * @return (Mixed) Array/String
     */
    public function getConfig($key=NULL) {
        if ( empty($key) ) {
            return $this->config;
        }
        if ( isset($this->config[$key]) ) {
            return $this->config[$key];
        }
        return NULL;
    }
    /**
     * Set the debug value
     * @param (Boolean) $debug
     */
    public function setDebug($debug=TRUE) {
        $this->modx->log(modX::LOG_LEVEL_ERROR,'Eletters->setDebug() ');
        $this->config['debug'] = (boolean) $debug;
    }
    
    /**
     * process the queue and send out the eletters
     * 
     * @return (Boolean)
     */
    public function processQueue() {
        $sendLimit = $this->modx->getOption('eletters.batchSize', '', 15);
        $delay = $this->modx->getOption('eletters.delay', '', 5);// delay in seconds between each send
        // 1. select all newsletters that are ready to be sent out 
        $newsletters = $this->modx->getCollection('EletterNewsletters', array(
            'status' => 'approved',
            'add_date:<=' => date('Y-m-d H:i:a'),
            'finish_date' => NULL// if there is an end date then it is complete
        ));
        if ( $this->config['debug'] ) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'Eletters->processQueue() - Run date: '.date('Y-m-d H:i:a'));
        }
        foreach ($newsletters as $newsletter ) {
            if ( $this->config['debug'] ) {
                $this->modx->log(modX::LOG_LEVEL_ERROR,'Eletters->processQueue() -> newsletter->sendList() for '.$newsletter->get('id').' newsletter');
                $newsletter->setDebug();
            }
            $sendLimit -= $newsletter->sendList($sendLimit, $delay);
            if ( $sendLimit <= 0 ) {
                break;
            }
        }
        return true;
    }
    /**
     * Signup
     * @param (Array) $fields
     * @param (Int) $confirmPage
     * @param (Array) $options - emailTpl => '', emailSubject => '',emailFrom => '', emailFromName => ''
     * @return (Boolean)
     */
    public function signup($fields, $confirmPage, $options=array()) {
        /*if( !$this->checkUniqueEmail($fields['email']) ) {
            $this->errormsg[] = $this->modx->lexicon('eletters.subscribers.signup.err.emailunique');
            return false;
        }*/
        $subscriber = $this->modx->getObject('EletterSubscribers', array('email' => $fields['email']) );
        if ( !is_object($subscriber)) {
            // create the new subscriber
    		$subscriber = $this->modx->newObject('EletterSubscribers');
    		$subscriber->fromArray($fields);
    		$subscriber->set('code', md5( time().$fields['email'] ));
    		$subscriber->set('active', 0);
            $subscriber->set('date_created', date('Y-m-d H:i:s'));
            $subscriber->save();            
        }
            
        //now add subscriber to selected groups
        if( is_array($fields['group']) ) {
            foreach($fields['group'] as $groupID) {
                //$this->modx->log(modX::LOG_LEVEL_ERROR,'[Group ELetters->signup()] GroupID: '.$groupID);
                $group = $this->modx->getObject('EletterGroups', array('id'=>$groupID));
                if ( $group ) {
                    // $myGroup = $subscriber->getOne('Groups', array('group' => $groupID) );
                    $myGroup = $this->modx->getObject('EletterGroupSubscribers', array('group'=>$groupID,'subscriber'=> $subscriber->get('id')) );
                    if ( $myGroup ) {
                        // this already exists
                        //$this->modx->log(modX::LOG_LEVEL_ERROR,'[Group ELetters->signup()] Subscriber Exists for group ('.$subscriber->get('id') .') to GroupID: '.$groupID);
                        $myGroup->set('recieve_email', 'Y');
                        $myGroup->save();
                    } else {
                        // http://rtfm.modx.com/display/XPDO10/addOne
                        //$group->addOne($subscriber, 'Subscribers');
                        $GroupSubscribers = $this->modx->newObject('EletterGroupSubscribers');
                        $GroupSubscribers->set('group', $groupID);
                        $GroupSubscribers->set('subscriber', $subscriber->get('id'));
                        $GroupSubscribers->set('date_created', date('Y-m-d H:i:s'));
                        $GroupSubscribers->save();
                        //$group->addOne($GroupSubscribers, 'Subscribers');
                        //$group->save();
                        //$this->modx->log(modX::LOG_LEVEL_ERROR,'[Group ELetters->signup()] Add subscriber ('.$subscriber->get('id') .') to GroupID: '.$groupID);
                    }
                    
                    
                }
                /*
                //only allow public groups
                if( $this->modx->getCount('EletterGroups', array('id' => $group, 'public' => 1)) == 1 ) {
                    $GroupSubscribers = $this->modx->newObject('EletterGroupSubscribers');
                    $GroupSubscribers->set('group', $group);
                    $GroupSubscribers->set('subscriber', $subscriber->get('id'));
                    $GroupSubscribers->save();
                }
                */
            }
            // unset($GroupSubscribers);
        }

        //sent confirm message
        $emailProperties = $subscriber->toArray();
        $emailProperties['confirmUrl'] = $this->modx->makeUrl($confirmPage, '', array('s' => $subscriber->get('id'), 'c' => $subscriber->get('code') ), 'full');;
        
        $this->modx->getService('mail', 'mail.modPHPMailer');
        $this->modx->mail->set(modMail::MAIL_BODY, $this->modx->getChunk($options['emailTpl'], $emailProperties ));
        $this->modx->mail->set(modMail::MAIL_FROM, $options['emailFrom'] );
        $this->modx->mail->set(modMail::MAIL_FROM_NAME, $options['emailFromName'] );
        $this->modx->mail->set(modMail::MAIL_SUBJECT, $options['emailSubject']);
        $this->modx->mail->address('to', $subscriber->get('email') );
        $this->modx->mail->address('reply-to', $options['emailReplyTo'] );
        $this->modx->mail->setHTML(true);
        //$this->modx->log(modX::LOG_LEVEL_ERROR,'Eletters->Send Confirmation Error to '.$subscriber->get('email').' From: '.$options['emailFrom'] );
        
        if (!$this->modx->mail->send()) {
             $this->modx->log(modX::LOG_LEVEL_ERROR,'Eletters->Signup() - An error occurred while trying to send the confirmation email to '.$subscriber->get('email'));
        }
        $this->modx->mail->reset();
        
        return true;
	}
    
    /**
     * Checks if an email address is unique
     *
     * @access private
     * @param string $email The email address to check
     * @return boolean False if address already in use, true if address is not in use
     */
	private function checkUniqueEmail($email) {
		$c = $this->modx->newQuery('EletterSubscribers');
		$c->where( array('email' => $email) );

		if( $this->modx->getCount('EletterSubscribers', $c ) > 0) {
			return false;
		}
		return true;
    }

    /**
     * Checks code and activates subscriber
     * @access public
     * @return boolean true on activated, false on not found
     */
    public function confirmSignup() {
		if ( !isset($_GET['s']) || !isset($_GET['c']) ) {
            return false;
        }
        $subscriber = $this->modx->getObject('EletterSubscribers', array('id' => (int)$_GET['s'], 'code' => $_GET['c']) );
        if( $subscriber ) {
			$subscriber->set('active', 1);
			$subscriber->save();
			return true;
		}
		return false;
	}

    /**
     * Checks code and removes subscriber
     * @TODO rewrite this method to unsubscribe from all or individual groups
     * @access public
     * @return boolean true on removed, false on not found
     */
    public function unsubscribe() {
		//$subscriber = $this->modx->getObject('EletterSubscribers', (int)$_GET['s']);
        /**
         * Unsubscribe from all - remove or set as inactive?  
         *    Set as inactive that way can do stats on how many unsubscribe
         * Set each EletterGroupSubscriber receive_email column to N 
         */
        if ( !isset($_GET['s']) || !isset($_GET['c']) ) {
            return false;
        }
        $subscriber = $this->modx->getObject('EletterSubscribers', array('id' => (int)$_GET['s'], 'code' => $_GET['c']) );
        if ( $subscriber ) {
            $myGroups = $subscriber->getMany('Groups');
            //$this->modx->log(modX::LOG_LEVEL_ERROR,'[ELetters->unsubscribe()] Set to inactive: ('.$subscriber->get('id') .')' );
            foreach ($myGroups as $myGroup) {
                //$this->modx->log(modX::LOG_LEVEL_ERROR,'[ELetters->unsubscribe()] Removed Subscriber ('.$subscriber->get('id') .') from group: '.$myGroup->get('group'));
                $myGroup->set('receive_email', 'N');
                $myGroup->set('receive_sms', 'N');
                $myGroup->set('date_updated', date('Y-m-d H:i:s'));
                $myGroup->save();
            }
            $subscriber->set('active', 0);
            $subscriber->save();
            return true;
        }
        return false;
	}
    
    /**
     * Load Tracker:
     */
    public function loadTracker() {
        require_once 'elettertracking.class.php';
        $tracking = new EletterTracking($this->modx);
        return $tracking;
    }
    
    /**
     * Utility function, will return a checked="checked" for radio and checkboxes
     * @param mixed $input
     * @param mixed $value
     * @return string $output
     */
    public function isChecked($input, $option){
        $output = ' ';
        if ($input == $option) {
            $output = ' checked="checked"';
        }
        return $output;
    }
    /**
     * Gets a Chunk and caches it; also falls back to file-based templates
     * for easier debugging.
     *
     * @access public
     * @param string $name The name of the Chunk
     * @param array $properties The properties for the Chunk
     * @return string The processed content of the Chunk
     */
    public function getChunk($name,$properties = array()) {
        $chunk = null;
        if (!isset($this->chunks[$name])) {
            $chunk = $this->_getTplChunk($name);
            if (empty($chunk)) {
                $chunk = $this->modx->getObject('modChunk',array('name' => $name));
                if ($chunk == false) return false;
            }
            $this->chunks[$name] = $chunk->getContent();
        } else {
            $o = $this->chunks[$name];
            $chunk = $this->modx->newObject('modChunk');
            $chunk->setContent($o);
        }
        $chunk->setCacheable(false);
        return $chunk->process($properties);
    }
    /**
     * Returns a modChunk object from a template file.
     *
     * @access private
     * @param string $name The name of the Chunk. Will parse to name.$postfix
     * @param string $postfix The default postfix to search for chunks at.
     * @return modChunk/boolean Returns the modChunk object if found, otherwise
     * false.
     */
    private function _getTplChunk($name,$postfix = '.chunk.tpl') {
        $chunk = false;
        $f = $this->config['chunksPath'].strtolower($name).$postfix;
        if (file_exists($f)) {
            $o = file_get_contents($f);
            $chunk = $this->modx->newObject('modChunk');
            $chunk->set('name',$name);
            $chunk->setContent($o);
        }
        return $chunk;
    }
    
    /**************************
     * FORMIT EMail
     ****************************/
    /**
     * Send an Autoreply email, this can be a second email like a thank you for the note 
     * 
     * Based on formit->hooks->email: https://github.com/splittingred/FormIt/blob/develop/core/components/formit/model/formit/fihooks.class.php
     *
     * Properties:
     * - emailTpl - The chunk name of the chunk that will be the email template.
     * This will send the values of the form as placeholders.
     * - emailTo - A comma separated list of email addresses to send to
     * - emailToName - A comma separated list of names to pair with addresses.
     * - emailFrom - The From: email address. Defaults to either the email
     * field or the emailsender setting.
     * - emailFromName - The name of the From: user.
     * - emailSubject - The subject of the email.
     * - emailHtml - Boolean, if true, email will be in HTML mode.
     *
     * @access public
     * @param (FormIt) $formit
     * @param (Hook) $hook
     * @param (Array) $fields An array of cleaned POST fields
     * @param (Array) $default_properties - name=>value ex: for auto response form_address=fiarFrom
     * 
     * @return (Boolean) True if email was successfully sent.
     */
    public function formItAutoReply(&$formit, &$hook, array $fields = array(), array $default_properties=array() ) {
        /**
         * Set the properties that auto reply will use: http://rtfm.modx.com/display/ADDON/FormIt.Hooks.FormItAutoResponder
         */
        $property_names = array(
            // EletterName => Snippet Property Name
            'from_address' => 'fiarFrom',
            'from_name' => 'fiarFromName',
            'useSubjectField' => 'fiarUseFieldForSubject',// not used?
            'subject' => 'fiarSubject',
            'to_address_field' => 'fiarToField',// ToField - an actual form feild not a config value
            'to_address' => 'fiarTo',// New
            'to_name' => 'fiarToName',// not used
            'cc_address' => 'fiarCC',
            'cc_name' => 'fiarCCName',
            'bcc_address' => 'fiarBCC',
            'bcc_name' => 'fiarBCCName',
            'reply_to_address' => 'fiarReplyTo',
            'reply_to_name' => 'fiarReplyToName',
            'emailMultiSeparator' => 'fiarMultiSeparator',// not used
            'emailMultiWrapper' => 'fiarMultiWrapper', // not used
            'ishtml' => 'fiarHtml',
            'emailConvertNewlines' => 'fiarConvertNewlines', // not used
            'emailTpl' => 'fiarTpl',
            // unique to Eletters
            'NewsletterID' => 'fiarNewsletterID',
            'EResourceID' => 'fiarEResourceID',
            'useChunk' => 'fiarUseChunk',
            'uploads' => 'fiarUploads',
            'files' => 'fiarFiles',
            'log' => 'fiarLog'
        );
        // set the field to a config value if set for the ToField:
        if ( isset($fields[$property_names['to_address_field']]) ) {
            $formit->config[$property_names['to_address']] = $fields[$property_names['to_address_field']];
        }
        return $this->formItEmail($formit, $hook, $fields, $property_names);
    }
    
    /**
     * Send an email of the form. 
     * 
     * Based on formit->hooks->email: https://github.com/splittingred/FormIt/blob/develop/core/components/formit/model/formit/fihooks.class.php
     *
     * Properties:
     * - emailTpl - The chunk name of the chunk that will be the email template.
     * This will send the values of the form as placeholders.
     * - emailTo - A comma separated list of email addresses to send to
     * - emailToName - A comma separated list of names to pair with addresses.
     * - emailFrom - The From: email address. Defaults to either the email
     * field or the emailsender setting.
     * - emailFromName - The name of the From: user.
     * - emailSubject - The subject of the email.
     * - emailHtml - Boolean, if true, email will be in HTML mode.
     *
     * @access public
     * @param (FormIt) $formit
     * @param (Hook) $hook
     * @param (Array) $fields An array of cleaned POST fields
     * @param (Array) $default_properties - name=>value ex: for auto response form_address=fiarFrom
     * 
     * @return (Boolean) True if email was successfully sent.
     */
    public function formItEmail(&$formit, &$hook, array $fields = array(), array $default_properties=array() ) {
        // these are set via the snippet call:
        $property_names = array(
            // EletterName => Snippet Property Name
            'from_address' => 'emailFrom',
            'from_name' => 'emailFromName',
            'useSubjectField' => 'emailUseFieldForSubject',
            'subject' => 'emailSubject',
            'to_address' => 'emailTo',
            'to_name' => 'emailToName',
            'cc_address' => 'emailCC',
            'cc_name' => 'emailCCName',
            'bcc_address' => 'emailBCC',
            'bcc_name' => 'emailBCCName',
            'reply_to_address' => 'emailReplyTo',
            'reply_to_name' => 'emailReplyToName',
            'emailMultiSeparator' => 'emailMultiSeparator',
            'emailMultiWrapper' => 'emailMultiWrapper',
            'ishtml' => 'emailHtml',
            'emailConvertNewlines' => 'emailConvertNewlines',
            'emailTpl' => 'emailTpl',
            // unique to Eletters
            'NewsletterID' => 'emailNewsletterID',
            'EResourceID' => 'emailResourceID',
            'useChunk' => 'emailUseChunk',
            'uploads' => 'emailUploads',
            'files' => 'emailFiles',
            'log' => 'emailLog'
        );
        $property_names = array_merge($property_names, $default_properties);
        
        // the actual property values
        $property_values = array(
            // EletterPropertyName => Value
            'from_address' => '',
            'from_name' => '',
            'useSubjectField' => TRUE,
            'subject' => '',
            'to_address' => '',
            'to_name' => '',
            'cc_address' => '',
            'cc_name' => '',
            'bcc_address' => '',
            'bcc_name' => '',
            'reply_to_address' => '',
            'reply_to_name' => '',
            'emailMultiSeparator' => "\n",
            'emailMultiWrapper' => "[[+value]]",
            'ishtml' => TRUE,
            'emailConvertNewlines' => FALSE,
            'emailTpl' => '',
            // unique to Eletters
            'NewsletterID' => '',
            'EResourceID' => '',
            'useChunk' => FALSE,
            'uploads' => TRUE,
            'files' => TRUE,
            'log' => TRUE
        );
        
        //$this->config['debug'] = TRUE;
        
        $attachments = array();
        if ( isset($formit->config[$property_names['useChunk']]) && !empty($formit->config[$property_names['useChunk']]) ) {
            $tpl = $this->modx->getOption($property_names['emailTpl'], $formit->config, '');
        } else {
            // Get Newsletter and fill default values:
            
            $c = array('id' => 0);
            if ( isset($formit->config[$property_names['NewsletterID']]) && !empty($formit->config[ $property_names['NewsletterID']]) ) {
                $c = array('id' => $formit->config[ $property_names['NewsletterID']]);
            } else if (isset($formit->config[ $property_names['EResourceID']]) && !empty($formit->config[$property_names['EResourceID']]) ) {
                $c = array('resource' => $formit->config[$property_names['EResourceID']]);
            }
            if ( $this->config['debug'] ) {
                $this->modx->log(modX::LOG_LEVEL_ERROR,'[Eletters->PRE loadNewsletter] Newsletter loaded: '.print_r($c, TRUE));
            }
            if( !$this->_loadNewsletter($c, $property_values, $attachments) ) {
                $hook->errors['emailTo'] = $this->modx->lexicon('formit.email_no_recipient');
                return FALSE;
            }
        }
        
        foreach ( $property_names as $property => $name ) {
            // $property_values['ishtml'] = (boolean)$this->modx->getOption($property_names['ishtml'], $formit->config, $property_values['ishtml']);
            switch ($property) {
                case 'ishtml':
                case 'emailConvertNewlines':
                case 'useSubjectField':
                case 'useChunk':
                case 'uploads':
                case 'files':
                case 'log':
                    // force boolean:
                    $property_values[$property] = (boolean)$this->modx->getOption($name, $formit->config, $property_values[$property]);
                    break;
                default:
                    $property_values[$property] = $this->modx->getOption($name, $formit->config, $property_values[$property]);
                    break;
            }
        }
        
        /* get from name */
        // $property_values['from_address'] = $this->modx->getOption($property_names['from_address'], $formit->config, $property_values['from_address']);
        if (empty($property_values['from_address'])) {
            $property_values['from_address'] = !empty($fields['email']) ? $fields['email'] : $this->modx->getOption('emailsender');
        }
        if (empty($property_values['from_name'])) {
            $property_values['from_name'] = $property_values['from_address'];
        }
        /* get subject */
        if (!empty($fields['subject']) && $property_values['useSubjectField']) {
            $property_values['subject'] = $fields['subject'];
        }
        
        /* check email to */
        if (empty($property_values['to_address'])) {
            $hook->errors['emailTo'] = $this->modx->lexicon('formit.email_no_recipient');
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[Eletters->FormItEmail] '.$this->modx->lexicon('formit.email_no_recipient'));
            return false;
        }
        
        if ( $this->config['debug'] ) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[Eletters->Checked TO] ');
        }
        /* reply to */
        if (empty($property_values['reply_to_address'])) {
            $property_values['reply_to_address'] = $property_values['from_address'];
        }
        if (empty($property_values['reply_to_name'])) {
            $property_values['reply_to_name'] = $property_values['from_name'];
        }
        
        /* compile message */
        $origFields = $fields;
        if ( empty($tpl) && $property_values['useChunk'] ) {
            /**
             * Make plain email in name => value format
             */
            $tpl = 'email';
            $f = '';

            foreach ($fields as $k => $v) {
                if ($k == 'nospam') continue;
                if (is_array($v) && !empty($v['name']) && isset($v['error']) && $v['error'] == UPLOAD_ERR_OK) {
                    $attachments['uploads'][$k] = $v;
                    $v = $v['name'];
                    $f[$k] = '<strong>'.$k.'</strong>: '.$v.'<br />';
                } else if (is_array($v)) {
                    $vOpts = array();
                    foreach ($v as $vKey => $vValue) {
                        if (is_string($vKey) && !empty($vKey)) {
                            $vKey = $k.'.'.$vKey;
                            $f[$vKey] = '<strong>'.$vKey.'</strong>: '.$vValue.'<br />';
                        } else {
                            $vOpts[] = str_replace('[[+value]]',$vValue,$property_values['emailMultiWrapper']);
                        }
                    }
                    $newValue = implode($property_values['emailMultiSeparator'],$vOpts);
                    if (!empty($vOpts)) {
                        $f[$k] = '<strong>'.$k.'</strong>:'.$newValue;
                    }
                } else {
                    $f[$k] = '<strong>'.$k.'</strong>: '.$v.'<br />';
                }
            }
            $fields['fields'] = implode("\n",$f);
        } else {
            /* handle file/checkboxes in email tpl */
            if (empty($property_values['emailMultiSeparator']) || $property_values['emailMultiSeparator'] == '\n' ) {/* allow for inputted newlines */
                $property_values['emailMultiSeparator'] = "\n";
            }
            if (empty($property_values['emailMultiWrapper'])) {
                $property_values['emailMultiWrapper'] = '[[+value]]';
            }
            
            foreach ($fields as $k => &$v) {
                if (is_array($v) && !empty($v['name']) && isset($v['error']) && $v['error'] == UPLOAD_ERR_OK) {
                    $attachments['uploads'][$k] = $v; 
                    $v = $v['name'];
                } else if (is_array($v)) {
                    $vOpts = array();
                    foreach ($v as $vKey => $vValue) {
                        if (is_string($vKey) && !empty($vKey)) {
                            $vKey = $k.'.'.$vKey;
                            $fields[$vKey] = $vValue;
                            unset($fields[$k]);
                        } else {
                            $vOpts[] = str_replace('[[+value]]',$vValue,$property_values['emailMultiWrapper']);
                        }
                    }
                    $v = implode($property_values['emailMultiSeparator'],$vOpts);
                }
            }
        }
        /**
         * Process all options - fill any open placeholders
         */
        foreach ( $property_values as $n => $v ) {
            $property_values[$n] = $hook->_process($v, $fields);
        }
        
        if ( $property_values['useChunk'] ) {
            $property_values['message'] = $formit->getChunk($tpl, $fields);
            $property_values['message'] = $hook->_process($property_values['message'], $hook->config);
            
            if ( $property_values['ishtml'] && $property_values['emailConvertNewlines'] ) {
                $property_values['message'] = nl2br($property_values['message']);
            }
        }
        $fields = array_merge($hook->config, $fields);
                
        if ( $this->config['debug'] ) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[Eletters->Call on _sendMail] ');
        }
        // sent email:
        $sent = $this->_sendMail($property_values, $fields, $attachments,  $property_values['log'] );
        
        if ( !$sent ) {
            $hook->errors[] = $this->modx->lexicon('formit.email_not_sent').' '.print_r($this->sendError, true);
        } 
        
        return $sent;
    }

    /**
     * 
     * @param (Array) $options  - name=>value ex: for auto response form_address=Fname Lname
     *              'from_address' => '',
                    'from_name' => '',
                    'to_address' => '',
                    'to_name' => '',
                    'cc_address' => '',
                    'cc_name' => '',
                    'bcc_address' => '',
                    'bcc_name' => '',
                    'reply_to_address' => '',
                    'reply_to_name' => '',
                    'ishtml' => TRUE,
                    'NewsletterID' => '',
                    'EResourceID' => '',
                    'uploads' => TRUE,
                    'files' => TRUE,
     * @param (Array) $placeholders - MODX placehoders -name=>value
     * @param (Boolean) $log - TRUE will save completed email to DB
     * @param (Array) $attachments - add addtional attachments
     * @return (Boolean)
     */
    public function sendResponse($options, $placeholders, $log=TRUE, $attachments=array()) {
        // the actual property values
        $default_options = array(
            // EletterPropertyName => Value
            'from_address' => '',
            'from_name' => '',
            'to_address' => '',
            'to_name' => '',
            'cc_address' => '',
            'cc_name' => '',
            'bcc_address' => '',
            'bcc_name' => '',
            'reply_to_address' => '',
            'reply_to_name' => '',
            'ishtml' => TRUE,
            'NewsletterID' => '',
            'EResourceID' => '',
            'uploads' => TRUE,
            'files' => TRUE,
            //'category' => '',
        );
        $options = array_merge($default_options, $options);
        
        $c = array('id' => 0);
        if ( isset($options['NewsletterID']) && !empty($options['NewsletterID']) ) {
            $c = array('id' => $options['NewsletterID']);
        } else if (isset($options['EResourceID']) && !empty($options['EResourceID']) ) {
            $c = array('resource' => $options['EResourceID']);
        }
        
        $this->_loadNewsletter($c, $options, $attachments);
        
        return $this->_sendMail($options, $placeholders, $attachments, $log);
    }
    
    /**
     * Load the newsletter and sets some default properties
     * 
     * @param (Mixed int|array) $criteria
     * @param (Array) $properties
     * @param (Array) $attachments
     * 
     */
    protected function _loadNewsletter($criteria, &$properties, &$attachments) {
        // Get Newsletter and fill default values:
        $this->newsletter = $this->modx->getObject('EletterNewsletters', $criteria);
        if ( !is_object($this->newsletter) ) {
            // Error!
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[Eletters->loadNewsletter] could not find newsletter for '.print_r($criteria,TRUE));
            return false;
        }
        
        if ( $this->config['debug'] ) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[Eletters->loadNewsletter] Newsletter loaded: '.$this->newsletter->get('id') );
            $this->newsletter->setDebug();
        }
        $properties['subject'] = $this->newsletter->get('subject');
        $properties['from_address'] = $this->newsletter->get('from');
        $properties['from_name'] = $this->newsletter->get('from_name');
        $properties['reply_to_address'] = $this->newsletter->get('reply_to');
        // add any attachments
        // @TODO Review:
        if ( isset($attachments['files']) ) {
            $attachments['files'] = array_merge(json_decode($this->newsletter->get('attachments'), true), $attachments['files']);
        } else {
            $attachments['files'] = json_decode($this->newsletter->get('attachments'), true);
        }
        // $properties['message'] = $this->newsletter->getELetter($fields);
        return TRUE;
    }
    
    /**
     * 
     * @param (Array) $options - name=>value
     * @param (Array) $attachments - uploads=>$_FILES, files =>array( path/filename, ..)
     * @param (Boolean) $logEmail
     * @return (Boolean) 
     */
    protected function _sendMail($options, $placeholders=array(), $attachments=array(), $logEmail=true) {
        if ( !isset($placeholders['current_year']) ) {
            $placeholders['current_year'] = date('Y');
        }
        if ( $this->config['debug'] ) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[Eletters->_sendMail] Start ');
        }
        // process subject:
        $chunk = $this->modx->newObject('modChunk');
        $chunk->setContent($options['subject']);
        $options['subject'] = $chunk->process($placeholders);
        // save email:
        if ( $logEmail ) {
            $log = $this->modx->newObject('EletterLog');
            $log->fromArray($options);
            //$log->set('ecode', md5( microtime(true)));
            $log->set('create_date', date('Y-m-d H:i:s'));
            $log->set('sender_ip', rtrim($_SERVER['REMOTE_ADDR']));
            $log->set('sender_pc_name', gethostbyaddr(rtrim($_SERVER['REMOTE_ADDR'])));
            if ( is_object($this->newsletter) ) {
                $log->set('newsletter', $this->newsletter->get('id'));
            }
            if ( isset($options['category']) ) {
                $log->set('category', substr($options['category'], 0, 60) );
            }
            $log->set('form_url', $_SERVER['REQUEST_URI']);
            // $log->set('referal_url', 0);
            // modx user
            if ( $this->modx->user->isAuthenticated($this->modx->context->get('key')) ) {
                $log->set('user_id', $this->modx->user->get('id'));
                $log->set('verified', 'Y');
            } elseif ( isset($placeholders['modx_user_id']) ) {
                $log->set('user_id', $placeholders['modx_user_id']);
                $log->set('verified', 'Y');
            }
            if ( isset($placeholders['crm_id']) ) {
                $log->set('crm_id', $placeholders['crm_id']);
            }
            $saved = $log->save();
            
            if ( $this->config['debug'] ) {
                $this->modx->log(modX::LOG_LEVEL_ERROR,'[Eletters->_sendMail] Load log email: '.$log->get('id') );
            }
        }
        
        if ( (!isset($options['useChunk']) || !$options['useChunk']) && is_object($this->newsletter) ) {
            // Get the Newsletter body:
            if ( $logEmail ){
                $placeholders['ecode'] = md5( microtime(true) + $log->get('id') );
                $placeholders['lid'] = $log->get('id');
            }
            
            $placeholders = array_merge($options, $placeholders);
            
            $options['message'] = $this->newsletter->getELetter($placeholders);
            $options['text_message'] = strip_tags($options['message']);
            
            if ( $logEmail ){
                $log->set('message', $options['message']);
                $log->set('text_message', $options['text_message']);
                $log->set('ecode', $placeholders['ecode']);
                $saved = $log->save();
            }
        }
        
        /* load mail service */
        $this->modx->getService('mail', 'mail.modPHPMailer');

        /* set HTML */
        $this->modx->mail->setHTML($options['ishtml']);

        /* set email main properties */
        $this->modx->mail->set(modMail::MAIL_BODY, $options['message']);
        $this->modx->mail->set(modMail::MAIL_BODY_TEXT, $options['text_message']);
        $this->modx->mail->set(modMail::MAIL_FROM, $options['from_address']);
        $this->modx->mail->set(modMail::MAIL_FROM_NAME, $options['from_name']);
        $this->modx->mail->set(modMail::MAIL_SENDER, $options['from_address']);
        $this->modx->mail->set(modMail::MAIL_SUBJECT, $options['subject']);
        
        /* handle file fields uploads */
        if ( $options['uploads'] && isset($attachments['uploads']) ){
            foreach ($attachments['uploads'] as $k => $v) {
                $attachmentIndex = 0;
                if (is_array($v) && !empty($v['tmp_name']) && isset($v['error']) && $v['error'] == UPLOAD_ERR_OK) {
                    if (empty($v['name'])) {
                        $v['name'] = 'attachment'.$attachmentIndex;
                    }
                    $this->modx->mail->mailer->AddAttachment($v['tmp_name'],$v['name'],'base64',!empty($v['type']) ? $v['type'] : 'application/octet-stream');
                    $attachmentIndex++;
                }
            }
        }
        // Newsletter attachments:
        if ( $options['files'] && isset($attachments['files']) ){
            // $attachments = json_decode($this->get('attachments'));
            foreach ( $attachments['files'] as $attachment ) {
                if ( file_exists(MODX_BASE_PATH.DIRECTORY_SEPARATOR.$attachment) ) {
                    $this->modx->mail->attach(MODX_BASE_PATH.DIRECTORY_SEPARATOR.$attachment);
                } elseif( file_exists($attachment) ) {
                    // @TODO Review this:
                    $this->modx->mail->attach($attachment);
                }
            }
            
            if (!empty($options['reply_to_address'])) {
                $this->modx->mail->address('reply-to', $options['reply_to_address'], $options['reply_to_name']);
            }
        }
        /**
         * Addresses:
         */
        $this->_multiAddress($options['to_address'], $options['to_name'], 'to');
        
        /* cc */
        $this->_multiAddress($options['cc_address'], $options['cc_name'], 'cc');
        
        /* bcc */
        $this->_multiAddress($options['bcc_address'], $options['bcc_name'], 'bcc');
        
        /* send email */
        if ( $this->config['debug'] ) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[Eletters->_sendMail] Sending... ');
        }
        //if (!$formit->inTestMode) {
            $sent = $this->modx->mail->send();
        //} else {
            //$sent = true;
        //}
        
        if (!$sent) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[Eletters->_sendMail] '.$this->modx->lexicon('formit.email_not_sent').' - '.$options['to_address'].' -  '.print_r($this->modx->mail->mailer->ErrorInfo,true));
            $this->sendError = $this->modx->mail->mailer->ErrorInfo;
        } else if ( $this->config['debug'] ) {
            //$this->modx->log(modX::LOG_LEVEL_ERROR,'[Eletters->_sendMail] Mail has been sent to: '.$options['to_address']);
        }
        $this->modx->mail->reset(array(
            modMail::MAIL_CHARSET => $this->modx->getOption('mail_charset',null,'UTF-8'),
            modMail::MAIL_ENCODING => $this->modx->getOption('mail_encoding',null,'8bit'),
        ));
        // $this->modx->mail->reset();
        
        // save status/error:
        if ( $logEmail ) {
            $log->set('status', ( $sent ? 'Delivered': 'Failed') );
            $log->save();
        }
        
        return $sent;
    }
        
    /**
     * Add all address to $mail
     * @param (Mixed) $emails
     * @param (mixed) $names
     * @param (String) $type - to, cc, bcc
     * @return Void
     */
    protected function _multiAddress($emails, $names, $type) {
        /* add to: with support for multiple addresses */
        $emails = explode(',', $emails);
        $names = explode(',', $names);
        $num_addresses = count($emails);
        
        for ( $i=0; $i < $num_addresses; $i++ ) {
            if ( empty($emails[$i]) ) {
                continue;
            }
            if ( isset($names[$i]) && !empty($names[$i]) ) {
                //$etn = $hook->_process($etn,$fields);
            } else {
                $names[$i] = '';
            }
            //$emails[$i] = $hook->_process($emails[$i], $fields);
            $this->modx->mail->address('to',$emails[$i], $names[$i]);
        }
    }
    
    /**
     * 
     * Simple function that returns the logged message of the email
     * 
     * @param (Int) $id - the id of the emaillog
     * @param (String) $ecode - md5 uniquely coded value 
     * 
     * @return (Mixed) False on error and email message on success
     */
    public function getLogEmail($id, $ecode) {
        $email = $this->modx->getObject('EletterLog', array('id' => $id, 'ecode' => $ecode) );
        if ( !is_object($email) ) {
            if ( $this->config['debug'] ) {
                $this->modx->log(modX::LOG_LEVEL_ERROR,'[Eletters->getLogEmail] Could not find email log with ID: '.$id.' and ecode: '.$ecode );
            }
            return false;
        }
        if ( $this->config['debug'] ) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[Eletters->getLogEmail] Loaded email log with ID: '.$id.' and ecode: '.$ecode );
        }
        return $email->get('message');
    }
     
}
