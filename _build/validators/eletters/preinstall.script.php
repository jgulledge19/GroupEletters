<?php
/**
 * Mycomponent pre-install script
 *
 * Copyright 2011 Your Name <you@yourdomain.com>
 * @author Your Name <you@yourdomain.com>
 * 1/1/11
 *
 * Mycomponent is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * Mycomponent is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Mycomponent; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package mycomponent
 */
/**
 * Description: Example validator checks for existence of getResources
 * @package mycomponent
 * @subpackage build
 */
/**
 * @package mycomponent
 * Validators execute before the package is installed. If they return
 * false, the package install is aborted. This example checks for
 * the installation of getResources and aborts the install if
 * it is not found.
 */

/* The $modx object is not available here. In its place we
 * use $object->xpdo
 */
$modx =& $object->xpdo;


$modx->log(xPDO::LOG_LEVEL_INFO,'Running PHP Validator.');
switch($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
   /* These cases must return true or the upgrade/uninstall will be cancelled */
   case xPDOTransport::ACTION_UPGRADE:
        //$modx->log(xPDO::LOG_LEVEL_INFO,'Checking for installed getResources snippet ');
        /* Check for FormIt * /
        if ( file_exists(MODX_ASSETS_PATH.'components/colorpicker/js/colorpickerfield.js') ) {
            $modx->log(xPDO::LOG_LEVEL_INFO,'ColorPicker found - install will continue');
        } else {
            $modx->log(xPDO::LOG_LEVEL_ERROR,'This package requires the ColorPicker package. Please install it and reinstall Church Events Calendar');
            $success = false;
        }
        */
        $success = true;
        break;

    case xPDOTransport::ACTION_UNINSTALL:
        $success = true;
        break;
}

return $success;