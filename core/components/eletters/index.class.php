<?php
require_once dirname(__FILE__) . '/model/eletters/eletters.class.php';
/**
 * This class replaces controllers/mgr/header.php from 2.1 and before
 */
abstract class ElettersManagerController extends modExtraManagerController {
    /** 
     * @var Eletters $eletters 
     */
    public $eletters;
    /**
     * Initialize, Load Eletters class and set default CSS and JS
     */
    public function initialize() {
        $this->eletters = new Eletters($this->modx);
        $config = $this->eletters->getConfig();
        
        // $this->addCss($config['cssUrl'].'mgr.css');
        $this->addJavascript($config['jsUrl'].'mgr/eletters.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            Eletters.config = '.$this->modx->toJSON($config).';
        });
        </script>');
        
        return parent::initialize();
    }
    /**
     * Set the Language Topics (Lexicon) for this CMP
     */
    public function getLanguageTopics() {
        return array('eletters:default');
    }
    /**
     * Check for permissions
     * @return (Boolean) 
     */
    public function checkPermissions() {
        return true;
    }
}
/**
 * Actual Class that MODX looks for IndexManagerController
 * 
 */
class IndexManagerController extends ElettersManagerController {
    /**
     * The default controller class to use in controllers/NAME.class.php
     * @return (STring) 'home'
     */
    public static function getDefaultController() {
        return 'home'; 
    }
}