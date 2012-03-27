<?php
/**
 * Loads the home page.
 *
 * @package ditsnews
 * @subpackage controllers
 */

$modx->regClientStartupScript($ditsnews->config['jsUrl'].'mgr/widgets/newsletters.grid.js');
$modx->regClientStartupScript($ditsnews->config['jsUrl'].'mgr/widgets/groups.grid.js');
$modx->regClientStartupScript($ditsnews->config['jsUrl'].'mgr/widgets/subscribers.grid.js');
$modx->regClientStartupScript($ditsnews->config['jsUrl'].'mgr/widgets/settings.panel.js');
$modx->regClientStartupScript($ditsnews->config['jsUrl'].'mgr/widgets/home.panel.js');
$modx->regClientStartupScript($ditsnews->config['jsUrl'].'mgr/sections/index.js');

$output = '<div id="ditsnews-panel-home-div"></div>';

return $output;