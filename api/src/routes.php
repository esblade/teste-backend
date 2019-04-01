<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/api', function($request, $response, $args){ 
    // Sample log message
    $mediaNacional = \Service::getMediaNacional(); 
    $byStateSim  = \Service::getByState(37);#SIM 
    $byStateNao  = \Service::getByState(38);#NAO

    for ($i = 0; $i < sizeof($byStateSim); $i++) { 
        $regionals[] = [
            "description" => $byStateSim[$i]['description'],
            "average" => $byStateSim[$i]['alunos'] / 
                ( $byStateSim[$i]['alunos'] + $byStateNao[$i]['alunos'] ) * 100
        ];
    }

    $args = [
        'senai' => [
            'regionals' => $regionals,
            'mediaNacional' => $mediaNacional
        ]
    ];

    $response = $response->withHeader('Content-Type', 'application/json');
    return $this->view->render($response, 'json.html', $args);
});

$app->get('/', function($request, $response, $args){ 
    return $this->view->render($response, 'view.html', $args);
});