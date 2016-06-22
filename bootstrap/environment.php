<?php

Dotenv::load(APP_PATH);

define('ENVIRONMENT', getenv('ENVIRONMENT'));

switch (strtoupper(ENVIRONMENT)) {
    case 'LOCALHOST':
    case 'STAGING':

        error_reporting(E_ALL);

        break;

    case 'PRODUCTION':

        error_reporting(0);

        break;

    default:
        die('The application environment is not set correctly.');
}

return $app;
