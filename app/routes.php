<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use App\Domain\User\UserApi as UserApi;

return function (App $app) {
    $user_connection = new UserApi();
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write(json_encode('Hello world!'));
        return $response;
    });

    $app->post('/createUser', function (Request $request, Response $response) use ($user_connection){
        $response->getBody()->write(json_encode(['data' => $user_connection->createUser($request->getQueryParams()['first_name'], $request->getQueryParams()['last_name'], $request->getQueryParams()['username'], $request->getQueryParams()['password'])]));
        return $response;
    });

    $app->post('/loginUser', function (Request $request, Response $response) use ($user_connection){
        $response->getBody()->write(json_encode(['data' => $user_connection->loginUser($request->getQueryParams()['username'], $request->getQueryParams()['password'])]));
        return $response;
    });

    $app->post('/checkLoginToken', function (Request $request, Response $response) use ($user_connection){
        $response->getBody()->write(json_encode(['data' => $user_connection->checkLoginToken($request->getQueryParams()['login_token'])]));
        return $response;
    });

    $app->get('/getUserDetail', function (Request $request, Response $response) use ($user_connection){
        $response->getBody()->write(json_encode($user_connection->getUserDetail($request->getQueryParams()['id'])));
        return $response;
    });

    $app->post('/sendMessage', function (Request $request, Response $response) use ($user_connection){
        $response->getBody()->write(json_encode(['data' => $user_connection->storeMessage($request->getQueryParams()['text'], $request->getQueryParams()['sender_id'], $request->getQueryParams()['receiver_id'])]));
        return $response;
    });

    $app->get('/getMessages', function (Request $request, Response $response) use ($user_connection){
        $response->getBody()->write(json_encode(['data' => $user_connection->getMessages($request->getQueryParams()['receiver_id'])]));
        return $user_connection;
    });

    $app->get('/getMessageTeaser', function (Request $request, Response $response) use ($user_connection){
        $response->getBody()->write(json_encode(['data' => $user_connection->getMessageTeaser($request->getQueryParams()['receiver_id'])]));
        return $response;
    });


};
