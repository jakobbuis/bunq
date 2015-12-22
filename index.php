<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

// Initialize server
require 'vendor/autoload.php';
$app = new App;

/*
 * Define endpoints
 */

// Update chat endpoint for polling
// returns all messages after a specific timestamp
$app->get('/chat', function(Request $request, Response $response){

});

// Main chat function: emit a message to the global chat
// messages take the JSON format {"user": "Peter", "message": "hello world"}
$app->post('/chat', function(Request $request, Response $response){

});

// Start the application
$app->run();
