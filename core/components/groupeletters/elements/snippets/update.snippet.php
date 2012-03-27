<?php

$handler = $modx->pdo;
$stmt = $this->handler->query('SHOW TABLES');
$tbs = $stmt->fetchAll();
$i=0;
foreach($tbs as $table){
    //echo '<br>Table: '. $table[0];
    if ( $this->useIncludeTables ) {
        //echo ' - useIncludes';
        if ( !in_array($table[0],$this->includeTables)) {
            //echo ' - exclude me';
            continue;
        }
    } elseif ( $this->useExcludeTables ) {
        if ( in_array($table[0],$this->excludeTables)) {
            continue;
        }
    }
    $this->tables[$i]['name'] = $table[0];
    $this->tables[$i]['create'] = $this->_getColumns($table[0]);
    $this->tables[$i]['data'] = $this->_getData($table[0]);
    $i++;
}

$output = '';
$manager = $modx->getManager();
    $dbname= 'website_db';
    
    $tableLike = ''; 
    
    $tablesStmt= $manager->xpdo->prepare("SHOW TABLES FROM {$dbname}{$tableLike}");
    $tablesStmt->execute();
    $tables= $tablesStmt->fetchAll(PDO::FETCH_NUM);
    //if ($manager->xpdo->getDebug() === true) $manager->xpdo->log(xPDO::LOG_LEVEL_DEBUG, print_r($tables, true));
    foreach ($tables as $table) {
        $xmlObject= array();
        $xmlFields= array();
        $xmlIndices= array();
        
        $output .= '<br>Table: '. $table[0];
        
    }
    
return $output;

///
require_once MODX_CORE_PATH.'/components/ditsnews/model/ditsnews/ditsnews.class.php';
$ditsnews = new Ditsnews($modx);

$manager = $modx->getManager();
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);



//$modx->exec();
$sql = "ALTER TABLE {$modx->getTableName('dnNewsletter')} ";
$statements = array(
     "ADD COLUMN `resource` INT NULL AFTER `message` ;",
     "ADD COLUMN `subject` VARCHAR(128) NULL AFTER `resource` ",
     "ADD COLUMN `from` VARCHAR(128) DEFAULT NULL NULL AFTER `subject`",
     "ADD COLUMN `from_name` VARCHAR(128) DEFAULT NULL NULL AFTER `from`",
     "ADD COLUMN `reply_to` VARCHAR(128) DEFAULT NULL NULL AFTER `from_name`",
     "ADD COLUMN `groups` VARCHAR(255) DEFAULT NULL NULL AFTER `reply_to`",
     "ADD COLUMN `status` SET('draft','submitted','approved','sent') DEFAULT 'draft' NULL AFTER `groups`",
     "ADD COLUMN `allow_comments` SET('Y','N') DEFAULT 'N' NULL AFTER `status`",
     "ADD COLUMN `user` INT NULL AFTER `allow_comments`",
     "ADD COLUMN `start_date` DATETIME NULL AFTER `user` ",
     "ADD COLUMN `end_date` DATETIME NULL AFTER `start_date`",
    );
foreach ( $statements as $statement ) {
    $tablesStmt= $manager->xpdo->prepare($sql.$statement);
    $tablesStmt->execute();
}
/*
CREATE TABLE `modx_ditsnews_newsletters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `date` int(20) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `resource` int(11) DEFAULT NULL,
  `subject` varchar(128) DEFAULT NULL,
  `from` varchar(128) DEFAULT NULL,
  `from_name` varchar(128) DEFAULT NULL,
  `reply_to` varchar(128) DEFAULT NULL,
  `groups` varchar(255) DEFAULT NULL,
  `status` set('draft','submitted','approved','sent') DEFAULT 'draft',
  `allow_comments` set('Y','N') DEFAULT 'N',
  `user` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8
*/
return 'update eletters..';

