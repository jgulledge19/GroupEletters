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
    $s_path = $modx->getOption('core_path').'components/groupeletters/model/';
    $modx->addPackage('groupeletters', $s_path);
    
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            
            //$modx->log(xPDO::LOG_LEVEL_INFO,'Package Path: '.$s_path);
            $m = $modx->getManager();

            $manager = $modx->getManager();
            $modx->setLogLevel(modX::LOG_LEVEL_ERROR);
            $m->createObjectContainer('EletterGroupSubscribers');
            $m->createObjectContainer('EletterGroups');
            $m->createObjectContainer('EletterLinks');
            $m->createObjectContainer('EletterNewsletterGroups');
            $m->createObjectContainer('EletterNewsletters');
            $m->createObjectContainer('EletterQueue');
            $m->createObjectContainer('EletterSubscriberHits');
            $m->createObjectContainer('EletterSubscribers');
            //$m->createObjectContainer('');
            $modx->setLogLevel(modX::LOG_LEVEL_INFO);
            break;
    }
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            
            break;
        case xPDOTransport::ACTION_UPGRADE:
            /* beta3 */
            $modx->exec("ALTER TABLE {$modx->getTableName('EletterSubscribers')} 
                ADD COLUMN `city` VARCHAR(64) NULL AFTER `address`
                ");
            /* rc1 */
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
            break;
    }
}
$modx->log(xPDO::LOG_LEVEL_INFO,'Tables resolver actions completed');

return true;
