<?php

/**
 * 
 */
class EletterTracking {
	
	/**
     * A reference to the modX instance
     * @var modX $modx
     */
    public $modx;
    
    /**
     * @param (Boolean) $debug
     */
    public $debug = FALSE;
    
    /**
     * Constructs the EletterTracking object
     *
     * @param modX &$modx A reference to the modX object
     */
    function __construct(modX &$modx ) {
        $this->modx =& $modx;
		
	}
    /**
     * Load all existing URLs for current newsletter
     */
    /**
     * Create the URL
     * @param (String) $html
     * @return (String) $html - processed
     */
    public function makeTrackingUrls ($html, $newsletter) {
        // 1. get all existing tracking URLs for current newsletter:
        $savedList = $this->modx->getCollection('EletterLinks', array('newsletter' => $newsletter->get('id') ) );
        $this->created_urls = array();
        foreach ( $savedList as $aLink ) {
            $tmp = $aLink->toArray();
            $this->created_urls[$tmp['url']] = $tmp['id'];
        }
        
        // 2. Convert all links to /tiny/Link id(base 64)/Person ID(base 64?) -> email_links
        $link_list = explode("<a ",$html);
        $tracking_email = NULL;
        
        foreach ($link_list as $line ) {
            // get the first occurance of href
            $position = strpos($line, 'href="');
            if ( $position === false ) {
                // no link:
                $tracking_email .= $line;
                continue;
            }
            $before = substr($line, 0, $position );
            $line = substr($line, ($position+6) );// remove the href=" and everything before it
            $end_quote_position = strpos($line, '"');// get the postion of the next " 
            $after = substr($line, ($end_quote_position+1) );
            $href = substr($line, 0, $end_quote_position );
            
            // strpos($href, 'http') !== false
            if ( strpos($href, 'mailto:') === false  && strpos($href, '[[') === false ) {
            
            } else {
                // mailto link:
                $tracking_email .= '<a '.$line;
                continue;
            }
            // now reconstruct the link_str:
            $tracking_email .= '<a '.$before.' href="'.$this->makeUrl($href, $newsletter->get('id')).'"'.$after;
        }
        if ( empty($tracking_email) ) {
            $tracking_email = $html;
        }
        return $tracking_email;
    }
    /**
     * Create the URLs
     * @param (STring) $url
     * @param (Int) $newsletter
     * @param (string) $type - click or image
     * 
     * @return (String) $url - the tracking URL
     */
    public function makeUrl ($url,$newsletter, $type='click') {
        if ( empty($this->created_urls[$url]) ){
            $link = $this->modx->newObject('EletterLinks');
            $link->set('url',$url);
            $link->set('newsletter', $newsletter);
            $link->set('type',$type);
            $link->save();
            
            $this->created_urls[$url] = $link->get('id');
            if ( $this->debug ){
                $this->modx->log(modX::LOG_LEVEL_ERROR,'EletterNewsletter->makeUrl() - LinkID: '.$link->get('id').' URL: '.$url );
            }
        }
        if ( $type == 'image' ){
            $url = $this->modx->getOption('site_url').$this->modx->getOption('assets_url').'components/groupeletters/?t='.base_convert($this->created_urls[$url],10,36).'|[[+code]]&amp;';
        } else {
            $url = $this->modx->makeUrl($this->modx->getOption('groupeletters.trackingPageID', '', 1),'', array('t' => base_convert($this->created_urls[$url],10,36).'|[[+code]]'), 'http');
        } 
        return str_replace('https://', 'http://', $url);
    }
    /**
     * Record and redirect the URLs
     * @param (String) $type - click or image, click will redirect and image will send back an image
     * @return (Void)
     */
    public function logAction($type='click') {
        $t = $code = $link_id = 0;
        if ( !isset($_REQUEST['t']) && $type == 'click' ) {
            // return and do nothing
            return;
        } else if ( isset($_REQUEST['t']) ) {
            list($t, $code ) = explode('|',$_REQUEST['t'], 2 );
            $link_id = base_convert($t, 36, 10);
        }
        
        if ( $this->debug ){
            $this->modx->log(modX::LOG_LEVEL_ERROR,'EletterNewsletter->logAction() - LinkID: '.$link_id.' type: '.$type );
        }
        
        if ( is_numeric($link_id) ) {
            // get the link:
            $conditions = array('id' => $link_id, 'type' => $type );
            $link = $this->modx->getObject('EletterLinks', $conditions );
            
            if ( is_object($link) ) {
                $placeholders = array();
                // get the subscriber:
                $subscriber = $this->modx->getObject('EletterSubscribers', array('code' => $code) );
                if ( is_object($subscriber) ){
                    // log the click:
                    $click = $this->modx->getObject('EletterSubscriberHits', array('link' => $link_id, 'subscriber' => $subscriber->get('id')));
                    if ( is_object($click) ) {
                        // it all ready has been recorded:
                        $click->set('view_total', $click->get('view_total')+1);
                    } else {
                        $click = $this->modx->newObject('EletterSubscriberHits');
                        $data = array(
                                'newsletter' => $link->get('newsletter'),
                                'subscriber' => $subscriber->get('id'),
                                'link' => $link_id,
                                'hit_type' => $type,
                                'hit_date' => date('Y-m-d H:i:s'),
                                'view_total' => 1,
                            );
                        $click->fromArray(
                            $data
                        );
                    }
                    $click->save();
                    $placeholders = $subscriber->toArray();
                }
                
                // set cookies?
                
                if ( $type == 'click' ) {
                    // set all info and process the string:
                    $chunk = $this->modx->newObject('modChunk');
                    $chunk->setContent($link->get('url'));
                    $url = $chunk->process($placeholders);
                    $this->modx->sendRedirect($url);
                }
            }
        }

        if ( $type == 'image') {
            // show the image:
            $display_name = 'clear';
            if ( isset($_GET['image']) ) {
                $filename = $display_name = $_GET['image'];
                $filename = str_replace(array('../', './', '%2F','.php', '.inc', chr(0)), '', $filename);
                $filename = MODX_ASSETS_PATH.'components'.DIRECTORY_SEPARATOR.'groupeletters'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$filename;
                if ( !file_exists($filename) ) {
                    $filename = 'clear.gif';
                }
            } else {
                $filename = MODX_ASSETS_PATH.'components'.DIRECTORY_SEPARATOR.'groupeletters'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'clear.gif';
            }
            
            $filesize = filesize($filename);
            
            # get the type of file
            $file_ext = substr($filename, strripos($filename, '.')+1 );
            
            $mime = '';
            switch ($file_ext) {
                case 'jpeg':
                case 'jpg':
                    $mime = 'image/jpeg';
                    break;
                case 'png':
                    $mime = 'image/png';
                    break;
                case 'tif':
                case 'tiff':
                    $mime = 'image/tiff';
                    break;
                case 'gif':
                default:
                    $mime = 'image/gif';
                    break;
            }
            
            /** 
            header_remove("Pragma");
            header_remove("Cache-Control");
            header_remove("Expires");
            header_remove("Set-Cookie");
            */
            header("Content-type: " . $mime );//.$mime_type );
            header("Content-length: ".$filesize);
            //header("Content-Transfer-Encoding: binary");
            //header('Accept-Ranges: bytes');
            
            /* Read It */
            $handle = fopen($filename, "rb");
            $contents = fread($handle, $filesize);
            fclose($handle);
            
            //$this->modx->log(modX::LOG_LEVEL_ERROR,'EletterNewsletter->logAction() headers: '. print_r(headers_list(),TRUE) );
            /* Print It */
            echo $contents;
            // $this->modx->log(modX::LOG_LEVEL_ERROR,'EletterNewsletter->logAction() filename: '.$filename );
            //exit;

        }
    }
    
    
}
