<?php
$count = 1;

$current_dir = dirname(dirname(dirname(__FILE__))).'/core/components/churchevents/elements/chunks/'; 
$open_dir = opendir( $current_dir ) ;

while ( $tmp_file = readdir( $open_dir ) ) {
    if ( $tmp_file != '.' && $tmp_file != '..' ) {
        # dir
        if ( is_dir( $current_dir.$tmp_file ) ) {
            continue;
        } elseif( is_file($current_dir.$tmp_file) ) {
            echo '
$chunks['.$count.']= $modx->newObject(\'modChunk\');
$chunks['.$count.']->fromArray(array(
    \'id\' => '.$count++.',
    \'name\' => \''.str_replace('.chunk.tpl', '', $tmp_file).'\',
    \'description\' => \'\',
    \'snippet\' => file_get_contents($sources[\'source_core\'].\'/elements/chunks/'.$tmp_file.'\'),
    \'properties\' => \'\',
),\'\',true,true);
            ';

        }
    }
}
