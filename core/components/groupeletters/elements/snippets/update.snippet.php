<?php
/**
 * This snippet will just update the DB tables from to 1.0 beta3+ and 1.0 beta5+
 */
if (!isset($modx->groupEletters)) {
    $modx->addPackage('groupeletters', $modx->getOption('core_path').'components/groupeletters/model/');
    $modx->groupEletters = $modx->getService('groupeletters', 'GroupEletters', $modx->getOption('core_path').'components/groupeletters/model/groupeletters/');
}
$groupEletters =& $modx->groupEletters;

$manager = $modx->getManager();
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
// added in 1.0beta3
$modx->exec("ALTER TABLE {$modx->getTableName('EletterSubscribers')} 
    ADD COLUMN `city` VARCHAR(64) NULL AFTER `address`
    ");

// added in 1.0rc1 
$modx->exec("ALTER TABLE {$modx->getTableName('EletterQueue')} 
    ADD COLUMN `sent_date` DATETIME NULL AFTER `sent`,
    ADD COLUMN `delivered` TINYINT(1) DEFAULT '1' NULL AFTER `sent_date`,
    ADD COLUMN `bounced` TINYINT(1) DEFAULT '0' NULL AFTER `delivered`, 
    ADD COLUMN `unsubscribed` TINYINT(1) DEFAULT '0' NULL AFTER `bounced`,
    ADD COLUMN `error` TEXT NULL AFTER `unsubscribed`
    ");
     
$modx->exec("ALTER TABLE {$modx->getTableName('EletterSubscriberHits')}
    DROP COLUMN `hit_time`, 
    DROP COLUMN `landing`, 
    DROP COLUMN `goal`,
    CHANGE `url` `link` INT(11) NULL , 
    CHANGE `hit_type` `hit_type` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_general_ci NULL
    ");

$modx->exec("ALTER TABLE {$modx->getTableName('EletterLinks')}
    CHANGE `type` `type` SET('click','image') CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'click' NULL
    ");