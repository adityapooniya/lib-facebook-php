<?php
/** Copy this file as setup.php before using */

// Start the session before test output begins
session_start();


// Define path constants
define('LIB_FACEBOOK_PATH', realpath(__DIR__ . DIRECTORY_SEPARATOR . '../'));
define('LIB_FACEBOOK_TEST_PATH', realpath(__DIR__));


// Define FB API constants
define('APP_ID', '__YOUR_APP_ID__');
define('APP_SECRET', '__YOUR_APP_SECRECT__');
define('USER_ACCESS_TOKEN', '__YOUR_ACCESS_TOKEN__');
define('USER_ID', '__YOUR_USER_ID__');


// Setup LibFacebook instance with default setup data.
require_once(LIB_FACEBOOK_PATH . DIRECTORY_SEPARATOR . 'LibFacebook.php');

LibFacebook::getInstance()->setApiConfig(
    array('appId'  => APP_ID, 'secret' => APP_SECRET)
);

LibFacebook::getInstance()->getApi()->setAccessToken(USER_ACCESS_TOKEN);



