<?php

defined('BASEPATH') || exit('No direct script access allowed');

$db['default']['hostname'] = getenv('DB_HOST') ?: 'db';
$db['default']['username'] = getenv('DB_USERNAME') ?: 'opensid_user';
$db['default']['password'] = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : 'opensid_password';
$db['default']['port']     = (int)(getenv('DB_PORT') ?: 3306);
$db['default']['database'] = getenv('DB_DATABASE') ?: 'opensid_bobu';
$db['default']['dbcollat'] = 'utf8mb4_general_ci';
$db['default']['stricton'] = false;

