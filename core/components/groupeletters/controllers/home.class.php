<?php
/**
 * http://rtfm.modx.com/display/revolution20/Developing+an+Extra+in+MODX+Revolution%2C+Part+II
 * This replaces controllers/mgr/index.php file
 */
class GroupElettersHomeManagerController extends GroupElettersManagerController {
    /**
     * Not sure what this is for?  But it is in the Doodles example and it is required
     * @param (Array) $scriptProperties
     */
    public function process(array $scriptProperties = array()) {
 
    }
    /**
     * Returns the <title> value 
     */
    public function getPageTitle() {
        return $this->modx->lexicon('groupeletters'); 
    }
    /**
     * Load the CSS and JS into the <head>
     */
    public function loadCustomCssJs() {
        /* /$this->addJavascript($this->doodles->config['jsUrl'].'mgr/widgets/doodles.grid.js');
        $this->addJavascript($this->doodles->config['jsUrl'].'mgr/widgets/home.panel.js');
        $this->addLastJavascript($this->doodles->config['jsUrl'].'mgr/sections/index.js');
        */
        $this->addJavascript($this->groupEletters->config['jsUrl'].'mgr/widgets/newsletters.grid.js');
        $this->addJavascript($this->groupEletters->config['jsUrl'].'mgr/widgets/groups.grid.js');
        $this->addJavascript($this->groupEletters->config['jsUrl'].'mgr/widgets/subscribers.grid.js');
        $this->addJavascript($this->groupEletters->config['jsUrl'].'mgr/widgets/settings.panel.js');
        $this->addJavascript($this->groupEletters->config['jsUrl'].'mgr/widgets/home.panel.js');
        // you must use this addLast method, it will put this file after the config file
        $this->addLastJavascript($this->groupEletters->config['jsUrl'].'mgr/sections/index.js');
    }
    /**
     * Returns a Smarty Template
     */
    public function getTemplateFile() {
        return $this->groupEletters->config['templatesPath'].'home.tpl'; 
    }
}