<?php
/**
 * @package groupEletters
 * @subpackage controllers
 */
require_once dirname(dirname(__FILE__)) . '/model/groupeletters/groupeletters.class.php';
$groupEletters = new GroupEletters($modx);

return $groupEletters->initialize('mgr');