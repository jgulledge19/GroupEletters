<?php
/**
 * Loads the home page.
 *
 * @package groupeletters
 * @subpackage controllers
 */

$modx->regClientStartupScript($groupEletters->config['jsUrl'].'mgr/widgets/newsletters.grid.js');
$modx->regClientStartupScript($groupEletters->config['jsUrl'].'mgr/widgets/groups.grid.js');
$modx->regClientStartupScript($groupEletters->config['jsUrl'].'mgr/widgets/subscribers.grid.js');
$modx->regClientStartupScript($groupEletters->config['jsUrl'].'mgr/widgets/settings.panel.js');
$modx->regClientStartupScript($groupEletters->config['jsUrl'].'mgr/widgets/home.panel.js');
$modx->regClientStartupScript($groupEletters->config['jsUrl'].'mgr/sections/index.js');

$output = '<div id="groupeletters-panel-home-div"></div>';

return $output;