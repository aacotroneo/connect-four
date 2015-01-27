<?php


    return array(
        'bd' => array(
            'dsn' => 'pgsql:host=localhost;port=5432;dbname=arai_usuarios',
            'username' => 'postgres',
            'password' => 'postgres'
        ),
        'saml' => array(
            'settings_file' => __DIR__ . '/xxx.php',
            'uid_key' => 'uid'
        ),
        'log'  => array(
            'dir' => __DIR__ . '/logs'
        )
    );