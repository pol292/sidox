<?php

return array(
    'defualt' => [
        'controller' => 'main',
        'action'     => 'index',
    ],
    'alias' => [
        'Sidox\Core\Controller' => 'Controller',
        'Sidox\Core\View' => 'View',
        'Sidox\Core\Model' => 'Model',
        '\Sidox\Core\Route' => 'Route',
    ],
    'settings' => [
        'session_name' => 'sidox',
        'mechin_name' => '-',
    ],
);
