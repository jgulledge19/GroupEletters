<?php
/**
 * @package groupEletters
 */
class GroupEletters {
    /**
     * Constructs the groupEletters object
     *
     * @param modX &$modx A reference to the modX object
     * @param array $config An array of configuration options
     */
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;

        $basePath = $this->modx->getOption('groupeletters.core_path',$config,$this->modx->getOption('core_path').'components/groupeletters/');
        $assetsUrl = $this->modx->getOption('groupeletters.assets_url',$config,$this->modx->getOption('assets_url').'components/groupeletters/');

        $this->config = array_merge(array(
            'basePath' => $basePath,
            'corePath' => $basePath,
            'modelPath' => $basePath.'model/',
            'processorsPath' => $basePath.'processors/',
            'chunksPath' => $basePath.'elements/chunks/',
            'jsUrl' => $assetsUrl.'js/',
            'cssUrl' => $assetsUrl.'css/',
            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $assetsUrl.'connector.php',
        ),$config);

        $this->modx->addPackage('groupeletters',$this->config['modelPath']);

        $this->modx->lexicon->load('groupEletters:default');
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
                if (!$this->modx->loadClass('GroupElettersControllerRequest',$this->config['modelPath'].'groupeletters/request/',true,true)) {
                    return 'Could not load controller request handler.';
                }
                $this->request = new groupElettersControllerRequest($this);
                return $this->request->handleRequest();
            break;
        }
        return true;
    }
    // @TODO remove this method?
    //Sets placeholders of newsletter template
    public function setPlaceholders($scriptProperties) {

        $placeholderTags = array(
            'firstname'     => $this->modx->getOption('firstnameTag', $scriptProperties, 'firstname'),
            'lastname'      => $this->modx->getOption('lastnameTag', $scriptProperties, 'lastname'),
            'fullname'      => $this->modx->getOption('fullnameTag', $scriptProperties, 'fullname'),
            'company'       => $this->modx->getOption('companyTag', $scriptProperties, 'company'),
            'email'         => $this->modx->getOption('emailTag', $scriptProperties, 'email'),
            'unsubscribe'   => $this->modx->getOption('unsubscribeTag', $scriptProperties, 'unsubscribe')
        );

        //change standard placeholders to entities ([[ to &#91;&#91; and ]] to &#93;&#93;), including default value
        if($_GET['sending']) {
            $this->modx->setPlaceholders(array(
                $placeholderTags['firstname'] => '&#91;&#91;+firstname:default=`'.$this->modx->getOption('firstnameDefault', $scriptProperties, '').'`&#93;&#93;',
                $placeholderTags['lastname'] => '&#91;&#91;+lastname:default=`'.$this->modx->getOption('lastnameDefault', $scriptProperties, '').'`&#93;&#93;',
                $placeholderTags['fullname'] => '&#91;&#91;+fullname:default=`'.$this->modx->getOption('fullnameDefault', $scriptProperties, '').'`&#93;&#93;',
                $placeholderTags['company'] => '&#91;&#91;+company:default=`'.$this->modx->getOption('companyDefault', $scriptProperties, '').'`&#93;&#93;',
                $placeholderTags['email'] => '&#91;&#91;+email:default=`'.$this->modx->getOption('emailDefault', $scriptProperties, '').'`&#93;&#93;'
            ));
        }
        else {
            $this->modx->setPlaceholders(array(
                $placeholderTags['firstname'] => $this->modx->getOption('firstnameDefault', $scriptProperties, ''),
                $placeholderTags['lastname'] => $this->modx->getOption('lastnameDefault', $scriptProperties, ''),
                $placeholderTags['fullname'] => $this->modx->getOption('fullnameDefault', $scriptProperties, ''),
                $placeholderTags['company'] => $this->modx->getOption('companyDefault', $scriptProperties, ''),
                $placeholderTags['email'] => $this->modx->getOption('emailDefault', $scriptProperties, '')
            ));
        }
    }
    /**
     * process the queue and send out the eletters
     * 
     * @return void
     */
    public function processQueue() {
        $sendLimit = 15;
        $delay = 5;// delay in seconds between each send
        // 1. select all newsletters that ready to be sent out 
        $newsletters = $modx->getColletion('EletterNewsletters', array(
            'status' => 'approved',
            'start_date:>=' => date('Y-m-d g:i:a'),
            'end_date' => NULL// if there is an end date then it is complete
        ));
        // 
        foreach ($newsletters as $newsletter ) {
            $limit -= $newsletter->sendList($limit, $delay);
            if ( $limit <= 0 ) {
                continue;
            }
        }
    }
    /**
     * Signup
     * @param (Array) $fields
     * @param (Int) $confirmPage
     * @return (Boolean)
     */
    public function signup($fields, $confirmPage=0) {
        if( !$this->checkUniqueEmail($fields['email']) ) {
            $this->errormsg[] = $this->modx->lexicon('groupeletters.subscribers.signup.err.emailunique');
            return false;
        }

		$subscriber = $this->modx->newObject('EletterSubscribers');
		$subscriber->fromArray($fields);
		$subscriber->set('code', md5( time().$fields['first_name'].$fields['last_name'] ));
		$subscriber->set('active', 0);
        $subscriber->set('signupdate', time());
        $subscriber->save();

        //add subscriber to selected groups
        if( is_array($fields['groups']) ) {
            foreach($fields['groups'] as $group) {
                //only allow public groups
                if( $this->modx->getCount('EletterGroups', array('id' => $group, 'public' => 1)) == 1 ) {
                    $GroupSubscribers = $this->modx->newObject('EletterGroupSubscribers');
                    $GroupSubscribers->set('group', $group);
                    $GroupSubscribers->set('subscriber', $subscriber->get('id'));
                    $GroupSubscribers->save();
                }
            }
            unset($GroupSubscribers);
        }

        //sent confirm message
        $confirmUrl =  $this->modx->makeUrl($confirmPage, '', '?s='.$subscriber->get('id').'&amp;c='.$subscriber->get('code'), 'full');
        // @TODO the chunk should be allowed to be choosen:
        $message = $this->modx->getChunk('GroupElettersSignupMail', array('confirmUrl' => $confirmUrl, 'first_name' => $subscriber->get('first_name'), 'last_name' => $subscriber->get('last_name')));

        $this->modx->getService('mail', 'mail.modPHPMailer');
        $this->modx->mail->set(modMail::MAIL_BODY, $message);
        $this->modx->mail->set(modMail::MAIL_FROM, $settings->get('email') );
        $this->modx->mail->set(modMail::MAIL_FROM_NAME, $settings->get('name') );
        $this->modx->mail->set(modMail::MAIL_SENDER, $settings->get('name') );
        $this->modx->mail->set(modMail::MAIL_SUBJECT, $this->modx->lexicon('groupeletters.subscribers.confirm.subject'));
        $this->modx->mail->address('to', $subscriber->get('email') );
        $this->modx->mail->address('reply-to', $settings->get('email') );
        $this->modx->mail->setHTML(true);
        if (!$this->modx->mail->send()) {
             $this->modx->log(modX::LOG_LEVEL_ERROR,'An error occurred while trying to send the confirmation email to '.$subscriber->get('email'));
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
		} else{
			return true;
	   }
    }

    /**
     * Checks code and activates subscriber
     * @access public
     * @return boolean true on activated, false on not found
     */
    public function confirmSignup() {
		$subscriber = $this->modx->getObject('EletterSubscribers', (int)$_GET['s']);

		if( $subscriber && $subscriber->get('code') == $_GET['c'] ) {
			$subscriber->set('active', 1);
			$subscriber->save();
			return true;
		} else {
			return false;
		}
	}

    /**
     * Checks code and removes subscriber
     * @TODO rewrite this method to unsubscribe from one group or more groups not to remove(delete) a subscriber
     * @access public
     * @return boolean true on removed, false on not found
     */
    public function unsubscribe() {
		$subscriber = $this->modx->getObject('EletterSubscribers', (int)$_GET['s']);

		if( $subscriber && $subscriber->get('code') == $_GET['c'] ) {
			$subscriber->remove();
			return true;
		} else {
			return false;
		}
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
}