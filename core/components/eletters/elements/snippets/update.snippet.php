<?php
/**
 * This snippet will just update the DB tables from to 1.0 beta3+ and 1.0 beta5+
 */
if (!isset($modx->eletters)) {
    $modx->addPackage('eletters', $modx->getOption('core_path').'components/eletters/model/');
    $modx->eletters = $modx->getService('eletters', 'Eletters', $modx->getOption('core_path').'components/eletters/model/eletters/');
}
$eletters =& $modx->eletters;

$output = '';
$manager = $modx->getManager();

$tableObjects = array(
        'EletterGroupSubscribers',
        'EletterGroups',
        'EletterLinks',
        'EletterNewsletterGroups',
        'EletterNewsletters',
        'EletterQueue',
        'EletterSubscriberHits',
        'EletterSubscribers',
        'EletterLog',
    );
    
// get list of existing table/columns:
$tables = array();// [table][column]

foreach( $tableObjects as $object ) {
    $table_name = $modx->getTableName($object);
    
    $sql = 'SELECT * FROM ' . $table_name.' LIMIT 1 ';
    $rs = $modx->query($sql);
    $tmp = $rs->fetch(PDO::FETCH_ASSOC);
    if ( is_array($tmp) ) {
        foreach ($tmp as $column => $value) {
            $tables[$object][$column] = 1;
        }
    }
}
//$output = '<pre>'.print_r($tables, true).'</pre>';
//return $output;


$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
/* beta3 */
if ( !isset($tables['EletterSubscribers']['city']) ) {
    $modx->exec("ALTER TABLE {$modx->getTableName('EletterSubscribers')} 
        ADD COLUMN `city` VARCHAR(64) NULL AFTER `address`
        ");
}
/* rc1 */
if ( !isset($tables['EletterQueue']['sent_date']) ) {
    $modx->exec("ALTER TABLE {$modx->getTableName('EletterQueue')} 
        ADD COLUMN `sent_date` DATETIME NULL AFTER `sent`,
        ADD COLUMN `delivered` TINYINT(1) DEFAULT '1' NULL AFTER `sent_date`,
        ADD COLUMN `bounced` TINYINT(1) DEFAULT '0' NULL AFTER `delivered`, 
        ADD COLUMN `unsubscribed` TINYINT(1) DEFAULT '0' NULL AFTER `bounced`,
        ADD COLUMN `error` TEXT NULL AFTER `unsubscribed`
        ");
}
if ( isset($tables['EletterSubscriberHits']['hit_time']) ) {
    $modx->exec("ALTER TABLE {$modx->getTableName('EletterSubscriberHits')}
        DROP COLUMN `hit_time`, 
        DROP COLUMN `landing`, 
        DROP COLUMN `goal`,
        CHANGE `url` `link` INT(11) NULL , 
        CHANGE `hit_type` `hit_type` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_general_ci NULL
        ");
}
//if ( !isset($tables['EletterLinks']['']) ) {
    $modx->exec("ALTER TABLE {$modx->getTableName('EletterLinks')}
        CHANGE `type` `type` SET('click','image') CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'click' NULL
        ");
//}
if ( !isset($tables['EletterNewsletters']['sent']) ) {
    $modx->exec("ALTER TABLE {$modx->getTableName('EletterNewsletters')}
            CHANGE `sent_cnt` `sent` INT(11) DEFAULT '0' NULL ,
            CHANGE `tot_cnt` `delivered` INT(11) DEFAULT '0' NULL ,
            CHANGE `bounce_cnt` `bounced` INT(11) UNSIGNED DEFAULT '0' NULL 
        ");
}
// added in 1.0rc2?
if ( !isset($tables['EletterNewsletters']['attachments']) ) {
    $modx->exec("ALTER TABLE {$modx->getTableName('EletterNewsletters')}
            ADD COLUMN `attachments` TEXT NULL AFTER `bounced`; 
        ");
}
/**
 * 1.1:
 */
if ( !isset($tables['EletterSubscribers']['user_id']) ) {
    $modx->exec("ALTER TABLE {$modx->getTableName('EletterSubscribers')}
            ADD COLUMN `user_id` INT(11) NULL COMMENT 'MODX User ID' AFTER `id`,     
            ADD COLUMN `sync_user` TINYINT(1) DEFAULT '1' NULL COMMENT 'Sync MODX users data with the user_id' AFTER `user_id`;
        ");
}
// Add indexes:
$modx->exec("ALTER TABLE {$modx->getTableName('EletterSubscribers')}
        ADD INDEX `MODX` (`user_id`, `sync_user`);
    ");
$modx->exec("ALTER TABLE {$modx->getTableName('EletterSubscribers')}
        ADD INDEX `CRM` (`crm_id`, `email`(20));
    ");
$modx->exec("ALTER TABLE {$modx->getTableName('EletterSubscribers')}
        ADD INDEX `Search` (`email`, `last_name`, `first_name`);
    ");
if ( !isset($tables['EletterGroups']['group_type']) ) {
    $modx->exec("ALTER TABLE {$modx->getTableName('EletterGroups')}
            ADD COLUMN `group_type` SET('Campaign','MODX','Dynamic') DEFAULT 'Campaign' NULL COMMENT 'If MODX then it will use member_group_id' AFTER `parent`;
        "); 
    $modx->exec("ALTER TABLE {$modx->getTableName('EletterGroups')}
            ADD COLUMN `member_group_id` INT NULL COMMENT 'MODX member group ID' AFTER `group_type` ;
        ");
}
if ( !isset($tables['EletterNewsletters']['type']) ) {
    $modx->exec("ALTER TABLE {$modx->getTableName('EletterNewsletters')}
            ADD COLUMN `type` SET('Campaign','Response','Trigger') DEFAULT 'Campaign' NULL AFTER `resource`,     
            ADD COLUMN `access` SET('Public','Protected') DEFAULT 'Public' NULL AFTER `type`;
        "); 
}
if ( !isset($tables['EletterQueue']['bounced']) ) {
    $modx->exec("ALTER TABLE {$modx->getTableName('EletterQueue')}
            ADD COLUMN `bounced` TINYINT(1) DEFAULT '0' NULL AFTER `delivered`,
            ADD COLUMN `unsubscribed` TINYINT(1) DEFAULT '0' NULL AFTER `bounced`,
            ADD COLUMN `opened` TINYINT(1) DEFAULT '0' NULL AFTER `unsubscribed`;
        ");
}

return 'Tables updated';
