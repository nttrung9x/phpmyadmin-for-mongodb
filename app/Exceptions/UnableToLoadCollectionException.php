<?php

/*
 * PhpMongoAdmin (www.phpmongoadmin.com) by Masterforms Mobile & Web (MFMAW)
 * @version      UnableToLoadCollectionException.php 1001 25/8/21, 8:37 pm  Gilbert Rehling $
 * @package      PhpMongoAdmin\app
 * @subpackage   UnableToLoadCollectionException.php
 * @link         https://github.com/php-mongo/admin PHP MongoDB Admin
 * @copyright    Copyright (c) 2021. Gilbert Rehling of MMFAW. All rights reserved. (www.mfmaw.com)
 * @licence      PhpMongoAdmin is an Open Source Project released under the GNU GPLv3 license model.
 * @author       Gilbert Rehling:  gilbert@phpmongoadmin.com (www.gilbert-rehling.com)
 *  php-mongo-admin - License conditions:
 *  Contributions to our suggestion box are welcome: https://phpmongotools.com/suggestions
 *  This web application is available as Free Software and has no implied warranty or guarantee of usability.
 *  See licence.txt for the complete licensing outline.
 *  See https://www.gnu.org/licenses/license-list.html for information on GNU General Public License v3.0
 *  See COPYRIGHT.php for copyright notices and further details.
 */

namespace App\Exceptions;

use Exception;

class UnableToLoadCollectionException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return string
     */
    public function message($msg = 'Unable to load selected collection')
    {
        return $msg;
    }
}
