<?php
/**
 * Loads the header for mgr pages.
 *
 * @package groupeletters
 * @subpackage controllers
 */
$modx->regClientStartupScript($ditsnews->config['jsUrl'].'mgr/groupeletters.js');
$modx->regClientStartupHTMLBlock('<script type="text/javascript">
Ext.onReady(function() {
    GroupEletters.config = '.$modx->toJSON($groupEletters->config).';
});
</script>');

return '';