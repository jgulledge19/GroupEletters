<?php
/**
 * MyComponent transport snippets
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
 * Description:  Array of snippet objects for MyComponent package
 * @package mycomponent
 * @subpackage build
 */

if (! function_exists('getSnippetContent')) {
    function getSnippetContent($filename) {
        $o = file_get_contents($filename);
        $o = str_replace('<?php','',$o);
        $o = str_replace('?>','',$o);
        $o = trim($o);
        return $o;
    }
}
$snippets = array();

$x = 0;

$snippets[++$x]= $modx->newObject('modSnippet');
$snippets[$x]->fromArray(array(
    'id' => $x, // set this in order not the ID for the snippet
    'name' => 'GroupEletterListGroups',
    'description' => 'List the aviable groups for the TV',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/groupeletterlistgroups.snippet.php'),
),'',true,true);
//$properties = include $sources['data'].'/properties/properties.mysnippet1.php';
//$snippets[$x]->setProperties($properties);
//unset($properties);

$snippets[++$x]= $modx->newObject('modSnippet');
$snippets[$x]->fromArray(array(
    'id' => $x, // set this in order not the ID for the snippet
    'name' => 'GroupEletterQueue',
    'description' => 'This will run a batch of eletters',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/groupeletterqueue.snippet.php'),
),'',true,true);
//$properties = include $sources['data'].'/properties/properties.mysnippet1.php';
//$snippets[$x]->setProperties($properties);
//unset($properties);

$snippets[++$x]= $modx->newObject('modSnippet');
$snippets[$x]->fromArray(array(
    'id' => $x, // set this in order not the ID for the snippet
    'name' => 'GroupEletterFormListGroups',
    'description' => 'List avaiable Groups for the signup form, preHook',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/groupeletterformlistgroups.snippet.php'),
),'',true,true);
//$properties = include $sources['data'].'/properties/properties.mysnippet1.php';
//$snippets[$x]->setProperties($properties);
//unset($properties);

$snippets[++$x]= $modx->newObject('modSnippet');
$snippets[$x]->fromArray(array(
    'id' => $x, // set this in order not the ID for the snippet
    'name' => 'GroupEletterSignup',
    'description' => 'The signup form postHook to assign subscriber to group(s)',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/groupelettersignup.snippet.php'),
),'',true,true);
//$properties = include $sources['data'].'/properties/properties.mysnippet1.php';
//$snippets[$x]->setProperties($properties);
//unset($properties);

$snippets[++$x]= $modx->newObject('modSnippet');
$snippets[$x]->fromArray(array(
    'id' => $x, // set this in order not the ID for the snippet
    'name' => 'GroupEletterConfirm',
    'description' => 'Confirm the subscription after completing the signup form',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/groupeletterconfirm.snippet.php'),
),'',true,true);
//$properties = include $sources['data'].'/properties/properties.mysnippet1.php';
//$snippets[$x]->setProperties($properties);
//unset($properties);

$snippets[++$x]= $modx->newObject('modSnippet');
$snippets[$x]->fromArray(array(
    'id' => $x, // set this in order not the ID for the snippet
    'name' => 'GroupEletterUnsubscribe',
    'description' => 'Unsubscribe from eletter groups',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/groupeletterunsubscribe.snippet.php'),
),'',true,true);
//$properties = include $sources['data'].'/properties/properties.mysnippet1.php';
//$snippets[$x]->setProperties($properties);
//unset($properties);ies);






return $snippets;