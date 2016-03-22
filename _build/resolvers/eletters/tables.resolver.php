<?php

/**
 * MyComponent resolver script - runs on install.
 *
 * Copyright 2011 Your Name <you@yourdomain.com>
 * @author Your Name <you@yourdomain.com>
 * 1/1/11
 *
 * MyComponent is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * MyComponent is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * MyComponent; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package mycomponent
 */
/**
 * Description: Resolver script for MyComponent package
 * @package mycomponent
 * @subpackage build
 */

/* Example Resolver script */

/* The $modx object is not available here. In its place we
 * use $object->xpdo
 */

if ($object->xpdo) {
    $modx =& $object->xpdo;
    // add package
    $s_path = $modx->getOption('core_path').'components/eletters/model/';
    $modx->addPackage('eletters', $s_path);
    
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            // no break
        case xPDOTransport::ACTION_UPGRADE:
            
            //$modx->log(xPDO::LOG_LEVEL_INFO,'Package Path: '.$s_path);
            $m = $modx->getManager();
            
            $modx->setLogLevel(modX::LOG_LEVEL_ERROR);
            $m->createObjectContainer('EletterGroupSubscribers');
            $m->createObjectContainer('EletterGroups');
            $m->createObjectContainer('EletterLinks');
            $m->createObjectContainer('EletterNewsletterGroups');
            $m->createObjectContainer('EletterNewsletters');
            $m->createObjectContainer('EletterQueue');
            $m->createObjectContainer('EletterSubscriberHits');
            $m->createObjectContainer('EletterSubscribers');
            // added 1.1
            $m->createObjectContainer('EletterLog');
            
            $modx->setLogLevel(modX::LOG_LEVEL_INFO);

            // $modx->getTableName('EletterSubscribers');
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
                if ( !$rs ) {
                    // did not run/return results
                } else {
                    $tmp = $rs->fetch(PDO::FETCH_ASSOC);
                    if ( is_array($tmp) ) {
                        foreach ($tmp as $column => $value) {
                            $tables[$object][$column] = 1;
                        }
                    }
                }

                // get the indexes:
                $tables[$object]['indexes'] = array();
                $sql = 'SHOW INDEX FROM ' . $table_name.' ';
                $rs = $modx->query($sql);
                if ( !$rs ) {
                    // did not run/return results
                } else {
                    while ( $row = $rs->fetch(PDO::FETCH_ASSOC) ) {
                        $tables[$object]['indexes'][$row['Key_name']] = 1;
                    }
                }
            }

        /**
             * $q = $dbh->query("DESCRIBE tablename"); 
             * $table_fields = $q->fetchAll(PDO::FETCH_COLUMN);
             */

            if ( !isset($tables['EletterLog']['newsletter']) ) {
                $modx->exec("ALTER TABLE {$modx->getTableName('EletterLog')} 
                        ADD COLUMN `newsletter` INT(11) NULL AFTER `id`
                        ");

                $modx->exec("ALTER TABLE {$modx->getTableName('EletterLog')}
                    CHANGE `form_url` `form_url` TEXT NULL, 
                    CHANGE `referal_url` `referal_url` TEXT NULL;
                    ");
            }
            if ( !isset($tables['EletterLog']['indexes']['Newsletters']) ) {
                $modx->exec("ALTER TABLE {$modx->getTableName('EletterLog')}
                    ADD INDEX `Newsletters` (`newsletter`);
                ");
            }
            
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
            if ( !isset($tables['EletterSubscribers']['indexes']['MODX']) ) {
                $modx->exec("ALTER TABLE {$modx->getTableName('EletterSubscribers')}
                    ADD INDEX `MODX` (`user_id`, `sync_user`);
                ");
            }
            if ( !isset($tables['EletterSubscribers']['indexes']['CRM']) ) {
                $modx->exec("ALTER TABLE {$modx->getTableName('EletterSubscribers')}
                    ADD INDEX `CRM` (`crm_id`, `email`(20));
                ");
            }
            if ( !isset($tables['EletterSubscribers']['indexes']['Search']) ) {
                $modx->exec("ALTER TABLE {$modx->getTableName('EletterSubscribers')}
                    ADD INDEX `Search` (`email`, `last_name`, `first_name`);
                ");
            }
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
            break;
    }
}
$modx->log(xPDO::LOG_LEVEL_INFO,'Tables resolver actions completed');

return true;
