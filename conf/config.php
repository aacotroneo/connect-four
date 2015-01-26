<?php


return
    array( //slim settings. this is loaded as $app->settings

        'templates.path' => __DIR__ . "/../php/View",
        'view' => new Slim\Views\Twig(),
    );