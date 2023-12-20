<?php

/**
* Register configs
*/

require __DIR__.'/configs.php';

/**
 * Register bootstrap application config
 */

require __DIR__.'/bootstrap.php';

/**
* Register routes
*/

if (php_sapi_name() == 'cli') {
    require __DIR__.'/console_routes.php';
} else {
    require __DIR__.'/routes.php';
}
