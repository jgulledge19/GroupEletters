<?php
/**
 * Loads the header for mgr pages.
 *
 * @package ditsnews
 * @subpackage controllers
 */
$modx->regClientStartupScript($ditsnews->config['jsUrl'].'mgr/ditsnews.js');
$modx->regClientStartupHTMLBlock('<script type="text/javascript">
Ext.onReady(function() {
    Ditsnews.config = '.$modx->toJSON($ditsnews->config).';
});
</script>');

return '';