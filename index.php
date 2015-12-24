<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

// Initialize server
require 'vendor/autoload.php';
require 'Message.php';
$app = new App;
$database = new medoo([
    'database_type' => 'sqlite',
    'database_file' => './database.sqlite'
]);
$message = new Message($database);

/*
 * Define server API endpoints
 */

// Main UI
$app->get('/', function(Request $request, Response $response){
    return readfile('interface.html');
});

// Update chat endpoint for polling
// returns all messages after a specific timestamp
$app->get('/chat', function(Request $request, Response $response) use ($message) {
    $response = $response->withHeader('Content-Type', 'application/json');
    return $response->getBody()->write(json_encode($message->getAll()));
});

// Main chat function: emit a message to the global chat
// messages take the JSON format {"user": "Peter", "message": "hello world"}
$app->post('/chat', function(Request $request, Response $response) use ($message) {

    $data = $request->getParsedBody();

    $message->create($data['name'], $data['message']);

    return $response->withStatus(204);
});

// Start the application
$app->run();
