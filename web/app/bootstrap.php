<?php

use App\View\View;
use App\Setup\Env;

require __DIR__ . './../vendor/autoload.php';

Env::load(__DIR__ . '/../');

define('URL', getenv('URL'));

$env = getenv();

View::init([
    'baseUrl' => URL,
    'baseAdminUrl' => URL . '/admin',
]);
