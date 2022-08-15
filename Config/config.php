<?php

return [
    'name'        => 'SteerCampaign Cron Plugin',
    'description' => 'Helper plugin for manging crons',
    'version'     => '1.0',
    'author'      => 'Mohammad Abu Musa<m.abumusa@steercampaign.com>',
    'services' => [
        'commands' => [
            'sc_cron_controller' => [
                'tag'       => 'console.command',
                'class'     => MauticPlugin\SCCronBundle\Command\GetSegmentsCommand::class,
            ]
        ]
    ]
];
