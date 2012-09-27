<?php
require_once dirname(__FILE__) . '/model/groupeletters/groupeletters.class.php';
/**
 * This class replaces controllers/mgr/header.php from 2.1 and before
 */
abstract class GroupElettersManagerController extends modExtraManagerController {
    /** 
     * @var GroupEletters $groupEletters 
     */
    public $groupEletters;
    /**
     * Initialize, Load GroupEletters class and set default CSS and JS
     */
    public function initialize() {
        $this->groupEletters = new GroupEletters($this->modx);
 
        // $this->addCss($this->groupEletters->config['cssUrl'].'mgr.css');
        $this->addJavascript($this->groupEletters->config['jsUrl'].'mgr/groupeletters.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            GroupEletters.config = '.$this->modx->toJSON($this->groupEletters->config).';
        });
        </script>');
        
        return parent::initialize();
    }
    /**
     * Set the Language Topics (Lexicon) for this CMP
     */
    public function getLanguageTopics() {
        return array('groupeletters:default');
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
class IndexManagerController extends GroupElettersManagerController {
    /**
     * The default controller class to use in controllers/NAME.class.php
     * @return (STring) 'home'
     */
    public static function getDefaultController() {
        return 'home'; 
    }
}